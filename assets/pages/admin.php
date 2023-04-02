<?php
require_once 'assets/php/functions.php';

global $user;

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<html>

<head>
    <title>InsightIntellect - admin login</title>
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

        .mainContactForm {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .adminBox {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-bottom: 1rem;
            padding: 1rem 3rem;
            background: #fff;
            margin: 2rem 0 0;
            border-radius: 1rem;
            box-shadow: 0.1rem 1rem 2rem #00000040;
        }

        label {
            font-size: 1.2rem;
        }
    </style>

</head>

<body>
    <div style="display:flex;
            align-items:center;
            justify-content:center;
            min-height:65vh" class="forHeight">

        <div class='mainContactForm'>

            <form style="text-align:center;width:100%" class="adminBox" method="POST" action="">
                <center style="width:100%;padding:0;margin:0">
                    <br>
                    <label>Admin Username</label>
                    <input type="text" placeholder="admin username" style="width:95%;margin-top:1rem;margin-bottom:1rem" name="AdminUsername" />

                    <hr>
                    <br>
                    <label>Admin Password</label>
                    <input type="password" placeholder="******" style="width:95%;margin-top:1rem;margin-bottom:1rem" name="AdminPassword" />

                    <button type="submit" style="height:3rem;width:50%!important; margin-top:1rem! important; margin-bottom:1rem! important; margin:0;" onClick="handleSubmit()" name="signin"> Log In
                    </button>
                    <br />
                    <a href="?">cancel</a>
                    <br />
                </center>
            </form>
        </div>
    </div>

    <?php
    ob_start();

    $db = mysqli_connect('localhost', 'root', "", 'insightintellect') or die("db not connected");

    if (isset($_POST['signin'])) {
        $query = "select * from admin_login where admin_name='$_POST[AdminUsername]' && admin_password='$_POST[AdminPassword]'";

        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['username'] = $_POST['AdminUsername'];
            header("location:?admin_panel");
            exit;
        } else {
            echo "<script>alert('incorrect username or password')</script>";
        }
    }

    ob_end_flush();
    ?>
</body>

</html>