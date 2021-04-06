<?php

namespace App\Models;

class UsersModel extends Model
{
    public function __construct()
    {
    }

    public function registration($data)
    {
        return $this->registrationDB('
                    INSERT INTO
                        users (
                        nickname,
                        password,
                        email,
                        birthday,
                        registration_date
                    ) VALUES (
                        :nickname,
                        :password,
                        :email,
                        :birthday,
                        NOW())', $data);
    }

    public function emailExist($data)
    {

        return $this->queryToDB('
                SELECT EXISTS (
                    SELECT *
                    FROM users
                    WHERE email = :email
                    ) AS "exist"', $data)
            ->fetch();
    }

    public function getPassword($data)
    {
        return $this->queryToDB('
                SELECT password
                    FROM users
                    WHERE email = :email
                    ', $data)
            ->fetch();
    }

    public function getAll($data)
    {
        return $this->queryToDB('
                SELECT *
                    FROM users
                    WHERE email = :email', $data)
            ->fetch();
    }

    public function nicknameExist($data)
    {
        return $this->queryToDB('
            SELECT EXISTS (
                SELECT * 
                FROM users
                WHERE nickname = :nickname
                ) AS "exist"', $data)
            ->fetch();
    }

    public function updateNickname($data)
    {
        return $this->queryToDB('
            UPDATE users
                SET nickname = :nickname
                WHERE id = :id', $data);

     }

     public function updateBio($data)
     {
         return $this->queryToDB('
            UPDATE users
                SET bio = :bio
                WHERE id = :id', $data);
     }

      public function searchUsers($data)
      {
          return $this->queryToDB('
                SELECT *
                FROM users
                WHERE nickname = :nickname
                ', $data)
            ->fetch();
      }

      public function searchAllUsers($data)
      {
          return $this->queryToDB('
                SELECT nickname, id, 
                CASE
                    WHEN bio IS null THEN ""
                    ELSE bio
                END AS "bio"
                FROM users
                WHERE nickname LIKE :nickname
                AND id != :id
                ORDER BY nickname
                LIMIT :limit
                OFFSET :offset
                ', $data)
            ->fetchAll();
      }
}
