import {GameCell, GameInstance, GameObject} from "./gameClasses.js";

const game = GameInstance.getInstance();
const turnsText = document.querySelector('#turns-text');
const coinsText = document.querySelector('#coins-text');
const hoverGameCell = new GameCell(document.getElementById('hover-card'),null);
//console.log(game.HEROES)
//console.log(game.OBJECTS)
//console.log(game.EFFECTS)
//console.log(game.TYPES)
let gameObjects = Array();
for(let i = 0; i < game.OBJECTS.length; i++)
{
    if(gameObjects[game.OBJECTS[i].id_type] === undefined){
        gameObjects[game.OBJECTS[i].id_type] = Array();
    }
    gameObjects[game.OBJECTS[i].id_type].push(game.OBJECTS[i]);
}
//console.log(gameObjects)
let hero = null;
{
    let heroId = parseInt(sessionStorage.getItem("curr_hero_id"));
    for (let i = 0; i < game.HEROES.length && hero === null; i++){
        if(heroId === game.HEROES[i].id)
        {
            hero = game.HEROES[i];
        }
    }
    //console.log(hero);
}//get playing hero

let playedTurns = 0;
let collectedCoins = 0;
let rows = 3, columns = 3;
let heroX = parseInt(columns/2), heroY = parseInt(rows/2);
let gameGrid = [];

const gameCards = document.querySelectorAll('.game-card');


document.querySelector('#hover-card').style.opacity = 0;
//initialize game cards
for (let i = 0; i < gameCards.length; i++)
{
    if(parseInt(i/columns) === 0){
        gameGrid.push([]);
    }
    gameCards[i].addEventListener('click', (e) =>
    {
        //console.log('Clicked');
    });
    gameCards[i].addEventListener('mouseover', (e) =>
    {

        //get the calling card
        //console.log(card);
        let classes = e.target.classList;
        //console.log(classes);
        let father = e.target;
        if (classes.contains('card-name') || classes.contains('card-img-top') || classes.contains("card-body"))
        {
            father = e.target.parentElement;
        }
        else if (!classes.contains("game-card"))
        {
            father = e.target.parentElement.parentElement;
        }
        let elements = father.children;

        //find the obj of the calling card
        let objTmp = null;
        for(let i = 0; i < gameGrid.length && objTmp === null; i++ ){
            for(let j = 0; j < gameGrid[i].length && objTmp === null; j++ ){
                if(gameGrid[i][j].card === father){
                    objTmp = gameGrid[i][j].obj;
                }
            }
        }

        //compile hover card
        hoverGameCell.obj = objTmp;
        hoverGameCell.graphicUpdatePlus();

        //change the visibility
        let card = document.querySelector('#hover-card');
        card.style.transitionDuration = "0.8s";
        card.style.opacity = 1;
    });
    gameCards[i].addEventListener('mouseleave', (e) =>
    {
        document.querySelector('#hover-card').style.transitionDuration = "0.5s";
        document.querySelector('#hover-card').style.opacity = 0;
    });
    if(i === parseInt((rows*columns-1)/2)){
        gameGrid[parseInt(i/columns)].push(new GameCell(gameCards[i],hero));
    }else {
        let tmp = new GameCell(gameCards[i],createNewObject());
        //console.log(tmp.obj);
        gameGrid[parseInt(i/columns)].push(tmp);
    }


}
//console.log(gameGrid);

graphicUpdate();




// quit btn logic
document.querySelector('#quit-btn').addEventListener('click', () =>
{
    //suicide the hero




});




function graphicUpdate()
{
    turnsText.innerText = playedTurns;
    coinsText.innerText = collectedCoins;

    for(let i = 0; i < gameGrid.length; i++){
        for(let j = 0; j < gameGrid[i].length; j++){
            gameGrid[i][j].graphicUpdate();
        }
    }


}
function createNewObject()
{
    //get the type
    let random = Math.floor(Math.random()*100+1);
    let sum = 0, type = null;
    //console.log("random: "+random);
    for (let i = 0; i < game.TYPES.length && type === null; i++){
        sum += game.TYPES[i].spawn_rate;
        //console.log("sum: "+sum);

        if(sum >= random){
            type = game.TYPES[i];
        }
    }

    //console.log('Type: '+type.id);
    //get probability
    let probability = 0;
    let objsOfChoice = gameObjects[type.id];
    //console.log(objsOfChoice);
    for(let i = 0; i < objsOfChoice.length; i++){
        probability += objsOfChoice[i].spawn_indicator;
    }

    //get the object
    random = Math.floor(Math.random()*probability+1);
    sum = 0;
    let winner = null;
    for (let i = 0; i < objsOfChoice.length && winner === null; i++){
        sum += objsOfChoice[i].spawn_indicator;

        if(sum >= random){
            winner = objsOfChoice[i];
        }
    }

    //console.log("return: "+winner);
    return winner;
}