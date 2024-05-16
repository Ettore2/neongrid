import {Effect, Hero, GameInstance} from "./gameClasses.js";
const game = GameInstance.getInstance()
const HEROES = game.HEROES;
const EFFECTS = game.EFFECTS;
const card1 = document.getElementById('hero-card-1');
const card2 = document.getElementById('hero-card-2');
const card3 = document.getElementById('hero-card-3');
const btn = document.getElementById('btn-play');
let heroIndex = 0;
document.getElementById("coins-text").innerText = game.COINS;

//console.log(HEROES);
//console.log(EFFECTS);


updateCards()

document.getElementById('btn_next').addEventListener('click', () =>
{
    heroIndex = (heroIndex + 1) % HEROES.length;
    updateCards();

});
document.getElementById('btn_previous').addEventListener('click', () =>
{
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
    if(HEROES[heroIndex].enabled){
        btn.disabled = false;
        if(HEROES[heroIndex].owned){
            //btn play
            text.innerText = 'Play';
            btn.addEventListener('click', play);
            btn.removeEventListener('click', buy);
            btn.classList.toggle('animation-hover', true);
            btn.style.background = '#18f300';
            img.style.display = "none";
        }else{
            //btn buy
            text.innerText = HEROES[heroIndex].price;
            btn.removeEventListener('click', play);
            btn.addEventListener('click', buy);
            img.style.display = "block";
            if(game.COINS < HEROES[heroIndex].price)
            {
                btn.classList.toggle('animation-hover', false);
                btn.style.background = '#FF0000';
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
 * @param {Hero} hero
 **/
function setCardAttribute(card, hero){
    let elements = card.children; //
    //console.log(elements);
    elements[0].innerHTML =  hero.name;
    elements[1].src = "assets/images/cards/" + hero.img;

    elements = elements[2].children;
    //console.log(elements);

    elements[0].innerHTML = "hp: " + hero.health;
    elements[1].innerHTML = "active: " + hero.active().name;
    elements[2].innerHTML = hero.active().description;
    elements[3].innerHTML = "passive: " + hero.passive().name;
    elements[4].innerHTML = hero.passive().description;

    //console.log(hero.active());
    //console.log(hero);
}

function play()
{
    //console.log("play");
    sessionStorage.setItem('hero',HEROES[heroIndex]);
}

function buy() {
    //console.log('buy');

    /** TODO: Algorithm of buy heroes.
     1. step: Check if the user has enough credits to buy the hero.
     1a. step: If he does proceed to the next point.
     1b. step: If he does not have enough credits show the user something or blocks the action.
     2. step: Do the purchase.

     **/

    if (game.COINS < HEROES[heroIndex].price) {
        console.log('Blocks');
        return;
    }
    console.log('Yay');
}