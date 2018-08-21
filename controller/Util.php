<?php

function fromInt2IP(int $id) : string {
        $b = unpack("C*", pack("L", $id));
        return sprintf("%d.%d.%d.%d", $b[1],$b[2],$b[3],$b[4]);
}
function fromIP2Int(string $ip) : string {
    return unpack("L", pack("C*",$ip[4],$ip[3],$ip[2],$ip[1]));
}

function getIP () {
    return 
        getenv('HTTP_CLIENT_IP')?:
        getenv('HTTP_X_FORWARDED_FOR')?:
        getenv('HTTP_X_FORWARDED')?:
        getenv('HTTP_FORWARDED_FOR')?:
        getenv('HTTP_FORWARDED')?:
        getenv('REMOTE_ADDR');
}