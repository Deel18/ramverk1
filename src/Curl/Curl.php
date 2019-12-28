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

    public function pastWeather($latitude, $longitude)
    {
        $apiKey = file_get_contents(ANAX_INSTALL_PATH . "/config/apikey.txt", FALSE, NULL, 33, 33);
        $apiKey = trim($apiKey);

        $url = "https://api.darksky.net/forecast/$apiKey/$latitude,$longitude";


        $month = [];
        for ($i = 0; $i > -30; $i--) {
            $month[] = strtotime("$i day");
        }

        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];

        $mh = curl_multi_init();

        $chAll = [];
        foreach ($month as $day) {
            $ch = curl_init("$url, $day");
            curl_setopt_array($ch, $options);
            curl_multi_add_handle($mh, $ch);
            $chAll[] = $ch;
        }

        $running = null;

        do {
            curl_multi_exec($mh, $running);
        } while ($running);

        foreach ($chAll as $ch) {
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);



        $response = [];

        foreach($chAll as $ch) {
            $data = curl_multi_getcontent($ch);
            $response[] = json_decode($data, true);
        }

        return $response;
    }



    public function getApiKey()
    {
        $apiKey = file_get_contents(ANAX_INSTALL_PATH . "/config/apikey.txt", FALSE, NULL, 66);
        $apiKey = trim($apiKey);
        return $apiKey;
    }
}
