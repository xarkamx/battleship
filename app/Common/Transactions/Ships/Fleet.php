<?php
namespace App\Common\Transactions\Ships;

use App\Common\Transactions\Ships\Support\BaseSupportShip;
use Exception;

class Fleet{
  function __construct()
  {
    $this->combatShips = array();
    $this->supportShips = array();

  }

  function addOffensiveShip(OffensiveShip $ship) {
    $this->combatShips[] = $ship;
  }

  function addSupportShip(BaseSupportShip $ship) {
    $this->supportShips[] = $ship;
  }

  function setCommandShip(OffensiveShip $ship) {
    $ship->setType("command");
    $hasCommander = array_filter($this->combatShips, function ($ship) {
      return $ship->getType() === "command";
    });
    if(count($hasCommander) > 0) {
      throw new Exception("There is already a commander in the fleet");
    }
    $this->combatShips[] = $ship;
  }
  function getCombatShips() {
    return $this->combatShips;
  }
  function getSupportShips() {
    return $this->supportShips;
  }
  function getCommandShip() {
    return array_filter($this->combatShips, function ($ship) {
      return $ship->getType() === "command";
    });
  }
  function getShips() {
    return array_merge($this->combatShips, $this->supportShips);
  }

  function pairShipsByDistanceBetween(){

  }
  function getNearestShip($ship){
    $position = $ship->getPosition();
    $ships = $this->getShips();
    $nearestShip = null;
    $nearestDistance = null;
    foreach($ships as $otherShip) {
      if($otherShip === $ship) {
        continue;
      }
      // calculate hipotenuse
      $distance = sqrt(pow($position[0] - $otherShip->getPosition()[0], 2) + pow($position[1] - $otherShip->getPosition()[1], 2));
      if($nearestDistance === null || $distance < $nearestDistance) {
        $nearestDistance = $distance;
        $nearestShip = $otherShip;
      }
    }
    return $nearestShip;
  }


}