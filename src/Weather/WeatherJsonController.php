<?php

namespace Anax\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Curl\Curl as Curl;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherJsonController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    public function indexAction() : object
    {

        $title = "Weather";

        $address = $_SERVER["REMOTE_ADDR"] ?? "No IP detected.";



        $page = $this->di->get("page");

        $data = [
            "address" => $address
        ];


        $page->add("weatherjson/verify", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function weatherjsonActionGet()
    {
        $request = $this->di->request;

        $doVerify = $request->getGet("verify", null);
        $address = $request->getGet("ip", null);
        $latitude = $request->getGet("latitude", null);
        $longitude = $request->getGet("longitude", null);

        $check = $this->di->get("validator");

        $weather = new Curl();


        if ($doVerify && $address) {
            $result = $check->checkIpv($address);

            $geotag = $check->geoTag($address);


            $fetchWeather = $weather->weather($geotag->latitude, $geotag->longitude);
            $fetchPastWeather = $weather->pastWeather($geotag->latitude, $geotag->longitude);

            $weatherData = $fetchWeather->daily;

            $pastData = $fetchPastWeather;

            $data = [
                "valid" => $result,
                "week" => $weatherData,
                "past Month" => $pastData,

            ];

            return [$data];
        }

        if ($doVerify && $latitude) {
            $verifyCoord = $check->verifyGeo($latitude, $longitude);

            if ($verifyCoord) {
                $fetchWeather = $weather->weather($latitude, $longitude);
                $fetchPastWeather = $weather->pastWeather($latitude, $longitude);

                $weatherData = $fetchWeather->daily;
                $pastData = $fetchPastWeather;

                $valid = "The coordinates $latitude, $longitude are valid.";

                $data = [
                    "valid" => $valid,
                    "week" => $weatherData,
                    "past Month" => $pastData,
                ];

                return [$data];
            } else {
                $invalid = "The coordinates are invalid. Try again.";

                return [$invalid];
            }
        }
    }
}
