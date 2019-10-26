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

    function getDataAll($sql,$conn){
        $get = mysqli_query($conn,$sql);
        if($get){
            if(mysqli_num_rows($get)){
                while($data = mysqli_fetch_assoc($get)){
                    $all[] = $data;
                }
                return $all;
            }else{
                return false;
            }
        }else{
            echo mysqli_error($conn);
        }
    }

    $numall = getDataAll("SELECT telnum FROM users WHERE telnum <> $sender",$conn);
    // print_r($numall);
    $no = 0;
    foreach($numall as $send){
        $penerima = $send['telnum'];
        $sql = "INSERT INTO messages (sender, receiver, title, text, viewed, date, time)
                VALUES ('$sender', '$penerima', '$title', '$text', '$viewed', '$date', '$time')";

                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                    header("Location: ".$redirect);
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
        $no++;
    }

    $conn->close();
?>