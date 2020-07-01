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



    echo "执行 一对一 方法...", '<br/>';
    $rq = new \Protobuf\Job();
    $rq->setId(14490);
    list($rp, $status) = $cli->GetJob($rq)->wait();
    if (!$rp) {
        echo json_encode($status);
        return;
    }
    // echo "name: ".$rp->getName(), '<br/>';
    // 序列化为string
    echo $rp->serializeToJsonString(), '<br/>';

    echo "执行 一对多 方法...", '<br/>';
    $rq = new \Protobuf\Job();
    $rq->setCompanyName("B技术公司");
    $call = $cli->CompanyJobs($rq);
    $stream = $call->responses();
    foreach ($stream as $s) {
        //序列化为string
        echo $s->serializeToJsonString(), '<br/>';
    }

    echo "执行 多对一 方法...", '<br/>';
    $call = $cli->AnalysisSalary();
    for ($i = 0; $i < 3; $i++) {
        $sr = new \Protobuf\SalaryRange();
        $sr->setMin(10+$i);
        $sr->setMax(15+$i);
        $call->write($sr);
    }
    list($rp, $status) = $call->wait();
    echo $rp->serializeToJsonString(), '<br/>';

    echo "执行 多对多 方法...", '<br/>';
    $call = $cli->GetJobs();
    $rq = new \Protobuf\Job();
    for ($i = 10; $i < 14; $i++) {
        $rq->setId($i);
        $call->write($rq);
    }
    $call->writesDone();
    while ($rp = $call->read()) {
        //序列化为string
        echo $rp->serializeToJsonString(), '<br/>';
    }

    // return $router->app->version();
});
