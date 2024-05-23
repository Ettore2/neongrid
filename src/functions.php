<?php

function checkCredentials(mysqli $connect, string $email, string $password):bool
{
    if(!isset($email) || !isset($password)){
        return false;
    }

    $stmt = $connect->prepare("SELECT password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result)) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];
        if (password_verify($password, $hashedPassword)) {
            return true;
        }
    }
    return false;
}


function checkIfUserExists(mysqli $connect, string $email):bool
{
    $stmt = $connect->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return mysqli_num_rows($result);
}

function getHashedPasswordFromEmail(mysqli $connect, string $email):string
{
    $stmt = $connect->prepare("SELECT password from user WHERE email = ?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);
    return $row['password'];
}

function insertUser(mysqli $connect,string $username,string $password,string $email): void
{
    $stmt = $connect->prepare("INSERT INTO user (username,password, email) values(?,?,?)");
    $stmt->bind_param("sss",$username,$password,$email);
    $stmt->execute();
    $stmt->close();
}

function getUserIdFromEmail(mysqli $connect, string $email):int
{
    $sql = "SELECT id FROM user WHERE email = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);
    return $row["id"];
}

function getObjects(mysqli $connect):array
{
    //need the cast type (by default they are strings)
    $effects_field = "effects";
    $objects = array();
    $sql = "select object.id,object.id_type,object.name,object.health,object.img,object.spawn_indicator,object.uses,object.max_health
            FROM object where id_type != 1";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null)
    {
        $row["id"] = (int)$row["id"];
        $row["id_type"] = (int)$row["id_type"];
        $row["health"] = (int)$row["health"];
        $row["spawn_indicator"] = (int)$row["spawn_indicator"];
        $row["uses"] = (int)$row["uses"];
        $row["max_health"] = (int)$row["max_health"];
        $row[$effects_field] = array();
        $objects[] = $row;
    }

    $sql = "select * 
            FROM have_effect";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null)
    {
        $row["id"] = (int)$row["id"];
        $row["id_object"] = (int)$row["id_object"];
        $row["id_effect"] = (int)$row["id_effect"];
        $found = false;
        for ($i = 0; $i < sizeof($objects) && !$found; $i++)
        {
            if($objects[$i]["id"] == $row["id_object"])
            {
                Array_push($objects[$i][$effects_field],$row["id_effect"]);
                $found = true;
            }
        }

    }



    return $objects;
}//do not take heroes
function getHeroes(mysqli $connect, $email):array
{
    //need the cast type (by default they are strings)
    $effects_field = "effects";
    $heroes = array();
    $sql = "select object.id,object.id_type,object.name,object.health,object.img,object.spawn_indicator,value as price, have_hero.id as owned, object.max_health
            FROM object 
            join type on object.id_type = type.id
            join price on price.id = object.id_price
            left join user on 1 left JOIN have_hero on object.id = have_hero.id_hero and user.id = have_hero.id_user
            where type.description = 'hero' and user.email = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null)
    {
        //echo("<p>".$row["id"]."</p>");
        //echo("<p>".($row["owned"] == null ? "true" : "false")."</p>");
        //var_dump($row["owned"] == null);
        $row[$effects_field] = array();
        $row["id"] = (int)$row["id"];
        $row["id_type"] = (int)$row["id_type"];
        $row["health"] = (int)$row["health"];
        $row["spawn_indicator"] = (int)$row["spawn_indicator"];
        $row["price"] = (int)$row["price"];
        $row["owned"] = $row["owned"] !== null;
        $row["max_health"] = (int)$row["max_health"];
        $heroes[] = $row;

    }



    $sql = "select * 
            FROM have_effect";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null)
    {
        $row["id"] = (int)$row["id"];
        $row["id_object"] = (int)$row["id_object"];
        $row["id_effect"] = (int)$row["id_effect"];
        $found = false;
        for ($i = 0; $i < sizeof($heroes) && !$found; $i++)
        {
            if($heroes[$i]["id"] == $row["id_object"])
            {
                Array_push($heroes[$i][$effects_field],$row["id_effect"]);
                $found = true;
            }
        }
    }

    return $heroes;
}
function getEffects(mysqli $connect): array
{
    //need the cast type (by default they are strings)
    $return = array();
    $sql = "select * 
            FROM effect";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null){
        $row["id"] = (int)$row["id"];
        $row["value"] = (int)$row["value"];
        $row["cd"] = (int)$row["cd"];
        $row["is_shown"] = $row["is_shown"]===1;
        $row["id_event"] = (int)$row["id_event"];
        $return[] = $row;
    }

    return $return;
}
function getTypes(mysqli $connect): array
{
    //need the cast type (by default they are strings)
    $return = array();
    $sql = "select * 
            FROM type";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null){
        $row["id"] = (int)$row["id"];
        $row["spawn_rate"] = (int)$row["spawn_rate"];
        $row["have_max_health"] = $row["have_max_health"] === 1;
        $return[] = $row;
    }

    return $return;
}
function getCoins(mysqli $connect, string $email): int
{
    $sql = "SELECT coins FROM user WHERE email = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = mysqli_fetch_assoc($result);
    return (int)$result['coins'];
}
function getPrices(mysqli $connect):array
{
    $return = array();
    $sql = "SELECT id, value as price FROM price";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null)
    {
        $row["id"] = (int)$row["id"];
        $row["price"] = (int)$row["price"];
        $return[] = $row;
    }
    return $return;
}

function getHeroById(mysqli $connect, string $email, int $id_hero): array
{
    //need the cast type (by default they are strings)
    $effects_field = "effects";
    $sql = "select object.id,object.id_type,object.name,object.health,object.img,object.spawn_indicator,value as price, have_hero.id as owned, object.max_health
            FROM object 
            join type on object.id_type = type.id
            join price on price.id = object.id_price
            left join user on 1 left JOIN have_hero on object.id = have_hero.id_hero and user.id = have_hero.id_user
            where type.description = 'hero' and user.email = ? and object.id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("si", $email,$id_hero);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $row[$effects_field] = array();
    $row["id"] = (int)$row["id"];
    $row["id_type"] = (int)$row["id_type"];
    $row["health"] = (int)$row["health"];
    $row["spawn_indicator"] = (int)$row["spawn_indicator"];
    $row["price"] = (int)$row["price"];
    $row["owned"] = $row["owned"] !== null;
    $row["max_health"] = (int)$row["max_health"];

    $hero = $row;




    $sql = "select * 
            FROM have_effect";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null)
    {
        $row["id"] = (int)$row["id"];
        $row["id_object"] = (int)$row["id_object"];
        $row["id_effect"] = (int)$row["id_effect"];
        if($hero["id"] == $row["id_object"])
        {
            Array_push($hero[$effects_field],$row["id_effect"]);
        }
    }

    return $hero;
}

function purchaseHero(mysqli $connect, string $email, int $id_hero):bool
{
    CONN->begin_transaction();
    try {
        $coins = getCoins($connect, $email) - getHeroById($connect, $email, $id_hero)["price"];
        if($coins >= 0){
            updateUserCoins($connect, $email, $coins);

            $id_user = getUserIdFromEmail($connect,$email);
            $sql = "INSERT INTO have_hero (id_user, id_hero) values (?,?)";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("ii", $id_user, $id_hero);
            $stmt->execute();

            // Commit transaction
            CONN->commit();
        }else{

            // Commit transaction
            CONN->commit();
            return false;
        }

    } catch (Exception $e) {
        // Rollback on failure
        CONN->rollback();
        $_SESSION[SESSION_WARNING] = ERROR_COULD_NOT_BUY_ITEM;

        return false;


    }

    return true;

}
function updateUserCoins(mysqli $connect, string $email,int $coins):void
{
    $sql = "UPDATE user SET coins = ? WHERE email = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("is", $coins, $email);
    $stmt->execute();
}

function getLatestVersion(mysqli $connect):array
{
    $sql = "SELECT MAX(id) as id, description FROM version ";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);
    $arr = array();
    $arr['id'] = $row['id'];
    $arr['description'] = $row['description'];
    return $arr;
}

function getBestRun(mysqli $connect, string $email)
{
    $sql = "SELECT * FROM run ORDER BY turns LIMIT 1";
}