<?php

namespace Tests\Feature\Unit;

use App\Common\Transactions\Ships\Fleet;
use App\Common\Transactions\Ships\Support\BaseSupportShip;
use App\Common\Transactions\Ships\Support\CargoShip;
use App\Common\Transactions\Ships\Support\MechanicalAssitance;
use App\Common\Transactions\Ships\Support\RefuelingShip;
use Tests\TestCase;

class FleetTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fleet_exists()
    {
        $fleet = new Fleet();
        $this->assertInstanceOf(Fleet::class, $fleet);
    }
    public function test_fleet_add_offensive_ship()
    {
        $fleet = new Fleet();
        $ship = new \App\Common\Transactions\Ships\OffensiveShip();
        $ship->setGuns(10);
        $ship->setDamagePerGun(10);
        $ship->setType("battleship");
        $fleet->addOffensiveShip($ship);
        $this->assertEquals(1, count($fleet->getCombatShips()));
        $this->assertEquals(10, $fleet->getCombatShips()[0]->getGuns());
    }
    public function test_fleet_add_support_ship()
    {
        $fleet = new Fleet();
        $refueling = new RefuelingShip();
        $mechanical = new MechanicalAssitance();
        $cargo= new CargoShip();
        $fleet->addSupportShip($refueling);
        $fleet->addSupportShip($mechanical);
        $fleet->addSupportShip($cargo);
        $this->assertEquals(3, count($fleet->getSupportShips()));
    }
    public function test_fleet_set_command_ship()
    {
        $fleet = new Fleet();
        $ship = new \App\Common\Transactions\Ships\OffensiveShip();
        $ship->setGuns(10);
        $ship->setDamagePerGun(10);
        $ship->setType("battleship");
        $fleet->setCommandShip($ship);
        $this->assertEquals(1, count($fleet->getCombatShips()));
        $this->assertEquals(10, $fleet->getCombatShips()[0]->getGuns());
        $this->assertEquals("command", $fleet->getCombatShips()[0]->getType());
    }

    public function test_generate_fleet()
    {
        $fleet = $this->generate_fleet();

        $this->assertEquals(25, count($fleet->getCombatShips()));
        $this->assertEquals(25, count($fleet->getSupportShips()));

    }


    public function generate_fleet($combatShips=25, $supportShips=25){
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
