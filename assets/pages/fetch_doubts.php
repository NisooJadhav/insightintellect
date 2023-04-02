<?php
$connect = mysqli_connect("localhost", "root", "", "insightintellect");
$sql = "SELECT id,user_id,doubt_text from doubts";
$result = mysqli_query($connect, $sql);
$data2 = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data2[] = $row;
}
echo json_encode($data2);
mysqli_close($connect);
?>