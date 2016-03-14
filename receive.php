<?php


$queue = $_GET['QUEUE'];
$hostaddress = '192.168.204.129';


require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection($hostaddress, 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare($queue, false, false, false, false);
echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
$callback = function($msg) {
  echo " [x] Received ", $msg->body, "\n";
};
$channel->basic_consume($queue, '', false, true, false, false, $callback);
while(count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();
?>