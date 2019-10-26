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
    
    // Prepare an insert statement
    $sql = "INSERT INTO users(telnum, pswd, admin, confirmed) VALUES (?, ?, ?, ?)";
     
    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssss", $telnump, $pswdp, $adminp, $confirmp);
        
        /* Set the parameters values and execute
        the statement again to insert another row */
        $telnump = $telnum;
        $pswdp = md5($pswd);
        $adminp = 'admin';
        $confirmp = 'confirmed';
        $stmt->execute();
        
        echo "Records inserted successfully.";
        header("Location: admin_dashboard.php");
    } else{
        echo "ERROR: Could not prepare query: $sql. " . $mysqli->error;
    }
     
    // Close statement
    $stmt->close();
    $conn->close();
?>