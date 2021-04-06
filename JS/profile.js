let html = "";

let background_color = localStorage.getItem('background-color');
let color_text = localStorage.getItem('color-text');
let input_color = localStorage.getItem('input');

let card = document.querySelector(".card");
let body = document.querySelector("body");
let modal = document.querySelectorAll(".modal-content");
let input = document.querySelectorAll("input");
let textarea = document.querySelectorAll("textarea");

textarea.forEach(element => {
    element.style.background = input_color;
});

input.forEach(element => {
    element.style.background = input_color;
});

modal.forEach(element => {
    element.style.background = background_color;
});
card.style.background = background_color;
body.style.background = background_color;
body.style.color = color_text;

$("#following-modal").ready(function() {

    var posting = $.post(`/Link_user_follower_user_following/findAllFollowingSession`);
    posting.done(function(data){
        data = JSON.parse(data);
        count = data.following.length;
      
        for(let c = 0; c < count; c++) {
            $("#show-following").append(`
            <div class="p-0 container-fluid border-bottom following-button">
                <form method="post" action="/Link_user_follower_user_following/insertOrDeleteFollow">
                    <h5 class="col-12 font-weight-bold mt-3 ml-1">${data.following[c].nickname}</h5>
                    <p class="col-12 ml-1"><a id="${data.following[c].nickname}" href="#">@${data.following[c].nickname}</a><p>
                    <div class="pl-2 container-fluid d-flex justify-content-between">
                        <p class="ml-3">${data.following[c].bio}</p>
                        <button class="mb-2 btn btn-outline-success" type="submit">Follow/Unfollow</button>
                    </div>
                    <input type="text" name="nickname" value="${data.following[c].nickname}" class="input-following"></input>
                </form>
            </div>
            `).ready(function() {
                $(`#${data.following[c].nickname}`).click(function(event) {
                    event.preventDefault();
                    var posting = $.post(`/Users/otherProfilePage`, {nickname: event.target.id});
                    posting.done(function(data){
                        $("span").trigger("click");
                        $('.cont-tweet').detach();
                        $('.card-body').children().detach();
                        
                        data = JSON.parse(data);
                        if(data.user.bio == undefined) {
                            data.user.bio = "";
                        }
                        $('.card-body').append(`

                                    <div class="d-flex justify-content-between">
                                        <h4 class="font-weight-bold m-0 ml-1">${data.user.nickname}</h4>
                                    </div>
                                    <p class=" p-0 m-0 text-secondary">@${data.user.nickname}</p>
                                    <p>${data.user.bio}</p>
                                    
                                    <p class="text-secondary">${data.user.registration_date}</p>
                                    <div class="row pl-3">
                                        <p class="font-weight-bold">
                                        ${data.following}
                                        </p>
                                        <p class="text-black mr-3">
                                            Following
                                        </p>
                                        <p class="font-weight-bold">
                                        ${data.follower}
                                        </p>
                                        <p class="text-black">
                                            Follower
                                        </p>

                                        <form method="post" action="/Link_user_follower_user_following/insertOrDeleteFollow">
                                            <button class="mb-2 ml-5 btn btn-outline-success" type="submit">Follow/Unfollow</button>
                                            <input type="text" name="nickname" value="${data.user.nickname}" class="input-following"></input>
                                        </form>
                                    </div>
                        `)

                        let tweetlimit = 4;
                        let tweetoffset = 0;
                        var posting = $.post(`/Tweet/getTweetOfOneMember`, {offset: tweetoffset, limit: tweetlimit, nickname: data.user.nickname});
                        posting.done(function(data){
                            data = JSON.parse(data);

                            if(data.tweets[0] != undefined){
                                $('#mid-section').append(
                                    `<div class="container border-bottom border-top">
                                        <h5 class="col-9 text-primary font-weight-bold p-0 m-0 ml-1">TWEET</h5>
                                    </div>`
                                );
                            }

                            for(let c = 0; c < tweetlimit; c++)
                            {
                                if(data.tweets[c] != undefined){
                                    $("#mid-section").append(`
                                    <div class="row border-bottom">
                                    <h5 class="col-9 font-weight-bold ml-2 mt-2">${data.tweets[c].nickname}</h5>
                                    <p class="col-9 ml-2">${data.tweets[c].content}</p>
                                    <p class="col-9 ml-2 text-secondary" id="date${c}">${data.tweets[c].date}</p>
    
                                        <a class="col-12 ml-2" id="display_comments${c}" name="${data.tweets[c].id}">Afficher les commentaires</a>
                                    
                                    <form method="post" class="ml-4" action="/Comments/addCommentsToTweet">
                                        <input style="display:none" type="text" name="id_tweet" value="${data.tweets[c].id}"></input>
                                        <input type="text" name="content"></input>
                                        <button class="mb-2 btn btn-outline-success" type="submit">Ajouter un commentaire</button>
                                    </form>
                                    <form method="post" class="ml-2" action="/Tweet/addTweet">
                                        <input style="display:none" type="text" name="content" value="${data.tweets[c].content}"></input>
                                        <button class="mb-2 btn btn-outline-success" type="submit">Retweeter</button>
                                    </form>
                                    `).ready(function(){

                                        $(`#display_comments${c}`).click(function(event){
                                            event.preventDefault();
                                            var posting = $.post(`/Comments/findCommentsByTweetId`, {tweetId: event.target.name});
                                            posting.done(function(data)
                                            {
                                                data = JSON.parse(data);
                                                for(let x = 0; x < data.comments.length; x++){
                                                $(`#date${c}`).append(`
                                                    <div class="container border">
                                                        <h6 class="col-9 text-black font-weight-bold ml-2 mt-2">${data.comments[x].nickname}</h6>
                                                        <p class="col-9 ml-2">${data.comments[x].content}</p>
                                                        <p class="col-9 ml-2 text-secondary" id="date">${data.comments[x].date}</p>
                                                    </div>
                                                `)
                                                };
                                            });
        
                                        });
        
                                    });
                                }
                            }
                        });
                    });
                })
            })
        };
    })
});     

$("#follower-modal").ready(function() {

    var posting = $.post(`/Link_user_follower_user_following/findAllFollowerSession`);
        posting.done(function(data){
            data = JSON.parse(data);
        
        count = data.following.length;
        for(let c = 0; c < count; c++)
        $("#show-follower").append(`
        <div class="p-0 container-fluid border-bottom following-button">
            <form method="post" action="/Link_user_follower_user_following/insertOrDeleteFollow">
                <h5 class="col-12 font-weight-bold mt-3 ml-1">${data.following[c].nickname}</h5>
                <p class="col-12 ml-1">@${data.following[c].nickname}</p>
                <div class="pl-2 container-fluid d-flex justify-content-between">
                    <p class="ml-3">${data.following[c].bio}</p>
                    <button class="mb-2 btn btn-outline-success" type="submit">Follow/Unfollow</button>
                </div>
                <input type="text" name="nickname" value="${data.following[c].nickname}" class="input-following"></input>
            </form>
        </div>
        `)

    });
})

$("body").ready(function() {

    let tweetlimit = 4;
    let tweetoffset = 0;

    var posting = $.post(`/Tweet/showTweetUsers`, {offset: tweetoffset, limit: tweetlimit});
        posting.done(function(data) {
            data = JSON.parse(data);
            let count = data.tweets.length;

        $('#mid-section').append(
            `
            <div class="cont-tweet">
            <div class="container border-bottom border-top">
                <h5 class="col-9 text-primary font-weight-bold p-0 m-0 ml-1">TWEET</h5>
            </div>
            </div>
            `
        ).ready(function() {
            for(let c = 0; c < count; c++)
            $(".cont-tweet").append(`
                <div class="container border-right border-left border-bottom">
                <div class="row mt-2 ml-2">
                    <h5 class="font-weight-bold">${data.tweets[c].nickname}</h5><p class="ml-2 text-secondary">@${data.tweets[c].nickname}</p>
                    </div>
                    <p class="col-12 m-0 mb-2 p-0">${data.tweets[c].content}</p>
                    <p class="col-12 text-secondary m-0 p-0">${data.tweets[c].date}</p>
                </div>
            `).ready(function()
            {
                click_mention();
                click_hashtag();
            })
        })
        })
})

function click_mention()
{
    $('.link-mention').click(function(event)
    {    
        event.preventDefault();
        console.log('it works');

    })
}

function click_hashtag()
{
    $('.link-hashtag').click(function(event)
    {    
        event.preventDefault();
        console.log('it works');

    })
}

$("#lightgrey").click(function (event) {
    event.preventDefault();
    localStorage.clear()
    localStorage['background-color'] = "lightgrey";
    localStorage['color-text'] = "black";
    localStorage['input'] = "darkblue";
    window.location = "/Users/profilePage";
})

$("#white").click(function (event) {
    event.preventDefault();
    localStorage.clear();
    localStorage['background-color'] = "white";
    localStorage['color-text'] = "black";  
    localStorage['input'] = "white";
    window.location = "/Users/profilePage";
})

$("#kawai").click(function (event) {
    event.preventDefault();
    localStorage.clear();
    localStorage['background-color'] = "pink";
    localStorage['color-text'] = "black"; 
    localStorage['input'] = "#E9BABA";
    window.location = "/Users/profilePage"; 
})