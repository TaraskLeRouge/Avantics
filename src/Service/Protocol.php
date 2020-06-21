<?php

namespace App\Service;

class Protocol
{
    public function getIp() {
        if (!empty($_SERVER["HTTP_CLIENT_IP"]) && $this->validIp($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        }

        if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            foreach (explode(",", $_SERVER["HTTP_X_FORWARDED_FOR"]) as $ip) {
                if ($this->validIp(trim($ip))) {
                    return $ip;
                }
            }
        }

        if (!empty($_SERVER["HTTP_PC_REMOTE_ADDR"]) && $this->validIp($_SERVER["HTTP_PC_REMOTE_ADDR"])) {
            return $_SERVER["HTTP_PC_REMOTE_ADDR"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED"]) && $this->validIp($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        } elseif (!empty($_SERVER["HTTP_FORWARDED_FOR"]) && $this->validIp($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (!empty($_SERVER["HTTP_FORWARDED"]) && $this->validIp($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    private function validIp($ip) {
        if (!empty($ip) && ip2long($ip) != -1) {
            $reserved_ips = array(
                array('0.0.0.0', '2.255.255.255'),
                array('10.0.0.0', '10.255.255.255'),
                array('127.0.0.0', '127.255.255.255'),
                array('169.254.0.0', '169.254.255.255'),
                array('172.16.0.0', '172.31.255.255'),
                array('192.0.2.0', '192.0.2.255'),
                array('192.168.0.0', '192.168.255.255'),
                array('255.255.255.0', '255.255.255.255')
            );

            foreach ($reserved_ips as $r) {
                $min = ip2long($r[0]);
                $max = ip2long($r[1]);
                if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
            }

            return true;
        } else {
            return false;
        }
    }
}