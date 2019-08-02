<?php
    ob_start();
    session_start(); 
    $id = $_POST['id'];
    $pswd = $_POST['newpass'];

    $settings = parse_ini_file('settings.ini.php');

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

    $sql = "UPDATE users SET pswd='$pswd' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
?>