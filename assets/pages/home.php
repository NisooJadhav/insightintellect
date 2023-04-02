<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InsightIntellect - ask any doubts!</title>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
        integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <style>
        body {
            background-image: linear-gradient(90deg, #0077d5 10%, #0A2647 90%);
        }

        .profilepic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 5px;
            background-size: cover;
        }

        .time {
            margin: 10px;
            font-size: 18px;
        }

        .card-title {
            padding: 15px 5px;
        }

        .card-body {
            font-size: 25px;
            padding: 15px 20px;
        }

        .name {
            font-size: 25px;
        }

        a:hover {
            color: #000;
            font-weight: bold;
            transition: all 0.3s;
        }

        .username {
            color: #0077d5
        }

        .comment-input {
            margin: 0;

        }

        .add-comment {
            margin: 0;
        }
    </style>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <script src="assets/js/jquery-3.6.0.min.js" type="text/javascript"></script>
</head>

<body>
    <?php
    global $user;
    global $doubts;
    global $follow_suggestions;
    ?>

    <div class="d-flex justify-content-center row">
        <div class="container col-7 rounded-0 d-flex justify-content-between" style="margin-top: 20px">
            <div class="col-sm-12" style="max-width:93vw; margin-bottom: 5%;">
                <?php
                showError('doubt_img');
                if (count($doubts) < 1) {
                    echo "<p style='width:50vw' class='p-2 bg-white border rounded text-center my-3 col-12'>Follow Someone or Add a new post</p>";
                }
                foreach ($doubts as $doubt) {
                    $likes = getLikes($doubt['id']);
                    $comments = getComments($doubt['id']);
                    ?>
                    <div class="card mt-4">
                        <div class="card-title d-flex justify-content-between align-items-center"
                            style="padding-bottom:0; margin-bottom: 0;padding-right:25px">
                            <div class="d-flex align-items-center p-2">
                                <img src="assets/images/profile/<?= $doubt['profile_pic'] ?>" alt="" height="30" width="30"
                                    class="profilepic" />&nbsp;&nbsp;<a href='?u=<?= $doubt['username'] ?>'
                                    class="text-decoration-none text-dark name"><?= $doubt['first_name'] ?>
                                    <?= $doubt['last_name'] ?></a>
                            </div>
                            <time class="time">
                                <?= time_elapsed_string($doubt['created_at']); ?>
                                <div><?php echo '<script>document.write(moment("' . $doubt['created_at'] . '").fromNow());</script>'; ?></div>
                            </time>
                        </div>
                        <hr>
                            <img src="assets/images/doubts/<?= $doubt['doubt_img'] ?>" loading=lazy class="col-11" alt="doubt image">

                        <h4 style="font-size: x-larger" class="p-2 border-bottom d-flex">
                        </h4>

                        <span class="d-flex flex-direction-row align-items-center justify-content-start"
                            style="cursor: pointer; margin-left: 25px; font-size: 25px">
                            <?php
                            if (checkLikeStatus($doubt['id'])) {
                                $like_btn_display = 'none';
                                $unlike_btn_display = '';
                            } else {
                                $like_btn_display = '';
                                $unlike_btn_display = 'none';
                            }
                            ?>
                            <i class="bi bi-heart-fill unlike_btn" style="display:<?= $unlike_btn_display ?>"
                                data-doubt-id='<?= $doubt['id'] ?>'></i>
                            <i class="bi bi-heart like_btn" style="display:<?= $like_btn_display ?>"
                                data-doubt-id='<?= $doubt['id'] ?>'></i>
                            <span class="p-1 mx-2" data-bs-toggle="modal" data-bs-target="#likes<?= $doubt['id'] ?>">
                                <?= count($likes) ?>     <?= count($likes) == 1 ? 'like' : 'likes' ?>
                            </span>

                            <i class="bi bi-chat-left d-flex align-items-center"></i>
                            <span class="p-1 mx-2" data-bs-toggle="modal" data-bs-target="#comments<?= $doubt['id'] ?>">
                                <?= count($comments) ?>     <?= count($comments) == 1 ? 'comment' : 'comments' ?>
                            </span>
                        </span>

                        <div class="card-body" style="margin-left: 10px;">
                            <?= $doubt['doubt_text'] ?>
                        </div>

                        <div class="row" style="margin-bottom:20px; font-size: 20px;">
                            <div class="col-12 d-flex flex-direction-row justify-content-start align-items-center">
                                <input type="text" name="comment" class="col-9 rounded comment-input"
                                    placeholder="say something..." aria-label="Recipient's username"
                                    aria-describedby="button-addon2" />
                                <button class="add-comment btn btn-outline-primary col-2 rounded"
                                    data-cs="comment-section<?= $doubt['id'] ?>" data-doubt-id="<?= $doubt['id'] ?>"
                                    type="button" id="button-addon2">Post</button>
                            </div>

                            <!-- modal for list of likes -->
                            <div class="modal fade" id="likes<?= $doubt['id'] ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Likes</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            if (count($likes) < 1) {
                                                ?>
                                                <p>Currently No Likes</p>
                                                <?php
                                            }
                                            foreach ($likes as $f) {
                                                $fuser = getuser($f['user_id']);
                                                $fbtn = '';
                                                if (checkFollowStatus($f['user_id'])) {
                                                    $fbtn = ' <button class="col-4 btn btn-danger unfollowbtn" data-user-id=' . $fuser['id'] . '>Unfollow</button>';
                                                } else if ($user['id'] == $f['user_id']) {
                                                    $fbtn = '';
                                                } else {
                                                    $fbtn = ' <button class="col-4 btn btn-primary followbtn" data-user-id=' . $fuser['id'] . '>Follow</button>';
                                                }
                                                ?>
                                                <div class="row d-flex flex-row justify-content-center align-items-center">
                                                    <div class="col-12">
                                                        <a href='?u=<?= $fuser['username'] ?>'>
                                                            <img src=assets/images/profile/<?= $fuser['profile_pic'] ?> alt=""
                                                                style="margin-top: 10px; border-radius:50%; background-size: cover; width: 50px; height: 50px; margin-left: 0"
                                                                class="col-1" />
                                                            <div class="col-5">
                                                                <h4>
                                                                    <?= $fuser['first_name'] ?>

                                                                    <?= $fuser['last_name'] ?>
                                                                </h4>
                                                                <h5 class="username">@
                                                                    <?= $fuser['username'] ?>
                                                                </h5>
                                                            </div>
                                                        </a>
                                                        <div style="margin-top:10px;">
                                                            <?= $fbtn ?>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal for list of comments -->
                            <div class="modal fade" id="comments<?= $doubt['id'] ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Comments</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            if (count($comments) < 1) {
                                                ?>
                                                <p>Currently No Comments</p>
                                                <?php
                                            }
                                            foreach ($comments as $f) {
                                                $fuser = getuser($f['user_id']);
                                                ?>
                                                <div class="row d-flex flex-row justify-content-center align-items-center">
                                                    <div class="col-12">
                                                        <a href='?u=<?= $fuser['username'] ?>'>
                                                            <img src=assets/images/profile/<?= $fuser['profile_pic'] ?> alt=""
                                                                style="margin-top: 10px; border-radius:50%; background-size: cover; width: 50px; height: 50px; margin-left: 0"
                                                                class="col-1" />
                                                            <div class="col-5">
                                                                <h4>
                                                                    <?= $fuser['first_name'] ?>

                                                                    <?= $fuser['last_name'] ?>
                                                                </h4>
                                                                <h5 class="username">@
                                                                    <?= $fuser['username'] ?>
                                                                </h5>
                                                                <h5>
                                                                    <?= $f['comment'] ?>
                                                                </h5>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-fill align-self-stretch overflow-auto" id="comment-section<?= $doubt['id'] ?>"
                            style="height: 100px;">

                            <?php
                            $comments = getComments($doubt['id']);
                            if (count($comments) < 1) {
                                ?>

                                <p class="p-3 text-center my-2 nce">no comments</p>
                                <?php
                            }
                            foreach ($comments as $comment) {
                                $cuser = getUser($comment['user_id']);
                                ?>

                                <div class="d-flex align-items-center p-2">

                                    <div>
                                        <a href="?u=<?= $cuser['username'] ?>">
                                            <img src=" assets/images/profile/<?= $cuser['profile_pic'] ?>" alt="profilepic"
                                                height="40" width="40" class="rounded-circle border"
                                                style="border-radius: 50%; width: 40px; height: 40px" />
                                        </a>
                                    </div>

                                    <div>&nbsp;&nbsp;&nbsp;</div>
                                    <div class="d-flex flex-column justify-content-start align-items-start">
                                        <h6 style="margin: 0px;"><a href="?u=<?= $cuser['username'] ?>"
                                                class="text-decoration-none text-muted"><?= $cuser['first_name'] ?>         <?= $cuser['last_name'] ?></a> -
                                            <br>
                                            <h5>
                                                <?= $comment['comment'] ?>
                                            </h5>
                                        </h6>
                                        <p style="margin:0px;" class="text-muted">
                                            <?= time_elapsed_string($comment['created_at']) ?>
                                        </p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>

                        <?php
                        if ($user['id'] == $doubt['user_id']) {
                            ?>
                            <div class="col-12 display-flex flex-direction-row align-items-start justify-content-center text-center">
                                <div class="col-5">
                                    <a href="assets/pages/delete.php?doubtid=<?=$doubt['id']?>"><button class="btn border-danger">Delete Doubt</button></a>
                                </div>
                                                                    
                                <button class="btn border-primary" id="update-doubt-btn">Update Doubt</button>

                                <!-- Modal -->
                                <div class="modal fade" id="doubt-modal" tabindex="-1" role="dialog" aria-labelledby="doubt-modal-label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="doubt-modal-label">Update your doubt</h5>
                                        <button type="button" class="close btn border-danger" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="assets/pages/update.php" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group">
                                            <label for="doubt-input" style="margin-bottom: 20px">Update Doubt Text:</label>
                                            <input type="hidden" name="doubtid" value="<?=$doubt['id']?>" />
                                            <input type="text" class="form-control" id="doubt" name="doubt" value="<?= $doubt['doubt_text']?>">
                                            </input>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" id="doubt-okay-btn">Update</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                        </div>
                    <?php
                    }
                    ?>

                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="container col-3 rounded d-flex flex-column align-items-center justify-content-start"
            style="position:sticky; margin-top:50px; overflow:auto; margin-bottom: 5%; background:#fff; padding-top:40px; clear:both; height:100%; position: -webkit-sticky; top: -1px; ">

            <h3>Follow them!</h3>
            <br>
            <?php
            foreach ($follow_suggestions as $suser) {
                ?>

                <div class="row d-flex flex-row justify-content-center align-items-center">
                    <div class="col-12">
                        <a href='?u=<?= $suser['username'] ?>'>
                            <img src=assets/images/profile/<?= $suser['profile_pic'] ?> alt=""
                                style="margin-top: 10px; border-radius:50%; background-size: cover; width: 50px; height: 50px; margin-left: 0"
                                class="col-1" />
                            <div class="col-5">
                                <h4>
                                    <?= $suser['first_name'] ?>

                                    <?= $suser['last_name'] ?>
                                </h4>

                                <h5 class="username">@
                                    <?= $suser['username'] ?>
                                </h5>
                            </div>
                        </a>
                        <div style="margin-top:10px;">
                            <button class="col-4 btn btn-primary followbtn"
                                data-user-id='<?= $suser['id'] ?>'>follow</button>
                        </div>
                    </div>
                    <hr>
                </div>
                <hr>
                <?php
            }

            if (count($follow_suggestions) < 1) {
                echo "no user found...";
                echo "<hr>";
            }
            ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#update-doubt-btn").click(function() {
            $("#doubt-modal").modal('show');
        });
    
        $("#doubt-okay-btn").click(function() {
            var doubt = $("#doubt-input").val();
            console.log(doubt); // Just for testing purposes
            $("#doubt-modal").modal('hide');
            });
        });

        $(".close").click(function() {
            $("#doubt-modal").modal("hide");
        });
    </script>
</body>

</html>