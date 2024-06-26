import {GameInstance,GameObject} from "./gameClasses.js";
const game = GameInstance.getInstance()
const HEROES = game.HEROES;
const EFFECTS = game.EFFECTS;
const card1 = document.getElementById('hero-card-1');
const card2 = document.getElementById('hero-card-2');
const card3 = document.getElementById('hero-card-3');
const btn = document.getElementById('btn-play');
let heroIndex = -1
let val = parseInt(sessionStorage.getItem('curr_hero_id'));
for(let i = 0; i < HEROES.length && heroIndex === -1; i++){
    if(HEROES[i].id === val){
        heroIndex = i;
    }
}
//console.log(HEROES);
HEROES[heroIndex].id_curr_img = parseInt(sessionStorage.getItem('curr_skin_id'));
let divBtnsSkind = document.querySelector("#div-btns-skins");
let btnNextSkin = document.querySelector("#btn-next-skin");
let btnPrevSkin = document.querySelector("#btn-prev-skin");
btnNextSkin.addEventListener("click",()=>{
    HEROES[heroIndex].id_curr_img = (HEROES[heroIndex].id_curr_img+1)%HEROES[heroIndex].id_skins.length;
    updateCards();
});
btnPrevSkin.addEventListener("click",()=>{
    HEROES[heroIndex].id_curr_img = (HEROES[heroIndex].id_curr_img-1+HEROES[heroIndex].id_skins.length)%HEROES[heroIndex].id_skins.length;
    updateCards();
});
//console.log(parseInt(sessionStorage.getItem('curr_hero_id')));
//console.log(heroIndex);

document.getElementById("coins-text").innerText = game.coins;

//console.log(HEROES);
//console.log(EFFECTS);

document.getElementById('btn_next').addEventListener('click', () =>
{
    heroIndex = (heroIndex + 1) % HEROES.length;
    updateCards();
    console.log("btn_next")

});
document.getElementById('btn_previous').addEventListener('click', () =>
{
    console.log("btn_previous")
    heroIndex = (heroIndex + HEROES.length - 1) % HEROES.length;
    updateCards();

});
/**
 * @return {void} **/
function updateCards(){
    setCardAttribute(card1, HEROES[(heroIndex + HEROES.length - 1) % HEROES.length]);
    setCardAttribute(card2, HEROES[heroIndex]);
    setCardAttribute(card3, HEROES[(heroIndex + 1) % HEROES.length]);

    //console.log(HEROES[heroIndex].owned);

    let text = btn.children[0];
    let img  = btn.children[1];
    if(HEROES[heroIndex].isEnabled()){
        btn.disabled = false;
        if(HEROES[heroIndex].isUnlocked()){
            btnPrevSkin.style.visibility = "visible";
            btnNextSkin.style.visibility = "visible";
            btnPrevSkin.disabled = false;
            btnNextSkin.disabled = false;
        }else{
            text.style.margin = "auto 0 auto auto";
            btnPrevSkin.style.visibility = "hidden";
            btnNextSkin.style.visibility = "hidden";
            btnPrevSkin.disabled = true;
            btnNextSkin.disabled = true;
        }
        if(HEROES[heroIndex].getSkin().owned){
            //btn play
            text.innerText = 'Play';
            text.style.margin = "auto auto auto auto";
            btn.addEventListener('click', play);
            btn.removeEventListener('click', buy);
            btn.classList.toggle('animation-hover', true);
            btn.style.background = '#18f300';
            img.style.display = "none";

        }else{
            //btn buy
            text.innerText = HEROES[heroIndex].getSkin().price;
            btn.removeEventListener('click', play);
            btn.addEventListener('click', buy);
            img.style.display = "block";
            if(game.coins < HEROES[heroIndex].getSkin().price)
            {
                btn.classList.toggle('animation-hover', false);
                btn.style.background = '#FF0000';
                btn.disabled = true;
            }
            else
            {
                btn.classList.toggle('animation-hover', true);
                btn.style.background = '#18f300';
            }


        }
    }else{
        //btn disabled
        btn.disabled = true;
        text.innerText = 'disabled';
        btn.classList.toggle('animation-hover', false);
        btn.style.background = '#656565';
        img.style.display = "none";
    }
}
/**
 * @param {HTMLElement} card
 * @param {GameObject} hero
 **/
function setCardAttribute(card, hero){
    let elements = card.children;
    //console.log(elements);
    elements[0].innerHTML =  hero.name;
    elements[1].src = "assets/images/cards/" + hero.getImgStr();

    elements = elements[2].children;
    //console.log(elements);
    //console.log(hero.active());
    //console.log(hero);

    elements[0].innerHTML = "hp: " + hero.health;
    elements[1].innerHTML = "active: " + hero.active().name;
    elements[2].innerHTML = hero.active().description + ". cd: " + hero.active().cd;
    elements[3].innerHTML = "passive: " + hero.passive().name;
    elements[4].innerHTML = hero.passive().description;

}

function play()
{
    //console.log("play");
    btn.value = HEROES[heroIndex].id+";"+HEROES[heroIndex].id_curr_img;
    document.getElementById("form-btn").action = "game.php";
}

function buy() {
    //console.log('buy');

    /**  Algorithm of buy heroes.
     1. step: Check if the user has enough credits to buy the hero.
     1a. step: If he does proceed to the next point.
     1b. step: If he does not have enough credits show the user something or blocks the action.
     2. step: Do the purchase.

     **/

    if (game.coins < HEROES[heroIndex].getSkin().price)
        return;

    btn.value = HEROES[heroIndex].getSkin().id;
    document.getElementById("form-btn").action = "buy_hero.php";
}

updateCards();