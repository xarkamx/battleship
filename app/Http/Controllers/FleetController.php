<?php

namespace App\Http\Controllers;

use App\Common\Helpers\Helpers;
use App\Http\Resources\FleetResource;

class FleetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $helper = new Helpers();
        $fleet = $helper->generate_fleet();
        $fleet->combatPositions();
        return  FleetResource::collection($fleet->getShips());
    }
}
