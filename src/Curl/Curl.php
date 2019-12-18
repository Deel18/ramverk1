<?php
/**
 * Curl, a class supporting the darkssky API.
 */

namespace Anax\Curl;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class Curl
{

    use ContainerInjectableTrait;

    public function weather($latitude, $longitude)
    {
        $apiKey = file_get_contents(ANAX_INSTALL_PATH . "/config/apikey.txt", FALSE, NULL, 33, 33);
        $apiKey = trim($apiKey);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "https://api.darksky.net/forecast/$apiKey/$latitude,$longitude?exclude=minutely,hourly,alerts,flags");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);

        $decode = json_decode($result);

        return $decode;
    }

    public function getApiKey()
    {
        $apiKey = file_get_contents(ANAX_INSTALL_PATH . "/config/apikey.txt", FALSE, NULL, 66);
        $apiKey = trim($apiKey);
        return $apiKey;
    }
}
