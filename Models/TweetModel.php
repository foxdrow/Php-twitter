<?php

namespace App\Models;

class TweetModel extends Model
{
    public function __construct()
    {
    }

    public function getLastTweets($data)
    {
        return $this->queryToDB('
        SELECT
            tweet.*,
            users.nickname
        FROM tweet
        INNER JOIN users ON users.id = tweet.id_user
        WHERE tweet.date > :date
        ORDER BY date DESC', $data)->fetchAll();
    }

    public function findTweetByUserMention($data) {
        return $this->queryToDB('
            SELECT
                tweet.*, 
                users.nickname
            FROM tweet
            INNER JOIN users ON users.id = tweet.id_user
            WHERE id_user_mention = :id_mention
            ORDER BY date DESC
            ', $data)->fetchAll();
    }

    public function getTweetOfOneMember($data)
    {  

        return $this->queryToDB('
            SELECT 
            tweet.*,
            users.nickname
            FROM tweet
            INNER JOIN users ON tweet.id_user = users.id
            WHERE users.nickname = :nickname
            LIMIT :tweetlimit
            OFFSET :tweetoffset
            ', $data)
            ->fetchAll();
    }

    public function getTweetAndNickname($data)
    {  

        return $this->queryToDB('
            SELECT tweet.*, users.nickname
            FROM tweet
            INNER JOIN users ON tweet.id_user = users.id
            ORDER BY tweet.date DESC
            LIMIT :limit
            OFFSET :offset
            ', $data)
            ->fetchAll();
    }

    public function addTweetModel($data)
    {
        return $this->queryToDB('
            INSERT INTO
                    tweet (
                    id_user,
                    content,
                    id_user_mention,
                    date
                ) VALUES (
                    :id_user,
                    :content,
                    :mention,
                    NOW()
                    )', $data);
    }

    public function addTweetNoHashtagModel($data)
    {
        return $this->queryToDB('
            INSERT INTO
                    tweet (
                    id_user,
                    content,
                    id_user_mention,
                    date
                ) VALUES (
                    :id_user,
                    :content,
                    :mention,
                    NOW()
                    )', $data);
    }

    public function searchTweetsFromIdTweets($data)
    {
        return $this->queryToDB('
            SELECT id_user, content, id_user_mention, id_media, date
            FROM tweet
            WHERE id = :id_tweet
            ', $data)
        ->fetchAll();
    }

    public function getTweetIdModel($data)
    {
        return $this->queryToDB('
            SELECT id
                FROM tweet
                WHERE 
                id_user = :id_user AND
                content = :content
                ', $data)
                ->fetch();
    }

    public function showTweetUsers($data)
    {
        return $this->queryToDB('
            SELECT content, users.nickname, tweet.date
            FROM tweet
            INNER JOIN users ON users.id = tweet.id_user
            WHERE id_user = :id
            ORDER BY date DESC
            LIMIT :limit
            OFFSET :offset
            ', $data)
            ->fetchAll();
    }
}