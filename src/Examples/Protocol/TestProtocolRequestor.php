<?php

namespace Examples\Protocol;

class TestProtocolRequestor extends \Requestor {
  
  private static $json_protocol =
<<<PROTO
{"namespace":"examples.protocol","protocol":"TestProtocol","types":[{"type":"record","name":"SimpleRequest","fields":[{"name":"subject","type":"string"}]},{"type":"record","name":"SimpleResponse","fields":[{"name":"response","type":"string"}]},{"type":"record","name":"Notification","fields":[{"name":"subject","type":"string"}]},{"type":"record","name":"RaiseException","fields":[{"name":"cause","type":"string"}]},{"type":"record","name":"NeverSend","fields":[{"name":"never","type":"string"}]},{"type":"record","name":"AlwaysRaised","fields":[{"name":"exception","type":"string"}]}],"messages":{"testSimpleRequestResponse":{"doc":"Simple Request Response","request":[{"name":"message","type":"SimpleRequest"}],"response":"SimpleResponse"},"testNotNamedResponse":{"doc":"Simple Request Response","request":[{"name":"message","type":"SimpleRequest"}],"response":{"type":"map","values":"string"}},"testNotification":{"doc":"Notification : one-way message","request":[{"name":"notification","type":"Notification"}],"one-way":true},"testRequestResponseException":{"doc":"Request Response with Exception","request":[{"name":"exception","type":"RaiseException"}],"response":"NeverSend","errors":["AlwaysRaised"]}}}
PROTO;

  
  public function __construct($host, $port) {
    $client = \NettyFramedSocketTransceiver::create($host, $port);
    parent::__construct(\AvroProtocol::parse(self::$json_protocol), $client);
  }
  
  public static function getJsonProtocol() { return self::$jsonProtocol; }
  
  public function close() { return $this->transceiver->close(); }
  
    
  public function testSimpleRequestResponse($message) {
    return $this->request('testSimpleRequestResponse', array('message' => $message));
  }
    
    
  public function testNotNamedResponse($message) {
    return $this->request('testNotNamedResponse', array('message' => $message));
  }
    
    
  public function testNotification($notification) {
    return $this->request('testNotification', array('notification' => $notification));
  }
    
    
  public function testRequestResponseException($exception) {
    return $this->request('testRequestResponseException', array('exception' => $exception));
  }
    
  
}