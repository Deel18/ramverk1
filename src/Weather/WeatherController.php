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
        $countryName = $session->get("country_name", null);
        $city = $session->get("city", null);
        $longitude = $session->get("longitude", null);
        $latitude = $session->get("latitude", null);
        $type = $session->get("type", null);

        $session->set("res", null);
        $session->set("ip", null);
        $session->set("country_name", null);
        $session->set("city", null);
        $session->set("longitude", null);
        $session->set("latitude", null);
        $session->set("type", null);



        $data = [
            "res" => $res,
            "ip" => $ipv,
            "address" => $address,
            "country_name" => $countryName,
            "city" => $city,
            "longitude" => $longitude,
            "latitude" => $latitude,
            "type" => $type,
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
        $check = new IPChecker();


        if ($doVerify) {
            $result = $check->checkIpv($address);

            $geotag = $check->geoTag($address);


            $session->set("res", $result);
            $session->set("ip", $address);
            $session->set("country_name", $geotag->country_name);
            $session->set("city", $geotag->city);
            $session->set("longitude", $geotag->longitude);
            $session->set("latitude", $geotag->latitude);
            $session->set("type", $geotag->type);
        }
        return $response->redirect("weather");
    }
}
