<?php
namespace App\Common\Transactions\Ships\Support;
use App\Common\Transactions\Ships\BaseShip;


class BaseSupportShip extends BaseShip{
  function healShip(BaseShip $ship) {
    $ship->setLifePoints($ship->getLifePoints()+100);
    return "Healing the ship";
  }
}
