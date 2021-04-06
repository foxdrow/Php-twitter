<?php 
namespace App\Models;

    class Link_tweet_hashtagModel extends Model
    {
        public function __construct(){
    
        }

        public function searchIdTweet($data)
        {
             return $this->queryToDB('
                SELECT id_tweet
                FROM link_tweet_hashtag
                WHERE id_hashtag = :id_tag
                ', $data)
            ->fetch();
            var_dump($data); die;
        }

        public function linkHashtagToTweet($data)
        {
            return $this->queryToDB('
                INSERT INTO 
                    link_tweet_hashtag (
                    id_hashtag,
                    id_tweet ) 
                    VALUES (
                    :id_hashtag,
                    :id_tweet )
                    ', $data);
        }
    }