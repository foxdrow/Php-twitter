    let myOffset = 0;
    let myLimit = 10;
    let html = "";
    $('#search').submit(function(event) 
    {
            myOffset = 0;
            $('#container-tweet').children().detach();

            var $form = $(this),
            term = $form.find("input[name='input_search']").val();
            var posting = $.post(`/Hashtags/searchTweetFromTag`, {input_search: term, offset: myOffset, limit: myLimit});
            posting.done(function(data)
            {   

                data = JSON.parse(data);

                if(data.user != undefined) 
                {
                    $('#container-tweet').append(
                        `<div class="row border-bottom test">
                            <h5 class="col-9 text-primary font-weight-bold ml-2 mt-2">MEMBER</h5>
                        </div>`
                    );

                    for(let c = 0; c < myLimit; c++)
                    {
                        if(data.user[c]) {
                            $('#container-tweet').append(`
                            <div class="p-0 container-fluid following-button">
                                    <form method="post" action="/Link_user_follower_user_following/insertOrDeleteFollow">
                                    <div class="row mt-2 ml-2">
                                      <h5 class="font-weight-bold">${data.user[c].nickname}</h5><p class="ml-2 text-secondary">@${data.user[c].nickname}</p>
                                    </div>
                                    <div class="pl-2 container-fluid d-flex justify-content-between">
                                        <p class="ml-3">${data.user[c].bio}</p>
                                        <button class="mb-2 btn btn-outline-success" type="submit">Follow/Unfollow</button>
                                    </div>
                                        <input type="text" name="nickname" value="${data.user[c].nickname}" class="input-users" style="display : none"></input>
                                    </form>
                                  </div>
                            `);
                        }else{
                            return mention();
                        }
                        wait_for_scroll_users(term)
                    }

                    function mention() {
                        if(data.mention) 
                        {
                            $('#container-tweet').append(
                                `<div class="row border-bottom border-top">
                                    <h5 class="col-9 text-primary font-weight-bold ml-2 mt-2">MENTION</h5>
                                </div>`
                            );
        
                            for(let c = 0; c < myLimit; c++)
                            {
                                if(data.mention[c]) {
                                    $('#container-tweet').append(`
                                        <div class="row border-bottom">
                                        <h5 class="font-weight-bold mt-2 ml-4">${data.mention[c].nickname}</h5><p class="mt-2 ml-2 text-secondary">@${data.mention[c].nickname}</p>
                                        <p class="col-12 ml-2">${data.mention[c].content}</p>
                                        <p class="col-12 ml-2 text-secondary">${data.mention[c].date}</p>
                                        </div>
                                    `).ready(function()
                                    {
                                        click_mention();
                                        click_hashtag();
                                    });
                                }else{
                                    return null;
                                }
                                wait_for_scroll_users(term)
                            }
                        }
                    }
                }

                if(data.hashtag != undefined) 
                {
                    for(let c = 0; c < myLimit; c++)
                    {
                        if(data.hashtag[c]) 
                        {
                        
                            $('#container-tweet').append(
                                `<div class="row border-bottom">
                                <h5 class="col-9 font-weight-bold ml-2 mt-2">${data.hashtag[c].nickname}</h5>
                                <p class="col-9 ml-2">${data.hashtag[c].content}</p>
                                <p class="col-9 ml-2 text-secondary" id="date${c}">${data.hashtag[c].date}</p>

                                    <a class="" id="display_comments${c}" name="${data.hashtag[c].id_tweet}">Afficher les commentaires</a>
                                
                                <form method="post" class="ml-4" action="/Comments/addCommentsToTweet">
                                    <input style="display:none" type="text" name="id_tweet" value="${data.hashtag[c].id_tweet}"></input>
                                    <input type="text" name="content"></input>
                                    <button class="mb-2 btn btn-outline-success" type="submit">Ajouter un commentaire</button>
                                </form>
                                <form method="post" class="ml-2" action="/Tweet/addTweet">
                                    <input style="display:none" type="text" name="content" value="${data.hashtag[c].content}"></input>
                                    <button class="mb-2 btn btn-outline-success" type="submit">Retweeter</button>
                                </form>
                            </div>`
                            ).ready(function(){

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
                        else
                        {
                            return null;
                        }
                    }
                    wait_for_scroll_tags(term)
                }
            })
        event.preventDefault();
    })


function wait_for_scroll_tags(term)
{
    $(window).scroll(function()
    {
        if($(window).scrollTop() + $(window).height() == $(document).height())
        {
            myOffset += 5;
            var posting = $.post(`/Hashtags/searchTweetFromTag`, {input_search: term, offset: myOffset, limit: myLimit});
            posting.done(function(data)
            {
                data = JSON.parse(data)
                for(let c = 0; c < myLimit; c++)
                $('#container-tweet').append(
                    `<div class="row border-bottom test">
                        <h5 class="col-9 font-weight-bold ml-2 mt-2">${data.hashtag[c].nickname}</h5>
                        <p class="col-9 ml-2">${data.hashtag[c].content}</p>
                        <p class="col-9 ml-2 text-secondary">${data.hashtag[c].date}</p>
                    </div>`
                ).ready(function()
                {
                    click_mention();
                    click_hashtag();
                });
            })
        }
    })
}

function wait_for_scroll_users(term)
{
    $(window).scroll(function()
    {
        if($(window).scrollTop() + $(window).height() == $(document).height())
        {
            myOffset += 5;
            var posting = $.post(`/Hashtags/searchTweetFromTag`, {input_search: term, offset: myOffset, limit: myLimit});
            posting.done(function(data)
            {
                data = JSON.parse(data)
                for(let c = 0; c < myLimit; c++)
                {
                    if(data.user[c]) 
                    {
                        $('#container-tweet').append(
                            `<div class="row border-bottom test">
                                <h5 class="col-9 font-weight-bold ml-2 mt-2">${data.user[c].nickname}</h5>
                            </div>`
                        );
                    }
                }
            })
        }
    })
}

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


let background_color = localStorage.getItem('background-color');
let color_text = localStorage.getItem('color-text');
let input_color = localStorage.getItem('input');

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
body.style.background = background_color;
body.style.color = color_text;