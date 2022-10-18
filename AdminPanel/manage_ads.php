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
                                        $query = "SELECT * FROM tbl_ads WHERE id='$id' ";
                                        $query_run = mysqli_query($mysqli, $query);

                                        foreach ($query_run as $row) {

                                        ?>

                                        <form action="code.php" method="POST">
                                        <input class="form-control" type="hidden" name="edit_id" value="<?php echo $row['id']?>">
                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Ads Status :</label>
                                        <div class="col-md-10">
                                           <select class="form-control" name="ads_status">
                                                <option value="true" <?php if($row['ads_status']=='true'){?>selected<?php }?>>ON</option>
                                                <option value="false" <?php if($row['ads_status']=='false'){?>selected<?php }?>>OFF</option>
                                            </select>
                                        </div>
                                        </div>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Ads Network :</label>
                                        <div class="col-md-10">
                                            <select class="form-control" name="ads_type">
                                                <option value="admob" <?php if($row['ads_type']=='admob'){?>selected<?php }?>>Admob</option>
                                                <option value="facebook" <?php if($row['ads_type']=='facebook'){?>selected<?php }?>>Facebook</option>
                                            </select>
                                        </div>
                                        </div>

                                        <input class="form-control" type="hidden" name="edit_id" value="<?php echo $row['id']?>">
                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Admob Banner Id :</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="admob_banner_id" value="<?php echo $row['admob_banner']?>" id="example-text-input">
                                        </div>
                                        </div>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Admob Inter Id :</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="admob_inter_id" value="<?php echo $row['admob_inter']?>" id="example-text-input">
                                        </div>
                                        </div>

                                        <input class="form-control" type="hidden" name="edit_id" value="<?php echo $row['id']?>">
                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Facebook Banner Id :</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="facebook_banner_id" value="<?php echo $row['facebook_banner']?>" id="example-text-input">
                                        </div>
                                        </div>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Facebook Inter Id</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="facebook_inter_id" value="<?php echo $row['facebook_inter']?>" id="example-text-input">
                                        </div>
                                        </div>

                                        

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label"></label>
                                        <div class="col-md-10">
                                            <button type="submit" name="ads_update_btn" class="btn btn-primary">Submit</button>
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
