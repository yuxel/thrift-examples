<?php
/** 
 * This client demonstrates Thrift's connection and "oneway" asynchronous jobs
 * Client connects to server host:port and calls 2 methods
 * showCurrentTimestamp : which returns current time stamp from server
 * asynchronousJob() : which calls a "oneway" method
 * FIXME : asynchronousJob() wont work for PHP HTTP server asynchronously
 *
 * Osman Yuksel < yuxel {{|AT|}} sonsuzdongu |-| com >
 */


//Check these lines below
$serverHost    = "127.0.0.1";
$serverPort    = "80";
$phpServerPath = "/github/thrift-examples/server/PhpServerHttp.php"; //path which you can access with http://$serverHost:$serverPort/$phpServerPath

//Thrift  libraries
$GLOBALS['THRIFT_ROOT'] = '../lib';

require_once $GLOBALS['THRIFT_ROOT'].'/Thrift.php';
require_once $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/TSocket.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/THttpClient.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/TBufferedTransport.php';

/**
 * files generated from Example.thrift
 * 'thrift --gen php:server Example.thrift
 * TODO: note that you need to comment out require_once line
 * for Example_types on Example/Example.php
 */

require_once "../gen-php/Example/Example.php"; 

try {

    //Open an HTTP Connection to $phpServerPath
    $socket = new THttpClient($serverHost, $serverPort, $phpServerPath);

    $transport = new TBufferedTransport($socket, 1024, 1024);
    $protocol = new TBinaryProtocol($transport);

    //set client 
    $client = new ExampleClient($protocol);
    $transport->open();

    //return current time stamp
    echo $client->showCurrentTimestamp();

    // FIXME : oneway methods doesnt work asynchronously on PHP HTTP server
    $client->asynchronousJob();

} catch (TException $tx) {
    print 'Something went wrong: '.$tx->getMessage()."\n";
}

