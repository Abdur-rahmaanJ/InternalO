<?php 
    ob_start();
    $id = $_GET['id'];

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

    $sql = "DELETE FROM users WHERE id='$id'";
// admin.php?type=...
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        header("Location: admin_dashboard.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
?>