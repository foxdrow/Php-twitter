<?php

namespace App\Controllers;
session_start();

use App\Controllers\Controller;
use App\Models\HashtagsModel;
use App\Models\TweetModel;
use App\Models\UsersModel;

class HashtagsController extends Controller
{

    private $id;

    public function searchTweetFromTag()
    {

        $data = $_POST['input_search'];
        $limit = $_POST['limit'];
        $offset = $_POST['offset'];
        $hashtag_sql = array();
        $member_sql = array();

        $hashtag = preg_match('/#([^\s]+)/', $data, $hashtag_sql);
        $member = preg_match('/@([^\s]+)/', $data, $member_sql);
       
        if($hashtag == 1) {
            $hashtag_sql = $hashtag_sql[1];
    
            $limit = intval($limit);
            $offset = intval($offset);
            $hashtagsModel = new HashtagsModel;
    
            $data = array(':hashtag_content' => $hashtag_sql, ':limit' => $limit, ':offset' => $offset);
            $tweets = $hashtagsModel->searchTweetsFromTag($data);

            $tab = $this->tweets_in_tab($tweets);
    
            echo json_encode(array("hashtag" => $tab));
        }

        if($member == 1) {
            $member_sql = $member_sql[1];
            $limit = intval($limit);
            $offset = intval($offset);
            $id = $_SESSION["ID"];

            $usersModel = new UsersModel;
            $user = $usersModel->searchAllUsers(array(":nickname" => "%$member_sql%", ":id" => $id,':limit' => $limit, ':offset' => $offset));

            $usersController = new UsersController;
            if($usersController->nicknameExist($member_sql)->exist == 1){
                
                $tweetModel = new TweetModel;
                $mention = $tweetModel->findTweetByUserMention(array("id_mention" => $user[0]->id));

            }
            echo json_encode(array("user" => $user, "mention" => $mention));
        }
    }

    function tweets_in_tab($tweets)
    {
        $tweets_tab = [];
        $tab = [];
        foreach ($tweets as $obj)
        {
            $tab = json_decode(json_encode($obj), true);
            array_push($tweets_tab, $tab);
        }
        return $tweets_tab;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function addHashtagsController($data, $id_tweet)
    {
 
        $HashtagsModel = new HashtagsModel;
 
        foreach ($data as $key => $value) {
 
            $val = array(
                ":content" => $value
            );
 
            $hashtagExist = $HashtagsModel->hashtagsExist($val);
 
            if ($hashtagExist->exist ==  false) {
                $HashtagsModel->addHashtagsModel($val);
            }
            
            $id_hashtag = $HashtagsModel->getHashtagIdModel($val);
            $id_hashtag = $id_hashtag->id;
 
            $datahash = array(
                ":id_hashtag" => $id_hashtag,
                ":id_tweet" => $id_tweet
            );
            $HashtagsModel->addTweetHashtagsLinkModel($datahash);
 
        }
    }
}
