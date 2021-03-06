<?php   
    use Ratchet\Server\IoServer;
    use App\Http\Controllers\WebsocketsController;
    
    require dirname(__DIR__) . './../../vendor/autoload.php';

    $server = IoServer::factory(
        new WebsocketsController(),
        9999
    );

    $server->run();
?>