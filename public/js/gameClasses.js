export class GameInstance
{
    constructor() {
        this.HEROES = Array();
        this.EFFECTS = Array();
        this.COINS = 0;
    }
    static getInstance() {
        return this.#instance;
    }

    static #instance = new GameInstance();

}

export class Hero
{

    /**
     *@constructor
     * @param {number} id
     * @param {number} id_type
     * @param {string} name
     * @param {number} health
     * @param {string} img
     * @param {[Effect]} effects
     * @param {boolean} enabled
     * @param {boolean} owned
     * @param {number} price
     * **/
    constructor(id, id_type, name, health, img, effects, enabled, owned, price)
    {
        this._id = id;
        this._id_type = id_type;
        this._name = name;
        this._health = health;
        this._img = img;
        this._effects = effects;
        this._enabled = enabled;
        this._owned = owned;
        this._price = price;
    }
    static convertObj(obj)
    {
        return new Hero(obj.id, obj.id_type, obj.name, obj.health, obj.img, obj.effects, obj.enabled, obj.owned, obj.price);
    }
    static convertJSON(obj)
    {
        return new Hero(obj._id, obj._id_type, obj._name, obj._health, obj._img, obj._spawn_indicator, obj._effects);
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
    get enabled()
    {
        return this._enabled;
    }
    get owned()
    {
        return this._owned;
    }
    get price()
    {
        return this._price;
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
        // Provo a cercare  qualcosa
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
