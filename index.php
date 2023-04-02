<?php
include 'assets/pages/header.php';
require_once 'assets/php/functions.php';

if (isset($_GET['newfp'])) {
    unset($_SESSION['auth_temp']);
    unset($_SESSION['forgot_email']);
    unset($_SESSION['forgot_code']);
}
if (isset($_SESSION['Auth'])) {
    $user = getUser($_SESSION['userdata']['id']);
    $doubts = filterDoubts();
    $follow_suggestions = FilterFollowSuggestion();
}

$pagecount = count($_GET);

if (isset($_SESSION['Auth']) && $user['ac_status'] == 1 && !$pagecount) {
    showPage('navbar');
    showPage('home');
} elseif (isset($_SESSION['Auth']) && $user['ac_status'] == 0 && !$pagecount) {
    showPage('verify_email');
} elseif (isset($_SESSION['Auth']) && $user['ac_status'] == 2 && !$pagecount) {
    showPage('blocked');
} elseif (isset($_SESSION['Auth']) && isset($_GET['editprofile']) && $user['ac_status'] == 1) {
    showPage('navbar');
    showPage('edit_profile');
} elseif (isset($_GET['admin007'])) {
    showPage('navbar');
    showPage('admin');
} elseif (isset($_GET['admin_panel'])) {
    showPage('admin_panel');
} elseif (isset($_SESSION['Auth']) && isset($_GET['u']) && $user['ac_status'] == 1) {
    $profile = getUserByUsername($_GET['u']);

    if (!$profile) {
        showPage('navbar');
        showPage('user_not_found');
    } else {
        $profile_doubt = getDoubtById($profile['id']);
        $profile['followers'] = getFollowers($profile['id']);
        $profile['following'] = getFollowing($profile['id']);

        // print_r($profile_doubt);
        showPage('navbar');
        showPage('profile');
    }
} elseif (isset($_GET['forgotpassword'])) {
    showPage('forgot_password');
} elseif (isset($_GET['signup'])) {
    showPage('signup');
} elseif (isset($_GET['login'])) {
    showPage('login');
} else {
    if (isset($_SESSION['Auth']) && $user['ac_status'] == 1) {
        showPage('navbar');
        showPage('home');
    } elseif (isset($_SESSION['Auth']) && $user['ac_status'] == 0) {
        showPage('verify_email');
    } elseif (isset($_SESSION['Auth']) && $user['ac_status'] == 2) {
        showPage('blocked');
    } else {
        showPage('login');
    }
}

showPage('footer');
// unset($_SESSION(['error']));
// unset($_SESSION(['formdata']));
