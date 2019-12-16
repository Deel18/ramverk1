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

        $weatherWeek = $session->get("weatherWeek", null);

        $session->set("res", null);
        $session->set("ip", null);
        $session->set("weatherWeek", null);



        $data = [
            "res" => $res,
            "ip" => $ipv,
            "address" => $address,
            "weatherWeek" => $weatherWeek,
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

        $check = $this->di->get("validator");

        if ($doVerify && $address) {
            $result = $check->checkIpv($address);

            $geotag = $check->geoTag($address);

            $weather = new \Anax\Curl\Curl();


            $fetchWeather = $weather->weather($geotag->latitude, $geotag->longitude);

            $data = $fetchWeather->daily;

            $session->set("res", $result);
            $session->set("ip", $address);
            $session->set("weatherWeek", $data);

        }





        return $response->redirect("weather");
    }
}
