<?php
function api_call($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Set curl option to return the transfer as a string
    $response = curl_exec($ch);
    if($response === false) {
        // Log the error if something happened
        echo 'Curl error: ' . curl_error($ch);
        return false;
    }
    curl_close($ch);
    return $response;
}

function show_weather_data($city_name, $country_code, $units){
    $api_key = "API KEY GOES HERE";
    $url = "https://api.openweathermap.org/data/2.5/weather?q={$city_name},{$country_code}&appid={$api_key}&units={$units}";

    $response = api_call($url);
    $responce = json_decode($response, true);
    //If the user inputed a not valid country/city return early and show an appropriate message
    if(!isset($responce["weather"])) {
        $_SESSION["not_valid_city_country"] = "<p class='text-danger fw-medium'> City/Country does not exist</p>";
        return;
    }

    //Getting the info about the weather(ex. Clear Sky) and the corresponding icon
    $weather = ucwords($responce["weather"][0]["description"]);
    $weather_icon = $responce["weather"][0]["icon"];

    //According to what the user chose change the temperature units
    if($units == "metric"){
        $temp_symbol = "°C";
    }
    else{
        $temp_symbol = "°F";
    }
    
    //Getting all the important information
    $current_temp = $responce["main"]["temp"];
    $max_temp = $responce["main"]["temp_max"];
    $min_temp = $responce["main"]["temp_min"];
    $humidity = $responce["main"]["humidity"];
    
    //Setting the session assoc variables to display when needed
    $_SESSION["weather_icon"] = "<h3 class='text-white'>$weather</h3><img src = https://openweathermap.org/img/wn/{$weather_icon}@2x.png>";

    $_SESSION["weather_info"] = "<ul class=list-group>
    <li class='list-group-item text-start'>Current Temperature: $current_temp $temp_symbol</li>
    <li class='list-group-item text-start'>Max Temperature: $max_temp $temp_symbol</li>
    <li class='list-group-item text-start'>Min Temperature: $min_temp $temp_symbol</li>
    <li class='list-group-item text-start'>Humidity: $humidity%</li>
    </ul> ";
    
}

function clean_data($data){
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);
    $data = strtolower($data);
    return $data;
}

?>