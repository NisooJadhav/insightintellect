<?php
global $user;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>InsightIntellect - ask any doubts</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-image: linear-gradient(90deg, #0077d4 10%, #aaa);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .box {
            background: #aaaaaa99;
            border-radius: 5px;
            text-align: center;
            padding: 5vw;
        }

        h2 {
            color: red;
            margin-bottom: 30px;
        }

        p {
            font-size: 20px;
            font-weight: bold;
        }

        p a {
            color: #20202080;
            transition: all 0.3s;
        }

        p>a:hover {
            color: #202020;
            transition: all 0.3s;
        }
    </style>
</head>

<body>
    <div class="box">
        <h2>
            <?= $user['first_name'] . ' ' . $user['last_name'] . '\'s ' ?>account has been blocked by admin
        </h2>
        <p><a href="mailto:nisoojadhav@gmail.com">try contacting admin</a> or <a
                href="assets/php/actions.php?logout">logout</a></p>
    </div>
</body>