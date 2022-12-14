  <?php
  
  $weather="";
  $error="";
  //for city doesn't exit
  //googling: "php check if url exists"
  if ($_GET['city']) {
    
    //echo file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".$_GET['city']."&appid=20c7a90d25324465ff8c0a6387623d1b");

    // cities with spaces in their name, gooling: "url encode" and see it in php.net website
    $urlContents = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".urlencode($_GET['city'])."&appid=20c7a90d25324465ff8c0a6387623d1b");

    /* itu hasilnya masih JSON (JavaScript Object Notation) Format, 
       jadi kita ingin buat ke Array, spy kita bisa extract datanya 
       untungnya ada function build ini di PHP utk memproses JSON yaitu json_decode, dgn flat true utk bisa mengEkstrak nya 
    */
    $weatherArray = json_decode($urlContents, true);

    //print_r($weatherArray); 
    /* lalu dari hasilnya, coba klik kanan di browser nya, lalu pilih view page source, lalu array2 tsb bisa diakses sprti data description, tempreture, dll
       lalu kita bisa kembali lagi ke openweathermap.org utk melihat arti parameter JSON nya 
    */
    // valid city name is always have cod = 200    
    if ($weatherArray['cod'] == 200) {
        $weather = "The weather in ".$_GET['city']." is currently '".$weatherArray['weather'][0]['description']."'. ";

        /* karena temperature nya dlm Kelvin, bukan Celcius (lihat keterangan JSON nya di website nya, 
           jadi perlu konversi, googling: convert from kelvin to celcius 
           lalu pembulatan dgn fungsi intval (gooling: php convert to whole number)
        */    
        //$tempInCelcius = $weatherArray['main']['temp'] - 273;
        $tempInCelcius = intval($weatherArray['main']['temp'] - 273);
        // utk simbil derajat, gooling: degree symbol html character code
        $weather .= " The temperature is ".$tempInCelcius."&deg;C"; 

        $windSpeed = $weatherArray['wind']['speed']; //default nya dlm meter/sec, kalau mau miles/hour hrs dikonversi
        $weather .= " and the wind speed is ".$windSpeed."m/s"  ;

        // valid city name is always have cod = 200
    }
    else {
      $error = "Couln't find city - please try again.";
    }

    // cities with spaces in their name, gooling: url encode

  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Weather Scapper</title>

    <style type="text/css">
        html { 
              background: url(Background3-scaled1.jpg) no-repeat center center fixed; 
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
        }

        body {
              background: none;
        }

        .container {
              text-align: center;
              margin-top: 150px;
              width: 450px;
        }

        form {
            margin-top: 20px;
        } 

        input {
            margin: 10px 0;
        }

        #weather {
            margin-top: 15px;
        }

    </style>
  </head>
  <body>
    <!-- <h1>Weather Scapper!</h1> -->

    <!-- <img src="Background3-scaled1.jpg"> -->
    <!-- googling for full screen image background: html full page background -->

    <div class="container">
        <h1>What's The Weather</h1>

        <form>
            <div class="form-group">
              <label for="city">Enter the name of a city :</label>
              <input type="text" class="form-control" id="city" aria-describedby="emailHelp" name="city" placeholder="Eg. London, Tokyo" value = "<?php echo $_GET['city']; ?>" >              
            </div>
           
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <div id="weather">
          <?php

            if ($weather) {
              echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
            } else if ($error) {
                echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';

            }

          ?>
        </div>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>