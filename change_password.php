<?php
    ob_start();
    session_start();
    if ($_SESSION["logged_in_admin"] === 0)
    {
        header("Location: index.php");
    }
    $settings = parse_ini_file('settings.ini.php');
    include("utils.php");

    $id = $_GET['id'];
    $telnum = $_GET['telnum'];

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
          <a class="nav-link" href="admin_dashboard.php">Back</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">logout</a>
        </li>
      </ul>
    </nav>
    <div class="container">
        <div class="card">
            <div class="card-header">
                CHANGE PASSWORD
            </div>
            <div class="card-body">
                <form 
                    method="post" 
                    action="set_pass.php">
                    <div class="form-group">
                        <label>Number</label>
                        <input class="form-control" type="" name="telnum" value="<?php echo $telnum ?>" disabled><br>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input class="form-control" type="number" name="newpass"><br>
                        <input class="form-control" type="hidden" name="id" value="<?php echo $id ?>">
                    </div>
                    <button class="btn btn-primary" type="submit">CHANGE</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>