<?php

namespace App\Controllers;

session_start();


use App\Controllers\Controller;
use App\Models\MessageModel;

class MessageController extends Controller
{
    public function usersSendPm()
    {
        $uri = "/Users" . strrchr($_SERVER['HTTP_REFERER'], "/");

        if (!empty($_POST['nameUser']) && !empty($_POST['content'])) {

            $MessageModel = new MessageModel;
            $userExist = $this->userExist();

            if ($userExist == true) {
                $userId = $this->getUserIdWithNickname();
                $userId = $userId->id;
                $date = date("Y-m-d");
                $data = array(
                    ":id_from" => $_SESSION['ID'],
                    ":id_to" => $userId,
                    ":content" => $_POST['content']
                );
                $MessageModel->sendMessages($data);
                header('location: '.$uri);
            } else {
                echo 'user does not exist';
                header('location: '.$uri);
            }
        }else{
            header('location: '.$uri);
        }
    }

    public function userExist()
    {
        $MessageModel = new MessageModel;

        $nameUser = $_POST['nameUser'];
        $data = array(
            ":nickname" => $nameUser
        );

        $response = $MessageModel->userExist($data);
        $response = $response->exist;
        return $response;
    }

    public function getUserIdWithNickname()
    {
        $MessageModel = new MessageModel;

        $nameUser = $_POST['nameUser'];
        $data = array(
            ":nickname" => $nameUser
        );

        $idUser = $MessageModel->getUserIdWithNickname($data);
        return $idUser;
    }

    public function searchUsersConversation()
    {

        if (!empty($_POST['nameUser'])) {
            $limit = $_POST['limit'];
            $offset = $_POST['offset'];

            $limit = intval($limit);
            $offset = intval($offset);

            $MessageModel = new MessageModel;
            $userExist = $this->userExist();

            if ($userExist == true) {
                $userId = $this->getUserIdWithNickname();
                $userId = $userId->id;

                $data = array(
                    ":id_from" => $_SESSION['ID'],
                    ":id_to" => $userId,
                    ":id_from2" => $_SESSION['ID'],
                    ":id_to2" => $userId,
                    ":limit" => $limit,
                    ":offset" => $offset
                );

                $conversation = $MessageModel->searchUsersConversation($data);
                echo json_encode($conversation);
            } else {
                echo 0;
            }
        }
    }
}
