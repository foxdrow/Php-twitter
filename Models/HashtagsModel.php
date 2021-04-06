<?php

namespace App\Models;

class HashtagsModel extends Model
{
    public function __construct()
    {
    }

    public function addHashtagsModel($data)
    {
        return $this->queryToDB('
            INSERT INTO 
                hashtags (
                content ) 
                VALUES (
                :content)', $data);
    }

    public function addTweetHashtagsLinkModel($data)
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

    public function hashtagsExist($data)
    {
        return $this->queryToDB('
            SELECT EXISTS (
                SELECT *
                FROM hashtags
                WHERE content = :content
                ) AS "exist"', $data)
                ->fetch();
    }

    public function searchIdTag($data)
        {
             return $this->queryToDB('
                SELECT id
                FROM hashtags
                WHERE content = :hashtag
                ', $data)
            ->fetch();
        }

    public function getHashtagIdModel($data)
    {
        return $this->queryToDB('
            SELECT id
                FROM hashtags
                WHERE 
                content = :content
                ', $data)
                ->fetch();
    }

    public function searchTweetsFromTag($data)
    {
        return $this->queryToDB('
            SELECT tweet.id_user, tweet.content, tweet.id_user_mention, tweet.id_media, tweet.date, nickname, tweet.id AS "id_tweet"
            FROM hashtags
            INNER JOIN link_tweet_hashtag
                ON hashtags.id = link_tweet_hashtag.id_hashtag
            INNER JOIN tweet 
                ON link_tweet_hashtag.id_tweet = tweet.id
            INNER JOIN users
                ON users.id = tweet.id_user
            WHERE hashtags.content = :hashtag_content
            ORDER BY date DESC
            LIMIT :limit
            OFFSET :offset', $data)
            ->fetchAll();
    }
}