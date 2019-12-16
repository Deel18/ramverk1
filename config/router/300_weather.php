<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Weather Controller",
            "mount" => "weather",
            "handler" => "\Anax\Weather\WeatherController",
        ],
    ],
];
