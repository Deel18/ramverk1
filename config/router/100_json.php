<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Json Controller",
            "mount" => "json",
            "handler" => "\Anax\Controller\JipController",
        ],
    ],
];
