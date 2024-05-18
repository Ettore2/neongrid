export class GameInstance
{
    constructor() {
        this.HEROES = Array();
        this.OBJECTS = Array();
        this.EFFECTS = Array();
        this.TYPES = Array();
        this.COINS = 0;
    }
    static getInstance() {
        return this.#instance;
    }

    static #instance = new GameInstance();

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
     * @param {[Effect]} effects
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
    // Methods
    isEnabled()
    {
        return this._spawn_indicator > 0;
    }
    getType(){
        let types = GameInstance.getInstance().TYPES;

        for(let i = 0; i < types.length; i++){
            if(this.id_type === types[i].id){
                return types[i];
            }
        }
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
    // Method

    active ()
    {
        let EFFECTS = GameInstance.getInstance().EFFECTS;

        for(let i = 0; i < EFFECTS.length; i++){
            for(let j = 0; j < this.effects.length; j++){
                if(EFFECTS[i].id === this.effects[j] && EFFECTS[i].cd !== 0){
                    return EFFECTS[i];
                }
            }
        }

        console.log("null a")
        return null;
    }
    passive ()
    {
        let EFFECTS = GameInstance.getInstance().EFFECTS;

        for(let i = 0; i < EFFECTS.length; i++){
            for(let j = 0; j < this.effects.length; j++){
                if(EFFECTS[i].id === this.effects[j] && EFFECTS[i].cd === 0){
                    return EFFECTS[i];
                }
            }
        }

        console.log("null p")
        return null;
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
     * **/
    constructor(id, description, spawn_rate, color_bg, color_bd)
    {
        this._id = id;
        this._description = description;
        this._spawn_rate = spawn_rate;
        this._color_bg = color_bg;
        this._color_bd = color_bd;
    }
    static convertObj(obj)
    {
        return new Type(obj.id, obj.description, obj.spawn_rate, obj.color_bg, obj.color_bd);
    }
    static convertJSON(obj)
    {
        return new Type(obj._id, obj._description, obj._spawn_rate, obj._color_bg, obj._color_bd);
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
        elements[0].innerHTML =  this._obj.name;
        elements[1].src = "assets/images/cards/" + this._obj.img;

        elements = elements[2].children;


        elements[0].innerHTML = "hp: " + this._obj.health;

        if(this._obj.uses !== undefined && this._obj.uses !== 0){
            elements[1].innerHTML = "uses: " + this._obj.uses;
        }else{
            elements[1].innerHTML = "uses: ";
        }

        let type = this.getType();
        this.card.style.backgroundColor = type.color_bg;
        this.card.style.borderColor = type.color_bd;

    }
    getType(){
        return this.obj.getType();
    }

}
