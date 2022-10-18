<?php 
    include("includes/connection.php");
    include("includes/session_check.php");

    date_default_timezone_set("Asia/Kolkata");
      
    //Get file name
    $currentFile = $_SERVER["SCRIPT_NAME"];
    $parts = Explode('/', $currentFile);
    $currentFile = $parts[count($parts) - 1]; 

    $requestUrl = $_SERVER["REQUEST_URI"];
    $urlparts = Explode('/', $requestUrl);
    $redirectUrl = $urlparts[count($urlparts) - 1]; 

    $mysqli->set_charset("utf8mb4");     

    $_SESSION['class']='success';
       
      
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600|Open+Sans:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="css/easion.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert/sweetalert.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
    <script src="js/chart-js-config.js"></script>
    <link rel="stylesheet" href="http://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <title><?php echo APP_NAME;?></title>
</head>

<body>
    <div class="dash">
        <div class="dash-nav dash-nav-dark">
            <header>
                <a href="#!" class="menu-toggle">
                    <i class="fas fa-bars" style="color: #000000;"></i>
                </a>
                <a href="index.html" class="easion-logo"><img src="images/logo.png" class="mr-1" style="width: 75px;">
                    <!-- <span style="color: #3f84fc"><?php echo APP_NAME;?></span></a> -->
            </header>
            <nav class="dash-nav-list">

                <?php if($currentFile=="dashboard.php"){?>
                <div class="dash-nav-dropdown show" class="dash-nav-dropdown">
                <a href="dashboard.php" class="dash-nav-item" style="color: #ffffff">
                <i class="fas fa-home"></i> Dashboard </a>
                </div>
                <?php }else{?>
                <div class="dash-nav-dropdown" class="dash-nav-dropdown">
                <a href="dashboard.php" class="dash-nav-item">
                <i class="fas fa-home"></i> Dashboard </a>
                </div>

                <?php }?>

                <?php if($currentFile=="manage_category.php" or $currentFile=="add_category.php" or $currentFile=="edit_category.php"){?>
                <div class="dash-nav-dropdown show"class="dash-na v-dropdown">
                <a href="manage_category.php" class="dash-nav-item" style="color: #ffffff">
                        <i class="fas fa-chart-bar"></i> Category </a>
                </div>
                <?php }else{?>
                    <div class="dash-nav-dropdown"class="dash-na v-dropdown">
                <a href="manage_category.php" class="dash-nav-item" >
                        <i class="fas fa-chart-bar"></i> Category </a>
                </div>
                <?php }?>

                <?php if($currentFile=="manage_wallpaper.php" or $currentFile=="add_recipe.php" or $currentFile=="edit_recipe.php"){?>
                <div class="dash-nav-dropdown show"class="dash-na v-dropdown">
                <a href="manage_wallpaper.php" class="dash-nav-item" style="color: #ffffff">
                        <i class="fas fa-leaf"></i> Recipes </a>
                </div>
                <?php }else{?>
                    <div class="dash-nav-dropdown"class="dash-na v-dropdown">
                <a href="manage_wallpaper.php" class="dash-nav-item" >
                        <i class="fas fa-leaf"></i> Recipes </a>
                </div>
                <?php }?>


                <?php if($currentFile=="notification.php"){?>
                <div class="dash-nav-dropdown show" class="dash-nav-dropdown">
                <a href="notification.php?add" class="dash-nav-item" style="color: #ffffff">
                        <i class="fas fa-bell"></i> Notification </a>
                </div>
                <?php }else{?> 
                <div class="dash-nav-dropdown" class="dash-nav-dropdown">
                <a href="notification.php?add" class="dash-nav-item">
                        <i class="fas fa-bell"></i> Notification </a>
                </div>
                <?php }?>

                <?php if($currentFile=="manage_ads.php"){?>
                <div class="dash-nav-dropdown show" class="dash-nav-dropdown">
                <a href="manage_ads.php" class="dash-nav-item" style="color: #ffffff">
                        <i class="fas fa-paper-plane"></i> Manage Ads </a>
                </div>
                <?php }else{?> 
                <div class="dash-nav-dropdown" class="dash-nav-dropdown">
                <a href="manage_ads.php" class="dash-nav-item">
                        <i class="fas fa-paper-plane"></i> Manage Ads </a>
                </div>
                <?php }?>

                <?php if($currentFile=="manage_setting.php"){?>
                <div class="dash-nav-dropdown show" class="dash-nav-dropdown">
                <a href="manage_setting.php" class="dash-nav-item" style="color: #ffffff">
                        <i class="fas fa-wrench"></i> Settings </a>
                </div>
                <?php }else{?> 
                <div class="dash-nav-dropdown" class="dash-nav-dropdown">
                <a href="manage_setting.php" class="dash-nav-item">
                        <i class="fas fa-wrench"></i> Settings </a>
                </div>
                <?php }?>
                
            </nav>
        </div>
        <div class="dash-app">
            <header class="dash-toolbar">
                <a href="#!" class="menu-toggle">
                   <i class="fas fa-bars" style="color: #ffffff;"></i>
                </a>
                <div class="tools">
                    <div class="dropdown tools-item">
                        <a href="#" class="" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user" style="color: #ffffff;"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                            <a class="dropdown-item" href="profile.php">Profile</a>
                            <button class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</button>
                        </div>
                    </div>
                </div>
            </header

            <!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="code.php" method="POST" enctype="multipart/form-data">

          <h5>You want to Sure ?</h5>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        <a href="logout.php" type="submit" class="btn btn-primary">Logout</a>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- end Modal -->