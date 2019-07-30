<?php
    ob_start();
    $settings = parse_ini_file('settings.ini.php');

    $telnum = $_POST["telnum"];
    $pswd = $_POST["pswd"];

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

    $sql = "INSERT INTO users (telnum, pswd, admin, confirmed)
    VALUES ('$telnum', '$pswd', 'nonadmin', 'nonconfirmed')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>