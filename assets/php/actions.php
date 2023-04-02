<?php
require 'functions.php';
require_once 'send_code.php';

if (isset($_GET['signup'])) {
    $response = validateSignup($_POST);
    if ($response['status']) {
        if (createUser($_POST)) {
            header("location:../../?login&newuser");
        } else {
            echo "<script>alert('something went wrong')</script>";
        }
    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;
        header("location:../../?signup");
    }
}

if (isset($_GET['login'])) {
    $response = validateLogin($_POST);

    if ($response['status']) {
        $_SESSION['Auth'] = true;
        $_SESSION['userdata'] = $response['user'];

        if ($response['user']['ac_status'] == 0) {
            $_SESSION['code'] = $code = rand(111111, 999999);
            sendCode($response['user']['email'], 'OTP from InsightIntellect', $code);
        }

        header("location:../../");
    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;
        header("location:../../?login");
    }
}

if (isset($_GET['resend_code'])) {
    $_SESSION['code'] = $code = rand(111111, 999999);
    sendCode($_SESSION['userdata']['email'], 'Verify your email', $code);

    header('location:../../?resended');
}

if (isset($_GET['verify_email'])) {
    $user_code = $_POST['code'];
    $code = $_SESSION['code'];

    if ($code == $user_code) {
        if (verifyEmail($_SESSION['userdata']['email'])) {
            header('location:../../');
        } else {
            echo "something went wrong";
        }
    } else {
        $response['msg'] = 'incorrect verification code!';
        if (!$_POST['code']) {
            $response['msg'] = 'enter 6 digit code!';
        }
        $response['field'] = 'verify_email';
        $_SESSION['error'] = $response;
        header('location:../../');
    }
}

if (isset($_GET['forgotpassword'])) {
    if (!$_POST['email']) {
        $response['msg'] = "* enter email!";
        $response['field'] = 'email';
        $_SESSION['error'] = $response;
        header('location:../../?forgotpassword');
    } elseif (!emailExists($_POST['email'])) {
        $response['msg'] = "* email not registered";
        $response['field'] = 'email';
        $_SESSION['error'] = $response;
        header('location:../../?forgotpassword');
    } else {
        $_SESSION['forgot_email'] = $_POST['email'];
        $_SESSION['forgot_code'] = $code = rand(111111, 999999);
        sendCode($_POST['email'], 'Forgot password?', $code);
        header('location:../../?forgotpassword&resended');
    }
}

if (isset($_GET['verifycode'])) {
    $user_code = $_POST['code'];
    $code = $_SESSION['forgot_code'];

    if ($code == $user_code) {
        $_SESSION['auth_temp'] = true;
        header('location:../../?forgotpassword');
    } else {
        $response['msg'] = 'incorrect verification code!';
        if (!$_POST['code']) {
            $response['msg'] = 'enter 6 digit code!';
        }
        $response['field'] = 'verify_email';
        $_SESSION['error'] = $response;
        header('location:../../?forgotpassword');
    }
}

if (isset($_GET['changepassword'])) {
    if (!$_POST['password']) {
        $response['msg'] = "* enter your new password!";
        $response['field'] = 'password';
        $_SESSION['error'] = $response;
        header('location:../../?forgotpassword');
    } else {
        resetPassword($_SESSION['forgot_email'], $_POST['password']);
        header('location:../../?reseted');
    }
}

if (isset($_GET['updateprofile'])) {
    $response = validateUpdate($_POST, $_FILES['profile_pic']);

    if ($response['status']) {
        if (updateProfile($_POST, $_FILES['profile_pic'])) {
            header("location:../../?editprofile&success");

        } else {
            echo "Something is wrong";
        }
    } else {
        $_SESSION['error'] = $response;
        header("location:../../?editprofile");
    }
}

if (isset($_GET['adddoubt'])) {
    $response = validateDoubtImage($_FILES['doubt_img']);

    if ($response['status']) {
        if (createDoubt($_POST, $_FILES['doubt_img'])) {
            header("location:../../?new_post_added");
        } else {
            echo "something went wrong";
        }
    } else {
        $_SESSION['error'] = $response;
        header("location:../../");
    }
}

if (isset($_GET['block'])) {
    $user_id = $_GET['block'];
    $user = $_GET['username'];
    if (blockUser($user_id)) {
        header("location:../../?u=$user");
    } else {
        echo "something went wrong";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('location:../../');
}