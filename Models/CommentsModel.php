<?php

namespace App\Models;

class CommentsModel extends Model
{
    public function __construct()
    {
    }

    public function addCommentsToTweet($data)
    {
        return $this->queryToDB('
            INSERT INTO
                    comments (
                    id_tweet,
                    id_user,
                    content,
                    date
                ) VALUES (
                    :id_tweet,
                    :id_user,
                    :content,
                    NOW()
                    )', $data);
    }

    public function findCommentsByTweetId($data)
    {
        return $this->queryToDB('
              SELECT *, users.nickname
              FROM comments
              INNER JOIN users ON users.id = comments.id_user
              WHERE id_tweet = :id_tweet
              ', $data)
          ->fetchAll();
    }
}
