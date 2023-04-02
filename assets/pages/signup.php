<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InsightIntellect - sign up</title>

    <script>
        function showPassword() {
            let pw_ele = document.querySelector(".password");
            let eye = document.querySelector(".eye");

            if (pw_ele.type === "password") {
                pw_ele.type = "text";
                eye.src = "https://img.icons8.com/sf-black-filled/512/visible.png"
            } else {
                pw_ele.type = "password";
                eye.src = "https://img.icons8.com/sf-black-filled/512/invisible.png"
            }
        }

        function showConfirmedPassword() {
            let pw_ele = document.querySelector(".confirmPassword");
            let eye = document.querySelector(".eye2");
            if (pw_ele.type === "password") {
                pw_ele.type = "text";
                eye.src = "assets/images/eye1.png"
            } else {
                pw_ele.type = "password";
                eye.src = "assets/images/eye2.png"
            }
        }

        function eye() {
            let eye = document.querySelector(".eye");
            let eye2 = document.querySelector(".eye2");

            eye.src = "assets/images/eye2.png"
            eye2.src = "assets/images/eye2.png"

            let passwordError = document.querySelector(".passwordError");
            passwordError.innerHTML = "password don't match";
        }

        function checkPassword() {
            let signup = document.getElementById('signup');
            signup.disabled = true;

            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirmPassword").value;
            let passwordError = document.querySelector(".passwordError");

            if (password == confirmPassword) {
                passwordError.innerHTML = '';
                signup.disabled = false;
            } else {
                passwordError.innerHTML = "password don't match";
            }
        }
    </script>
</head>

<body onload="eye()">
    <div class="main">
        <div class="leftBox">
            <img src="assets/images/logo.png" />
        </div>
        <div class="rightBox">
            <form action="assets/php/actions.php?signup" class="container" method="post">
                <h2 class="head">Sign Up</h2>
                <div class="row">
                    <input type="text" value="<?= showFormData('first_name') ?>" name="first_name" placeholder="first name" class="col-6" />
                    <input type="text" value="<?= showFormData('last_name') ?>" name="last_name" placeholder="last name" class="col-6" />
                    <?= showError('first_name') ?>
                    <?= showError('last_name') ?>

                    <div class="col-12">
                        <h3 class="radios">
                            <div class="col-4">
                                <input type="radio" name="gender" id="male" value="1" <?= showFormData('gender') == 1 ? 'checked' : '' ?> <? isset($_SESSION['formdata']) ? '' : 'checked' ?> Male </div>
                                <div class="col-4">
                                    <input type="radio" name="gender" id="female" value="2" <?= showFormData('gender') == 2 ? 'checked' : '' ?> <? isset($_SESSION['formdata']) ? '' : 'checked' ?> Female </div>
                                    <div class="col-4">
                                        <input type="radio" name="gender" id="other" value="3" <?= showFormData('gender') == 3 ? 'checked' : '' ?> <? isset($_SESSION['formdata']) ? '' : 'checked' ?> Other </div>
                        </h3>
                    </div>

                    <input type="text" value="<?= showFormData('username') ?>" name="username" class="col-12" placeholder="username" />
                    <?= showError('username') ?>

                    <input type="text" value="<?= showFormData('email') ?>" name="email" placeholder="email" class="col-12" />
                    <?= showError('email') ?>

                    <div class="row passwords">
                        <input type="password" value="<?= showFormData('password') ?>" name="password" placeholder="password" class="col-12 password" id="password" />
                        <img onclick="showPassword()" class="eye" />
                    </div>
                    <?= showError('password') ?>

                    <div class="row passwords">
                        <input type="password" onkeyup='checkPassword()' placeholder="confirm password" class="col-12 confirmPassword" id="confirmPassword" required />
                        <img onclick="showConfirmedPassword()" class="eye2" />
                    </div>
                    <span class="passwordError error"></span>
                </div>

                <center>
                    <div class="buttons">
                        <button class="signup col-12" type="submit" id="signup">Sign Up</button>
                    </div>
                    <button class="anotherButton"><a href="?login">have an account?</a></button>
                </center>
            </form>
        </div>
    </div>
</body>

</html>

<?php
// unset($_SESSION(['error']));
// session_destroy();
?>