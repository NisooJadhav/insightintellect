<?php
if (!isset($_SESSION['username'])) {
    header("location:?admin");
}
;

$connect = mysqli_connect("localhost", "root", "", "insightintellect");
$query1 = "SELECT * FROM students";
$query2 = "SELECT * FROM doubts";
$query3 = "SELECT * FROM comments";
$query4 = "SELECT * FROM block_list";
$query5 = "SELECT * FROM likes";

$result1 = mysqli_query($connect, $query1);
$result2 = mysqli_query($connect, $query2);
$result3 = mysqli_query($connect, $query3);
$result4 = mysqli_query($connect, $query4);
$result5 = mysqli_query($connect, $query5);

if (mysqli_num_rows($result1) > 0) {
    while ($row = mysqli_fetch_assoc($result1)) {
        $students[] = $row;
    }
}

if (mysqli_num_rows($result2) > 0) {
    while ($row = mysqli_fetch_assoc($result2)) {
        $doubts[] = $row;
    }
}

if (mysqli_num_rows($result3) > 0) {
    while ($row = mysqli_fetch_assoc($result3)) {
        $comments[] = $row;
    }
}

if (mysqli_num_rows($result4) > 0) {
    while ($row = mysqli_fetch_assoc($result4)) {
        $block_list[] = $row;
    }
}

if (mysqli_num_rows($result5) > 0) {
    while ($row = mysqli_fetch_assoc($result5)) {
        $likes[] = $row;
    }
}

$sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS date, COUNT(*) as count FROM students GROUP BY DATE_FORMAT(created_at, '%Y-%m')";
$result6 = mysqli_query($connect, $sql);

$sql2 = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS date, COUNT(*) as count FROM doubts GROUP BY DATE_FORMAT(created_at, '%Y-%m')";
$result7 = mysqli_query($connect, $sql2);

$data = array();
while ($row = mysqli_fetch_assoc($result6)) {
    $data[] = $row;
}

$data2 = array();
while ($row = mysqli_fetch_assoc($result7)) {
    $data2[] = $row;
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>InsightIntellect - admin panel</title>
    <style>
        body {
            background: url('assets/images/bg2.png');
            background-size: cover;
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

        .logout {
            border: 1px solid red;
        }

        .logout:hover {
            color: red;
            background: #fff;
        }

        table {
            width: 100%;
            margin: 20px auto;
            table-layout: auto;
        }

        table,
        td,
        th {
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: solid 1px;
            text-align: center;
        }

        td>img {
            width: 200px;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.4.2/morris.css"
        integrity="sha512-1Yp/f4otHy/6yrj/SXnNXr/YINbCaFF9UbA01u2hcAuMED7+ZbGc0YjqqMbP0uDdXcEPgxA9/gtJTYLT0fwScA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

</head>

<body>
    <div
        style="width: 99vw; height: 100%; display: flex; flex-direction: column; justify-content: flex-start; align-items:center;">
        <div
            style="width: 95vw; height: 100%; overflow: auto; background: linear-gradient(to bottom, #eee, #eeeeee99) ; backdrop-filter: blur(20px);">
            <div class="row" style="display: flex; flex-direction: row; justify-content: center; align-items: center;">
                <div class="col-5">
                    <a href="?">
                        <img src="assets/images/logo.png"
                            style="border-radius: 1rem; padding: 0; padding-left: 10px; padding-bottom: 10px; margin-top: 2vh; width: 25vw; margin-left: 5vw;" />
                    </a>
                </div>
                <div class="col-5">
                    <h3 style="text-align:center; margin:0; padding: 0; color: black">Welcome Admin - <u
                            style="color: #0077d5">
                            <?php echo $_SESSION['username'] ?>
                        </u></h3>
                </div>
                <div class="col-2">
                    <form method="post">
                        <button class="btn btn-danger logout"
                            style="font-size: 1rem; padding: 0.75rem; border-radius: 10px; cursor: pointer"
                            name="logout">Log Out</button>
                    </form>
                </div>
            </div>

            <hr>

            <div class="row" style="display: flex; flex-direction: row; text-align: center; margin-top: 2vh;">
                <div class="col-2"
                    style="display:flex; flex-direction:column; align-items:center; justify-content:space-evenly; background: #fff; padding: 1rem; border-radius: 10px; height: 50vh; overflow: auto; top: 0; position: sticky; clear: both; font-size: 20px;">
                    <a href="#users">Users</a>
                    <div class="col-12" style="background: #aaaaaa99; height: 1px;"></div>
                    <a href="#doubts">Doubts</a>
                    <div class="col-12" style="background: #aaaaaa99; height: 1px;"></div>
                    <a href="#comments">Comments</a>
                    <div class="col-12" style="background: #aaaaaa99; height: 1px;"></div>
                    <a href="#blockedusers">Blocked Users</a>
                    <div class="col-12" style="background: #aaaaaa99; height: 1px;"></div>
                    <a href="#graphs">Graphs</a>
                    <div class="col-12" style="background: #aaaaaa99; height: 1px;"></div>
                    <a href="#reports">Reports</a>
                    <div class="col-12" style="background: #aaaaaa99; height: 1px;"></div>
                    <a href="#media">Media</a>
                </div>
                <div class="col-10"
                    style="display:flex; flex-direction:column; justify-content: flex-start; align-items:center ; background: #fff; padding: 2rem; border-radius: 10px;">
                    <h2 style="color: green">🛡️ Admin Panel</h2>
                    <div class="col-12" style="background: #aaa; height: 1px"></div>

                    <div id="users" style="height: auto; width: 50vw">
                        <h3>Users</h3>
                        <?php
                        echo '<table>';
                        echo '<tr><th>Username</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Education</th><th>Account Status</th><th></th></tr>';
                        foreach ($students as $student) {
                            echo '<tr>';
                            echo '<td>' . $student['username'] . '</td>';
                            echo '<td>' . $student['first_name'] . '</td>';
                            echo '<td>' . $student['last_name'] . '</td>';
                            echo '<td>' . $student['email'] . '</td>';
                            echo '<td>' . $student['education'] . '</td>';
                            echo '<td>' . $student['ac_status'] . '</td>';
                            echo '<td><a  href="assets/pages/delete.php?userid=' . $student['id'] . '"><button style="display: flex; flex-direction: row; align-items: center; justify-content: center; padding: 10px; cursor: pointer"><img src="https://cdn-icons-png.flaticon.com/128/6711/6711573.png" style="width: 25px; margin: 2px">Delete</button></a></td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        ?>
                    </div>

                    <div class="col-12" style="background: #aaa; height: 1px"></div>
                    <div id="doubts" style="height: auto; width: 50vw">
                        <h3>Doubts</h3>
                        <?php
                        echo '<table>';
                        echo '<tr><th>User ID</th><th>Doubt Image</th><th>Doubt Text</th><th></th></tr>';
                        foreach ($doubts as $doubt) {
                            echo '<tr>';
                            echo '<td>' . $doubt['user_id'] . '</td>';
                            echo '<td><img src="assets/images/doubts/' . $doubt['doubt_img'] . '" /></td>';
                            echo '<td>' . $doubt['doubt_text'] . '</td>';
                            echo '<td><a  href="assets/pages/delete.php?doubtid=' . $doubt['id'] . '"><button style="display: flex; flex-direction: row; align-items: center; justify-content: center; padding: 10px; cursor: pointer"><img src="https://cdn-icons-png.flaticon.com/128/6711/6711573.png" style="width: 25px; margin: 2px">Delete</button></a></td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        ?>
                    </div>

                    <div class="col-12" style="background: #aaa; height: 1px"></div>
                    <div id="comments" style="height: auto; width: 50vw">
                        <h3>Comments</h3>
                        <?php
                        echo '<table>';
                        echo '<tr><th>Doubt ID</th><th>User ID</th><th>Comment</th><th></th></tr>';
                        foreach ($comments as $comment) {
                            echo '<tr>';
                            echo '<td>' . $comment['doubt_id'] . '</td>';
                            echo '<td>' . $comment['user_id'] . '</td>';
                            echo '<td>' . $comment['comment'] . '</td>';
                            echo '<td><a  href="assets/pages/delete.php?commentid=' . $comment['id'] . '"><button style="display: flex; flex-direction: row; align-items: center; justify-content: center; padding: 10px; cursor: pointer"><img src="https://cdn-icons-png.flaticon.com/128/6711/6711573.png" style="width: 25px; margin: 2px">Delete</button></a></td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        ?>
                    </div>

                    <div class="col-12" style="background: #aaa; height: 1px"></div>
                    <div id="blockedusers" style="height: auto; width: 50vw">
                        <h3>Blocked Users</h3>
                        <?php
                        echo '<table>';
                        echo '<tr><th>Blocked By User</th><th>Blocked User ID</th><th></th></tr>';
                        foreach ($block_list as $block) {
                            echo '<tr>';
                            echo '<td>' . $block['user_id'] . '</td>';
                            echo '<td>' . $block['blocked_user_id'] . '</td>';
                            echo '<td><a  href="assets/pages/delete.php?blockid=' . $block['id'] . '"><button style="display: flex; flex-direction: row; align-items: center; justify-content: center; padding: 10px; cursor: pointer"><img src="https://cdn-icons-png.flaticon.com/128/6711/6711573.png" style="width: 25px; margin: 2px">Delete</button></a></td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        ?>
                    </div>

                    <div class="col-12" style="background: #aaa; height: 1px"></div>
                    <div id="graphs" style="height: auto; width: 50vw">
                        <h3>Graphs</h3>
                        <br>

                        <div id="chart">
                            <hr>
                            <h4>Number of Students: </h4>
                            <canvas id="students"></canvas>
                            <hr>
                            <h4>Number of Doubts: </h4>
                            <canvas id="doubts_chart"></canvas>
                        </div>
                    </div>

                    <div class="col-12" style="background: #aaa; height: 1px"></div>
                    <div id="reports" style="height: auto; width: 50vw">
                        <h3>Reports</h3>
                        <br>
                        <button id="generate-pdf"
                            style="padding: 10px; font-size: 18px; border-radius:10px; cursor: pointer">Generate PDF for
                            Students Data</button>
                        <br>
                        <br>
                        <button id="generate-pdf2"
                            style="padding: 10px; font-size: 18px; border-radius:10px; cursor: pointer">Generate PDF for
                            Doubts Data</button>
                        <br>
                        <br>
                    </div>

                    <div class="col-12" style="background: #aaa; height: 1px"></div>

                    <div id="media" style="height: auto; width: 50vw">
                        <h3>Media</h3>
                        <p>click on image to download</p>
                        <br>
                        <br>
                        <img src="assets/images/favicon.png" style="width: 25%" onclick="downloadImage(this)" />
                        <br>
                        <br>
                        <hr>
                        <img src="assets/images/logo.png" style="width: 50%" onclick="downloadImage(this)" />
                        <hr>
                        <img src="assets/images/bw.png" style="width: 50%" onclick="downloadImage(this)" />
                        <hr>
                        <img src="assets/images/bw_transparent.png" style="width: 50%" onclick="downloadImage(this)" />

                        <br>
                        <br>
                        <br>
                    </div>

                    <div class="col-12" style="background: #aaa; height: 1px"></div>
                    <br>
                    <h3>Data Dictionary</h3>
                    <embed src="assets/documents/dd.pdf" width="1000" height="500" type="application/pdf">

                    <div class="col-12" style="background: #aaa; height: 1px"></div>
                    <br>
                    <h3>DFD</h3>
                    <embed src="assets/documents/dfd.pdf" width="1000" height="500" type="application/pdf">

                    <div class="col-12" style="background: #aaa; height: 1px"></div>
                    <br>
                    <h3>SRS</h3>
                    <embed src="assets/documents/srs.pdf" width="1000" height="500" type="application/pdf">

                    <div class="col-12" style="background: #aaa; height: 1px"></div>
                    <br>
                    <h3>Design Layouts</h3>
                    <embed src="assets/documents/dl.pdf" width="1000" height="500" type="application/pdf">
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['logout'])) {
        session_destroy();
        header("location:?");
    }
    ?>

    <script type="text/javascript">
        let data = <?php echo json_encode($data); ?>;

        let labels = [];
        let counts = [];

        for (let i in data) {
            labels.push(data[i].date);
            counts.push(data[i].count);
        }

        let ctx = document.getElementById('students').getContext('2d');
        let students = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Number of Students',
                    data: counts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        });

        let data2 = <?php echo json_encode($data2); ?>;
        let labels2 = [];
        let counts2 = [];

        for (let i in data2) {
            labels2.push(data2[i].date);
            counts2.push(data2[i].count);
        }

        let ctx2 = document.getElementById('doubts_chart').getContext('2d');
        let doubts = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels2,
                datasets: [{
                    label: 'Number of Doubts',
                    data: counts2,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        });

        // PDF for students
        document.getElementById('generate-pdf').addEventListener('click', function () {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'assets/pages/fetch_students.php', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    var doc = new jsPDF();
                    for (var i = 0; i < data.length; i++) {
                        doc.text(data[i].username + ', ' + data[i].first_name + ' ' + data[i].last_name + ', ' + data[i].gender + ', ' + data[i].email + ', ' + data[i].ac_status, 10, 10 + i * 10);
                    }
                    doc.save('students.pdf');
                }
            };
            xhr.send();
        });

        // PDF for doubts
        document.getElementById('generate-pdf2').addEventListener('click', function () {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'assets/pages/fetch_doubts.php', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    var doc = new jsPDF();
                    for (var i = 0; i < data.length; i++) {
                        doc.text(data[i].id + ', ' + data[i].user_id + ', ' + data[i].doubt_text, 10, 10 + i * 10);
                    }
                    doc.save('doubts.pdf');
                }
            };
            xhr.send();
        });
    </script>
</body>

</html>