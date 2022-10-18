<?php
include("includes/header.php");
?>

<main class="dash-content">
                <div class="container-fluid">
                    <h1 class="dash-title">Manage Profile</h1>
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
                                    <div class="easion-card-title"> Admin </div>
                                </div>
                                <div class="card-body ">

                                    <?php

                                        # code...
                                        $id = 1;
                                        $query = "SELECT * FROM tbl_admin WHERE id='$id' ";
                                        $query_run = mysqli_query($mysqli, $query);

                                        foreach ($query_run as $row) {

                                        ?>

                                        <form action="code.php" method="POST">
                                        <input class="form-control" type="hidden" name="edit_id" value="<?php echo $row['id']?>">
                                        

                                        
                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Username :</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="username" value="<?php echo $row['username']?>" id="example-text-input">
                                        </div>
                                        </div>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Password :</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="password" name="password" value="<?php echo $row['password']?>" id="example-text-input">
                                        </div>
                                        </div>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Email :</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="email" value="<?php echo $row['email']?>" id="example-text-input">
                                        </div>
                                        </div>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label"></label>
                                        <div class="col-md-6">
                                            <button type="submit" name="profile_update_btn" class="btn btn-primary">Submit</button>
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
