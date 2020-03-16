<?php
require_once 'vendor/autoload.php';

class Server
{
    protected $server;

    public function __construct()
    {
        $this->server = new \Swoole\Server("127.0.0.1", 9501);
        $this->onConnect();
        $this->onReceive();
        $this->onClose();
        $this->start();;
    }

    public function onConnect()
    {
        $this->server->on('Connect', function ($serv, $fd) {
            echo "Client: Connect.\n";
        });
    }

    public function onReceive()
    {
        $this->server->on('Receive', function ($serv, $fd, $from_id, $data) {
            $data = json_decode($data, true);
            $service = $data['service'];
            $action = $data['action'];
            $page = $data['param'];
            $class = "rpc\\Service\\" . $service;
            $instance = new $class;
            $result = json_encode($instance->$action($page));
            $serv->send($fd, $result);
        });
    }

    public function onClose()
    {
        $this->server->on('Close', function ($serv, $fd) {
            echo "Client: Close.\n";
        });
    }

    public function start()
    {
        $this->server->start();
    }
}

$server = new Server();
