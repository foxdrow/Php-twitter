<?php

namespace App\Controllers;

session_start();

use App\Controllers\Controller;
use App\Models\UsersModel;
use App\Controllers\Link_user_follower_user_followingController;

class UsersController extends Controller
{
    private $registration_date;
    private $follower;
    private $following;
    private $bio;

    /*--------------------------- RENDER ---------------------------*/

    public function index()
    {
        if(isset($_SESSION['NICKNAME']) && isset($_SESSION['EMAIL'])){
            header('Location: /Users/profilePage');
        }else{
            $this->render('Registration/index');
        }
    }

    public function connectionPage()
    {
        if(isset($_SESSION['NICKNAME']) && isset($_SESSION['EMAIL'])){
            header('Location: /Users/profilePage');
        }else{
            $this->render('Connection/index');
        }
    }

    public function messagePage(){
        $this->render('Message/index');
    }

    public function profilePage(){
        $this->initialize();
        $this->render('./Profile/index');
    }

    public function otherProfilePage(){
        $nickname = $_POST['nickname'];

        $userModel = new UsersModel;
        $to_js = $userModel->searchUsers(array(":nickname" => $nickname));

        $link_user_follower_user_followingController = new Link_user_follower_user_followingController;
        $following = $link_user_follower_user_followingController->countFollowingOther(array(":nickname" => $nickname));
        $follower = $link_user_follower_user_followingController->countFollowerOther(array(":nickname" => $nickname));

        echo json_encode(array("user" => $to_js, "following" => $following, "follower" => $follower));
    }

    public function explorePage(){
        $this->render('./Explore/index');
    }

    public function searchPage()
    {
        $this->initialize();
        $this->render('./Search/index');
    }
    
    /*--------------------------- REGISTER ---------------------------*/

    public function registration()
    {

        $data = $_POST;
        $check_email = 0;
        if (!empty($data['nickname']) && !empty($data['email']) && !empty($data['password']) && !empty($data['birthday']) && !empty($data['password_verif'])) {

            $userModel = new UsersModel;

            $check_nickname = $userModel->nicknameExist(array(":nickname" => $data['nickname']));

            if($check_nickname->exist == 1){
                return var_dump("Nickname already taken");
            }

            $options = [
                'salt' => "vive le projet tweet_academy"
            ];
            $password_hash = password_hash($data['password'], PASSWORD_BCRYPT, $options);

            if ($data['password'] !== $data['password_verif']) {

                return var_dump("password not correct.");
            } elseif (strlen($data['password']) < 8) {

                return  var_dump("password too short.");
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

                return  var_dump("Invalid email format.");
            }

            array_splice($data, 2, 1);
            $data['password'] = $password_hash;


            foreach ($data as $key => $value) {

                array_shift($data);
                $data[':' . $key] = trim($value);
            }

            $check_email = $userModel->emailExist(array(":email" => $data[':email']));
            if ($check_email->exist == 1) {
                return var_dump("Email already taken.");
            } else {

                $userModel->registration($data);

                $getAll_result = $userModel->getAll(array(':email' => $data[':email']));

                $_SESSION['ID'] = $getAll_result->id;
                $_SESSION['EMAIL'] = $getAll_result->email;
                $_SESSION['NICKNAME'] = $getAll_result->nickname;

                $this->profilePage();
            }
        } else {
            echo "Champs manquant";
        }
    }

    /*--------------------------- LOGIN ---------------------------*/

    public function userConnection()
    {

        $data = $_POST;
        foreach ($data as $key => $value) {

            array_shift($data);
            $data[':' . $key] = trim($value);
        }

        $userModel = new UsersModel;

        if (!empty($data[':email']) && !empty($data[':password'])) {

            $emailExist = $userModel->emailExist(array(':email' => $data[':email']));

            if ($emailExist->exist ==  0) {
                echo "email inexistant";
            } elseif ($emailExist->exist ==  1) {
                $password_hash = $userModel->getPassword(array(':email' => $data[':email']));

                if (password_verify($data[':password'], $password_hash->password) == true) {
                    $getAll_result = $userModel->getAll(array(':email' => $data[':email']));

                    $_SESSION['ID'] = $getAll_result->id;
                    $_SESSION['EMAIL'] = $getAll_result->email;
                    $_SESSION['NICKNAME'] = $getAll_result->nickname;

                    $this->profilePage();
                } else {
                    echo "Wrong password";
                }
            }
        }
    }

    public function calculMonth($datetime)
    {
        list($date, $time) = explode(" ", $datetime);
        list($year, $month, $day) = explode("-", $date);
        $months_word = array(
            "january", "february", "march", "april", "may", "june",
            "july", "august", "september", "october", "november", "december"
        );
        $registration_month = $months_word[$month - 1];
        $registration_date = $registration_month . ' ' . $year;
        return $registration_date;
    }

    public function registrationDate()
    {
        $userModel = new UsersModel;
        $data = $_SESSION['EMAIL'];
        $result = $userModel->getAll(array(':email' => $data));
        $datetime = $result->registration_date;
        $registration_date = $this->calculMonth($datetime);

        $this->setRegistrationDate($registration_date);
    }

    public function findNumberFollow()
    {
        $follow = new Link_user_follower_user_followingController;
        $this->setFollower($follow->countFollowerSession());
        $this->setFollowing($follow->countFollowingSession());
    }

    public function bio(){
        $model = new UsersModel;
        $all = $model->getAll(array(':email' => $_SESSION['EMAIL']));
        $bio = $all->bio;

        $this->setBio($bio);
    }

    public function initialize() {

        $this->findNumberFollow();
        $this->registrationDate();
        $this->bio();
    }

    public function editProfile()
    {
        $users_model = new UsersModel;
        $data = $_POST;
        foreach ($data as $key => $value){
            array_shift($data);
            $data[':'. $key] = trim($value);
        }

        $this->updateBio($users_model, $data[':bio']);

        if($data[':nickname'] != '') {
            $nickname_exist = $users_model->nicknameExist(array(':nickname' => $data[':nickname']));
            $exist = $nickname_exist->exist;
            $this->updateNickname($users_model, $data[':nickname'], $exist);
        }else
        {
        $this->profilePage();
        }
    }

    public function updateNickname($model, $nickname, $exist)
    {
        if($exist == 1){
            $this->profilePage();
        }
        else{
        $data = array(
            ':nickname' => $nickname,
            ':id' => $_SESSION['ID']
        );
        $model->updateNickname($data);
        $_SESSION['NICKNAME'] = $nickname;

        $this->profilePage();
        }   
    }

    public function updateBio($model, $bio)
    {   
        if($bio !== ''){
            $data = array(
                ':bio' => $bio,
                ':id' => $_SESSION['ID']
            );
            $model->updateBio($data);
        }
        else {
        }
    }

    public function searchUsers($userNickname)
    {
        $userModel = new UsersModel;
        return $userModel->searchUsers(array(":nickname" => $userNickname));
    }

    public function nicknameExist($userNickname)
    {
        $userModel = new UsersModel;
        return $userModel->nicknameExist(array(":nickname" => $userNickname));
    }

    public function test()
    {
        echo "ok";
    }

    public function logout() {
        session_destroy();
        header('Location: /');
    }

    /*------------------------- GETTER -------------------------*/

    public function getRegistrationDate()
    {
        return $this->registration_date;
    }

    public function getBio()
    {
        return $this->bio;
    }

    public function getFollower() {
        return $this->follower;
    }

    public function getFollowing()
    {
        return $this->following;
    }
    /*------------------------- SETTER -------------------------*/

    public function setRegistrationDate($registration_date)
    {
        $this->registration_date = $registration_date;
    }

    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    public function setFollower($follower)
    {
        $this->follower = $follower;
    }

    public function setFollowing($following)
    {
        $this->following = $following;
    }

}
