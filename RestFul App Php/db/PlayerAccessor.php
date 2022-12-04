<?php
require_once 'ConnectionManager.php';
require_once (__DIR__ . '/../entity/PlayerStats.php');
require_once (__DIR__ . '/../utils/ChromePhp.php');

class playerAccessor {

    private $getByIDStatementString = "select * from lebron where seasonID = :seasonID";
    private $deleteStatementString = "delete from lebron where seasonID = :seasonID";
    private $insertStatementString = "insert INTO lebron values (:seasonID, :seasonDateStart, :seasonDateEnd, :team, :gamesPlayed, :ppg, :rpg, :apg, :totalMins, :totalPoints)";
    private $updateStatementString = "update lebron set seasonDateStart = :seasonDateStart, seasonDateEnd = :seasonDateEnd, team = :team, gamesPlayed = :gamesPlayed, ppg = :ppg, rpg = :rpg, apg = :apg, totalMins = :totalMins, totalPoints = :totalPoints where seasonID = :seasonID";
    private $conn = NULL;
    private $getByIDStatement = NULL;
    private $deleteStatement = NULL;
    private $insertStatement = NULL;
    private $updateStatement = NULL;

    // Constructor will throw exception if there is a problem with ConnectionManager,
    // or with the prepared statements.
    public function __construct() {
        $cm = new ConnectionManager();

        $this->conn = $cm->connect_db();
        if (is_null($this->conn)) {
            throw new Exception("no connection");
        }
        $this->getByIDStatement = $this->conn->prepare($this->getByIDStatementString);
        if (is_null($this->getByIDStatement)) {
            throw new Exception("bad statement: '" . $this->getAllStatementString . "'");
        }

        $this->deleteStatement = $this->conn->prepare($this->deleteStatementString);
        if (is_null($this->deleteStatement)) {
            throw new Exception("bad statement: '" . $this->deleteStatementString . "'");
        }

        $this->insertStatement = $this->conn->prepare($this->insertStatementString);
        if (is_null($this->insertStatement)) {
            throw new Exception("bad statement: '" . $this->getAllStatementString . "'");
        }

        $this->updateStatement = $this->conn->prepare($this->updateStatementString);
        if (is_null($this->updateStatement)) {
            throw new Exception("bad statement: '" . $this->updateStatementString . "'");
        }
    }

    /**
     * Gets menu items by executing a SQL "select" statement. An empty array
     * is returned if there are no results, or if the query contains an error.
     * 
     * @param String $selectString a valid SQL "select" statement
     * @return array MenuItem objects
     */
    public function getItemsByQuery($selectString) {
        $result = [];

        try {
            $stmt = $this->conn->prepare($selectString);
            $stmt->execute();
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dbresults as $r) {
                $seasonID = $r['seasonID'];
                $seasonStart = $r['seasonDateStart'];
                $seasonEnd = $r['seasonDateEnd'];
                $team = $r['team'];
                $gamesPlayed = $r['gamesPlayed'];
                $ppg = $r['ppg'];
                $rpg = $r['rpg'];
                $apg = $r['apg'];
                $totalMins = $r['totalMins'];
                $totalPoints = $r['totalPoints'];
                
                $obj = new playerStats($seasonID,$seasonStart,$seasonEnd,$team,$gamesPlayed,$ppg,$rpg,$apg,$totalMins,$totalPoints);
                array_push($result, $obj);
            }
        }
        catch (Exception $e) {
            $result = [];
        }
        finally {
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
        }

        return $result;
    }

    /**
     * Gets all menu items.
     * 
     * @return array MenuItem objects, possibly empty
     */
    public function getAllItems() {
        return $this->getItemsByQuery("select * from lebron");
    }

    /**
     * Gets the menu item with the specified ID.
     * 
     * @param Integer $id the ID of the item to retrieve 
     * @return the MenuItem object with the specified ID, or NULL if not found
     */
    public function getItemByID($id) {
        $result = NULL;

        try {
            $this->getByIDStatement->bindParam(":itemID", $id);
            $this->getByIDStatement->execute();
            $dbresults = $this->getByIDStatement->fetch(PDO::FETCH_ASSOC); // not fetchAll

            if ($dbresults) {
                $itemID = $dbresults['itemID'];
                $itemCategoryID = $dbresults['itemCategoryID'];
                $description = $dbresults['description'];
                $price = $dbresults['price'];
                $vegetarian = $dbresults['vegetarian'];
                $result = new MenuItem($itemID, $itemCategoryID, $description, $price, $vegetarian);
            }
        }
        catch (Exception $e) {
            $result = NULL;
        }
        finally {
            if (!is_null($this->getByIDStatement)) {
                $this->getByIDStatement->closeCursor();
            }
        }

        return $result;
    }

    /**
     * Deletes a menu item.
     * @param MenuItem $item an object EQUAL TO the item to delete
     * @return boolean indicates whether the item was deleted
     */
    public function deleteItem($item) {
        $success;

         $seasonID = $item->getSeasonID(); // only the ID is needed

        try {
            $this->deleteStatement->bindParam(":seasonID", $seasonID);
            $success = $this->deleteStatement->execute();
        }
        catch (PDOException $e) {
            $success = false;
        }
        finally {
            if (!is_null($this->deleteStatement)) {
                $this->deleteStatement->closeCursor();
            }
            return $success;
        }
    }

    /**
     * Inserts a menu item into the database.
     * 
     * @param MenuItem $item an object of type MenuItem
     * @return boolean indicates if the item was inserted
     */
    public function insertItem($item) {
        $success;
         $seasonID = $item->getSeasonID();
         $seasonStart = $item->getSeasonStart();
         $seasonEnd = $item->getSeasonEnd();
         $team = $item->getTeam();
         $gamesPlayed = $item->getGamesPlayed();
         $ppg = $item->getPpg();
         $rpg = $item->getRpg();
         $apg = $item->getApg();
         $totalMins = $item->getTotalMins();
         $totalPoints = $item->getTotalPoints();

        try {
            $this->insertStatement->bindParam(":seasonID", $seasonID);
            $this->insertStatement->bindParam(":seasonDateStart", $seasonStart);
            $this->insertStatement->bindParam(":seasonDateEnd", $seasonEnd);
            $this->insertStatement->bindParam(":team", $team);
            $this->insertStatement->bindParam(":gamesPlayed", $gamesPlayed);
            $this->insertStatement->bindParam(":ppg", $ppg);
            $this->insertStatement->bindParam(":rpg", $rpg);
            $this->insertStatement->bindParam(":apg", $apg);
            $this->insertStatement->bindParam(":totalMins", $totalMins);
            $this->insertStatement->bindParam(":totalPoints", $totalPoints);
            $success = $this->insertStatement->execute();
        }
        catch (PDOException $e) {
            $success = false;
        }
        finally {
            if (!is_null($this->insertStatement)) {
                $this->insertStatement->closeCursor();
            }
            return $success;
        }
    }

    /**
     * Updates a menu item in the database.
     * 
     * @param MenuItem $item an object of type MenuItem, the new values to replace the database's current values
     * @return boolean indicates if the item was updated
     */
    public function updateItem($item) {
        $success;
        $seasonID = $item->getSeasonID();
        $seasonStart = $item->getSeasonStart();
        $seasonEnd = $item->getSeasonEnd();
        $team = $item->getTeam();
        $gamesPlayed = $item->getGamesPlayed();
        $ppg = $item->getPpg();
        $rpg = $item->getRpg();
        $apg = $item->getApg();
        $totalMins = $item->getTotalMins();
        $totalPoints = $item->getTotalPoints();
        try {
            $this->updateStatement->bindParam(":seasonID", $seasonID);
            $this->updateStatement->bindParam(":seasonDateStart", $seasonStart);
            $this->updateStatement->bindParam(":seasonDateEnd", $seasonEnd);
            $this->updateStatement->bindParam(":team", $team);
            $this->updateStatement->bindParam(":gamesPlayed", $gamesPlayed);
            $this->updateStatement->bindParam(":ppg", $ppg);
            $this->updateStatement->bindParam(":rpg", $rpg);
            $this->updateStatement->bindParam(":apg", $apg);
            $this->updateStatement->bindParam(":totalMins", $totalMins);
            $this->updateStatement->bindParam(":totalPoints", $totalPoints);
            $success = $this->updateStatement->execute();
        }
        catch (PDOException $e) {
            $success = false;
        }
        finally {
            if (!is_null($this->updateStatement)) {
                $this->updateStatement->closeCursor();
            }
            return $success;
        }
    }

}
// end class MenuItemAccessor
