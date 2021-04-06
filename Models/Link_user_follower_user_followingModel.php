<?php 
namespace App\Models;

    class Link_user_follower_user_followingModel extends Model
    {
        public function __construct(){
    
        }

        public function insertOrDeleteFollow($data)
        {
            return $this->queryToDB('
                SELECT EXISTS (
                    SELECT *
                    FROM link_user_follower_user_following
                    WHERE id_follower = :id_follower
                    AND   id_following = :id_following
                    ) AS "exist"', $data)
                ->fetch();
        }
        
        public function insertFollow($data)
        {
            return $this->queryToDB('
                INSERT INTO
                link_user_follower_user_following(
                        id_follower,
                        id_following
                    ) VALUES (
                        :id_follower,
                        :id_following)', $data);
        }

        public function deleteFollow($data)
        {
            return $this->queryToDB('
                DELETE FROM
                link_user_follower_user_following
                WHERE id_follower = :id_follower
                AND   id_following = :id_following', $data);
        }

        public function countFollower($data)
        {
            return $this->queryToDB('
                SELECT COUNT(id_following) AS "total"
                FROM link_user_follower_user_following
                INNER JOIN users 
                ON link_user_follower_user_following.id_following = users.id
                WHERE users.email = :email
                GROUP BY id_following', $data)
                ->fetch();
        }

        public function countFollowing($data)
        {
            return $this->queryToDB('
                SELECT COUNT(id_follower) AS "total"
                FROM link_user_follower_user_following
                INNER JOIN users 
                ON link_user_follower_user_following.id_follower = users.id
                WHERE users.email = :email
                GROUP BY id_follower', $data)
                ->fetch();
        }

        public function findAllFollowing($data)
        {
            return $this->queryToDB('
                SELECT nickname, 
                CASE
                    WHEN bio IS null THEN ""
                    ELSE bio
                END AS "bio" 
                FROM users
                INNER JOIN link_user_follower_user_following
                ON users.id = link_user_follower_user_following.id_following
                WHERE id_follower = :id
                ORDER BY nickname', $data)
                ->fetchAll();
        }

        public function findAllFollower($data)
        {
            return $this->queryToDB('
                SELECT nickname,
                CASE
                    WHEN bio IS null THEN ""
                    ELSE bio
                END AS "bio"
                FROM users
                INNER JOIN link_user_follower_user_following
                ON users.id = link_user_follower_user_following.id_follower
                WHERE id_following = :id
                ORDER BY nickname', $data)
                ->fetchAll();
        }

        public function findIdFollowing($data)
        {
            return $this->queryToDB('
                SELECT id
                FROM users
                WHERE nickname = :nickname', $data)
                ->fetch();
        }

        public function findEmail($data)
        {
            return $this->queryToDB('
                SELECT email
                FROM users
                WHERE nickname = :nickname', $data)
                ->fetch();
        }
    }

