export class GameInstance
{
    constructor() {
        this.HEROES = Array();//normal
        this.OBJECTS = Array();//normal
        this.EFFECTS = Array();//key val
        this.TYPES = Array();//normal


        this.coins = 0;
        this.gameObjects = Array();
        this.player = null;
        this.playedTurns = 0;
        this.rows = 3;
        this.columns = 3;
        this.gameGrid = [];
        this.gameCards = [];
        this.playerWeapon = null;
        this.EMPTY_OBJ_ID = 33;
        this.EMPTY_OBJ_INSTANCE;
        this.DT_START = null;

    }
    static getInstance() {
        return this.#instance;
    }

    static #instance = new GameInstance();

    // methods
    initializeALl()
    {
        this.initializeHeroes();
        this.initializeObjects();
        this.initializeTypes();
        this.initializeEffects();
    }

    //elaborate data from php
    initializeHeroes(obj)
    {
        //get heroes
        for(let i = 0; i < obj.length; i++)
        {
            //console.log(obj[i]);
            this.HEROES.push(GameObject.convertObj(obj[i]));
        }
    }
    initializeObjects(obj)
    {
        for(let i = 0; i < obj.length; i++)
        {
            this.OBJECTS.push(GameObject.convertObj(obj[i]));
            if(this.gameObjects[this.OBJECTS[i].id_type] === undefined){
                this.gameObjects[this.OBJECTS[i].id_type] = Array();
            }
            this.gameObjects[this.OBJECTS[i].id_type].push(this.OBJECTS[i]);
            if(this.OBJECTS[i].id===this.EMPTY_OBJ_ID){
                this.EMPTY_OBJ_INSTANCE = this.OBJECTS[i];
            }

        }
    }
    initializeTypes(obj)
    {
        for(let i = 0; i < obj.length; i++)
        {
            this.TYPES.push(Type.convertObj(obj[i]));
        }
    }
    initializeEffects(obj)
    {
        for(let i = 0; i < obj.length; i++)
        {
            let effect = Effect.convertObj(obj[i])
            this.EFFECTS[effect.id] = effect;
        }
    }

    //work with js after initializing in things

    /**
     * @param {int} heroId
     * */
    setPlayer(heroId) {
        for (let i = 0; i < this.HEROES.length && this.player === null; i++) {
            if (heroId === this.HEROES[i].id) {
                this.player = this.HEROES[i];
                return this.HEROES[i];
            }
        }
        return null;
    }
    /**
     * @param {HTMLElement} card
     * @return GameCell**/
    getCellByCard(card){
        for(let i = 0; i < this.gameGrid.length; i++){
            for(let j = 0; j < this.gameGrid[i].length; j++){
                if(this.gameGrid[i][j].card === card){
                    return this.gameGrid[i][j];
                }
            }
        }
        return null;
    }
    /**
     * @param {GameObject} obj
     * @return GameCell**/
    getCellByObj(obj){
        for(let i = 0; i < this.gameGrid.length; i++){
            for(let j = 0; j < this.gameGrid[i].length; j++){
                if(this.gameGrid[i][j].obj === obj){
                    return this.gameGrid[i][j];
                }
            }
        }
        return null;
    }
    /**
     * @param {GameCell} cell
     * @return [int]**/
    getCoordinates(cell){
        for(let i = 0; i < this.gameGrid.length; i++){
            for(let j = 0; j < this.gameGrid[i].length; j++){
                if(this.gameGrid[i][j] === cell){
                    return [i,j];
                }
            }
        }
        return null;
    }
    /**
     * @return {GameObject} **/
    getEmptyObj(){
        return GameObject.convertObj(this.EMPTY_OBJ_INSTANCE);
    }
    /**
     * @return {GameObject} **/
    createNewObject()
    {
        //get the type
        let random = Math.floor(Math.random()*100+1);
        let sum = 0, type = null;
        //console.log("random: "+random);
        for (let i = 0; i < this.TYPES.length && type === null; i++){
            sum += this.TYPES[i].spawn_rate;
            //console.log("sum: "+sum);

            if(sum >= random){
                type = this.TYPES[i];
            }
        }

        return this.createNewObjectOfType(type.id);
    }
    /**
     * @param {int} id
     * @return {GameObject} **/
    getNewObject(id)
    {
        for (let i = 0; i < this.OBJECTS.length; i++){
            if(this.OBJECTS[i].id === id){
                return GameObject.convertObj(this.OBJECTS[i]);
            }
        }


        return null;
    }
    createNewObjectOfType(id_type)
    {
        console.log('Type: '+id_type);
        //get probability
        let probability = 0;
        let objsOfChoice = this.gameObjects[id_type];
        //console.log(objsOfChoice);
        for(let i = 0; i < objsOfChoice.length; i++){
            probability += objsOfChoice[i].spawn_indicator;
        }

        //get the object
        let random = Math.floor(Math.random()*probability+1);
        let sum = 0;
        let winner = null;
        for (let i = 0; i < objsOfChoice.length && winner === null; i++){
            if(objsOfChoice[i].spawn_indicator !== 0){
                sum += objsOfChoice[i].spawn_indicator;

                if(sum >= random){
                    winner = objsOfChoice[i];
                }
            }
        }

        //console.log("return: "+winner);
        return GameObject.convertObj(winner);

    }

    /**
     * Kills the player **/
    killPlayer()
    {
        //console.log("killPlayer");
        let diff = Date.now() - this.DT_START;
        diff = Math.floor(diff / 1000);




        window.location.href = './game_end.php'+
                                '?played_turns='+this.playedTurns+
                                '&coins='+this.coins+
                                '&id_hero='+this.player.id+
                                '&played_time='+diff;
    }

}
export class GameObject
{

    static DIR_UP = 1;
    static DIR_DOWN = -1;
    static DIR_LEFT = -2;
    static DIR_RIGHT = 2;
    static DIR_STR = null;
    static DIR_V = [GameObject.DIR_UP,GameObject.DIR_RIGHT,GameObject.DIR_DOWN,GameObject.DIR_LEFT]

    static STOP_THE_PLAYER = [2,4];//stop the player
    static IS_WEAPON = [5];//weapon -> equip
    static IS_TARGET = [2];//enemy -> attack
    static IS_INTERACTABLE = [4];//interactable -> die
    static DIE_ON_HOVER = [6];//interactable -> die

    static INTERACTION_DEFAULT = 0;
    static INTERACTION_SWAP = 1;


    /**
     *@constructor
     * @param {number} id
     * @param {number} id_type
     * @param {string} name
     * @param {number} health
     * @param {number} max_health
     * @param {string} img
     * @param {[int]} effects
     * @param {int} spawn_indicator
     * @param {boolean} owned
     * @param {number} price
     * @param {int} uses
     * **/
    constructor(id, id_type, name, health,max_health, img, effects, spawn_indicator, owned, price, uses)
    {
        if(GameObject.DIR_STR === null)
        {
            GameObject.DIR_STR = Array();
            GameObject.DIR_STR[GameObject.DIR_UP] = "up";
            GameObject.DIR_STR[GameObject.DIR_DOWN] = "down";
            GameObject.DIR_STR[GameObject.DIR_LEFT] = "left";
            GameObject.DIR_STR[GameObject.DIR_RIGHT] = "right";
        }

        this._id = id;
        this._id_type = id_type;
        this._name = name;
        this._health = health;
        this._max_health = max_health;
        this._img = img;
        this._effects = effects;
        this._spawn_indicator = spawn_indicator;
        this._owned = owned;
        this._price = price;
        this._uses = uses;

        //console.log(effects === null);
        this._shields = 0;
        this._rotation = null;
        this._is_corroded = false;
        this._interaction_type = GameObject.INTERACTION_DEFAULT;
        this._damage_multiplier = 1;

        if(id_type === 1 || id_type === 2){
            this._max_health = health;
        }else{
            this._max_health = -1;
        }


        this.executeEffects(2, {"val":0,"owner":this,"target":null});
    }
    static convertObj(obj)
    {
        return new GameObject(obj.id, obj.id_type, obj.name, obj.health, obj.max_health, obj.img, obj.effects, obj.spawn_indicator, obj.owned, obj.price, obj.uses);
    }
    static convertJSON(obj)
    {
        return new GameObject(obj._id, obj._id_type, obj._name, obj._health, obj._max_health, obj._img, obj._effects, obj._spawn_indicator, obj._owned, obj._price, obj._uses);
    }
    get id()
    {
        return this._id;
    }
    get id_type()
    {
        return this._id_type;
    }
    get name()
    {
        return this._name;
    }
    get health()
    {
        return this._health;
    }
    get max_health()
    {
        return this._max_health;
    }
    get rotation()
    {
        return this._rotation;
    }
    set health(health)
    {
        this._health = health;
    }
    get img()
    {
        return this._img;
    }
    get effects()
    {
        return this._effects;
    }
    get spawn_indicator()
    {
        return this._spawn_indicator;
    }
    get damage_multiplier()
    {
        return this._damage_multiplier;
    }
    get owned()
    {
        return this._owned;
    }
    get price()
    {
        return this._price;
    }
    get uses()
    {
        return this._uses;
    }
    get is_corroded()
    {
        return this._is_corroded;
    }
    get interaction_type()
    {
        return this._interaction_type;
    }
    get shields()
    {
        return this._shields;
    }
    set shields(shields)
    {
        this._shields = shields;
    }
    set rotation(rotation)
    {
        this._rotation = rotation;
    }
    set is_corroded(corroded)
    {
        this._is_corroded = corroded;
    }


    // Methods
    isEnabled()
    {
        return this._spawn_indicator > 0;
    }
    active ()
    {
        let EFFECTS = GameInstance.getInstance().EFFECTS;

        for(let i = 0; i < this.effects.length; i++){
            if(!EFFECTS[this.effects[i]].isPassive()){
                return EFFECTS[this.effects[i]];
            }
        }

        return null;
    }
    passive ()
    {
        let EFFECTS = GameInstance.getInstance().EFFECTS;

        for(let i = 0; i < this.effects.length; i++){
            if(EFFECTS[this.effects[i]].isPassive()){
                return EFFECTS[this.effects[i]];
            }
        }

        return null;
    }
    /**
     * @return Type **/
    getType(){
        let types = GameInstance.getInstance().TYPES;

        for(let i = 0; i < types.length; i++){
            if(this.id_type === types[i].id){
                return types[i];
            }
        }
    }
    cahHeal(){
        return this.max_health > this.health || !this.getType().have_max_health;
    }
    heal(val){
        this.executeEffects(10, {"val":val,"owner":this,"target":null});//heal
        this.health += val;
        if(this.health > this._max_health && this.getType().have_max_health){
            this.health = this._max_health;
        }

        this.setCorrosion(false);
    }
    heal_overflow(val){
        this.executeEffects(10, {"val":val,"owner":this,"target":null});//heal
        this.health += val;
        if(this.health > this._max_health && this.getType().have_max_health){
            this._max_health = this.health
        }
    }
    haveUses(){
        return this.uses !== undefined && this.uses !== 0;
    }
    getPassives(){
        let game = GameInstance.getInstance();
        let result = Array();
        for(let i = 0; i < this.effects.length; i++){
            if(game.EFFECTS[this.effects[i]].isPassive()){
                result.push(game.EFFECTS[this.effects[i]]);
            }
        }
        return result;
    }
    havePassives(){
        let game = GameInstance.getInstance();
        for(let i = 0; i < this.effects.length; i++){
            if(game.EFFECTS[this.effects[i]].isPassive()){
                return true;
            }
        }
        return false;
    }
    haveShields(){
        return this.shields > 0;
    }
    /**
     * @param {GameObject} obj **/
    die(obj){
        let game = GameInstance.getInstance();
        this.executeEffects(1,{"val":0,"owner":this,"target":obj});
        if(obj !== null){
            obj.executeEffects(9,{"val":0,"owner":obj,"target":this});
        }


        let cell = game.getCellByObj(this);
        if(cell !== null){//check if the obj is in the grid
            cell.obj = game.getEmptyObj();
            //console.log("kill the obj");
            if (this === game.player)
            {
                //console.log("the obj is player");
                // Kill the player.
                game.killPlayer();
            }
        }
    }
    /**
     * @param {int} val **/
    setUses(val){
        if(this.haveUses() ){
            this._uses = val;
            if(val < 0){
                this._uses = 0;
                this.die(null);
            }
        }
    }
    /**
     * @param {int} val **/
    setShield(val){
        this.shields = val;
        if(this.shields < 0){
            this.shields = 0;
        }
    }
    /**
     * @param {int} val **/
    addShield(val){
        this.setShield(this.shields + val);
    }
    decreaseUses(){
        if(this.haveUses()){
            this.setUses(this.uses - 1);
        }
    }
    /**
     * @param {GameObject} source
     * @param {int} dmg **/
    takeNormalDamage(source, dmg){
        this.executeEffects(17,{"val":dmg,"owner":this,"target":source});//before dmg
        this.executeEffects(18,{"val":dmg,"owner":this,"target":source});//before normal dmg
        if(!this.haveShields()){
            this.health -= dmg;
            if(this.health < 0){
                this.health = 0;
            }
        }else{
            this.shields--;
        }
        this.executeEffects(3,{"val":dmg,"owner":this,"target":source});//dmg taken
        this.executeEffects(5,{"val":dmg,"owner":this,"target":source});//normal dmg taken
    }
    /**
     * @param {GameObject} source
     * @param {int} dmg **/
    takeSpecialDamage(source, dmg){
        this.executeEffects(17,{"val":dmg,"owner":this,"target":source});//before dmg
        this.executeEffects(19,{"val":dmg,"owner":this,"target":source});//before special dmg
        this.health -= dmg;
        if(this.health <= 0){
            this.health = 1;
        }
        this.executeEffects(3,{"val":dmg,"owner":this,"target":source});//dmg taken
    }
    /**
     * @param {boolean} val
     * **/
    setCorrosion(val){
        let val2 = val ? 1 : 0;
        this.executeEffects(15,{"val":val2,"owner":this,"target":null});
        val = val2 === 1;
        this.is_corroded = val;
    }
    applyCorrosion(){
        let val = 1;
        this.executeEffects(15,{"val":val,"owner":this,"target":null});//effect applied
        this.is_corroded = val === 1;
    }
    removeCorrosion(){
        this.is_corroded = false;
    }
    /**
     * @param {int} event
     * @param {{"val" : int,"owner" : GameObject,"target" : GameObject}} v**/
    executeEffects(event,v){

        /**/
        let game = GameInstance.getInstance();
        for (let i = 0; i < this.effects.length; i++){
            let eTmp = game.EFFECTS[this.effects[i]];
            if(eTmp.isPassive() && eTmp.id_event === event){//death
                eTmp.execute(v);
            }
        }
    }
    click()
    {
        //console.log("click");
        let game = GameInstance.getInstance();
        //get actors
        let obj = this;
        let cObj = game.getCoordinates(game.getCellByObj(obj));
        let cPlayer = game.getCoordinates(game.getCellByObj(game.player));
        if ((cObj[0] === cPlayer[0] || cObj[1] === cPlayer[1]) && obj !== game.player && Math.abs(cObj[0] - cPlayer[0]) < 2 && Math.abs(cObj[1] - cPlayer[1]) < 2){//legal move
            //console.log("legal move");
            if(game.player.interaction_type === GameObject.INTERACTION_DEFAULT){
                //console.log("default");
                if(!GameObject.STOP_THE_PLAYER.includes(this.id_type))//move
                {
                    //get original player coords
                    let coord = game.getCoordinates(game.getCellByObj(game.player));
                    let x = coord[0];
                    let y = coord[1];

                    //delete old player
                    game.getCellByObj(game.player).obj = game.getEmptyObj();

                    //move the player
                    game.getCellByObj(this).obj = game.player;
                    coord = game.getCoordinates(game.getCellByObj(game.player));
                    let xEnd = coord[0];
                    let yEnd = coord[1];

                    //find player movement dir
                    let move;
                    if(x === xEnd){
                        if(yEnd > y){
                            move = GameObject.DIR_DOWN;
                        }else{
                            move = GameObject.DIR_UP;
                        }
                    }else{
                        if(xEnd > x){
                            move = GameObject.DIR_RIGHT;
                        }else{
                            move = GameObject.DIR_LEFT;
                        }
                    }

                    //find direction for filling the empty spaces
                    let dir;
                    do{
                        dir = GameObject.DIR_V[Math.floor(Math.random()*100) % GameObject.DIR_V.length];
                    }while (dir === move);

                    //move the objs and create new obj
                    switch (dir){
                        case GameObject.DIR_UP:
                            for(let y2 = y; y2 > 0; y2--){
                                game.gameGrid[x][y2].obj = game.gameGrid[x][y2-1].obj;
                            }
                            game.gameGrid[x][0].obj = game.createNewObject();
                            break;
                        case GameObject.DIR_DOWN:
                            for(let y2 = y; y2 < game.gameGrid[0].length-1; y2++){
                                game.gameGrid[x][y2].obj = game.gameGrid[x][y2+1].obj;
                            }
                            game.gameGrid[x][game.gameGrid[0].length-1].obj = game.createNewObject();
                            break;
                        case GameObject.DIR_RIGHT:
                            for(let x2 = x; x2 < game.gameGrid.length-1; x2++){
                                game.gameGrid[x2][y].obj = game.gameGrid[x2+1][y].obj;
                            }
                            game.gameGrid[game.gameGrid.length-1][y].obj = game.createNewObject();
                            break;
                        case GameObject.DIR_LEFT:
                            for(let x2 = x; x2 > 0; x2--){
                                game.gameGrid[x2][y].obj = game.gameGrid[x2-1][y].obj;
                            }
                            game.gameGrid[0][y].obj = game.createNewObject();
                            break;
                    }


                    //resolve hover
                    this.executeEffects(14,{"val":0,"owner":this,"target":game.player});//normal interaction
                    if(GameObject.DIE_ON_HOVER.includes(this.id_type)) {
                        this.die(game.player);
                    }

                }

                if(GameObject.IS_WEAPON.includes(this.id_type))//weapon
                {
                    game.playerWeapon.obj = this;
                }
                if(GameObject.IS_TARGET.includes(this.id_type))//target
                {
                    let weapon = game.playerWeapon.obj
                    if(weapon != null){
                        let val = weapon.health
                        game.player.executeEffects(20,{"val":val,"owner":game.player,"target":this});//before dmg done
                        game.player.executeEffects(21,{"val":val,"owner":game.player,"target":this});//before normal dmg done
                        val *= game.player._damage_multiplier;
                        game.player._damage_multiplier = 1;
                        this.takeNormalDamage(game.player,val);
                        weapon.decreaseUses();
                    }else if(game.player.health > this.health){
                        game.player.takeNormalDamage(game.player,this.health);
                        this.health = 0;
                    }else {
                        this.takeNormalDamage(game.player,game.player.health);
                        game.player.health = 0;
                    }
                    game.player.executeEffects(4,{"val":0,"owner":game.player,"target":this});//dmg done
                    game.player.executeEffects(6,{"val":0,"owner":game.player,"target":this});//normal dmg done


                    if (game.playerWeapon.obj !== null && game.playerWeapon.obj.uses <= 0){
                        game.playerWeapon.obj = null;
                    }

                    //console.log(this.health);

                }
                if(GameObject.IS_INTERACTABLE.includes(this.id_type))//interactable
                {
                    this.die(game.player);
                }
            }
            else if(game.player.interaction_type === GameObject.INTERACTION_SWAP){
                //console.log("switch");
                let cell1 = game.getCellByObj(this);
                let cell2 = game.getCellByObj(game.player);
                cell1.obj = game.player;
                cell2.obj = this;
            }

            if(this.interaction_type !== GameObject.INTERACTION_DEFAULT){
                this._interaction_type = GameObject.INTERACTION_DEFAULT;
            }


            if(this.health <= 0){
                this.die(game.player);
            }
            return true;
        }
        return false;
    }

}
export class Effect
{
    /**
     *@constructor
     * @param {number} id
     * @param {string} name
     * @param {string} description
     * @param {number} value
     * @param {number} cd
     * @param {boolean} is_shown
     * @param {int} id_event
     * **/
    constructor(id, name, description, value, cd, is_shown, id_event)
    {
        this._id = id;
        this._name = name;
        this._description = description;
        this._value = value;
        this._cd = cd;
        this._currCd = cd;
        this._is_shown = is_shown;
        this._id_event = id_event;

        this.execute;

        //["val"]["owner"]["target"]
        let game = GameInstance.getInstance();
        switch (id){
            case 1:
                this.execute = (v) => {
                    v["val"] = 0;
                }
                break
            case 2:
                this.execute = (v) => {
                    v["val"] = game.getNewObject(this.value);
                }
                break
            case 3:
                this.execute = (v) => {
                    v["val"] += this.value;
                }
                break
            case 4:
                this.execute = (v) => {
                    for(let x = 0; x < game.gameGrid.length; x++){
                        for(let y = 0; y < game.gameGrid[x].length; y++){
                            if(game.gameGrid[x][y].obj !== v["owner"]){
                                game.gameGrid[x][y].obj.heal_overflow(1);
                            }

                        }
                    }
                }
                break
            case 5:
                this.execute = (v) => {
                    if(v["target"].id_type === 6){
                        v["val"] = 0;
                    }

                }
                break
            case 6:
                this.execute = (v) => {
                    v["owner"].interaction_type = GameObject.INTERACTION_SWAP;
                }
                break
            case 7:
                this.execute = (v) => {
                    if(game.playerWeapon.obj !== null){
                        game.playerWeapon.obj._uses += this.value;
                    }
                }
                break
            case 8:
                this.execute = (v) => {
                    v["owner"].damage_multiplier = this.value;
                }
                break
            case 9:
                this.execute = (v) => {
                    v["owner"].shields += this.value;
                }
                break
            case 10:
                this.execute = (v) => {
                    game.playerWeapon._uses = 0;
                }
                break
            case 11:
                this.execute = (v) => {
                    let cell = game.getCellByObj(v["owner"]);
                    cell.obj = game.getNewObject(this.value);
                }
                break
            case 12:
                this.execute = (v) => {
                    v["target"].setCorrosion(true);
                }
                break
            case 13:
                this.execute = (v) => {
                    let cell = game.getCellByObj(v["owner"]);
                    cell.obj = game.getNewObject(this.value);
                }
                break
            case 14:
                this.execute = (v) => {
                    v["target"].takeNormalDamage(v["owner"],this.value);
                }
                break
            case 15:
                this.execute = (v) => {
                    v["val"] -= this.value;
                }
                break
            case 16:
                this.execute = (v) => {
                    let cell = game.getCellByObj(v["owner"]);
                    //console.log(this);
                    cell.obj = game.createNewObjectOfType(this.value);
                }
                break
            case 17:
                this.execute = (v) => {
                    let cell = game.getCellByObj(v["owner"]);
                    let health = v["owner"].health;
                    cell.obj = game.getNewObject(this.value);
                    cell.obj._health = health;
                }
                break
            case 18:
                this.execute = (v) => {
                    let cell = game.getCellByObj(v["owner"]);
                    let health = v["owner"].health;
                    cell.obj = game.getNewObject(this.value);
                    cell.obj._health = health;
                }
                break
            case 19:
                this.execute = (v) => {
                    let coord = game.getCoordinates(game.getCellByObj(v["owner"]));
                    let x = coord[0];
                    let y = coord[1];
                    if(x+1 < game.gameGrid.length){
                        game.gameGrid[x+1][y].obj.takeNormalDamage(v["owner"],this.value);
                    }
                    if(x-1 > -1) {
                        game.gameGrid[x-1][y].obj.takeNormalDamage(v["owner"], this.value);
                    }
                    if(y+1 < game.gameGrid[x].length){
                        game.gameGrid[x][y+1].obj.takeNormalDamage(v["owner"],this.value);
                    }
                    if(y-1 > -1) {
                        game.gameGrid[x][y-1].obj.takeNormalDamage(v["owner"], this.value);
                    }
                }
                break
            case 20:
                this.execute = (v) => {
                    v["owner"]._is_corroded = true;
                }
                break
            case 21:
                this.execute = (v) => {
                    v["owner"].decreaseUses();
                    if(!v["owner"].haveUses()){
                        v["owner"].die(null);
                    }
                }
                break
            case 23:
                this.execute = (v) => {
                    v["val"] = 0;
                }
                break
            case 24:
                this.execute = (v) => {
                    v["target"].setCorrosion(true);
                }
                break
            case 25:
                this.execute = (v) => {
                    v["target"].heal(v["owner"].health);
                }
                break
            case 26:
                this.execute = (v) => {
                    game.coins += this.value;
                }
                break
            case 27:
                this.execute = (v) => {
                    if(!v["owner"].haveShields()){
                        v["owner"].addShield(this.value);
                    }
                }
                break
            case 28:
                this.execute = (v) => {
                    v["owner"].heal(this.value);
                }
                break
            case 29:
                this.execute = (v) => {
                    v["owner"].rotation = GameObject.DIR_V[Math.random()*100%GameObject.DIR_V.length];
                }
                break
            case 30:
                this.execute = (v) => {
                    v["target"].takeNormalDamage(v["owner"],this.value);
                }
                break
            case 31:
                this.execute = (v) => {
                    let found = false;
                    for(let i = 0; i < GameObject.DIR_V.length && !found;i++){
                        if(v["owner"].rotation === GameObject.DIR_V[i]){
                            v["owner"].rotation = GameObject.DIR_V[(i+1)%GameObject.DIR_V.length]
                            found = true;
                        }

                    }

                }
                break
            case 32:
                this.execute = (v) => {
                    let found = false;
                    for(let i = 0; i < GameObject.DIR_V.length && !found;i++){
                        if(v["owner"].rotation === GameObject.DIR_V[i]){
                            v["owner"].rotation = GameObject.DIR_V[(i-1+GameObject.DIR_V.length)%GameObject.DIR_V.length]
                            found = true;
                        }

                    }

                }
                break
            default:
                this.execute = (v) => {}
                break
        }


    }
    static convertObj(obj)
    {
        return new Effect(obj.id, obj.name, obj.description, obj.value, obj.cd,obj.is_shown,obj.id_event);
    }
    static convertJSON(obj)
    {
        return new Effect(obj._id, obj._name, obj._description, obj._value, obj._cd, obj._is_shown, obj._id_event);
    }

    get id() {
        return this._id;
    }

    get name() {
        return this._name;
    }

    get description() {
        return this._description;
    }

    get value() {
        return this._value;
    }

    get cd() {
        return this._cd;
    }

    get is_shown() {
        return this._is_shown;
    }

    get currCd() {
        return this._currCd;
    }

    get id_event()
    {
        return this._id_event;
    }

    //method
    isPassive(){
        return this.cd === 0;
    }
}
export class Type
{
    /**
     *@constructor
     * @param {number} id
     * @param {string} description
     * @param {int} spawn_rate
     * @param {string} color_bg
     * @param {string} color_bd
     * @param {boolean} have_max_health
     * **/
    constructor(id, description, spawn_rate, color_bg, color_bd,have_max_health)
    {
        this._id = id;
        this._description = description;
        this._spawn_rate = spawn_rate;
        this._color_bg = color_bg;
        this._color_bd = color_bd;
        this._have_max_health = have_max_health;
    }
    static convertObj(obj)
    {
        return new Type(obj.id, obj.description, obj.spawn_rate, obj.color_bg, obj.color_bd, obj.have_max_health);
    }
    static convertJSON(obj)
    {
        return new Type(obj._id, obj._description, obj._spawn_rate, obj._color_bg, obj._color_bd, obj._have_max_health);
    }

    get id() {
        return this._id;
    }
    get description() {
        return this._description;
    }
    get spawn_rate() {
        return this._spawn_rate;
    }
    get color_bg() {
        return this._color_bg;
    }
    get color_bd() {
        return this._color_bd;
    }
    get have_max_health() {
        return this._have_max_health;
    }
}
export class GameCell
{

    /**
     *@constructor
     * @param {HTMLElement} card
     * @param {GameObject} obj
     * **/
    constructor(card, obj)
    {
        this._card = card;
        this._obj = obj;
    }
    get card()
    {
        return this._card;
    }
    get obj()
    {
        return this._obj;
    }
    /**
     @param {GameObject} obj
     * **/
    set obj(obj)
    {
        this._obj = obj;
    }
    // Methods
    graphicUpdate(){
        //console.log(this._card.children);

        let elements = this._card.children;
        elements[0].innerHTML = this.obj.name + (this.obj.is_corroded ? " #" : "");
        elements[1].src = "assets/images/cards/" + this.obj.img;

        elements = elements[2].children;


        if(this.obj.health > 0){
            if(this.obj.getType().have_max_health){
                elements[0].innerHTML = "hp: " + this._obj.health +"/"+this.obj.max_health;
            }else{
                elements[0].innerHTML = "hp: " + this._obj.health;
            }
        }else{
            elements[0].innerHTML = "<br>";
        }
        //console.log(this._obj);

        if(this._obj.haveUses()){
            elements[1].innerHTML = "uses: " + this._obj.uses;
        }else{
            if(this.obj.haveShields()){
                if(this.obj.shields > 1){
                    elements[1].innerHTML = this.obj.shields +" x shields";
                }else{
                    elements[1].innerHTML = this.obj.shields +" x shield";
                }
            }else{
                if(this.obj.rotation !== null){
                    elements[1].innerHTML = "rotation: " + GameObject.DIR_STR[this.obj.rotation];
                }else{
                    elements[1].innerHTML = "<br>";
                }
            }

        }

        let type = this.getType();
        this.card.style.backgroundColor = type.color_bg;
        this.card.style.borderColor = type.color_bd;

    }
    graphicUpdatePlus(){
        //console.log(this.obj);
        this.graphicUpdate();
        let elements = this._card.children[2].children;
        if(this.obj.id_type === 1){
            elements[1].innerText = "";
            elements[2].innerText = "active: " + this.obj.active().name;
            elements[3].innerText = this.obj.active().description;
            elements[4].innerText = "passive: " + this.obj.passive().name;
            elements[5].innerText = this.obj.passive().description;
        }else{
            elements[2].innerText = "";
            elements[3].innerText = "";
            elements[4].innerText = "";
            elements[5].innerText = "";
            if(this.obj.havePassives()){
                elements[1].innerText = "";
                let passives = this.obj.getPassives();
                let s = "";
                for (let i = 0; i < passives.length; i++){
                    if(s.length !== 0){
                        s = s +", ";
                    }
                    if(passives[i].is_shown){
                        s = s + passives[i].description;
                    }
                }
                elements[3].innerText = s;
            }
        }
        /**/


    }
    getType(){
        return this.obj.getType();
    }
    click(){
        return this.obj.click();
    }
}