<?php
ob_start();
global $user;
global $doubts;
global $profile;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="assets/bootstrap.min.css" rel="stylesheet" />

    <style>
        nav {
            top: 0;
        }

        body {
            background-image: linear-gradient(90deg, #0077d4 10%, #aaa);
        }

        li {
            margin: 0 20px;
        }

        button {
            margin-left: 120px;
            margin-right: 60px;
        }

        form>button {
            margin: 0
        }

        .search {
            width: 30px;
            height: 30px;
        }

        .small-profile-pic {
            margin-top: -7px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: 10px;
            margin-right: 0;
            background-size: cover;
        }
    </style>
</head>

<body>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <nav
        class="d-flex flex-wrap align-items-center justify-content-center navbar navbar-expand-lg bg-body-tertiary bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand col-4" href="?"><img src="assets/images/logo.png" class="col-6"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="d-flex" id="searchform">
                        <input class="form-control me-2" type="search" id="search" placeholder="looking for someone?"
                            aria-label="Search" autocomplete="off" style="height: 50px; width: 300px">
                        <img src="https://cdn-icons-png.flaticon.com/128/954/954591.png"
                            style="cursor:default; width: 30px; height: 30px; margin-top: 10px" alt="search_icon">

                        <div class="bg-white text-end rounded border shadow py-2 px-2 mt-5"
                            style="width:300px;display:none;position:absolute;z-index:+99;" id="search_result"
                            data-bs-auto-close="true">
                            <center>
                                <button type="button" class="btn-close" aria-label="Close" id="close_search"></button>
                                <div id="sra" class="text-start">
                                    <p class="text-center text-muted">enter name or username</p>
                                </div>
                            </center>
                        </div>
                    </form>
                    
                </div>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adddoubt">
                    Add Doubt +
                </button>

                <!-- Modal -->
                <div class="modal fade" id="adddoubt" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Doubt</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="" style="display:none" id="doubt_img" class="w-100 rounded border">
                                <form method="post" action="assets/php/actions.php?adddoubt"
                                    enctype="multipart/form-data">
                                    <div class="my-3">

                                        <input class="form-control" name="doubt_img" type="file" id="select_post_img">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Say
                                            Something</label>
                                        <textarea name="doubt_text" class="form-control"
                                            id="exampleFormControlTextarea1" rows="1"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Post Doubt </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <li class="nav-item d-flex align-items-center">
                    <a class="nav-link" href='?u=<?= $_SESSION['userdata']['username'] ?>' />
                    <img class="small-profile-pic"
                        src="assets/images/profile/<?= $_SESSION['userdata']['profile_pic'] ?>" />
                    <?php echo $_SESSION['userdata']['username'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?editprofile">Edit Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="assets/php/actions.php?logout">Log Out</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/custom.js?v=<?= time() ?>"></script>
</body>

</html>