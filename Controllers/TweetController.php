<?php
namespace App\Controllers;
session_start();

use App\Controllers\Controller;
use App\Controllers\UsersController;
use App\Controllers\HashtagsController;
use App\Models\Link_user_tweetModel;
use App\Models\TweetModel;

class TweetController extends Controller
{

    public function getLastFiveMinDate()
    {
        $current_hour = date('H:i:s');
        $tab = explode(":", $current_hour);
        $val = $tab[1] - 5;

        if ($val < 0){
            $tab[0] -= 1;
            $tab[1] = 60 + $val;
        }else {
            $tab[1] = $val;
        }

        $last_hour = $tab[0].":".$tab[1].":".$tab[2];
        $current_date = date('Y-m-d');
        $date = $current_date . " " . $last_hour;
        return $date;
    }

    public function getLastTweets()
    {
        $date = $this->getLastFiveMinDate();
        $tweetModel = new TweetModel;
        $tweets = $tweetModel->getLastTweets(array(":date" => $date));

        echo json_encode(array("tweets" => $tweets));
    }

    public function getTweetOfOneMember(){
        $data = $_POST;
        $tweetModel = new TweetModel;
        $tweets = $tweetModel->getTweetOfOneMember(array(":nickname" => $data['nickname'], ":tweetlimit" => $data['limit'], ":tweetoffset" => $data['offset']));
        
        echo json_encode(array("tweets" => $tweets));
    }

    public function getTweetAndNickname(){
        $limit = $_POST['limit'];
        $offset = $_POST['offset'];

        $data = array(':limit' => $limit, ':offset' => $offset);

        $tweetModel = new TweetModel;

        $tweets = $tweetModel->getTweetAndNickname($data);

        echo json_encode(array("tweets" => $tweets));
    }

    
    public function searchTweetsFromIdTweets($id_tweet)
    {

        $tweetModel = new TweetModel;

        $id_tweet_prepare = array(':id_tweet' => $id_tweet);

        $tweets = $tweetModel->searchTweetsFromIdTweets($id_tweet_prepare); 
        return $tweets;
    }

    public function addTweet()
    {   
        $uri = "/Users" . strrchr($_SERVER['HTTP_REFERER'], "/");
        
        $TweetModel = new TweetModel;
        $HashtagsController = new HashtagsController;
        $UsersController = new UsersController;

        $id_user = $_SESSION['ID'];
        $content = $_POST['content'];

        $mention = array();
        if(preg_match_all('/@([^\s]+)/', $content, $mention) == 1) {
            preg_match_all('/@([^\s]+)/', $content, $mention);
            $full_mention = $mention[0][0];
            
            $full_mention = "<a href='' class='link-mention' disabled='disabled'> ".$full_mention." </a>";
            
            $content = str_replace($mention[0][0], $full_mention, $content);
            $mention = $mention[1];
                        
            $id_mention = $UsersController->searchUsers($mention[0])->id;
        }

        if (empty($_SESSION['ID'])) {
            echo 'pas de text';
            return 0;
        } elseif (strlen($_POST['content']) > 140) {
            echo 'string superieur a 140 caracteres';
            return 0;
        }
        $TweetModel->addTweetModel(array("id_user" => $id_user , ":content" => $content, ":mention" => $id_mention));
        
        $id_tweet = $TweetModel->getTweetIdModel(array("id_user" => $id_user , ":content" => $content));
        $id_tweet = $id_tweet->id;
        
        $linkUserTweetModel = new Link_user_tweetModel;
        $linkUserTweetModel->addLinkUserTweet(array(":id_tweet" => $id_tweet, ":id_user" => $_SESSION['ID']));

        $hashtag = array();
        preg_match_all('/#([^\s]+)/', $content, $hashtag);
        $hashtag = $hashtag[1];
        $HashtagsController->addHashtagsController($hashtag, $id_tweet);
        
        header('location: '.$uri);
    }

    public function showTweetUsers() {
        $data = $_POST;
        $tweetModel = new TweetModel;
        $id = $_SESSION["ID"];

        $all_tweet = $tweetModel->showTweetUsers(array(":id" => $id, ":limit" => $data['limit'],":offset" => $data['offset'] ));
        echo json_encode(array("tweets" => $all_tweet));
    }
}
