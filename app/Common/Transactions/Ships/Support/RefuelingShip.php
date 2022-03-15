<?php
namespace App\Common\Transactions\Ships\Support;

class RefuelingShip extends BaseSupportShip{
  function refuelShip(BaseSupportShip $ship) {
    $ship->setFuel($ship->getFuel()+100);
    return "Refueling the ship";
  }
}