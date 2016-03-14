<?php
# https://www.rabbitmq.com/tutorials/tutorial-one-php.html
# https://www.binpress.com/tutorial/getting-started-with-rabbitmq-in-php/164

$queue = $_GET['QUEUE'];
$message = $_GET['MESSAGE'];
$hostaddress = 'localhost';

# In send.php, we need to include the library and use the necessary classes:
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

# then we can create a connection to the server:
$connection = new AMQPStreamConnection( $hostaddress , 5672, 'guest', 'guest');
$channel = $connection->channel();

# To send, we must declare a queue for us to send to; then we can publish a message to the queue:
$channel->queue_declare( $queue , false, false, false, false);
$msg = new AMQPMessage( $message );
$channel->basic_publish($msg, '', $queue );
#echo " [x] Sent '"+$message+"'\n";
$channel->close();
$connection->close();
?>