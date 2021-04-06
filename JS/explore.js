let myOffset = 0;
let myLimit = 10;
let html = "";



$(document).ready(function() 
{

    var posting = $.post(`/Tweet/getTweetAndNickname`, {offset: myOffset, limit: myLimit});
    posting.done(function(data)
    {     
        
        data = JSON.parse(data)
        for(let c = 0; c < myLimit; c++)
        {
        $("#tweets-container").append(`
        <div class="row border-bottom">
            <h5 class="font-weight-bold mt-2 ml-4">${data.tweets[c].nickname}</h5><p class="mt-2 ml-2 text-secondary">@${data.tweets[c].nickname}</p>
            <p class="col-12 ml-2">${data.tweets[c].content}</p>
            <p class="col-12 ml-2 text-secondary">${data.tweets[c].date}</p>
        </div>
        `).ready(function()
        {
            click_mention();
            click_hashtag();
        })
        }
    });
    
    wait_for_scroll()
})

function wait_for_scroll()
{
    $(window).scroll(function()
    {
        if($(window).scrollTop() + $(window).height() == $(document).height())
            {
                var posting = $.post(`/Tweet/getTweetAndNickname`, {offset: myOffset, limit: myLimit});
                posting.done(function(data)
                {     
                    
                    data = JSON.parse(data)
                    for(let c = 0; c < myLimit; c++)
                    {
                    $("#tweets-container").append(`
                    <div class="row border-bottom">
                        <h5 class="font-weight-bold mt-2 ml-4">${data.tweets[c].nickname}</h5><p class="mt-2 ml-2 text-secondary">@${data.tweets[c].nickname}</p>
                        <p class="col-12 ml-2">${data.tweets[c].content}</p>
                        <p class="col-12 ml-2 text-secondary">${data.tweets[c].date}</p>
                    </div>
                    `).ready(function()
                    {
                        click_mention();
                        click_hashtag();
                    })
                    }
                });
                myOffset += 10;
            }
    })
}

function loadLastTweets()
{
    var posting = $.post(`/Tweet/getLastTweets`);
    posting.done(function(data)
    {     
        
        data = JSON.parse(data)
        for(let c = 0; c < myLimit; c++)
        {
        $("#tweets-container").prepend(`
        <div class="row border-bottom">
            <h5 class="font-weight-bold mt-2 ml-4">${data.tweets[c].nickname}</h5><p class="mt-2 ml-2 text-secondary">@${data.tweets[c].nickname}</p>
            <p class="col-12 ml-2">${data.tweets[c].content}</p>
            <p class="col-12 ml-2 text-secondary">${data.tweets[c].date}</p>
        </div>
        `).ready(function()
        {
            click_mention();
            click_hashtag();
        })
        }
    });
    wait_for_scroll()
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

setInterval(function(){
    loadLastTweets();
}, 300000)

let background_color = localStorage.getItem('background-color');
let color_text = localStorage.getItem('color-text');
let input_color = localStorage.getItem('input');

let body = document.querySelector("body");
let modal = document.querySelector(".modal-content");
let input = document.querySelectorAll("input");
let textarea = document.querySelectorAll("textarea");

textarea.forEach(element => {
    element.style.background = input_color;
});

input.forEach(element => {
    element.style.background = input_color;
});

modal.style.background = background_color;
body.style.background = background_color;
body.style.color = color_text;