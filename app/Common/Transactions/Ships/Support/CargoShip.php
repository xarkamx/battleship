<?php
namespace App\Common\Transactions\Ships\Support;
use App\Common\Transactions\Ships\OffensiveShip;

class CargoShip extends BaseSupportShip{
  function loadCargo(OffensiveShip $ship) {
    $ship->setGuns($ship->getGuns()+1);
    return "Loading the cargo";
  }
}