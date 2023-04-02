<?php
$connect = mysqli_connect("localhost", "root", "", "insightintellect");
$sql = "SELECT username, first_name, last_name, gender, email, ac_status from students";
$result = mysqli_query($connect, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode($data);
mysqli_close($connect);
?>

