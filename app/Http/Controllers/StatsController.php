<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class StatsController extends Controller
{
    public function view(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date'
        ]);
        
        $client = new Client();
        
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        
        $astroids = [];
        $dates = [];
        $counts = [];
        
        $average_size = 0;
        
        $response = $client->request('GET', 'https://api.nasa.gov/neo/rest/v1/feed?start_date='.$start_date.'&end_date='.$end_date.'&detailed=true&api_key='.env('NEO_API_KEY'));
        $json_object = json_decode($response->getBody()); 


        foreach ($json_object->near_earth_objects as $key => $days) {
            array_push($dates, $key);
            array_push($counts, count($days));
        }

        foreach ($json_object->near_earth_objects as $objects) {
            foreach($objects as $object){
                array_push($astroids,array(
                    "id" => $object->id,
                    "kilometers_per_hour" => $object->close_approach_data[0]->relative_velocity->kilometers_per_hour,
                    "kilometers" => $object->close_approach_data[0]->miss_distance->kilometers
                ));

                $average_size += (double)$object->estimated_diameter->kilometers->estimated_diameter_min * (double)$object->estimated_diameter->kilometers->estimated_diameter_max;

            }
        }

        $sorted_distance = array_values(\Arr::sort($astroids, function ($value) {
            return $value['kilometers'];
        }));

        $sorted_fastest = array_values(\Arr::sort($astroids, function ($value) {
            return $value['kilometers_per_hour'];
        }));

        $average_size = $average_size / count($astroids);
        $fastest_astroid = \Arr::last($sorted_fastest);
        $closest_astroid = \Arr::first($sorted_distance);

        
        return view('view',compact('dates', 'counts', 'fastest_astroid','closest_astroid','average_size'));
    }

    
}
