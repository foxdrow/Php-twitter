<?php

namespace App\Models;

class MessageModel extends Model
{
    public function __construct()
    {
    }

    public function sendMessages($data)
    {
        return $this->queryToDB('
            INSERT INTO
                    message (
                    id_from,
                    id_to,
                    content,
                    date
                ) VALUES (
                    :id_from,
                    :id_to,
                    :content,
                    NOW()
                    )', $data);
    }

    public function getUserIdWithNickname($data)
    {
        return $this->queryToDB('
            SELECT id
                FROM users
                WHERE 
                nickname = :nickname
                ', $data)
            ->fetch();
    }

    public function userExist($data)
    {
        return $this->queryToDB('
            SELECT EXISTS (
                SELECT *
                FROM users
                WHERE nickname = :nickname
                ) AS "exist"', $data)
            ->fetch();
    }

    public function searchUsersConversation($data)
    {
        return $this->queryToDB('
            SELECT nickname, content, date
                FROM message
            INNER JOIN users
                ON 
                    users.id = message.id_from
                WHERE 
                    id_from = :id_from 
                AND
                    id_to = :id_to
                OR
                    id_from = :id_to2
                AND
                    id_to = :id_from2
                ORDER BY date DESC
                LIMIT :limit
                OFFSET :offset
                ', $data)
            ->fetchAll();
    }
}