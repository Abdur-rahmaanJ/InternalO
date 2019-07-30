<?php
    ob_start();
    session_start(); 
    $settings = parse_ini_file('settings.ini.php');

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

    $sql = "INSERT INTO messages (sender, receiver, title, text, viewed, date, time)
    VALUES ('$sender', '$receiver', '$title', '$text', '$viewed', '$date', '$time')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>