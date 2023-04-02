<?php 
    $connect = mysqli_connect("localhost", "root", "", "insightintellect");

    $doubtid = intval($_POST['doubtid']);
    $doubt = $_POST['doubt'];

    $update_doubt = "UPDATE doubts SET doubt_text='$doubt' WHERE id = $doubtid";
    $result = mysqli_query($connect, $update_doubt);

    if($result) {
        echo "Doubt Updated successfully";
        echo "<br>";
        echo "<a href='http://localhost/insightintellect'>back to home</a>";
    } else {
        echo "Error deleting doubt: " . mysqli_error($connect);
    }
?>