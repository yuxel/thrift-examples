#!/usr/bin/env python

# This client demonstrates Thrift's connection and "oneway" asynchronous jobs
# Client connects to server host:port and calls 2 methods
# showCurrentTimestamp : which returns current time stamp from server
# asynchronousJob() : which calls a "oneway" method
#
# Osman Yuksel < yuxel {{|AT|}} sonsuzdongu |-| com >

host = "localhost"
port = 9090

import sys

# your gen-py dir
sys.path.append('../gen-py')

# Example files
from Example import *
from Example.ttypes import *

# Thrift files 
from thrift import Thrift
from thrift.transport import TSocket
from thrift.transport import TTransport
from thrift.protocol import TBinaryProtocol

try:

    # Init thrift connection and protocol handlers
    transport = TSocket.TSocket( host , port)
    transport = TTransport.TBufferedTransport(transport)
    protocol = TBinaryProtocol.TBinaryProtocol(transport)

    # Set client to our Example
    client = Example.Client(protocol)

    # Connect to server
    transport.open()

    # Run showCurrentTimestamp() method on server
    currentTime = client.showCurrentTimestamp()
    print currentTime

    # Assume that you have a job which takes some time
    # but client sholdn't have to wait for job to finish 
    # ie. Creating 10 thumbnails and putting these files to sepeate folders
    client.asynchronousJob()


    # Close connection
    transport.close()

except Thrift.TException, tx:
    print 'Something went wrong : %s' % (tx.message)
