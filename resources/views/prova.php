<?php

public function scopeCloseTo($query, $location, $radius = 25)
{
    /**
     * In order for this to work correctly, you need a $location object
     * with a ->latitude and ->longitude.
     */
    $haversine = "(6371 * acos(cos(radians($location->latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($location->longitude)) + sin(radians($location->latitude)) * sin(radians(latitude))))";
    return $query
        ->select(['comma','separated','list','of','your','columns'])
        ->selectRaw("{$haversine} AS distance")
        ->whereRaw("{$haversine} < ?", [$radius]);
}