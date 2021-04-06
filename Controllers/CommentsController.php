<?php

namespace App\Controllers;

session_start();


use App\Controllers\Controller;
use App\Models\CommentsModel;

class CommentsController extends Controller
{

    public function addCommentsToTweet()
    {
        $uri = "/Users" . strrchr($_SERVER['HTTP_REFERER'], "/");
        if (!empty($_POST['id_tweet']) && !empty($_POST['content'])) {

            $MessageModel = new CommentsModel;

            $data = array(
                ":id_tweet" => $_POST['id_tweet'],
                ":id_user" => $_SESSION['ID'],
                ":content" => $_POST['content']
            );
            $MessageModel->addCommentsToTweet($data);
            header('location: '.$uri);
        }
        header('location: '.$uri);
    }

    public function findCommentsByTweetId(){
        $data = $_POST;
        $commentsModel = new CommentsModel;
        $to_js = $commentsModel->findCommentsByTweetId(array(":id_tweet" => $data['tweetId']));
        echo json_encode(array("comments" => $to_js));
    }
    
}
