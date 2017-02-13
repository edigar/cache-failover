<?php

namespace AppBundle\Service;

use Predis;

/**
* Here you have to implement a CacheService with the operations above.
* It should contain a failover, which means that if you cannot retrieve
* data you have to hit the Database.
**/
class CacheService
{
    protected $predis;

    public function __construct($host, $port, $prefix)
    {
        try {
            $this->predis = new Predis\Client(array(
                "scheme" => "tcp",
                "host" => $host,
                "port" => $port
            ));
        }catch(Predis\Connection\ConnectionException $e) {
            exit("Couldn't connect to the remote redis instance!");
        }

    }

    public function get($key)
    {
        try {
            return $this->predis->get($key);
        } catch(\Exception $e) { }
    }

    public function set($key, $value)
    {
        try {
            $this->predis->set($key, $value);
        } catch (\Exception $e) { }
    }

    public function del($key)
    {
        try{
            $this->predis->del($key);
        } catch(\Exception $e) { }
    }
}
