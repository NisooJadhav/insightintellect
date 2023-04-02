<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="assets/images/favicon.png" />
    <title>InsightIntellect - forgot password</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

        function eye() {
            let eye = document.querySelector(".eye");
            let eye2 = document.querySelector(".eye2");

            eye.src = "assets/images/eye2.png"
            eye2.src = "assets/images/eye2.png"

            let passwordError = document.querySelector(".passwordError");
            passwordError.innerHTML = "password don't match";
        }
    </script>

    <style>
        h2,
        h3,
        h4 {
            text-align: center;
            margin-top: 20px;
        }

        u {
            color: black
        }

        input {
            margin: 20px 0 !important;
        }
    </style>
</head>

<body onload="eye()">
    <div class="main">
        <div class="leftBox">
            <img src="assets/images/logo.png" />
        </div>
        <div class="rightBox">
            <?php
            if (isset($_SESSION['forgot_code']) && !isset($_SESSION['auth_temp'])) {
                $action = 'verifycode';
            } elseif (isset($_SESSION['forgot_code']) && isset($_SESSION['auth_temp'])) {
                $action = 'changepassword';
            } else {
                $action = 'forgotpassword';
            }
            ?>
            <form method="post" action="assets/php/actions.php?<?= $action ?>" class="container">
                <h2 class="head">Forgot Password?</h2>

                <?php
                if ($action == 'forgotpassword') {
                    ?>
                    <h4>enter your email</h4>
                    <div class="row">
                        <input type="text" name="email" placeholder="enter your email" class="col-12" />
                        <?= showError('email') ?>
                    </div>
                    <div class="buttons">
                        <button class="signup col-12" id="signup" type="submit">Send Verification Code</button>
                    </div>
                <?php
                }
                ?>

                <?php
                if ($action == 'verifycode') {
                    ?>
                    <h4>enter 6 digit code sent to you
                        <u>
                            <?= $_SESSION['forgot_email'] ?>
                        </u>
                    </h4>
                    <div class="row">
                        <input type="text" name="code" placeholder="******" class="col-12" />
                        <?= showError('verify_email') ?>
                    </div>
                    <div class="buttons">
                        <button class="signup col-12" id="signup" type="submit">Verify Code</button>
                    </div>
                <?php
                }
                ?>

                <?php
                if ($action == 'changepassword') {
                    ?>
                    <div class="row">
                        <h4>enter new password for
                            <u>
                                <?= $_SESSION['forgot_email'] ?>
                            </u>
                        </h4>

                        <div class="row passwords">
                            <input type="password" name="password" placeholder="password" class="col-12 password" />
                            <img onclick="showPassword()" class="eye" />
                        </div>
                        <?= showError('password') ?>

                    </div>
                    <div class="buttons">
                        <button class="signup col-12" id="signup" type="submit">Change Password</button>
                    </div>
                <?php
                }
                ?>

                <center>
                    <button class="anotherButton"><a href="?login">back to Login</a></button>
                </center>
            </form>
        </div>
    </div>
</body>

</html>