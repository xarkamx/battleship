<?php
namespace App\Common\Transactions\Ships;
class OffensiveShip extends BaseShip{
  function __construct()
  {
    $this->guns=0;
    $this->shields=0;
    $this->damagePerGun=0;
  }
  function attack() {
    $damage = $this->getTotalDamage();
    return "Attacking the target" + $damage;
  }

  function activateBarrier() {
    return "Activating the barrier";
  }
  function setGuns($guns) {
    $this->guns = $guns;
  }
  function getGuns() {
    return $this->guns;
  }
  function setDamagePerGun($damagePerGun=0) {
    $this->damagePerGun = $damagePerGun;
  }
  function getDamagePerGun() {
    return $this->damagePerGun;
  }
  function getTotalDamage() {
    return $this->getGuns()*$this->damagePerGun;
  }

}