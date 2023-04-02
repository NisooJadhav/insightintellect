<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InsightIntellect - profile page</title>

    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <link href="assets/bootstrap.min.css" rel="stylesheet" />

    <style>
        .profile-pic {
            margin-top: 5vh;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-right: 5px;
            background-size: cover;
        }

        .main-box {
            margin-top: 1vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #ffffff99;
            width: 50%;
            border-radius: 20px;
        }

        h2 {
            margin-top: 20px;
        }

        li {
            margin: 0 20px;
        }

        button {
            margin-left: 120px;
            margin-right: 60px;
        }

        .buttons,
        .buttons>button {
            margin: 10px !important;
        }   

        form>button {
            margin: 0
        }

        .search {
            width: 30px;
            height: 30px;
        }

        .doubt_img {
            margin: 20px;
        }

        .doubt_text {
            margin-left: 0;
            padding-left: 0;
            font-size: large;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    global $profile;
    global $profile_doubt;
    global $user;
    ?>

    <center>
        <img class="profile-pic" src="assets/images/profile/<?= $profile['profile_pic'] ?>" />
        <div class="main-box">
            <h2 class="display-7 fw-bold">
                <?php print_r($profile['first_name']); ?>
                <?php print_r($profile['last_name']); ?>
            </h2>
            <div>
                <p style="font-size: 1.5rem">@
                    <?php print_r($profile['username']); ?>
                </p>
            </div>

            <div class="buttons row text-center d-flex align-items-center justify-content-center">
                <hr>
                <button class="col-2 btn border-primary">
                    <?= count($profile_doubt) ?>
                    <?php
                    if (count($profile_doubt) > 1) {
                        echo " Posts";
                    } else {
                        echo " Post";
                    }
                    ?>
                </button>
                <button class="col-2 btn border-success" data-bs-toggle='modal' data-bs-target="#follower_list" role='button'>
                    <?= count($profile['followers']) ?>
                    <?php
                    if (count($profile['followers']) > 1) {
                        echo " Followers";
                    } else {
                        echo " Follower";
                    }
                    ?>
                </button>
                <button class="col-2 btn border-danger" data-bs-toggle='modal' data-bs-target="#following_list" role='button'>
                    <?= count($profile['following']) ?> Following
                </button>

                <?php
                if ($user['id'] != $profile['id']) {
                ?>
                    <?php
                    if (checkFollowStatus($profile['id'])) {
                    ?>
                        <button class="col-2 btn btn-danger unfollowbtn" data-user-id='<?= $profile['id'] ?>' style="cursor: pointer;">Unfollow</button>
                    <?php
                    } else {
                    ?>
                        <button class="col-2 btn btn-success followbtn" data-user-id='<?= $profile['id'] ?>' style="cursor: pointer;">Follow</button>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>
            </div>

            <div class="buttons row text-center d-flex align-items-center justify-content-center">
                <?php
                if ($user['id'] != $profile['id']) {
                ?>
                    <button class="col-2 btn btn-secondary" style="cursor: pointer">💬 Message</button>
                    <a class="blockbtn" href="assets/php/actions.php?block=<?= $profile['id'] ?>&username=<?= $profile['username'] ?>"><i class="bi bi-x-circle-fill"></i>🚫 Block</a>
                <?php
                }
                ?>
            </div>
            <?php


            if ($user['id'] != $profile['id']) {
            ?>
                <div class="d-flex align-items-center justify-content-center">
                    <?php
                    if (checkBlockStatus($user['id'], $profile['id'])) {
                    ?>
                        <center>
                            <button class="btn btn-sm btn-danger unblockbtn" data-user-id='<?= $profile['id'] ?>'>Unblock</button>
                        </center>

                    <?php
                    } else if (checkBlockStatus($profile['id'], $user['id'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-x-octagon-fill"></i> @
                            <?= $profile['username'] ?> blocked you !
                        </div>
                    <?php } else if (checkFollowStatus($profile['id'])) {
                    ?>
                    <?php
                    }
                    ?>
                <?php
            }
                ?>
                </div>

                <hr>
                <h3 style="margin-top: 20px; margin-bottom: 20px; color: white; font-weight: bold">Doubts</h3>
                <div class="col-10" style="background: #ffffff90; height: auto; border-radius: 10px;">
                    <div class="row">

                        <?php
                        if (count($profile_doubt) < 1) {
                            echo "<p class='p-2 bg-white border rounded text-center my-3'>user has no doubts!</p>";
                        }
                        ?>
                        <div class="gallery d-flex flex-wrap gap-2 mb-4">
                            <?php
                            foreach ($profile_doubt as $doubt) {
                                $likes = getLikes($doubt['id']);
                            ?>

                                <div class="col-5">
                                    <div class="col-md-4 col-sm-4">
                                        <img src="assets/images/doubts/<?= $doubt['doubt_img'] ?>" data-bs-toggle="modal" data-bs-target="#doubtview<?= $doubt['id'] ?>" width="300px" class="rounded" />

                                        <div class="modal fade" id="doubtview<?= $doubt['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body d-md-flex p-0" style="width: 1046px;">
                                                        <div class="col-md-8 col-sm-12">
                                                            <img src="assets/images/doubts/<?= $doubt['doubt_img'] ?>" style="max-height:90vh" class="w-100 rounded-start">
                                                        </div>

                                                        <div class="col-md-4 col-sm-12 d-flex flex-column">
                                                            <div class="d-flex align-items-center p-2 <?= $doubt['doubt_text'] ? '' : 'border-bottom' ?>">
                                                                <div>
                                                                    <img src="assets/images/profile/<?= $profile['profile_pic'] ?>" alt="" style="border-radius: 50%; width: 50px; height: 50px;" class="rounded-circle border">
                                                                </div>
                                                                <div>&nbsp;&nbsp;&nbsp;</div>
                                                                <div class="d-flex flex-column justify-content-start">
                                                                    <h6 style="margin: 0px;"><?= $profile['first_name'] ?> <?= $profile['last_name'] ?></h6>
                                                                    <p style="margin:0px;" class="text-muted">@<?= $profile['username'] ?></p>
                                                                </div>

                                                                <div class="d-flex flex-column align-items-end flex-fill">
                                                                    <div class=""></div>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-link dropdown-toggle" type="button" id="likes-dropdown-<?= $doubt['id'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <?= count($likes) ?> likes
                                                                        </button>
                                                                        <ul class="dropdown-menu" aria-labelledby="likes-dropdown-<?= $doubt['id'] ?>">
                                                                            <?php foreach ($likes as $like) : ?>
                                                                                <li><a class="dropdown-item" href="?u=<?= getUser($like['user_id'])['username'] ?>"><?= getUser($like['user_id'])['first_name'] . ' ' . getUser($like['user_id'])['last_name'] ?> (@<?= getUser($like['user_id'])['username'] ?>)</a></li>
                                                                            <?php endforeach; ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="border-bottom p-2 <?= $doubt['doubt_text'] ? '' : 'd-none' ?>"><?= $doubt['doubt_text'] ?></div>

                                                            <div class="flex-fill align-self-stretch overflow-auto" id="comment-section<?= $doubt['id'] ?>" style="height: 100px;">
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
                                                                        <div><img src="assets/images/profile/<?= $cuser['profile_pic'] ?>" alt="" style="border-radius:50%;width: 50px; height: 50px;" class="rounded-circle border">
                                                                        </div>
                                                                        <div>&nbsp;&nbsp;&nbsp;</div>
                                                                        <div class="d-flex flex-column justify-content-start align-items-start">
                                                                            <h6 style="margin: 0px;"><a href="?u=<?= $cuser['username'] ?>" class="text-decoration-none text-muted">@<?= $cuser['username'] ?></a> - <?= $comment['comment'] ?></h6>
                                                                        </div>
                                                                    </div>

                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            
                                                            <?php
                                                            if (checkFollowStatus($profile['id']) || $profile['id'] == $user['id']) {
                                                            ?>
                                                                <div class="input-group p-2 border-top">
                                                                    <input type="text" class="form-control rounded-0 border-0 comment-input" placeholder="say something.." aria-label="Recipient's username" aria-describedby="button-addon2">
                                                                    <button class="btn btn-outline-primary rounded-0 border-0 add-comment" data-cs="comment-section<?= $doubt['id'] ?>" data-doubt-id="<?= $doubt['id'] ?>" type="button" id="button-addon2">add comment</button>
                                                                </div>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <div class="text-center p-2">
                                                                    if you want to comment follow this user</div>

                                                            <?php
                                                            }
                                                            ?>

                                                        </div>



                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                                    ?>


                                    </div>




                                </div>


                        </div>
                        <!-- this is for followers list -->
                        <div class="modal fade" id="follower_list" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Followers</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        foreach ($profile['followers'] as $f) {
                                            $fuser = getuser($f['follower_id']);
                                            $fbtn = '';
                                            if (checkFollowStatus($f['follower_id'])) {
                                                $fbtn = ' <button class="col-4 btn btn-danger unfollowbtn" data-user-id=' . $fuser['id'] . '>Unfollow</button>';
                                            } else if ($user['id'] == $f['follower_id']) {
                                                $fbtn = '';
                                            } else {
                                                $fbtn = ' <button class="col-4 btn btn-primary followbtn" data-user-id=' . $fuser['id'] . '>Follow</button>';
                                            }

                                        ?>
                                            <div class="row d-flex flex-row justify-content-center align-items-center">
                                                <div class="col-12">
                                                    <a href='?u=<?= $fuser['username'] ?>'>
                                                        <img src=assets/images/profile/<?= $fuser['profile_pic'] ?> alt="" style="margin-top: 10px; border-radius:50%; background-size: cover; width: 50px; height: 50px; margin-left: 0" class="col-1" />
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
                    </div>
                </div>

                <!-- this is for following list -->
                <div class="modal fade" id="following_list" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Following Users</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                foreach ($profile['following'] as $f) {
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
                                                <img src=assets/images/profile/<?= $fuser['profile_pic'] ?> alt="" style="margin-top: 10px; border-radius:50%; background-size: cover; width: 50px; height: 50px; margin-left: 0" class="col-1" />
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

                <div style="height: 30px; width:90vw"></div>
    </center>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>