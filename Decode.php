<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Decode
 *
 * @author HP
 */
class Decode {
    
    public function decodeJson(){
        $BASE_URL = "http://query.yahooapis.com/v1/public/yql"; 
        $yql_query = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="prague, cz") AND  u="c"'; 
        $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json"; 
        
        // Make call with cURL 
        $session = curl_init($yql_query_url); 
        curl_setopt($session, CURLOPT_RETURNTRANSFER,true); 

        $json = curl_exec($session); 

        // Convert JSON to PHP array 
        return json_decode($json,true); 
    }
}
