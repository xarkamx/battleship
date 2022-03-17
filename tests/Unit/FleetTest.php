<?php

namespace Tests\Feature\Unit;

use App\Common\Helpers\Helpers;
use App\Common\Transactions\Ships\Fleet;
use App\Common\Transactions\Ships\Support\CargoShip;
use App\Common\Transactions\Ships\Support\MechanicalAssitance;
use App\Common\Transactions\Ships\Support\RefuelingShip;
use Tests\TestCase;

use function App\Common\Helpers\getNearestPoint;

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
        $helper = new Helpers();
        $fleet = $helper->generate_fleet();

        $this->assertEquals(25, count($fleet->getCombatShips()));
        $this->assertEquals(25, count($fleet->getSupportShips()));

    }

    public function test_pairShips(){
        $fleet = $this->pairShipsInFleet();
        $uniques = $this->has_dupes($fleet->getAllCoords());
        $this->assertEquals(0, $uniques);
    }

    function pairShipsInFleet(){
        $helper = new Helpers();
        $fleet = $helper->generate_fleet();
        return $fleet->combatPositions();
    }
    
    
    function has_dupes($points) {
        $dupe_array = [];
        foreach ($points as $val) {
            $val = implode(",", $val);
            if (isset($dupe_array[$val])) {
                return true;
            }
        }
        return false;
    }
}
