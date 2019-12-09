<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Geotag Controller",
            "mount" => "geotag",
            "handler" => "\Anax\Ip\GeotagController",
        ],
    ],
];
