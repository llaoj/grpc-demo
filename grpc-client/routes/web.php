<?php


/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    
    $cli = new \Protobuf\JobServiceClient('192.168.33.1:13481',[
        'credentials' => Grpc\ChannelCredentials::createInsecure()
    ]);

    // 单一
    $rq = new \Protobuf\JobRq();
    $rq->setId(14490);
    list($rp, $status) = $cli->GetCard($rq)->wait();
    if (!$rp) {
        echo json_encode($status);
        return;
    }
    //序列化为string
    echo $rp->serializeToJsonString(), '<br/>';



    // 双工stream请求
    $call = $cli->GetCards();
    $rq = new \Protobuf\JobRq();
    foreach ([428, 13120] as $item) {
        $rq->setId($item);
        $call->write($rq);
    }
    $call->writesDone();

    while ($rp = $call->read()) {
        if (!$rp) {
            echo json_encode($status);
            return;
        }
        //序列化为string
        echo $rp->serializeToJsonString(), '<br/>';
    }

    // return $router->app->version();
});
