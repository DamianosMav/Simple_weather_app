<?php
session_start();
require("functions.php");

$city_name = "";
$country_code = "";

//Checking if the submit button was pressed in the form
if (isset($_POST["submit"])) {
    //If the user filled all the required fields then we clean the data from any malicious code
    if (isset($_POST["city_name"]) && isset($_POST["country_code"]) && isset($_POST["tempUnits"])) {
        $city_name = clean_data($_POST["city_name"]);
        $country_code = clean_data($_POST["country_code"]);
        $temperature_unit = clean_data($_POST["tempUnits"]);

        //Depending on what temperature the user chose display the correct format 
        if ($temperature_unit == "c" ) {
            $units = "metric";
            show_weather_data($city_name, $country_code, $units);

        } else if(clean_data($_POST["tempUnits"]) == "f") {
            $units = "imperial";
            show_weather_data($city_name, $country_code, $units);

        }
        else{
            $_SESSION["not_valid_temp_units"] = "<p class='text-danger fw-medium'> Incorrect temperature unit</p>";
        }

        unset($_POST["submit"]);
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Weather App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background:url(images/background.jpg); background-size:cover">
    <div class="container mt-5">
        <h2 class="text-center text-light mb-5">Weather App</h2>
        <div class="row align-items-start">
            <div class="col-2">
            </div>
            <div class="col-4">
                <h3 class="text-light">Select city/Country</h3>
                <?php
                if (isset($_SESSION["not_valid_city_country"])) {
                    echo $_SESSION["not_valid_city_country"];
                    unset($_SESSION["not_valid_city_country"]);
                }
                if (isset($_SESSION["not_valid_temp_units"])) {
                    echo $_SESSION["not_valid_temp_units"];
                    unset($_SESSION["not_valid_temp_units"]);
                }
                ?>
                <form method="POST" class="row g-1">
                    <div class="col-5">
                        <input type="text" class="form-control" name="city_name" placeholder="ex. Athens">
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" name="country_code" placeholder="ex. GR">
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" name="tempUnits" placeholder="ex. °C/°F">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-light mb-3" name="submit">Search</button>
                    </div>
                </form>
                <?php
                if (isset($_SESSION["weather_icon"])) {
                    echo $_SESSION["weather_icon"];
                    unset($_SESSION["weather_icon"]);
                }
                ?>
            </div>

            <div class="col-4">
                <div class="text-center me-5">
                    <h3 class="text-light">Details:</h3>
                    <?php
                    if (isset($_SESSION["weather_info"])) {
                        echo $_SESSION["weather_info"];
                        unset($_SESSION["weather_info"]);
                    } else {
                        echo "
                            <ul class='list-group'>
                                <li class='list-group-item text-start'>Current Temperature: </li>
                                <li class='list-group-item text-start'>Max Temperature: </li>
                                <li class='list-group-item text-start'>Min Temperature: </li>
                                <li class='list-group-item text-start'>Humidity: </li>
                            </ul>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>