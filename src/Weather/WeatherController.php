<?php

namespace Anax\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

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
class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    public function indexAction() : object
    {

        $title = "Weather";

        $address = $_SERVER["REMOTE_ADDR"] ?? "No IP detected.";



        $page = $this->di->get("page");
        $session = $this->di->session;

        $res = $session->get("res", null);
        $ipv = $session->get("ip", null);
        $geo = $session->get("geo", null);
        $apikey = $session->get("apikey", null);
        $weatherWeek = $session->get("weatherWeek", null);
        $latitude = $session->get("latitude", null);
        $longitude = $session->get("longitude", null);

        $session->set("res", null);
        $session->set("ip", null);
        $session->set("weatherWeek", null);
        $session->set("geo", null);
        $session->set("latitude", null);
        $session->set("longitude", null);
        $session->set("apikey", null);



        $data = [
            "res" => $res,
            "ip" => $ipv,
            "address" => $address,
            "weatherWeek" => $weatherWeek,
            "geo" => $geo,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "apikey" => $apikey,
        ];

        $page->add("weather/verify", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function indexActionPost()
    {
        $request = $this->di->request;
        $response = $this->di->response;
        $session = $this->di->session;

        $doVerify = $request->getPost("verify", null);
        $address = $request->getPost("ip", null);
        $latitude = $request->getPost("latitude", null);
        $longitude = $request->getPost("longitude", null);

        $check = $this->di->get("validator");

        $weather = new \Anax\Curl\Curl();


        if ($doVerify && $address) {
            $result = $check->checkIpv($address);

            $geotag = $check->geoTag($address);



            $fetchWeather = $weather->weather($geotag->latitude, $geotag->longitude);

            $data = $fetchWeather->daily;

            $session->set("res", $result);
            $session->set("ip", $address);
            $session->set("weatherWeek", $data);
            $session->set("latitude", $geotag->latitude);
            $session->set("longitude", $geotag->longitude);
            $session->set("apikey", $weather->getApiKey());

        }

        if ($doVerify && $latitude) {
            $verifyCoord = $check->verifyGeo($latitude, $longitude);

            if ($verifyCoord) {
                $fetchWeather = $weather->weather($latitude, $longitude);

                $data = $fetchWeather->daily;

                $valid = "The coordinates $latitude, $longitude are valid.";

                $session->set("geo", $valid);
                $session->set("weatherWeek", $data);
                $session->set("latitude", $latitude);
                $session->set("longitude", $longitude);
                $session->set("apikey", $weather->getApiKey());

            } else {
                $session->set("geo", "The coordinates are invalid. Try again.");
            }


        }

        return $response->redirect("weather");
    }
}
