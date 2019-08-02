<?php
    ob_start();
    session_start();
    if ($_SESSION["logged_in"] === 0)
    {
        header("Location: index.php");
    }
    $settings = parse_ini_file('settings.ini.php');
    include("utils.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-light navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Back</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li>
      </ul>
    </nav>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-8">
        <?php
        $fileList = glob('uploads/*');
        //Loop through the array that glob returned.
        foreach($fileList as $filename){
           //Simply print them out onto the screen.
           echo "<img width='500px' src='" . $filename . "'>";
        }
        ?>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        SEND MESSAGE
                    </div>
                    <div class="card-body">
                        <form 
                        method="post" 
                        action="send_message.php">
                            <div class="form-group">
                                <label>To</label>
                                <input name="receiver" class="form-control" type="" name="telnum"><br>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input name="title" class="form-control" type="" name="telnum"><br>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="text" class="form-control">
                                    
                                </textarea>
                            </div>
                            <input name="redirect" type="hidden" value="roster.php#send_message">
                            <button class="btn btn-primary" type="submit">SEND</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row">
            
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        MESSAGES
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                              <tr>
                                <th>Sender</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Time</th>
                              </tr>
                            </thead>
                            <tbody>
                        <?php 
                            $conn = new mysqli(
                                    $settings['db_host'], 
                                    $settings['db_user'], 
                                    $settings['db_pass'], 
                                    $settings['db_name']);
                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                } 
                            $mynum = $_SESSION["phone_num"];
                            $sql = "SELECT id, sender, receiver, title, text, viewed, date, time FROM messages where receiver='$mynum'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>".
                                            "<td>" . $row["sender"] . "</td>";
                                    $redirect = 'roster.php#send_message';
                                    if($row["viewed"] == "no"){
                                        echo "<td><b><a href='display_message.php?id=". $row["id"] ."&redirect=".$redirect."'>" . $row["title"] . "</a></b></td>";
                                    }else{
                                        echo "<td><a href='display_message.php?id=". $row["id"] ."&redirect=".$redirect."'>" . $row["title"] . "</td>";
                                    }
                                    echo "<td>" . $row["date"] . "</td>" .
                                            "<td>" . $row["time"] . "</td>" .
                                        "</tr>";
                                }
                            } else {
                                echo "0 results";
                            }
                            $conn->close();
                        ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header" id="display_message">
                        MESSAGE
                    </div>
                    <div class="card-body">
                        <?php
                            if (isset($_SESSION['msgtodisplay_id']))
                                {
                                    $conn = new mysqli(
                                        $settings['db_host'], 
                                        $settings['db_user'], 
                                        $settings['db_pass'], 
                                        $settings['db_name']);
                                    // Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    } 
                                    $msgid = $_SESSION['msgtodisplay_id'];
                                    $sql = "SELECT id, sender, receiver, title, text, viewed, date, time FROM messages where id='$msgid'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($row = $result->fetch_assoc()) {
                                            echo $row["sender"] . " | " . $row["date"] . " | " . $row["time"] . "<br>";
                                            echo "<b>" . $row["title"] . "</b><hr>";
                                            echo $row["text"];
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    $conn->close();
                                }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>