<?php
/**
 * Ip Checker, a class supporting IP validation.
 */

namespace Anax\Controller;

class IPChecker
{

    public function checkIpv6($ipv)
    {
        if (filter_var($ipv, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return "$ipv is a valid IPv6 address.";
        } else {
            return "$ipv is not a valid IPv6 address.";
        }
    }

    public function checkIpv4($ipv)
    {
        if (filter_var($ipv, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return "$ipv is a valid IPv4 address.";
        } else {
            return "$ipv is not a valid IPv4 address.";
        }
    }
}
