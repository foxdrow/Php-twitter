<?php 
namespace App\Models;

    class Link_user_tweetModel extends Model
    {
        public function __construct(){
    
        }

        public function addLinkUserTweet($data)
        {
            return $this->registrationDB('
                        INSERT INTO
                            link_user_tweet (
                            id_user,
                            id_tweet
                        ) VALUES (
                            :id_user,
                            :id_tweet
                            )', $data);
        }
    }