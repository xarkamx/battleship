<?php
namespace App\Common\Helpers;
use App\Common\Transactions\Ships\Fleet;
use App\Common\Transactions\Ships\Support\BaseSupportShip;

class Helpers{
  

function generate_fleet($combatShips=25, $supportShips=25){
  $fleet = new Fleet();
  $x = $this->randomGen(0, 100,100);
  $y = $this->randomGen(0, 100,100);
  $coordIndex = 0;
  for($i=0; $i<$combatShips; $i++){
      $ship = new \App\Common\Transactions\Ships\OffensiveShip();
      $ship->setGuns(10);
      $ship->setDamagePerGun(10);
      $ship->setType("battleship");
      $ship->setPosition($x[$coordIndex],$y[$coordIndex]);
      $coordIndex++;
      $fleet->addOffensiveShip($ship);
  }
  for($i=0; $i<$supportShips; $i++){
      $ship = new BaseSupportShip();
      $ship->setPosition($x[$coordIndex],$y[$coordIndex]);
      $coordIndex++;
      $fleet->addSupportShip($ship);
  }
  return $fleet;
} 


    //https://stackoverflow.com/questions/17778723/generating-random-numbers-without-repeats
    function randomGen($min, $max, $quantity) {
      $numbers = range($min, $max);
      shuffle($numbers);
      return array_slice($numbers, 0, $quantity);
  }
}