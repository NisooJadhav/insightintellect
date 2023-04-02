<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="assets/images/favicon.png" />
    <title>InsightIntellect - log in</title>
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
</head>

<body onload="eye()">
    <div class="main">
        <div class="leftBox">
            <img
                src="assets/images/logo.png" />
        </div>
        <div class="rightBox">
            <form method="post" action="assets/php/actions.php?login" class="container">
                <h2 class="head">Log In</h2>

                <div class="row">
                    <input value="<?= showFormData('username_email') ?>" type="text" name="username_email"
                        placeholder="email or username" class="col-12" />
                    <?= showError('username_email') ?>

                    <div class="row passwords">
                        <input type="password" name="password" placeholder="password" class="col-12 password" />
                        <img onclick="showPassword()" class="eye" />
                    </div>
                    <?= showError('password') ?>

                    <?= showError('checkuser') ?>
                </div>

                <center>
                    <div class="buttons">
                        <button class="signup col-7">Log In</button>
                    </div>
                    <button class="anotherButton"><a href="?signup">need an account?</a></button>
                    <button class="anotherButton"><a href="?forgotpassword&newfp">forgot password</a></button>
                </center>
            </form>
        </div>
    </div>
</body>

</html>