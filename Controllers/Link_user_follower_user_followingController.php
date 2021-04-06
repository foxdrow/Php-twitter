<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Controllers\UsersController;
use App\Models\Link_user_follower_user_followingModel;

class Link_user_follower_user_followingController extends Controller
{
    private $count_follower_sessions;
    private $count_following_sessions;

    public function findIdFollowing($nickname)
    {
        $followerFollowingModel = new Link_user_follower_user_followingModel;
        $id = $followerFollowingModel->findIdFollowing(array(':nickname' => $nickname));
        $id = $id->id;
        return $id;
    }

    public function insertOrDeleteFollow()
    {
        $followerFollowingModel = new Link_user_follower_user_followingModel;
        $users_controller = new UsersController;
        $nickname = $_POST['nickname'];
        $id_following_prepare = $this->findIdFollowing($nickname);
        $id_follower_prepare = $_SESSION['ID'];
        $data = array(
            ':id_follower' => $id_follower_prepare,
            ':id_following' => $id_following_prepare
        );
        $followExist = $followerFollowingModel->insertOrDeleteFollow($data);
        if ($followExist->exist == 1) {
            $this->deleteFollow($id_follower_prepare, $id_following_prepare, $followerFollowingModel);
        } else {
            $this->insertFollow($id_follower_prepare, $id_following_prepare, $followerFollowingModel);
        }

        $uri = "/Users" . strrchr($_SERVER['HTTP_REFERER'], "/");

        header('location: ' . $uri);
    }

    public function insertFollow($id_follower_prepare, $id_following_prepare, $followerFollowingModel)
    {
        $data = array(
            ':id_follower' => $id_follower_prepare,
            ':id_following' => $id_following_prepare
        );

        $followerFollowingModel->insertFollow($data);
    }

    public function deleteFollow($id_follower_prepare, $id_following_prepare, $followerFollowingModel)
    {
        $data = array(
            ':id_follower' => $id_follower_prepare,
            ':id_following' => $id_following_prepare
        );

        $followerFollowingModel->deleteFollow($data);
    }

    public function countFollowerSession()
    {
        $followerFollowingModel = new Link_user_follower_user_followingModel;
        $email_prepare = $_SESSION['EMAIL'];

        $count_follower = $followerFollowingModel->countFollower(array(':email' => $email_prepare));

        if ($count_follower !== false) {
            $total = $count_follower->total;
            return $total;
        }
    }

    public function countFollowerOther()
    {
        $data = $_POST['nickname'];
        $followerFollowingModel = new Link_user_follower_user_followingModel;
        $email = $followerFollowingModel->findEmail(array(':nickname' => $data));
        $email_prepare = $email->email;
        $count_follower = $followerFollowingModel->countFollower(array(':email' => $email_prepare));
        $total = $count_follower->total;

        return $total;
    }

    public function countFollowingSession()
    {
        $followerFollowingModel = new Link_user_follower_user_followingModel;
        $email_prepare = $_SESSION['EMAIL'];

        $count_following = $followerFollowingModel->countFollowing(array(':email' => $email_prepare));

        if ($count_following !== false) {
            $total = $count_following->total;
            return $total;
        }
    }

    public function countFollowingOther()
    {
        $data = $_POST['nickname'];
        $followerFollowingModel = new Link_user_follower_user_followingModel;
        $email = $followerFollowingModel->findEmail(array(':nickname' => $data));
        $email_prepare = $email->email;
        $count_follower = $followerFollowingModel->countFollower(array(':email' => $email_prepare));
        $total = $count_follower->total;

        return $total;
    }

    public function findAllFollowingSession()
    {
        $followerFollowingModel = new Link_user_follower_user_followingModel;
        $id_prepare = $_SESSION['ID'];
        $data = $followerFollowingModel->findAllFollowing(array(':id' => $id_prepare));


        echo json_encode(array("following" => $data));
    }

    public function findAllFollowingOther()
    {
        $followerFollowingModel = new Link_user_follower_user_followingModel;
        $nickname = $_POST['nickname'];
        $id_prepare = $this->findIdFollowing($nickname);

        $data = $followerFollowingModel->findAllFollowing(array(':id' => $id_prepare));
    }

    public function findAllFollowerSession()
    {
        $followerFollowingModel = new Link_user_follower_user_followingModel;
        $id_prepare = $_SESSION['ID'];
        $data = $followerFollowingModel->findAllFollower(array(':id' => $id_prepare));

        echo json_encode(array("following" => $data));
    }

    public function findAllFollowerOther()
    {
        $followerFollowingModel = new Link_user_follower_user_followingModel;
        $nickname = $_POST['nickname'];
        $id_prepare = $this->findIdFollowing($nickname);

        $data = $followerFollowingModel->findAllFollower(array(':id' => $id_prepare));
    }
}
