<?php
global $user;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InsightIntellect - verify email</title>

    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        form {
            background: #eee;
            padding: 5vh;
            border-radius: 20px;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        input {
            width: 20vw;
        }

        span {
            width: 20vw;
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
        }
    </style>
</head>

<body>
    <div>
        <form action="assets/php/actions.php?verify_email" method="post">
            <h2>Verify your email(
                <?= $user['email'] ?>)
            </h2>
            <br>
            <h3>enter 6 digit code sent to you:</h3>
            <br>
            <input type="text" placeholder="******" name="code" />
            <?php
            if (isset($_GET['resended'])) {
                ?>
                <p style="font-size:1.2rem; color: green; font-weight: 600;">resended verification code!</p>
            <?php
            }
            ?>
            <?= showError('verify_email') ?>
            <br>
            <button type="submit" class="signup">verify email</button>
            <br>
            <span>
                <a href="assets/php/actions.php?resend_code">resend code</a>
                <a href="assets/php/actions.php?logout">log out</a>
            </span>
        </form>
    </div>
</body>