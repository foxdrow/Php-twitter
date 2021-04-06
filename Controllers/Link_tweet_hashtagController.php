<?php
namespace App\Controllers;


use App\Controllers\Controller;
use App\Models\Link_tweet_hashtagModel;

class Link_tweet_hashtagController extends Controller
{
    public function searchIdTweet($id_tag)
    {

        $hashtagsModel = new Link_tweet_hashtagModel;

        $id_tag_prepare = array(':id_tag' => $id_tag);

        $id_tag = $hashtagsModel->searchIdTweet($id_tag_prepare); 
        return $id_tweet;
    }

    public function linkHashtagToTweet($data) {
        $link_tweet_hashtagModel = new Link_tweet_hashtagModel;
        $link_tweet_hashtagModel->linkHashtagToTweet($data);
    }

}