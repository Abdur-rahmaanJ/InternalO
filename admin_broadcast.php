<?php
    ob_start();
    session_start();
    if (isset($_SESSION["logged_in_admin"])){
        if ($_SESSION["logged_in_admin"] === 0)
        {
            header("Location: index.php");
        }
    }else{
        header("Location: index.php");
    }

    $settings = parse_ini_file('settings.ini.php');
    include("utils.php");

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


    // === UPLOADS === //
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) 
        {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) 
            {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else 
            {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) 
        {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 1000000) 
        {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) 
        {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else 
        {// move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)
            $yourFileNAME = "roster.png";
            if (move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], "uploads/".$yourFileNAME)) //
            {
                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
            } else 
            {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    // === UPLOADS === // end

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
    <base href="index.php">
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-light navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link active" href="index.php">Home</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link active" href="admin_broadcast.php">Broadcast</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li>
      </ul>
    </nav>
    <br>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" id="send_message">
                        SEND MESSAGE
                    </div>
                    <div class="card-body">
                        <form 
                        method="post" 
                        action="send_message_broadcast.php">
                            <div class="form-group">
                                <label>To</label>
                                <input name="receiver" class="form-control" type="text" value="broadcast to all" readonly><br>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input name="title" class="form-control" type="" ><br>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="text" class="form-control">
                                    
                                </textarea>
                            </div>
                            <input name="redirect" type="hidden" value="admin_dashboard.php#send_message">
                            <button class="btn btn-primary" type="submit">SEND</button>
                        </form>
                    </div>
                </div>
          </div>
        </div>

    </div>
    <footer class="footer">
        
    </footer>
</body>
</html>