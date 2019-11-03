<?php
ob_start();
session_start();
$settings = parse_ini_file('settings.ini.php');

$redirect = $_POST["redirect"];

$sender = $_SESSION["phone_num"];
$receiver = $_POST["receiver"];
$title = $_POST["title"];
$text = $_POST["text"];
$viewed = "no";
$date = date('Y-m-d');
$time = date('H:i:s');

// Create connection
$conn = new mysqli(
    $settings['db_host'],
    $settings['db_user'],
    $settings['db_pass'],
    $settings['db_name']);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($receiver == '@all') {
    $select_query = "SELECT telnum FROM users WHERE admin = 'nonadmin' AND  confirmed = 'confirmed'";
    $result = mysqli_query($conn, $select_query);
    if (!empty($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $telnum = $row['telnum'];
            $sql = "INSERT INTO messages (sender, receiver, title, text, viewed, date, time)
    VALUES ('$sender','$telnum','$title','$text','$viewed','$date','$time')";
            mysqli_query($conn, $sql);
        }
        echo "New record created successfully";
        header("Location: " . $redirect);
    } else {
        echo "No registered users.";
    }
} else {
    $sql = "INSERT INTO messages (sender, receiver, title, text, viewed, date, time)
    VALUES ('$sender', '$receiver', '$title', '$text', '$viewed', '$date', '$time')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: " . $redirect);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
mysqli_close($conn);
?>