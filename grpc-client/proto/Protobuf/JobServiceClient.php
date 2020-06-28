<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Protobuf;

/**
 */
class JobServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * 单一请求应答，一对一
     * @param \Protobuf\JobRq $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetCard(\Protobuf\JobRq $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/protobuf.JobService/GetCard',
        $argument,
        ['\Protobuf\JobCardRp', 'decode'],
        $metadata, $options);
    }

    /**
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetCards($metadata = [], $options = []) {
        return $this->_bidiRequest('/protobuf.JobService/GetCards',
        ['\Protobuf\JobCardRp','decode'],
        $metadata, $options);
    }

}
