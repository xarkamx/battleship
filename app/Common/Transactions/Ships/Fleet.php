<?php

namespace App\Common\Transactions\Ships;

use App\Common\Helpers\NearestNeighbor;
use App\Common\Transactions\Ships\Support\BaseSupportShip;
use Exception;

/**
 * Class Fleet
 * @package App\Common\Transactions\Ships
 */
class Fleet
{

  function __construct()
  {
    $this->combatShips = array();
    $this->supportShips = array();
  }
  /**
   *  Add offensive ship to fleet
   *  @param OffensiveShip $ship
   *  @return void
   */
  function addOffensiveShip(OffensiveShip $ship)
  {
    $this->combatShips[] = $ship;
  }
  /**
   *  Add support ship to fleet
   *  @param SupportShip $ship
   *  @return void
   */
  function addSupportShip(BaseSupportShip $ship)
  {
    $this->supportShips[] = $ship;
  }
  /**
   *  Set command ship
   *  @param OffensiveShip $ship
   *  @return void
   */
  function setCommandShip(OffensiveShip $ship)
  {
    $ship->setType("command");
    $hasCommander = array_filter($this->combatShips, function ($ship) {
      return $ship->getType() === "command";
    });
    if (count($hasCommander) > 0) {
      throw new Exception("There is already a commander in the fleet");
    }
    $this->combatShips[] = $ship;
  }
  /**
   *  Get all ships
   *  @return array
   */
  function getCombatShips()
  {
    return $this->combatShips;
  }
  /**
   *  Get all support ships
   *  @return array
   */
  function getSupportShips()
  {
    return $this->supportShips;
  }
  /**
   *  Get all ships
   *  @return array
   */
  function getCommandShip()
  {
    return array_filter($this->combatShips, function ($ship) {
      return $ship->getType() === "command";
    });
  }
  /**
   *  Get all ships
   *  @return array
   */
  function getShips()
  {
    return array_merge($this->combatShips, $this->supportShips);
  }
  /**
   *  Get all ships
   *  @return array
   */
  function getAllCoords()
  {
    $coords = array();
    foreach ($this->getShips() as $ship) {
      $coords[] = $ship->getPosition();
    }
    return $coords;
  }
  /**
   *  Get all ships
   *  @return array
   */
  function getNearestShip($ship)
  {
    $position = $ship->getPosition();
    $ships = $this->getShips();
    $nearestShip = null;
    $nearestDistance = null;
    foreach ($ships as $otherShip) {
      if ($otherShip === $ship) {
        continue;
      }
      // calculate hipotenuse
      $distance = sqrt(pow($position[0] - $otherShip->getPosition()[0], 2) + pow($position[1] - $otherShip->getPosition()[1], 2));
      if ($nearestDistance === null || $distance < $nearestDistance) {
        $nearestDistance = $distance;
        $nearestShip = $otherShip;
      }
    }
    return $nearestShip;
  }
  /**
   *  Get all ships
   *  @return Fleet
   */
  function combatPositions()
  {
    $combatShips = $this->getCombatShips();
    $supportShips = $this->getSupportShips();
    $nearestHelper = new NearestNeighbor();

    $combatShips = array_map(function ($ship) use ($supportShips, $nearestHelper) {
      $supportShip = $nearestHelper->getNearestPoint($ship->getPosition(), $supportShips);
      $ship->setNearestShip($supportShip);
      $supportShip->setNearestShip($ship);
      return $ship;
    }, $combatShips);

    $this->edgeContraction($combatShips);
    $coords = $this->getAllCoords();
    usort($coords, function ($a, $b) {
      return $a[0] - $b[0];
    });
    return $this;
  }
  /**
   *  Get all ships
   *  @return array
   */
  function edgeContraction($ships)
  {
    $edgeCords = [];

    foreach ($ships as $ship) {
      $ship1 = $ship;
      $ship2 = $ship->getNearestShip();
      $midPoint = $this->getMidPoint($ship1->getPosition(), $ship2->getPosition());
      $pair = $this->getNearestAvailablePair($midPoint, $ships);
      $edgeCords = [$pair[0], $pair[1], ...$edgeCords];
      $ship1->setPosition(...$pair[0]);
      $ship2->setPosition(...$pair[1]);
    }

    return [$edgeCords];
  }

  /**
   *  Get all ships
   *  @return array
   */
  function getNearestAvailablePair($midPoint, $points)
  {
    $point1 = $midPoint;
    $point2 = [$point1[0] + 1, $point1[1]];
    if (!in_array([$point1, $point2], $points)) {
      return [$point1, $point2];
    }
    return $this->getNearestAvailablePair($point2, $points);
  }

  /**
   *  Get all ships
   *  @return array
   */
  function getMidPoint($point1, $point2)
  {
    $x = floor(($point1[0] + $point2[0]) / 2);
    $y = floor(($point1[1] + $point2[1]) / 2);
    return [$x, $y];
  }
}
