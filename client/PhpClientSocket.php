<?php
/** 
 * This client demonstrates Thrift's connection and "oneway" asynchronous jobs
 * Client connects to server host:port and calls 2 methods
 * showCurrentTimestamp : which returns current time stamp from server
 * asynchronousJob() : which calls a "oneway" method
 *
 * Osman Yuksel < yuxel {{|AT|}} sonsuzdongu |-| com >
 */


// Your thrift libraries
$GLOBALS['THRIFT_ROOT'] = '../lib/';

require_once $GLOBALS['THRIFT_ROOT'].'/Thrift.php';
require_once $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/TSocket.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/THttpClient.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/TBufferedTransport.php';


// Your gen-php dir
$GEN_DIR = '../gen-php';

// Our example
// TODO : note that you need to comment out require_once line 
//        for Example_types on Example/Example.php
require_once $GEN_DIR . '/Example/Example.php';
require_once $GEN_DIR . '/Example/Example_types.php';

// Set server host and port
$host = "localhost";
$port = 9090;


try {

    //Thrift connection handling
    $socket = new TSocket( $host , $port );
    $transport = new TBufferedTransport($socket, 1024, 1024);
    $protocol = new TBinaryProtocol($transport);

    // get our example client
    $client = new ExampleClient($protocol);
    $transport->open(); 

    // Get current timestamp from server
    $currentTimeStamp = $client->showCurrentTimestamp();
    echo $currentTimeStamp;

    // Assume that you have a job which takes some time
    // but client sholdn't have to wait for job to finish 
    // ie. Creating 10 thumbnails and putting these files to sepeate folders
    $client->asynchronousJob();

    $transport->close();

} catch (TException $tx) {
    print 'Something went wrong: '.$tx->getMessage()."\n";
}
