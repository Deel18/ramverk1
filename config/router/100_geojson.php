<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Geojson Controller",
            "mount" => "geojson",
            "handler" => "\Anax\Ip\GeojsonController",
        ],
    ],
];
