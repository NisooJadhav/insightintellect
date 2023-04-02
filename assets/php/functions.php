<?php
require('config.php');
$db = mysqli_connect(host, user, pass, name) or die("db not connected");

function showPage($page)
{
    include("assets/pages/$page.php");
}

function showFormData($field)
{
    if (isset($_SESSION['formdata'])) {
        $formdata = $_SESSION['formdata'];
        return $formdata[$field];
    }
}

function followUser($user_id)
{
    global $db;
    $current_user = $_SESSION['userdata']['id'];
    $query = "insert into follow_list(follower_id, user_id) values($current_user, $user_id)";

    return mysqli_query($db, $query);
}

function unfollowUser($user_id)
{
    global $db;
    $current_user = $_SESSION['userdata']['id'];
    $query = "delete from follow_list where follower_id=$current_user && user_id=$user_id";

    return mysqli_query($db, $query);
}

function showError($field)
{
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        if ($field == $error['field']) {
            ?>
            <div class="error">
                <?= $error['msg'] ?>
            </div>
            <?php
        }
    }
}

function emailExists($email)
{
    global $db;

    $query = "select count(*) as row from students where email='$email'";
    $run = mysqli_query($db, $query);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['row'];
}

function usernameExists($username)
{
    global $db;

    $query = "select count(*) as row from students where username='$username'";
    $run = mysqli_query($db, $query);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['row'];
}
function usernameExistsByOther($username)
{
    global $db;
    $user_id = $_SESSION['userdata']['id'];
    $query = "select count(*) as row from students where username='$username' && id!=$user_id";
    $run = mysqli_query($db, $query);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['row'];
}

function validateSignup($form_data)
{
    $response = array();
    $response['status'] = true;

    if (!$form_data["password"]) {
        $response['msg'] = "* password not given";
        $response['status'] = false;
        $response['field'] = "password";
    }
    if (!$form_data["email"]) {
        $response['msg'] = "* email not given";
        $response['status'] = false;
        $response['field'] = "email";
    }
    if (!$form_data["last_name"]) {
        $response['msg'] = "* last name not given";
        $response['status'] = false;
        $response['field'] = "last_name";
    }
    if (!$form_data["first_name"]) {
        $response['msg'] = "* first name not given";
        $response['status'] = false;
        $response['field'] = "first_name";
    }
    if (!$form_data["username"]) {
        $response['msg'] = "* username not given";
        $response['status'] = false;
        $response['field'] = "username";
    }
    if (emailExists($form_data['email'])) {
        $response['msg'] = "* email already registered";
        $response['status'] = false;
        $response['field'] = 'email';
    }
    if (usernameExists($form_data['username'])) {
        $response['msg'] = "* username already taken";
        $response['status'] = false;
        $response['field'] = 'username';
    }
    return $response;
}

function createUser($data)
{
    global $db;

    $username = mysqli_real_escape_string($db, $data['username']);
    $password = mysqli_real_escape_string($db, $data['password']);
    $first_name = mysqli_real_escape_string($db, $data['first_name']);
    $last_name = mysqli_real_escape_string($db, $data['last_name']);
    $gender = $data['gender'];
    $email = mysqli_real_escape_string($db, $data['email']);

    $password = md5($password);

    $query = "insert into students(username, password, first_name, last_name, gender, email) values('$username', '$password', '$first_name', '$last_name', $gender, '$email' )";

    echo "<script>alert('$email')</script>";
    return mysqli_query($db, $query);
}

function checkUser($login_data)
{
    global $db;

    $username_email = $login_data['username_email'];
    $password = md5($login_data['password']);

    $query = "select * from students where (email='$username_email' || username='$username_email') && password='$password'";
    $run = mysqli_query($db, $query);
    $data['user'] = mysqli_fetch_assoc($run) ?? array();

    if (count($data['user']) > 0) {
        $data['status'] = true;
    } else {
        $data['status'] = false;
    }

    return $data;
}

function validateLogin($form_data)
{
    $response = array();
    $response['status'] = true;
    $blank = false;

    if (!$form_data["password"]) {
        $response['msg'] = "* password not given";
        $response['status'] = false;
        $response['field'] = "password";
        $blank = true;
    }
    if (!$form_data["username_email"]) {
        $response['msg'] = "* username/email not given";
        $response['status'] = false;
        $response['field'] = "username_email";
        $blank = true;
    }
    if (!$blank && !checkUser($form_data)['status']) {
        $response['msg'] = "incorrect data";
        $response['status'] = false;
        $response['field'] = "checkuser";
    } else {
        $response['user'] = checkUser($form_data)['user'];
    }

    return $response;
}

function getUser($user_id)
{
    global $db;

    $query = "select * from students where id=$user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run);
}

function filterFollowSuggestion()
{
    $list = getFollowSuggestions();
    $filter_list = array();
    foreach ($list as $user) {
        if (!checkFollowStatus($user['id']) && count($filter_list) < 4) {
            $filter_list[] = $user;
        }
    }

    return $filter_list;
}

function filterDoubts()
{
    $list = getDoubts();
    $filter_list = array();
    foreach ($list as $doubt) {
        if (checkFollowStatus($doubt['user_id']) || $doubt['user_id'] == $_SESSION['userdata']['id']) {
            $filter_list[] = $doubt;
        }
    }

    return $filter_list;
}

function checkFollowStatus($user_id)
{
    global $db;

    $current_user = $_SESSION['userdata']['id'];
    $query = "select count(*) as row from follow_list where follower_id=$current_user && user_id=$user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

function getFollowSuggestions()
{
    global $db;

    $current_user = $_SESSION['userdata']['id'];
    $query = "select * from students where id!=$current_user limit 10";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

function getFollowers($user_id)
{
    global $db;
    $query = "select * from follow_list where user_id=$user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

function getFollowing($user_id)
{
    global $db;
    $query = "select * from follow_list where follower_id=$user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

function getUserByUsername($username)
{
    global $db;

    $query = "select * from students where username='$username'";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run);
}

function verifyEmail($email)
{
    global $db;
    $query = "update students set ac_status=1 where email='$email'";
    return mysqli_query($db, $query);
}

function validateUpdate($form_data, $image_data)
{
    $response = array();
    $response['status'] = true;


    if (!$form_data["last_name"]) {
        $response['msg'] = "* last name not given";
        $response['status'] = false;
        $response['field'] = "last_name";
    }
    if (!$form_data["first_name"]) {
        $response['msg'] = "* first name not given";
        $response['status'] = false;
        $response['field'] = "first_name";
    }
    if (!$form_data["username"]) {
        $response['msg'] = "* username not given";
        $response['status'] = false;
        $response['field'] = "username";
    }
    if (usernameExistsByOther($form_data['username'])) {
        $response['msg'] = $form_data['username'] . " is already taken";
        $response['status'] = false;
        $response['field'] = 'username';
    }

    if ($image_data['name']) {
        $image = basename($image_data['name']);
        $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $size = $image_data['size'] / 1000;
        if ($type !== 'jpg' && $type !== 'jpeg' && $type !== 'png') {
            $response['msg'] = "Only jpg,jpeg and png formats are allowed";
            $response['status'] = false;
            $response['field'] = "profile_pic";
        }
        if ($size > 1000) {
            $response['msg'] = "Upload image less than 1 MB";
            $response['status'] = false;
            $response['field'] = "profile_pic";
        }
    }
    return $response;
}

function updateProfile($data, $imagedata)
{
    global $db;
    $username = mysqli_real_escape_string($db, $data['username']);
    $first_name = mysqli_real_escape_string($db, $data['first_name']);
    $last_name = mysqli_real_escape_string($db, $data['last_name']);
    $password = mysqli_real_escape_string($db, $data['password']);
    $education =  mysqli_real_escape_string($db, $data['education']);

    // $password= $data['password']?md5($data['password']):$_SESSION['userdata']['password'];
    if (!$data['password']) {
        $password = $_SESSION['userdata']['password'];
    } else {
        $password = md5($password);
        $_SESSION['userdata']['password'] = md5($password);
    }

    $profile_pic = "";
    if ($imagedata['name']) {
        $image_name = time() . basename($imagedata['name']);
        $image_dir = "../images/profile/$image_name";
        move_uploaded_file($imagedata['tmp_name'], $image_dir);
        $profile_pic = ", profile_pic='$image_name'";
    }
    $query = "UPDATE students SET first_name = '$first_name', last_name='$last_name', username='$username', password='$password' $profile_pic, education='$education' WHERE id=" . $_SESSION['userdata']['id'];
    return mysqli_query($db, $query);
}

function validateDoubtImage($image_data)
{
    $response = array();
    $response['status'] = true;

    if (!$image_data['name']) {
        $response['msg'] = "no image is selected";
        $response['status'] = false;
        $response['field'] = 'doubt_img';
    }

    if ($image_data['name']) {
        $image = basename($image_data['name']);
        $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $size = $image_data['size'] / 1000;

        if ($type != 'jpg' && $type != 'jpeg' && $type != 'png') {
            $response['msg'] = "only jpg,jpeg,png images are allowed";
            $response['status'] = false;
            $response['field'] = 'doubt_img';
        }

        if ($size > 2000) {
            $response['msg'] = "upload image less then 1 mb";
            $response['status'] = false;
            $response['field'] = 'doubt_img';
        }
    }
    return $response;
}

function createDoubt($text, $image)
{
    global $db;

    $doubt_text = mysqli_real_escape_string($db, $text['doubt_text']);
    $user_id = $_SESSION['userdata']['id'];

    $image_name = time() . basename($image['name']);
    $image_dir = "../images/doubts/$image_name";
    move_uploaded_file($image['tmp_name'], $image_dir);


    $query = "INSERT INTO doubts(user_id,doubt_text,doubt_img)";
    $query .= "VALUES ($user_id,'$doubt_text','$image_name')";
    return mysqli_query($db, $query);
}

function getDoubts()
{
    global $db;
    $query = "SELECT doubts.id,doubts.user_id,doubts.doubt_img,doubts.doubt_text,doubts.created_at,students.first_name,students.last_name,students.username,students.profile_pic FROM doubts JOIN students ON students.id=doubts.user_id";

    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

function getHomeDoubts()
{
    global $db;
    $query = "SELECT doubts.id,doubts.user_id,doubts.doubt_img,doubts.doubt_text,doubts.created_at,students.first_name,students.last_name,students.username,students.profile_pic FROM doubts JOIN students ON students.id=doubts.user_id";

    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

function getDoubtById($user_id)
{
    global $db;

    $query = "select * from doubts where user_id=$user_id ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

function resetPassword($email, $password)
{
    global $db;
    $password = md5($password);
    $query = "update students set password='$password' where email='$email'";
    return mysqli_query($db, $query);
}

function checkLikeStatus($doubt_id)
{
    global $db;
    $current_user = $_SESSION['userdata']['id'];
    $query = "select count(*) as row from likes where user_id=$current_user && doubt_id=$doubt_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

function like($doubt_id)
{
    global $db;
    $current_user = $_SESSION['userdata']['id'];
    $query = "insert into likes(doubt_id, user_id) values($doubt_id, $current_user)";

    return mysqli_query($db, $query);
}

function getlikes($doubt_id)
{
    global $db;
    $query = "select * from likes where doubt_id=$doubt_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

function unlike($doubt_id)
{
    global $db;
    $current_user = $_SESSION['userdata']['id'];
    $query = "DELETE FROM likes WHERE user_id=$current_user && doubt_id=$doubt_id";
    return mysqli_query($db, $query);
}

function getPosterId($doubt_id)
{
    global $db;
    $query = "SELECT user_id FROM doubts WHERE id=$doubt_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['user_id'];
}

function addComment($doubt_id, $comment)
{
    global $db;
    $comment = mysqli_real_escape_string($db, $comment);

    $current_user = $_SESSION['userdata']['id'];
    $query = "INSERT INTO comments(doubt_id,user_id,comment) VALUES($doubt_id,$current_user,'$comment')";

    return mysqli_query($db, $query);
}

function searchUser($keyword)
{
    global $db;
    $query = "SELECT * FROM students WHERE username LIKE '%" . $keyword . "%' || (first_name LIKE '%" . $keyword . "%' || last_name LIKE '%" . $keyword . "%')";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

function getComments($doubt_id)
{
    global $db;
    $query = "SELECT * FROM comments WHERE doubt_id=$doubt_id ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

function blockUser($blocked_user_id)
{
    global $db;
    $cu = getUser($_SESSION['userdata']['id']);
    $current_user = $_SESSION['userdata']['id'];
    $query = "INSERT INTO block_list(user_id,blocked_user_id) VALUES($current_user,$blocked_user_id)";

    $query2 = "DELETE FROM follow_list WHERE follower_id=$current_user && user_id=$blocked_user_id";
    mysqli_query($db, $query2);
    $query3 = "DELETE FROM follow_list WHERE follower_id=$blocked_user_id && user_id=$current_user";
    mysqli_query($db, $query3);

    return mysqli_query($db, $query);
}

function unblockUser($user_id)
{
    global $db;
    $current_user = $_SESSION['userdata']['id'];
    $query = "DELETE FROM block_list WHERE user_id=$current_user && blocked_user_id=$user_id";
    return mysqli_query($db, $query);
}

function checkBlockStatus($current_user, $user_id)
{
    global $db;

    $query = "SELECT count(*) as row FROM block_list WHERE user_id=$current_user && blocked_user_id=$user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'm' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

?>