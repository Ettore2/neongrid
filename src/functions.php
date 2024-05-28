<?php
const EFFECTS = "effects";
const ID_SKINS = "id_skins";

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
    $objects = array();
    $sql = "select object.id,object.id_type,object.name,object.health,object.spawn_indicator,object.uses,object.max_health,object.id_original_img as id_curr_img
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
        $row["id_curr_img"] = (int)$row["id_curr_img"];
        $row[EFFECTS] = array();
        $row[ID_SKINS] = array();
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
                Array_push($objects[$i][EFFECTS],$row["id_effect"]);
                $found = true;
            }
        }

    }
    $sql = "select id,id_object 
            FROM skin";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null)
    {
        $row["id"] = (int)$row["id"];
        $row["id_object"] = (int)$row["id_object"];
        $found = false;
        for ($i = 0; $i < sizeof($objects) && !$found; $i++)
        {
            if($objects[$i]["id"] == $row["id_object"])
            {
                Array_push($objects[$i][ID_SKINS],$row["id"]);
                $found = true;
            }
        }

    }
    return $objects;
}//do not take heroes
function getHeroes(mysqli $connect):array
{
    //need the cast type (by default they are strings)
    $heroes = array();
    $sql = "select object.id,object.id_type,object.name,object.health,object.spawn_indicator,object.max_health,object.id_original_img as id_curr_img
            FROM object 
            where id_type = 1";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null) {
        $row["id"] = (int)$row["id"];
        $row["id_type"] = (int)$row["id_type"];
        $row["health"] = (int)$row["health"];
        $row["spawn_indicator"] = (int)$row["spawn_indicator"];
        $row["max_health"] = (int)$row["max_health"];
        $row["id_curr_img"] = (int)$row["id_curr_img"];
        $row[EFFECTS] = array();
        $row[ID_SKINS] = array();
        $heroes[] = $row;

    }


    $sql = "select * 
            FROM have_effect";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null) {
        $row["id"] = (int)$row["id"];
        $row["id_object"] = (int)$row["id_object"];
        $row["id_effect"] = (int)$row["id_effect"];
        $found = false;
        for ($i = 0; $i < sizeof($heroes) && !$found; $i++) {
            if ($heroes[$i]["id"] == $row["id_object"]) {
                Array_push($heroes[$i][EFFECTS], $row["id_effect"]);
                $found = true;
            }
        }
    }

    $sql = "select id,id_object 
            FROM skin";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null) {
        $row["id"] = (int)$row["id"];
        $row["id_object"] = (int)$row["id_object"];
        $found = false;
        for ($i = 0; $i < sizeof($heroes) && !$found; $i++) {
            if ($heroes[$i]["id"] == $row["id_object"]) {
                Array_push($heroes[$i][ID_SKINS], $row["id"]);
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
function getSkins(mysqli $connect, string $email): array
{
    //need the cast type (by default they are strings)
    $return = array();
    $sql = "select skin.id,price.value as price,img,have_skin.id as owned
            FROM skin
            left JOIN price on skin.id_price = price.id
            LEFT join have_skin on have_skin.id_skin = skin.id and have_skin.id_user = 
            (SELECT id FROM user WHERE email = ?);";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null){
        $row["id"] = (int)$row["id"];
        $row["price"] = (int)$row["price"];
        $row["owned"] = $row["owned"] != null ? true : false;
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

function getHeroById(mysqli $connect, int $id_hero): array
{
    //need the cast type (by default they are strings)
    $sql = "select object.id,object.id_type,object.name,object.health,object.spawn_indicator,object.max_health,object.id_original_img as id_curr_img
            FROM object 
            where id_type = 1 and object.id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i" ,$id_hero);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $row["id"] = (int)$row["id"];
    $row["id_type"] = (int)$row["id_type"];
    $row["health"] = (int)$row["health"];
    $row["spawn_indicator"] = (int)$row["spawn_indicator"];
    $row["max_health"] = (int)$row["max_health"];
    $row["id_curr_img"] = (int)$row["id_curr_img"];
    $row[EFFECTS] = array();
    $row[ID_SKINS] = array();

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
            Array_push($hero[EFFECTS],$row["id_effect"]);
        }
    }

    $sql = "select id,id_object 
            FROM skin";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while (($row = $result->fetch_assoc()) != null) {
        $row["id"] = (int)$row["id"];
        $row["id_object"] = (int)$row["id_object"];
        if ($hero["id"] == $row["id_object"]) {
            Array_push($hero[ID_SKINS], $row["id"]);
        }
    }

    return $hero;
}
function getSkinById(mysqli $connect, int $id_skin): array
{
    $sql = "select skin.id,skin.img,skin.id_object,price.value as price
    FROM skin
    join price on skin.id_price = price.id
    where skin.id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i" ,$id_skin);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $row["id"] = (int)$row["id"];
    $row["id_object"] = (int)$row["id_object"];
    $row["price"] = (int)$row["price"];
    return $row;
}
function getSkinPrice(mysqli $connect, int $id_skin): int
{
    //need the cast type (by default they are strings)
    $sql = "select price.value as price from skin JOIN price on skin.id_price = price.id where skin.id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i" ,$id_skin);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    return $result['price'];

}

function purchaseSkin(mysqli $connect, string $email, int $id_skin):bool
{
    CONN->begin_transaction();
    try {
        $coins = getCoins($connect, $email) - getSkinPrice($connect, $id_skin);
        if($coins >= 0){
            updateUserCoins($connect, $email, $coins);

            $id_user = getUserIdFromEmail($connect,$email);
            $sql = "INSERT INTO have_skin (id_user, id_skin) values (?,?)";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("ii", $id_user, $id_skin);
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

function getBestRun(mysqli $connect, int $id_user, int $id_version): false|array|null
{
    $sql = "
    SELECT * 
    FROM run
    WHERE 
    id_user = ?
    AND
    id_version = ?
    ORDER BY turns DESC
    LIMIT 1";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ii",$id_user,$id_version);
    $stmt->execute();
    $result = $stmt->get_result();
    return mysqli_fetch_assoc($result);
}

function getPositionRun(mysqli $connect, int $turns): int
{
    $sql = "SELECT COUNT(*) AS position FROM run
            WHERE turns > ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param('i',$turns);
    $stmt->execute();
    $result = $stmt->get_result();
    return (int)mysqli_fetch_assoc($result)['position'] + 1;
}
function getBestRunView(mysqli $connect, int $id_user, int $id_version): false|array|null
{
    $sql = "
            SELECT user.id as id, user.username as username,
            skin.img as img,
            object.name as name,
            run.turns as turns, run.coins as coins,run.duration as duration
            FROM run
            JOIN user ON
            run.id_user = user.id
            JOIN skin ON
            run.id_skin = skin.id
            join object on 
            skin.id_object = object.id
            WHERE id_user = ?
            AND
            id_version = ?
            ORDER BY turns DESC
            LIMIT 30";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ii",$id_user,$id_version);
    $stmt->execute();
    $result = $stmt->get_result();
    return mysqli_fetch_assoc($result);
}

function updateRun(mysqli $connect, int $id_skin, int $turns, int $coins, int $duration, int $id_version, int $idBest): void
{
    $sql = "
            UPDATE run 
            SET id_skin = ?, turns = ?, coins = ?, duration = ?, id_version = ?
            WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param('iiiiii',$id_skin,$turns,$coins,$duration,$id_version,$idBest);
    $stmt->execute();

}

function getRuns(mysqli $connect): false|mysqli_result
{
    $sql = "
            SELECT user.id as id, user.username as username,
            skin.img as img,
            object.name as name,
            run.turns as turns, run.coins as coins,run.duration as duration
            FROM run
            JOIN user ON
            run.id_user = user.id
            JOIN skin ON
            run.id_skin = skin.id
            join object on 
            skin.id_object = object.id
            ORDER BY turns DESC
            LIMIT 30";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    return $stmt->get_result();
}

function insertRun(mysqli $connect,int $id_user, int $id_skin, int $turns, int $coins, int $duration, int $id_version):void
{
    CONN->begin_transaction();
    try
    {
        $data = getBestRun($connect, $id_user, $id_version);
        if ($data !== FALSE && $data !== NULL)
        {
            if($data["turns"] <= $turns){
                // UPDATE THE BEST RUN
                updateRun($connect,$id_skin,$turns,$coins,$duration,$id_version,$data["id"]);
            }
        }
        else
        {
            // INSERT THE BEST RUN
            $sql = "
                    INSERT 
                    INTO run 
                    (id_user, id_skin, turns, coins, duration, id_version)
                    VALUES (?,?,?,?,?,?)
            ";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("iiiiii",$id_user,$id_skin,$turns,$coins,$duration,$id_version);
            $stmt->execute();
        }
        CONN->commit();
    }
    catch (Exception $e)
    {
        // Rollback on failure
        CONN->rollback();
        $_SESSION[SESSION_WARNING] = ERROR_COULD_NOT_UPDATE_RUN;
        consume_error();
    }
}

function getImgFromID(mysqli $connect, int $id): string
{
    $sql = "SELECT img FROM skin WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = mysqli_fetch_assoc($result);
    return (string)$result['img'];
}