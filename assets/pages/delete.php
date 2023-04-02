<?php
    $connect = mysqli_connect("localhost", "root", "", "insightintellect");

    // Validate input
    $userid = intval($_GET['userid']);

    // Delete user
    $delete_user = "DELETE FROM students WHERE id = $userid";
    $result = mysqli_query($connect, $delete_user);

    if($result) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . mysqli_error($connect);
    }

    ob_clean();

    // Delete doubt
    $doubtid = intval($_GET['doubtid']);

    $delete_doubt = "DELETE FROM doubts WHERE id = $doubtid";
    $result2 = mysqli_query($connect, $delete_doubt);

    if($result2) {
        echo "Doubt deleted successfully";
    } else {
        echo "Error deleting doubt: " . mysqli_error($connect);
    }

    ob_clean();
    
    // Delete comment
    $commentid = intval($_GET['commentid']);

    $delete_comment = "DELETE FROM comments WHERE id = $commentid";
    $result3 = mysqli_query($connect, $delete_comment);

    if($result3) {
        echo "Comment deleted successfully";
    } else {
        echo "Error deleting comment: " . mysqli_error($connect);
    }

    ob_clean();

    // Delete block user
    $blockid = intval($_GET['blockid']);

    $delete_block = "DELETE FROM block_list WHERE id = $blockid";
    $result4 = mysqli_query($connect, $delete_block);

    if($result4) {
        echo "Blocked User deleted successfully";
    } else {
        echo "Error deleting Blocked User: " . mysqli_error($connect);
    }

    ob_clean();

    // Reload page
    //echo "<script>window.location.reload()</script>";
?>
