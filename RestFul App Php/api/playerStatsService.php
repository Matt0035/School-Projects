<?php

require_once (__DIR__ . '/../db/PlayerAccessor.php');
require_once (__DIR__ . '/../entity/PlayerStats.php');
require_once (__DIR__ . '/../utils/ChromePhp.php');

/*
 * Important Note:
 * 
 * Even if the method is not GET, the $_GET array will still contain the item ID. 
 * Why? Because the router (.htaccess) converts the URL from 
 *     menuService/items/N
 * to
 *     menuService.php?itemid=N
 * The syntax "?key=value" is interpreted as a GET parameter and is therefore
 * stored in the $_GET array.
 */

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {
    doGet();
} else if ($method === "POST") {
    doPost();
} else if ($method === "DELETE") {
    doDelete();
} else if ($method === "PUT") {
    doPut();
}

function doGet() {
    // individual
    if (isset($_GET['itemid'])) { 
        // Individual gets not implemented.
        ChromePhp::log("Sorry, individual gets not allowed!");
    }
    // collection
    else {
        try {
            $mia = new playerAccessor();
            $results = $mia->getAllItems();
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    }
}

function doDelete() {
    if (isset($_GET['seasonID'])) { 
        $seasonID = $_GET['seasonID']; 
        $playerStatsService = new playerStats($seasonID, "dummyCat", "dummyDesc","mdjnd", 1, 0, 0,0,0,0);
        // delete the object from DB
        $mia = new playerAccessor();
        $success = $mia->deleteItem($playerStatsService);
        echo $success;
    } else {
        // Bulk deletes not implemented.
        ChromePhp::log("Sorry, bulk deletes not allowed!");
    }
}

// aka CREATE
function doPost() {
    if (isset($_GET['seasonID'])) { 
        // The details of the item to insert will be in the request body.
        $body = file_get_contents('php://input');
        $contents = json_decode($body, true);

        // create a MenuItem object
        $playerStatsObj = new playerStats($contents['seasonID'], $contents['seasonStart'], $contents['seasonEnd'], $contents['team'], $contents['gamesPlayed'], $contents['ppg'], $contents['rpg'], $contents['apg'], $contents['totalMins'], $contents['totalPoints']);

        // add the object to DB
        //ChromePhp::log($playerStatsObj);
        $mia = new playerAccessor();
        $success = $mia->insertItem($playerStatsObj);
        echo $success;
    } else {
        // Bulk inserts not implemented.
        ChromePhp::log("Sorry, bulk inserts not allowed!");
    }
}

// aka UPDATE
function doPut() {
    if (isset($_GET['seasonID'])) { 
        // The details of the item to update will be in the request body.
        $body = file_get_contents('php://input');
        $contents = json_decode($body, true);

        // create a MenuItem object
        $playerStatsObj = new playerStats($contents['seasonID'], $contents['seasonStart'], $contents['seasonEnd'], $contents['team'], $contents['gamesPlayed'], $contents['ppg'], $contents['rpg'], $contents['apg'], $contents['totalMins'], $contents['totalPoints']);

        // update the object in the  DB
        $mia = new playerAccessor();
        $success = $mia->updateItem($playerStatsObj);
        echo $success;
    } else {
        // Bulk updates not implemented.
        ChromePhp::log("Sorry, bulk updates not allowed!");
    }
}
