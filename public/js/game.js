import {GameCell, GameInstance, GameObject} from "./gameClasses.js";

const game = GameInstance.getInstance();
const turnsText = document.querySelector('#turns-text');
const coinsText = document.querySelector('#coins-text');
const hoverGameCell = new GameCell(document.getElementById('hover-card'),null);
//console.log(game.HEROES)
//console.log(game.OBJECTS)
console.log(game.EFFECTS)
console.log("??????????????????????????")
//console.log(game.TYPES)
//console.log(gameObjects)
game.setPlayer(parseInt(sessionStorage.getItem("curr_hero_id")))
game.coins = 0;
game.gameCards = document.querySelectorAll('.game-card');
game.playerWeapon = new GameCell(document.querySelector('#weapon-card'),null);

document.querySelector('#hover-card').style.opacity = 0;
//initialize game cards
for (let i = 0; i < game.gameCards.length; i++)
{
    if(parseInt(i/game.columns) === 0){
        game.gameGrid.push([]);
    }
    game.gameCards[i].addEventListener('click', (e) =>
    {
        //console.log('Clicked');a//get who is clicked and if it is legal

        //get actors
        let obj = game.getCellByCard(getFather(e.target)).obj;
        if(obj.click()){
            game.playedTurns++;
            if(game.player.health === 0){
                game.player.die(obj)
            }

            for(let x = 0; x < game.gameGrid.length; x++){
                for(let y = 0; y < game.gameGrid[x].length; y++){
                    if(game.gameGrid[x][y].obj.is_corroded){
                        game.gameGrid[x][y].obj.takeSpecialDamage(1);
                        game.gameGrid[x][y].obj.executeEffects(7,this);//special damage taken
                    }
                }
            }

            for(let x = 0; x < game.gameGrid.length; x++){
                for(let y = 0; y < game.gameGrid[x].length; y++){
                    this.executeEffects(12,this);//normal turn end
                }
            }
            for(let x = 0; x < game.gameGrid.length; x++){
                for(let y = 0; y < game.gameGrid[x].length; y++){
                    this.executeEffects(13,this);//normal turn start
                }
            }
            for(let x = 0; x < game.gameGrid.length; x++){
                for(let y = 0; y < game.gameGrid[x].length; y++){
                    this.executeEffects(16,this);//normal turn play
                }
            }


            graphicUpdate()
        }

    });
    game.gameCards[i].addEventListener('mouseover', (e) =>
    {

        let card = getFather(e.target);
        let elements = card.children;

        //find the obj of the calling card
        let objTmp = null;
        for(let i = 0; i < game.gameGrid.length && objTmp === null; i++ ){
            for(let j = 0; j < game.gameGrid[i].length && objTmp === null; j++ ){
                if(game.gameGrid[i][j].card === card){
                    objTmp = game.gameGrid[i][j].obj;
                }
            }
        }

        //compile hover card
        hoverGameCell.obj = objTmp;
        hoverGameCell.graphicUpdatePlus();

        //change the visibility
        let cardHover = document.querySelector('#hover-card');
        cardHover.style.transitionDuration = "0.8s";
        cardHover.style.opacity = 1;
    });
    game.gameCards[i].addEventListener('mouseleave', (e) =>
    {
        document.querySelector('#hover-card').style.transitionDuration = "0.5s";
        document.querySelector('#hover-card').style.opacity = '0';
    });
    if(i === parseInt((game.rows*game.columns-1)/2)){
        game.gameGrid[parseInt(i%game.columns)].push(new GameCell(game.gameCards[i],game.player));
        //console.log(game.player);
    }else {
        let tmp = new GameCell(game.gameCards[i],createNewObject());
        //console.log(tmp.obj);
        game.gameGrid[parseInt(i%game.columns)].push(tmp);
    }


}
//console.log(gameGrid);

graphicUpdate();




// quit btn logic
document.querySelector('#quit-btn').addEventListener('click', () =>
{
    //suicide the hero
    game.player.killPlayer();



});




function graphicUpdate()
{
    turnsText.innerText = game.playedTurns;
    coinsText.innerText = game.coins;

    for(let i = 0; i < game.gameGrid.length; i++){
        for(let j = 0; j < game.gameGrid[i].length; j++){
            //console.log(game.gameGrid[i][j]);
            game.gameGrid[i][j].graphicUpdate();
        }
    }

    if(game.playerWeapon.obj === null){
        game.playerWeapon.card.style.opacity = '0';
    }else{
        game.playerWeapon.graphicUpdate();
        game.playerWeapon.card.style.opacity = '1';
    }


}
function createNewObject()
{
    return game.createNewObject();
}
/**
 * @param {HTMLElement} htmlElem
 * **/
function getFather(htmlElem){
    let classes = htmlElem.classList;
    //console.log(classes);
    let father = htmlElem;
    if (classes.contains('card-name') || classes.contains('card-img-top') || classes.contains("card-body"))
    {
        father = htmlElem.parentElement;
    }
    else if (!classes.contains("game-card"))
    {
        father = htmlElem.parentElement.parentElement;
    }
    return father;
}