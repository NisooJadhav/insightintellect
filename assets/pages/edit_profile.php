<?php global $user; ?>
<html>

<head>
    <title>InsightIntellect - edit profile</title>
    <style>
        body {
            background-image: linear-gradient(90deg, #0077d4 10%, #aaa);
        }

        .update {
            margin: 0
        }

        .noprofile {
            width: 25%;
            border-radius: 50%
        }

        .form-check-input:checked {
            width: 20px;
            height: 5px;
            border-radius: 50%;
        }

        .genders,
        label {
            cursor: not-allowed;
            user-select: none;
        }
    </style>
</head>

<body>
    <center>
        <div style="width:99vw; height: 10vh"></div>
        <div class="container col-9 rounded d-flex align-items-center justify-content-center">
            <div class="col-12 bg-white border rounded p-4 mt-2 shadow-sm">
                <form method="post" action="assets/php/actions.php?updateprofile" enctype="multipart/form-data">
                    <h1 class="h5 mb-1 fw-normal">Edit Profile</h1>
                    <hr>
                    <?php
                    if (isset($_GET['success'])) {
                    ?>
                        <p class="text-success">Profile is updated !</p>
                    <?php
                    }
                    ?>
                    <div class="form-floating mt-1 col-6">
                        <img src="assets/images/profile/<?= $user['profile_pic'] ?>" class="my-2 col-10 noprofile" alt="..." style="border-radius:50%; background-size: cover; width: 7vw; height: 7vw;">


                        <div class="mb-1">
                            <label for="formFile" class="form-label">Change Profile Picture</label>
                            <input class="form-control" type="file" name="profile_pic" id="formFile">
                        </div>

                    </div>
                    <?= showError('profile_pic') ?>
                    <div class="d-flex">
                        <div class="form-floating mt-1 col-6 ">
                            <input type="text" name="first_name" value="<?= $user['first_name'] ?>" class="form-control rounded-0" placeholder="first name">
                            <label for="floatingInput">first name</label>
                        </div>
                        <div class="form-floating mt-1 col-6">
                            <input type="text" name="last_name" value="<?= $user['last_name'] ?>" class="form-control rounded-0" placeholder="last name">
                            <label for="floatingInput">last name</label>
                        </div>
                    </div>
                    <?= showError('first_name') ?>
                    <?= showError('last_name') ?>

                    <br>
                    <div class="d-flex justify-content-center align-items-center gap-3 my-2 genders">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" <?= $user['gender'] == 1 ? 'checked' : '' ?> disabled>
                            <label class="form-check-label" for="exampleRadios1">
                                Male
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option2" <?= $user['gender'] == 2 ? 'checked' : '' ?> disabled>
                            <label class="form-check-label" for="exampleRadios3">
                                Female
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" <?= $user['gender'] == 3 ? 'checked' : '' ?> disabled>
                            <label class="form-check-label" for="exampleRadios2">
                                Other
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="form-floating mt-1">
                        <input type="text" name="education" value="<?= $user['education'] ?>" class="form-control rounded-0" placeholder="education">
                        <label for="floatingInput">education</label>
                    </div>
                    <?= showError('education') ?>
                    <br>
                    <div class="form-floating mt-1">
                        <input type="email" value="<?= $user['email'] ?>" class="form-control rounded-0" placeholder="email">
                        <label for="floatingInput">email</label>
                    </div>
                    <div class="form-floating mt-1">
                        <input type="text" name="username" value="<?= $user['username'] ?>" class="form-control rounded-0" placeholder="username/email">
                        <label for="floatingInput">username</label>
                    </div>
                    <?= showError('username') ?>
                    <div class="form-floating mt-1">
                        <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">New password</label>
                    </div>

                    <hr>

                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <button class="btn btn-primary update" type="submit">Update Profile</button>

                        <a href="?">cancel</a>
                    </div>
                </form>

                <br>
                <hr>

                <a href="assets/pages/delete.php?userid=<?= $user['id'] ?>">
                    <button class="btn btn-danger delete">Delete Profile</button>
                </a>
            </div>
        </div>
        <div style="width:99vw; height: 10vh"></div>

</body>

</html>