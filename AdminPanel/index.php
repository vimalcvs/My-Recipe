<?php
  include("includes/connection.php");
  include("language/language.php");

  if(isset($_SESSION['admin_name']))
  {
    header("Location:dashboard.php");
    exit;
  }
?>
<!-- My Recipe - My Recipe app with Admin panel
 * Version v1.0
 * Copyright 2021 - G-Devs
 * https://codecanyon.net/user/g-devs -->


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600|Open+Sans:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="css/easion.css">
    <title><?php echo APP_NAME; ?> </title>
</head>

<body class="bg-dark">
    <div class="form-screen dark">
        
        <div class="card account-dialog">
            <div class="card-header bg-primary text-white text-center"> <?php echo APP_NAME; ?> </div>
            <div class="card-body">
                <form action="login_db.php" method="post">
                                  <div class="input-group" style="border:0px;">
                <?php if(isset($_SESSION['msg'])){?>
                <div class="alert alert-danger  alert-dismissible" role="alert"> Username / Password is invalid ! </div>
                <?php unset($_SESSION['msg']);}?>
              </div>
                    <div class="form-group">
                        <label for="inputEmail4">Username</label>
                       <input type="text" name="username" id="username" value="admin" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail4">Password</label>
 <input type="password" name="password" id="password" value="admin" class="form-control" placeholder="Password" aria-describedby="basic-addon2">
                    </div>
                   
                    <div class="account-dialog-actions">
                        <button type="submit" class="btn btn-success btn-block" value="Login">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/easion.js"></script>
</body>

</html>