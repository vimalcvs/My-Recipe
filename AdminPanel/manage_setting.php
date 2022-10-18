<?php
include("includes/header.php");
?>

<main class="dash-content">
                <div class="container-fluid">
                    <h1 class="dash-title">Manage Ads</h1>
                    <?php

    if (isset($_SESSION['status']) && $_SESSION['status'] !='') {
       ?>
       
       <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Hey !</strong> <?php echo $_SESSION['status']; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>


       <?php  unset($_SESSION['status']);
     } 

    ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card easion-card">
                                <div class="card-header">
                                    <div class="easion-card-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div class="easion-card-title"> Form </div>
                                </div>
                                <div class="card-body ">

                                    <?php

                                        # code...
                                        $id = 1;
                                        $query = "SELECT * FROM tbl_settings WHERE id='$id' ";
                                        $query_run = mysqli_query($mysqli, $query);

                                        foreach ($query_run as $row) {

                                        ?>

                                        <form action="code.php" method="POST">
                                        <input class="form-control" type="hidden" name="edit_id" value="<?php echo $row['id']?>">
                                        

                                        
                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">App Name :</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="app_name" value="<?php echo $row['app_name']?>" id="example-text-input">
                                        </div>
                                        </div>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">App Image :</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="app_logo" value="<?php echo $row['app_logo']?>" id="example-text-input">
                                        </div>
                                        </div>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Onesignal ID :</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="onesignal_app_id" value="<?php echo $row['onesignal_app_id']?>" id="example-text-input">
                                        </div>
                                        </div>

                                    
                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">OneSignal Rest Key :</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="onesignal_rest_key" value="<?php echo $row['onesignal_rest_key']?>" id="example-text-input">
                                        </div>
                                        </div>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Category Order :</label>
                                        <div class="col-md-10">
                                           <select class="form-control" name="category_order">
                                                <option value="id" <?php if($row['category_order']=='cid'){?>selected<?php }?>>ID</option>
                                                <option value="name" <?php if($row['category_order']=='name'){?>selected<?php }?>>NAME</option>
                                            </select>
                                        </div>
                                        </div>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Category Type :</label>
                                        <div class="col-md-10">
                                            <select class="form-control" name="category_sort">
                                                <option value="ASC" <?php if($row['category_sort']=='ASC'){?>selected<?php }?>>ASC</option>
                                                <option value="DESC" <?php if($row['category_sort']=='DESC'){?>selected<?php }?>>DESC</option>
                                            </select>
                                        </div>
                                        </div>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Privacy Policy</label>
                                        <div class="col-md-10">
                                            <textarea type="text" class="ckeditor" name="app_privacy_policy"><?php echo $row['app_privacy_policy']?></textarea>
                                        </div>
                                        </div>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label"></label>
                                        <div class="col-md-10">
                                            <button type="submit" name="setting_update_btn" class="btn btn-primary">Submit</button>
                                        </div>
                                        </div>
                                        
                                        </form>
                                            <?php
                                        
                                    }
                                    ?>
                                    
                                </div>
                            </div>
                        </div>
            </main>
<?php
include("includes/footer.php");
?>
