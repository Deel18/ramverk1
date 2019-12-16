<?php
/**
 * Ip Checker, a class supporting IP validation.
 */

namespace Anax\Ip;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class IPChecker
{

    use ContainerInjectableTrait;

    public function checkIpv($ipv)
    {
        if (filter_var($ipv, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $hostname = gethostbyaddr($ipv);
            return "$ipv is a valid IPv6 address and the host is: $hostname";
        } elseif (filter_var($ipv, FILTER_VALIDATE_IP)) {
            $hostname = gethostbyaddr($ipv);
            return "$ipv is a valid IPv4 address and the host is: $hostname";
        } else {
            return "$ipv is not a valid IP address";
        }
    }

    public function geoTag($ipv)
    {
        $apiKey = file_get_contents(ANAX_INSTALL_PATH . "/config/apikey.txt", FALSE, NULL, 0, 33);
        $apiKey = trim($apiKey);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "http:/api.ipstack.com/$ipv?access_key=$apiKey");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);

        $decode = json_decode($result);

        return $decode;
    }
}
