// let script = document.createElement("script");
// script.src = "https://code.jquery.com/jquery-3.6.3.min.js";
// document.getElementsByTagName("head")[0].appendChild(script);

var input = document.querySelector("#select_post_img");

input.addEventListener("change", preview);

function preview() {
  var fileobject = this.files[0];
  var filereader = new FileReader();

  filereader.readAsDataURL(fileobject);

  filereader.onload = function () {
    var image_src = filereader.result;
    var image = document.querySelector("#doubt_img");
    image.setAttribute("src", image_src);
    image.setAttribute("style", "display:");
  };
}

$(".followbtn").click(function () {
  var user_id_v = $(this).data("userId");
  var button = this;
  $(button).attr("disabled", true);

  $.ajax({
    url: "assets/php/ajax.php?follow",
    method: "post",
    dataType: "json",
    data: { user_id: user_id_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        $(button).data("userId", 0);
        $(button).html("✔Followed");
      } else {
        $(button).attr("disabled", false);

        alert("something is wrong,try again after some time");
      }
    },
  });
});

$(".unfollowbtn").click(function () {
  var user_id_v = $(this).data("userId");
  var button = this;
  $(button).attr("disabled", true);

  $.ajax({
    url: "assets/php/ajax.php?unfollow",
    method: "post",
    dataType: "json",
    data: { user_id: user_id_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        $(button).data("userId", 0);
        $(button).html("✔Unfollowed");
      } else {
        $(button).attr("disabled", false);

        alert("something is wrong,try again after some time");
      }
    },
  });
});

$(".like_btn").click(function () {
  var doubt_id_v = $(this).data("doubtId");
  var button = this;
  $(button).attr("disabled", true);
  $.ajax({
    url: "assets/php/ajax.php?like",
    method: "post",
    dataType: "json",
    data: { doubt_id: doubt_id_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        $(button).attr("disabled", false);
        $(button).hide();
        $(button).siblings(".unlike_btn").show();
        location.reload();
      } else {
        $(button).attr("disabled", false);

        alert("something is wrong,try again after some time");
      }
    },
  });
});

$(".unlike_btn").click(function () {
  var doubt_id_v = $(this).data("doubtId");
  var button = this;
  $(button).attr("disabled", true);
  $.ajax({
    url: "assets/php/ajax.php?unlike",
    method: "post",
    dataType: "json",
    data: { doubt_id: doubt_id_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        $(button).attr("disabled", false);
        $(button).hide();
        $(button).siblings(".like_btn").show();
        location.reload();
      } else {
        $(button).attr("disabled", false);

        alert("something is wrong,try again after some time");
      }
    },
  });
});

$(".add-comment").click(function () {
  var button = this;

  var comment_v = $(button).siblings(".comment-input").val();

  if (comment_v == "") {
    return 0;
  }
  var doubt_id_v = $(this).data("doubtId");
  $(button).attr("disabled", true);
  $(button).siblings(".comment-input").attr("disabled", true);
  $.ajax({
    url: "assets/php/ajax.php?addcomment",
    method: "post",
    dataType: "json",
    data: { doubt_id: doubt_id_v, comment: comment_v },
    success: function (response) {
      if (response.status) {
        window.location.reload();
        $(button).attr("disabled", false);
        $(button).siblings(".comment-input").attr("disabled", false);
        $(button).siblings(".comment-input").val("");
        $("#" + cs).prepend(response.comment);

        $(".nce").hide();
      } else {
        $(button).attr("disabled", false);
        $(button).siblings(".comment-input").attr("disabled", false);
        alert("something is wrong,try again after some time");
      }
    },
  });
}); 

var sr = false;

$("#search").focus(function () {
  $("#search_result").show();
});

$("#close_search").click(function () {
  $("#search_result").hide();
});

$("#search").keyup(function () {
  var keyword_v = $(this).val();

  $.ajax({
    url: "assets/php/ajax.php?search",
    method: "post",
    dataType: "json",
    data: { keyword: keyword_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        $("#sra").html(response.users);
      } else {
        $("#sra").html('<p class="text-center text-muted">no user found !</p>');
      }
    },
  });
});

$(".unblockbtn").click(function () {
  var user_id_v = $(this).data("userId");
  var button = this;
  $(button).attr("disabled", true);
  $.ajax({
    url: "assets/php/ajax.php?unblock",
    method: "post",
    dataType: "json",
    data: { user_id: user_id_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        location.reload();
      } else {
        $(button).attr("disabled", false);

        alert("something is wrong,try again after some time");
      }
    },
  });
});
