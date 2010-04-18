# Thrift Examples

An example which demonstrates Client/Server integration and "oneway" asynchronous jobs of Thrift

## Contents

* Example.thrift : Thrift Definition file for a service which returns current timestamp and an asynchronous job
* client/PythonClient.py : Python Client which connects to server localhost:9090 and call methods
* client/PhpClientSocket.php : PHP Client which connects to server localhost:9090 and call methods
* client/PhpClientHttp.php : PHP client which connects to an HTTP server which runs on localhost:80 (Note that oneway method doesnt work for PHP HTTP server)
* server/PythonServer.py : Python server which runs on localhost:9090
* server/PhpServerHttp.php : PHP server which runs on localhost:80  (Note that oneway method doesnt work for PHP HTTP server)
* gen-php : Files generated from Example.thrift using 'thrift --gen php:server Example.thrift'
* gen-py : Files generated from Example.thrift using 'thrift --gen py Example.thrift'
* lib : Thrift library files


## Example.thrift

This is the example service DDL, which has 2 methods. One to return current time stamp synchronously and one to make a job which takes 10 seconds but work asynchronously

    namespace php Example
    service Example{
        string showCurrentTimestamp()
        oneway void asynchronousJob()
    }


## Howto Run

### Python Server & PHOi Client
* cd server && python PythonServer.py
* Call client/PhpClientSocket.php from your browser


### Python Server & Python Client
* cd server && python PythonServer.py
* cd client && python PythonClient.py


### PHP  Server & PHP Client
Note that asynchronous method doesnt work with PHP HTTP Server
* Call client/PhpClientHttp.php from your browser

