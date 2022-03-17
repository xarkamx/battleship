<?php
  

  namespace App\Common\Helpers;

  
  class NearestNeighbor {
    function getNearestPoint($point, $ships)
  {
    $nearestPoint = null;
    $nearestDistance = null;
    foreach ($ships as $p) {
      if($p->getNearestShip()) continue;
      $distance = $this->getDistance($point, $p->getPosition());
      if ($nearestPoint == null || $distance < $nearestDistance) {
        $nearestPoint = $p;
        $nearestDistance = $distance;
      }
    }
    return $nearestPoint;
  }
  function getDistance($point, $point2)
  {
    return sqrt(pow($point[0] - $point2[0], 2) + pow($point[1] - $point2[1], 2));
  }
  }
  