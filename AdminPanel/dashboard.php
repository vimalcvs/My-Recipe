<?php include("includes/header.php");

$qry_slider="SELECT COUNT(*) as num FROM tbl_category";
$total_category= mysqli_fetch_array(mysqli_query($mysqli,$qry_slider));
$total_category = $total_category['num'];

$qry_enabled_slider ="SELECT COUNT(*) as num FROM tbl_recipe";
$total_wallpaper = mysqli_fetch_array(mysqli_query($mysqli,$qry_enabled_slider));
$total_wallpaper = $total_wallpaper['num'];


$qry_ringtones_hidden="SELECT COUNT(*) as num FROM tbl_notification";
$total_noti= mysqli_fetch_array(mysqli_query($mysqli,$qry_ringtones_hidden));
$total_noti = $total_noti['num'];


$qry_downloads="SELECT ads_type FROM tbl_ads WHERE id=1";
$total_ads= mysqli_fetch_array(mysqli_query($mysqli,$qry_downloads));
$total_ads = $total_ads['ads_type'];
 


?>       


 <main class="dash-content">
                <div class="container-fluid">
                  <div class="col-xl-12">
                    <h1 class="dash-title">Dashboard</h1>
                    </div>
                  </div>
                    <div class="row">


                        

                        <div class="col-xl-3 col-sm-6 col-12" style="margin-bottom: 20px">
<div class="card text-center">
                    <div class="card-block" style="padding: 10px;">
                        <h4 class="card-title"><?php echo $total_category ?></h4>
                        <p class="card-text">Categories<br>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="manage_category.php" class="btn btn-dark">Manage Category</a>
                    </div>
                </div></div>


      <div class="col-xl-3 col-sm-6 col-12" style="margin-bottom: 20px">
<div class="card text-center">
                    <div class="card-block" style="padding: 10px;">
                        <h4 class="card-title"><?php echo $total_wallpaper ?></h4>
                        <p class="card-text">Recipes<br>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="manage_wallpaper.php" class="btn btn-dark">Manage Recipes</a>
                    </div>
                </div></div>

      <div class="col-xl-3 col-sm-6 col-12" style="margin-bottom: 20px">
<div class="card text-center">
                    <div class="card-block" style="padding: 10px;">
                        <h4 class="card-title"><?php echo $total_ads  ?></h4>
                        <p class="card-text">Ads Network<br>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="manage_ads.php" class="btn btn-dark">Manage Ads</a>
                    </div>
                </div></div>

      <div class="col-xl-3 col-sm-6 col-12" style="margin-bottom: 20px">
<div class="card text-center">
                    <div class="card-block" style="padding: 10px;">
                        <h4 class="card-title"><?php echo $total_noti ?></h4>
                        <p class="card-text">Notification<br>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="notification.php" class="btn btn-dark">Send Notification</a>
                    </div>
                </div></div>

      


                        
        </div> </div> 
      	</div>
<?php include("includes/footer.php");?>       

 <script type="text/javascript">
  $('.timer').countTo();
</script>