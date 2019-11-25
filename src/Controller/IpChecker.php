<?php
/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */

namespace Deel\Controller;


class IPChecker
{

    public function checkIpv6($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return "$ip is a valid IPv6 address.";
        } else {
            return "$ip is not a valid IPv6 address.";
        }

    }

    public function checkIpv4($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return "$ip is a valid IPv4 address.";
        } else {
            return "$ip is not a valid IPv4 address.";
        }
    }



}
