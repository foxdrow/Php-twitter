<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../views/Profile/style.css">
    <link rel="stylesheet" href="../Views/Style/style.css">
    <title>Twitter - Profile</title>
</head>

<body>
    <div class="container">
        <div class="row">

            <div class=" col-1 border-right vh-100 pr-0 pl-0" id="div-nav">
                <nav class="navbar pr-0 pl-1 mr-5 flex-column col-2 navbar-light ">
                    <ul class="navbar-nav">    
                        <li class="" id="nav-hover">
                            <a class="" href="/Users/explorePage"><img src="../Views/Assets/twitter_icn/home.png" alt=""></a>
                        </li>
                        <li class="" id="nav-hover">
                            <a class="" href="/Users/searchPage"><img src="../Views/Assets/twitter_icn/search.png" alt=""></a>
                        </li>
                        <li class="" id="nav-hover">
                            <a class="" href="/Users/messagePage"><img src="../Views/Assets/twitter_icn/message.png" alt=""></a>
                        </li>
                        <li class="active" id="nav-hover">
                            <a class="" href="/Users/profilePage"><img src="../Views/Assets/twitter_icn/profil.png" alt=""></a>
                        </li>
                        <li class="">
                            <button type="button" id="btn-tweet" class="btn p-0" data-toggle="modal" data-target="#tweetModal">
                                <img src="../Views/Assets/twitter_icn/tweet.png" alt="">
                            </button>
                        </li>
                        <li class="" id="">
                            <a class="" href="/Users/logout"><img class="logout" src="../Views/Assets/twitter_icn/logout.png" alt=""></a>
                        </li>
                    </ul>
                </nav>
            </div>
            
            <div class="modal fade" id="tweetModal" aria-labelledby="tweetModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header p-2">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/tweet/addTweet">
                            <div class="form-group">
                                <textarea name="content" placeholder="What's happening ?" class="form-control" id="message-text"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btn-post-tweet">Tweet</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" col-7 vh-100 p-0" id="mid-section">
                <div class="container border">
                    <div class="row">
                        <div class="col-2 align-self-center p-0">
                            <a class="" href="#" ><img id="icn-back" src="../Views/Assets/twitter_icn/back.png" alt=""></a>
                        </div>
                        <div class="col-10 align-self-center pl-3">
                            <h4 class="font-weight-bold"><?= $_SESSION['NICKNAME'] ?></h4>
                        </div>
                    </div>
                </div>
            
                <div class="card">
                    <img class="card-img-top" src="../Views/Assets/background-profile.jpg" alt="Card image cap">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="font-weight-bold m-0 ml-1"><?= $_SESSION['NICKNAME'] ?></h4>
                            <button type="button" class="btn btn-link" id="btn-edit-profile" data-toggle="modal" data-target="#profil-modal">
                                <p class="font-weight-bold color-primary m-0">Edit Profile</p>
                            </button>
                        </div>
                        <p><?= $this->getBio()?> </p>
                        <p class=" p-0 m-0 text-secondary">@<?= $_SESSION['NICKNAME'] ?></p>
                        <p class="text-secondary"><?= $this->getRegistrationDate() ?></p>
                        <div class="row pl-3">
                            <p class="font-weight-bold">
                                <?= $this->getFollowing()?>
                            </p>
                            <p class="text-secondary mr-3">
                                <a type="button" class="p-0" id="" data-toggle="modal" data-target="#following-modal">Following</a>
                            </p>
                            <p class="font-weight-bold">
                                <?= $this->getFollower() ?>
                            </p>
                            <p class="text-secondary">
                                <a type="button" class="" id="" data-toggle="modal" data-target="#follower-modal">Follower</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="following-modal" aria-labelledby="following-modalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header p-2">
                            <p class="font-weight-bold color-primary ml-2 m-0" id="following-section">Following</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body m-0 p-0">
                            <div id="show-following">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="follower-modal" aria-labelledby="follower-modalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header p-2">
                            <p class="font-weight-bold color-primary m-0" id="follower-section">Follower</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="show-follower">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="profil-modal" aria-labelledby="profil-modalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header p-2">
                            <p class="font-weight-bold color-primary m-0 pl-3">Edit Profile</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="./editProfile">
                            <div class="form-group">
                                <input class="form-control mb-4" type="text" placeholder="Nickname" id="nickname" name="nickname">
                                <textarea placeholder="Bio" class="form-control" id="bio" name="bio"></textarea>
                            </div>
                            <div id="button_theme">
                            <button class="btn btn-secondary" id="lightgrey">Lightgrey</button>
                            <button class="btn btn-light" id="white">White</button>
                            <button class="btn btn-danger" id="kawai">Kawai</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" col-2 border-left vh-100">
                <form class="form-inline pt-2" method="post" action="/Hashtags/searchTweetFromTag">
                    <input class="form-control mr-sm-2 mb-2 p-2" type="text" name="hashtag" placeholder="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" id="btn-search" type="submit">Search</button>
                </form>         
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="../../JS/profile.js"></script>
</body>
</html>