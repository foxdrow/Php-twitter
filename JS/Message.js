let myOffset = 0;
let myLimit = 10;
let html = "";

$("#conv-search").submit(function (event) {

  var $form = $(this),
    term = $form.find("input[name='nameUser']").val();

  let posting = $.post("/Message/searchUsersConversation", { nameUser: term, limit: myLimit, offset: myOffset });

  posting.done(function (data) {

    data = JSON.parse(data);

    if (data == 0) {
      $("#message-container").html("");
      $("#message-container").append(`
        <div class="row border-bottom">
            <p class="col-12 ml-2">Vous n'avez pas encore de message avec cette utilisateur</p>
        </div>
        `);
    } else {
      $("#message-container").html("");
      for (let c = 0; c < myLimit; c++)
      {
        $("#message-container").append(`
        <div class="container border-bottom">
            <h5 class="font-weight-bold mt-2 ml-4">${data[c].nickname}</h5>
            <p class="col-12 ml-2">${data[c].content}</p>
            <p class="col-12 ml-2 text-secondary">${data[c].date}</p>
        </div>
        `).ready(function()
        {
            click_mention();
            click_hashtag();
        });
      }
    }
  });
  wait_for_scroll(term);
  event.preventDefault();
});

function wait_for_scroll(term) {
  $(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() == $(document).height()) 
    {
      myOffset += 10;
      var posting = $.post(`/Message/searchUsersConversation`, { nameUser: term, limit: myLimit, offset: myOffset });
      posting.done(function (data) 
      {
        let c = 0;

        data = JSON.parse(data);

        console.log(myOffset)
        console.log(data);
        
        if (data[c])
        {
            for (let c = 0; c < myLimit; c++)
            {
              if (data[c])
              {
                $("#message-container").append(`
                  <div class="container border-bottom">
                    <h5 class="font-weight-bold mt-2 ml-4">${data[c].nickname}</h5>
                    <p class="col-12 ml-2">${data[c].content}</p>
                    <p class="col-12 ml-2 text-secondary">${data[c].date}</p>
                  </div>
              `).ready(function()
              {
                  click_mention();
                  click_hashtag();
              });
              }
            }
        }
      });
    }
  });
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