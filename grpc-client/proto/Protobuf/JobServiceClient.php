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
     * 一对一
     * @param \Protobuf\Job $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Protobuf\Job
     */
    public function GetJob(\Protobuf\Job $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/protobuf.JobService/GetJob',
        $argument,
        ['\Protobuf\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * 一对多
     * @param \Protobuf\Job $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Protobuf\Job
     */
    public function CompanyJobs(\Protobuf\Job $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/protobuf.JobService/CompanyJobs',
        $argument,
        ['\Protobuf\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * 多对一
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Protobuf\SalaryRange
     */
    public function AnalysisSalary($metadata = [], $options = []) {
        return $this->_clientStreamRequest('/protobuf.JobService/AnalysisSalary',
        ['\Protobuf\SalaryRange','decode'],
        $metadata, $options);
    }

    /**
     * 多对多
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Protobuf\Job
     */
    public function GetJobs($metadata = [], $options = []) {
        return $this->_bidiRequest('/protobuf.JobService/GetJobs',
        ['\Protobuf\Job','decode'],
        $metadata, $options);
    }

}
