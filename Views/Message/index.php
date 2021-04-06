<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!--BOOTSTRAP--->
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="../Views/Style/style.css">
    <title>Twitter - Message</title>
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
                        <li class="active" id="nav-hover">
                            <a class="" href="/Users/messagePage"><img src="../Views/Assets/twitter_icn/message.png" alt=""></a>
                        </li>
                        <li class="" id="nav-hover">
                            <a class="" href=/Users/profilePage><img src="../Views/Assets/twitter_icn/profil.png" alt=""></a>
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

            <div class=" col-8 vh-100 p-0 border-right">
                <div class="container border-bottom">
                    <form class="form-inline pl-4 pt-4 pr-4 row d-flex justify-content-between" method="post" id="conv-search">
                        <input class="form-control col-8" type="text" name="nameUser" placeholder="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0 col-3 btn-search-conv" id="btn-search" type="submit">Search</button>
                    </form>
                    <div class="row mt-2 justify-content-end">
                        <button class="btn btn-outline-primary mr-4 mb-3" id="btn-start-conversation" type="button" data-toggle="modal" data-target="#messageModal">Send a new message</button>
                    </div>
                </div>

                <div class="modal fade" id="messageModal" aria-labelledby="messageModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header p-2">
                                <p class="font-weight-bold color-primary m-0">New message</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form method="post" action="/Message/usersSendPm">
                                    <div class="form-group mt-2">
                                        <input class="form-control col-7" type="text" name="nameUser" placeholder="Send to ?">
                                        <br>
                                        <textarea placeholder="Message" name="content" class="form-control" id="message-text"></textarea>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="btn-save">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-bottom" id="message-container">
                    Veuillez taper le nom d'un utilisateur pour voir votre conversation
                </div>
            </div>

        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
        <script src="../JS/message.js"></script>
</body>

</html>