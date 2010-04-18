<?php
/** 
 * This server demonstrates Thrift's connection and "oneway" asynchronous jobs
 * Client connects to server host:port and calls 2 methods
 * showCurrentTimestamp : which returns current time stamp from server
 * asynchronousJob() : which calls a "oneway" method
 * FIXME : asynchronousJob() wont work for PHP HTTP server asynchronously
 *
 * Osman Yuksel < yuxel {{|AT|}} sonsuzdongu |-| com >
 */

// Thrift libraries
$GLOBALS['THRIFT_ROOT'] = "../lib";
require_once $GLOBALS['THRIFT_ROOT'].'/Thrift.php';
require_once $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/TPhpStream.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/TBufferedTransport.php';

// Your gen-php dir
$GEN_DIR = '../gen-php';

/**
 * files generated from Example.thrift
 * 'thrift --gen php:server Example.thrift
 * TODO: note that you need to comment out require_once line
 * for Example_types on Example/Example.php
 */

require_once $GEN_DIR . "/Example/Example.php";
require_once $GEN_DIR . "/Example/Example_types.php";

// Server implementation
class ExampleHandler implements ExampleIf {
    protected $log = array();

    //this is the showTime function of server which returns current timestamp
    public function showCurrentTimestamp() {
        $now = time();
        return $now;
    }

    // FIXME : oneway methods doesnt work for PHP HTTP server
    public function asynchronousJob(){
        sleep(10);
        file_put_contents("/tmp/thrift","foo", FILE_APPEND);
    }

};

header('Content-Type', 'application/x-thrift');
$handler = new ExampleHandler();
$processor = new ExampleProcessor($handler);

$transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
$protocol = new TBinaryProtocol($transport, true, true);

//start server
$transport->open();
$processor->process($protocol, $protocol);
$transport->close();
