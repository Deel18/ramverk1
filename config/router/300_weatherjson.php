<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "WeatherJson Controller",
            "mount" => "weatjson",
            "handler" => "\Anax\Weather\WeatherJsonController",
        ],
    ],
];
