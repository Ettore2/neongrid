export class GameInstance
{
    constructor() {
        this.HEROES = Array();//normal
        this.OBJECTS = Array();//normal
        this.EFFECTS = Array();//key val
        this.TYPES = Array();//normal
        this.COINS = 0;
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

    initializeHeroes(obj)
    {
        //get heroes
        for(let i = 0; i < obj.length; i++)
        {
            this.HEROES.push(Hero.convertObj(obj[i]));
        }
    }
    initializeObjects(obj)
    {
        for(let i = 0; i < obj.length; i++)
        {
            this.OBJECTS.push(GameObject.convertObj(obj[i]));
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

}

export class GameObject
{

    /**
     *@constructor
     * @param {number} id
     * @param {number} id_type
     * @param {string} name
     * @param {number} health
     * @param {string} img
     * @param {[int]} effects
     * @param {int} spawn_indicator
     * @param {boolean} owned
     * @param {number} price
     * @param {int} uses
     * **/
    constructor(id, id_type, name, health, img, effects, spawn_indicator, owned, price, uses)
    {
        this._id = id;
        this._id_type = id_type;
        this._name = name;
        this._health = health;
        this._img = img;
        this._effects = effects;
        this._spawn_indicator = spawn_indicator;
        this._owned = owned;
        this._price = price;
        this._uses = uses;

        this._shields = 0;
        this._maxHealth;

        if(id_type === 1 || id_type === 2){
            this._maxHealth = health;
        }else{
            this._maxHealth = -1;
        }
    }
    static convertObj(obj)
    {
        return new GameObject(obj.id, obj.id_type, obj.name, obj.health, obj.img, obj.effects, obj.spawn_indicator, obj.owned, obj.price, obj.uses);
    }
    static convertJSON(obj)
    {
        return new GameObject(obj._id, obj._id_type, obj._name, obj._health, obj._img, obj._effects, obj._spawn_indicator, obj._owned, obj._price, obj._uses);
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
    get maxHealth()
    {
        return this._maxHealth;
    }
    get shields()
    {
        return this._shields;
    }
    set shields(shields)
    {
        this._shields = shields;
    }
    // Methods
    isEnabled()
    {
        return this._spawn_indicator > 0;
    }

    // Method
    active ()
    {
        let EFFECTS = GameInstance.getInstance().EFFECTS;

        for(let i = 0; i < this.effects.length; i++){
            if(EFFECTS[this.effects[i]].cd !== 0){
                return EFFECTS[this.effects[i]];
            }
        }

        return null;
    }
    passive ()
    {
        let EFFECTS = GameInstance.getInstance().EFFECTS;

        for(let i = 0; i < this.effects.length; i++){
            if(EFFECTS[this.effects[i]].cd === 0){
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
        return this.maxHealth > this.health || !this.getType().have_max_health;
    }
    heal(val){
        this.health += val;
        if(this.health > this.maxHealth && this.getType().have_max_health){
            this.health = this.maxHealth
        }
    }
    haveUses(){
        return this.uses !== undefined && this.uses !== 0;
    }
    getPassives(){
        let game = GameInstance.getInstance();
        let result = Array();
        for(let i = 0; i < this.effects.length; i++){
            if(game.EFFECTS[this.effects[i]].cd === 0){
                result.push(game.EFFECTS[this.effects[i]]);
            }
        }
        return result;
    }
    havePassives(){
        let game = GameInstance.getInstance();
        for(let i = 0; i < this.effects.length; i++){
            if(game.EFFECTS[this.effects[i]].cd === 0){
                return true;
            }
        }
        return false;
    }
    haveShields(){
        return this.shields > 0;
    }

}
export class Hero extends GameObject
{
    /**
     *@constructor
     * @param {number} id
     * @param {number} id_type
     * @param {string} name
     * @param {number} health
     * @param {string} img
     * @param {[Effect]} effects
     * @param {int} spawn_indicator
     * @param {boolean} owned
     * @param {number} price
     * **/
    constructor(id, id_type, name, health, img, effects, spawn_indicator, owned, price)
    {
        super(id, id_type, name, health, img, effects, spawn_indicator, owned, price,0);
        this._uses = 0;
    }
    static convertObj(obj)
    {
        return new Hero(obj.id, obj.id_type, obj.name, obj.health, obj.img, obj.effects, obj.spawn_indicator, obj.owned, obj.price);
    }
    static convertJSON(obj)
    {
        return new Hero(obj._id, obj._id_type, obj._name, obj._health, obj._img, obj._effects, obj._spawn_indicator, obj._owned, obj._price);
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
     * **/
    constructor(id, name, description, value, cd)
    {
        this._id = id;
        this._name = name;
        this._description = description;
        this._value = value;
        this._cd = cd;
        this._currCd = cd;
    }
    static convertObj(obj)
    {
        return new Effect(obj.id, obj.name, obj.description, obj.value, obj.cd);
    }
    static convertJSON(obj)
    {
        return new Effect(obj._id, obj._name, obj._description, obj._value, obj._cd);
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

    get currCd() {
        return this._currCd;
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
        elements[0].innerHTML =  this.obj.name;
        elements[1].src = "assets/images/cards/" + this.obj.img;

        elements = elements[2].children;


        if(this.obj.getType().have_max_health){
            elements[0].innerHTML = "hp: " + this._obj.health +"/"+this.obj.maxHealth;
        }else{
            elements[0].innerHTML = "hp: " + this._obj.health;
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
                elements[1].innerHTML = "<br>";
            }

        }

        let type = this.getType();
        this.card.style.backgroundColor = type.color_bg;
        this.card.style.borderColor = type.color_bd;

    }
    graphicUpdatePlus(){
        console.log(this.obj);
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
                    if(i !== 0){
                        s = s +", ";
                    }
                    s = s + passives[i].description;
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
        switch (this.obj.getType().id){

        }
    }

}
