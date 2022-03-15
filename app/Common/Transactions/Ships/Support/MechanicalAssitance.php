<?php
namespace App\Common\Transactions\Ships\Support;

use App\Common\Transactions\Ships\OffensiveShip;

class MechanicalAssitance extends BaseSupportShip{
  function increaseDamagePerGun(OffensiveShip $ship) {
    $ship->setDamagePerGun($ship->getDamagePerGun()+1);
    return "Increasing the damage per gun";
  }
}