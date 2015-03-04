<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/places.php";

session_start();
if (empty($_SESSION["places"])) {
    $_SESSION["places"] = array();
}

$app = new Silex\Application();


$app->get("/", function()
{
    $output = "";


    $output .= "<!DOCTYPE html>

  <head>

    <title>Places We've Been</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css'>

  </head>
  <body>
<div class='container'>
  <form action = '/places_list' method='post'>
        <div class='form-group'>
            <label for='city'>Enter the city</label>
            <input id='city' name='city' class='form-control' type='text'>
        </div>
        <div class='form-group'>
            <label for='state'>Enter the state</label>
            <input id='state' name='state' class='form-control' type='text'>
        </div>
        <div class='form-group'>
            <label for='year'>Enter the year</label>
            <input id='year' name='year' class='form-control' type='text'>
        </div>
        <button type='submit'>Go</button>
    </form>
    <form action = '/delete' method='post'>
        <button type= 'submit'>Clear all</button>
    </form>

</div>
        </body>
    </html>
    ";
    foreach (Places::getAllPlaces() as $places) {
        $output .= "<ul><li>" . $places->getCity() . "</li><li>" . $places->getState() . "</li><li>" . $places->getYears() . "</li></ul>";
    }
    return $output;
});

$app->post("/places_list", function()
{


    if (
        (empty($_POST['city'])) ||
        (empty($_POST['state'])) ||
        (empty($_POST['year']))
        ) {


        return "error " . "<a href='/'>please enter an item</a>";

    }

    
    else {

        $places = new Places($_POST['city'], $_POST['state'], $_POST['year']);
        $places->save();
        return "<ul><li>" . $places->getCity() . "</li><li>" . $places->getState() . "</li><li>" .    $places->getYears() . "</li></ul>" . "<a href='/'>Go home</a>";
    }

});

$app->post("/delete", function()
{
    Places::deleteAll();
    return "<p> Your list of places is empty</p>" . "<a href='/'>Go home</a>";

});

return $app;
?>
