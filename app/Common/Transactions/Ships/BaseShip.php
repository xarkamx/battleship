<?php
namespace App\Common\Transactions\Ships;
class BaseShip {
  function setPosition($x, $y) {
    $this->x = $x;
    $this->y = $y;
    $this->nearestShip = null;
  }
  function setLifePoints($lifePoints) {
    return $this->life=$lifePoints;
  }
  function getLifePoints() {
    return $this->life;
  }
  function getPosition() {
    return array($this->x, $this->y);
  }
  function getName() {
    return $this->name;
  }
  function getType() {
    return $this->type;
  }
  function setType($type) {
    return $this->type=$type;
  }
  function setFuel($fuel) {
    return $this->fuel=$fuel;
  }
  function getFuel() {
    return $this->fuel;
  }
  function setNearestShip($nearestShip) {
    return $this->nearestShip=$nearestShip;
  }
  function getNearestShip() {
    return $this->nearestShip;
  }

}