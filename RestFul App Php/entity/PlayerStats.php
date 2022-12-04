<?php

class playerStats implements JsonSerializable {
    private $seasonID;
    private $seasonStart;
    private $seasonEnd;
    private $team;
    private $gamesPlayed;
    private $ppg;
    private $rpg;
    private $apg;
    private $totalMins;
    private $totalPoints;
    
    
    public function __construct($seasonID, $seasonStart, $seasonEnd, $team, $gamesPlayed, $ppg, $rpg, $apg, $totalMins, $totalPoints) {
        $this->seasonID = $seasonID;
        $this->seasonStart = $seasonStart;
        $this->seasonEnd = $seasonEnd;
        $this->team = $team;
        $this->gamesPlayed = $gamesPlayed;
        $this->ppg = $ppg;
        $this->rpg = $rpg;
        $this->apg = $apg;
        $this->totalMins = $totalMins;
        $this->totalPoints = $totalPoints;
    }

    public function getSeasonID() {
        return $this->seasonID;
    }

    public function getSeasonStart() {
        return $this->seasonStart;
    }
    
    public function getSeasonEnd() {
        return $this->seasonEnd;
    }

    public function getTeam() {
        return $this->team;
    }

    public function getGamesPlayed() {
        return $this->gamesPlayed;
    }

    public function getPpg() {
        return $this->ppg;
    }
    
    public function getRpg() {
        return $this->rpg;
    }
    
    public function getApg() {
        return $this->apg;
    }
    
    public function getTotalMins() {
        return $this->apg;
    }
    
    public function getTotalPoints() {
        return $this->apg;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
