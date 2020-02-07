<?php

namespace Tuiter\Services;

class FollowService {

    private $collection;

    public function __construct($collection){
        $this->collection = $collection;
    }

    public function follow($followerId, $followedId): bool{
        if(!in_array($followedId,$this->getFollowed($followerId))){
            $followId = "pinga" . md5(microtime());
            $this->collection->insertOne(
                array(
                    'followId' => $followId,
                    'followerId' => $followerId,
                    'followedId' => $followedId
                    )
            );
            return true;
        }
        return false;
    }

    public function getFollowers($userId): array{
        $raw = $this->collection->find(array('followedId' => $userId));
        $followers = array();
        foreach($raw as $follow){
            $followers[] = $follow['followerId'];
        }
        return $followers;
    }

    public function getFollowed($userId): array{
        $raw = $this->collection->find(array('followerId' => $userId));
        $followed = array();
        foreach($raw as $follow){
            $followed[] = $follow['followedId'];
        }
        return $followed;
    }
}