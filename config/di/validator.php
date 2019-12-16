<?php
/**
 * Configuration file for DI container.
 */
return [
    "services" => [
        "validator" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Ip\IPChecker();
                $obj->setDI($this);
                return $obj;
            }
        ],
    ],
];
