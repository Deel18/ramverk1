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
        $apiKey = file_get_contents(ANAX_INSTALL_PATH . "/config/apikey.txt", false, null, 33, 33);
        $apiKey = trim($apiKey);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "https://api.darksky.net/forecast/$apiKey/$latitude,$longitude?exclude=minutely,hourly,alerts,flags");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);

        $decode = json_decode($result);

        return $decode;
    }

    public function pastWeather($latitude, $longitude)
    {
        $apiKey = file_get_contents(ANAX_INSTALL_PATH . "/config/apikey.txt", false, null, 33, 33);
        $apiKey = trim($apiKey);

        $url = "https://api.darksky.net/forecast/$apiKey/$latitude,$longitude";


        $month = [];
        for ($i = 0; $i > -30; $i--) {
            $month[] = strtotime("$i day");
        }

        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];

        $mhd = curl_multi_init();

        $chAll = [];
        foreach ($month as $day) {
            $chd = curl_init("$url, $day");
            curl_setopt_array($chd, $options);
            curl_multi_add_handle($mhd, $chd);
            $chAll[] = $chd;
        }

        $running = null;

        do {
            curl_multi_exec($mhd, $running);
        } while ($running);

        foreach ($chAll as $chd) {
            curl_multi_remove_handle($mhd, $chd);
        }
        curl_multi_close($mhd);



        $response = [];

        foreach ($chAll as $chd) {
            $data = curl_multi_getcontent($chd);
            $response[] = json_decode($data, true);
        }

        return $response;
    }



    public function getApiKey()
    {
        $apiKey = file_get_contents(ANAX_INSTALL_PATH . "/config/apikey.txt", false, null, 66);
        $apiKey = trim($apiKey);
        return $apiKey;
    }
}
