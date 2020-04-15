<?php

namespace Tuiter\Services;

use Tuiter\Services\UserService;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ReshardingMongo{

    private $oldDBs = array();
    private $newDBs = array();
    private $queue = "userIds";
    private $connection;
    private $channel;

    public function __construct(array $oldDBs, array $newDBs){
        $this->oldDBs = $oldDBs;
        $this->newDBs = $newDBs;
        $this->connection = new AMQPStreamConnection("localhost", "5672", 'guest', 'guest');
        $this->channel = $this->connection->channel();
    }

    public function prepareReshardingUsers(){
        $this->channel->queue_declare($this->queue, false, true, false, false);

        foreach($this->oldDBs as $dB){
            $cursor = $dB->find(array());

            foreach($cursor as $user){
                $messageBody = $user["userId"];
                $message = new AMQPMessage(
                    $messageBody,
                    array(
                    'content_type' => 'text/plain',
                    'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
                    )
                );
                $this->channel->basic_publish($message, '', $this->queue);
            }
        }
        return True;
    }

    public function reshardingUsers(){
        $this->channel->queue_declare($this->queue, false, true, false, false);

        $process_message = function ($message){
            $uServiceOld = new UserService($this->oldDBs);
            $uServiceNew = new UserService($this->newDBs);
            $userId = $message->body;

            $user = $uServiceOld->getUser($userId);
            $uServiceNew->register(
                $user->getUserId(),
                $user->getName(),
                $user->getPassword()
            );
            foreach($this->oldDBs as $dB){
                $dB->deleteOne(
                    array(
                        "userId" => $userId
                    )
                );
            }

            $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
        };


        $this->channel->basic_consume($this->queue, '', false, false, false, false, $process_message);

        $shutdown = function ($channel, $connection){
            $channel->close();
            $connection->close();
        };

        register_shutdown_function($shutdown, $this->channel, $this->connection);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}