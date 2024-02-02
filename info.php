<?php

if (class_exists('Memcached')) {
    // Memcache is enabled.
    echo 'memcached available<br/>';

    //$memcache = new Memcache;
    //$memcache->connect('localhost', 11211) or die ("Could not connect");
    $version = $client->getVersion();
    echo "Server's version: " . json_encode($version) . "<br/>";
} else {
    echo "memcached unavailable<br/>";
}

phpinfo();
