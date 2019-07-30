<?php
    ob_start();
    session_start(); 
    $id = $_GET['id'];
    $_SESSION["msgtodisplay_id"] = $id;
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

    $sql = "UPDATE messages SET viewed='yes' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php#display_message");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
?>