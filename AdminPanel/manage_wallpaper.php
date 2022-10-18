<?php

$page_title="Manage Category";
$active_page="Category";


include("includes/header.php");
session_start();

if(isset($_POST['data_search']))
{

  $search_txt=strip_tags(htmlentities(trim($_POST['search_value'])));

  $qry="SELECT * FROM tbl_recipe                   
  WHERE tbl_recipe.`wallpaper_name` LIKE '%$search_txt%'
  ORDER BY tbl_recipe.`wallpaper_name`";

  $result=mysqli_query($mysqli,$qry); 

}
else
{
  //Get all Category 
  $tableName="tbl_recipe";   
  $targetpage = "manage_wallpaper.php"; 
  $limit = 12; 

  $query = "SELECT COUNT(*) as num FROM $tableName";
  $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
  $total_pages = $total_pages['num'];

  $stages = 3;
  $page=0;
  if(isset($_GET['page'])){
    $page = mysqli_real_escape_string($mysqli,$_GET['page']);
  }

  if($page){
    $start = ($page - 1) * $limit; 
  }else{
    $start = 0; 
  } 

  $qry="SELECT * FROM tbl_recipe
  LEFT JOIN tbl_category ON tbl_recipe.cat_id= tbl_category.cid ORDER BY tbl_recipe.id DESC LIMIT $start, $limit";

  $result=mysqli_query($mysqli,$qry); 

}


if(isset($_GET['id']))
{

  $imageUrl = 'images/'.$_GET['recipe_image'];

    //delete the image
  unlink('images/'.$_GET['recipe_image'].'');

  Delete('tbl_recipe','id='.$_GET['recipe_image'].'');




  $_SESSION['msg']="12";
  header( "Location:manage_wallpaper.php");
  exit;

}

?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Recipe</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="code.php" method="POST" enctype="multipart/form-data">

          <div class="form-group col-md-12">
                                        
                                        <select class="form-control" name="recipe_category">
                                            <option value="">--Select Category--</option>
                                            <?php
                                            $cat_qry="SELECT * FROM tbl_category WHERE `status`='1' ORDER BY `category_name`";
                                            $cat_result=mysqli_query($mysqli,$cat_qry);
                                            while($cat_row=mysqli_fetch_array($cat_result))
                                            {
                                                ?>                                   
                                                <option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>                                       
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                        
                                        <input type="text" class="form-control" name="recipe_name" placeholder="Recipe Name">
                                        </div>

                                        <div class="col-md-12">

                                        <div class="row">
                                          
                                        

                                        <div class="form-group col-md-6">
                                        
                                        <input type="text" class="form-control" name="recipe_time" placeholder="Recipe Time">
                                        </div>

                                        <div class="form-group col-md-6">
                                        
                                        <input type="text" class="form-control" name="recipe_person" placeholder="Recipe Person">
                                        </div>

                                      </div></div>

                                        <div class="form-group col-md-12">
                                        <select class="form-control" name="recipe_type" id="recipe_type">
                                            <option value="image">IMAGE</option>
                                            <option value="video">VIDEO</option>
                                        </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                        
                                        <input type="text" class="form-control" name="recipe_video" id="recipe_video" placeholder="Youtube video url..">
                                        </div>

                                        <div class="form-group col-md-12">
                                        
                                        <input type="file" class="form-control" name="recipe_image">
                                        </div>

                                        <div class="form-group col-md-12">
                                        
                                        <textarea type="email" class="ckeditor" name="recipe_description" style="height: 500px"></textarea>
                                        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        <button type="submit" name="save_recipe" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- end Modal -->


<!-- edit Modal -->
<div class="modal fade" id="editmodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Recipe</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="code.php" method="POST" enctype="multipart/form-data">

          <input type="hidden" name="edit_id" id="edit_id">

          <div class="form-group col-md-12">
                                        
                                        <select class="form-control" name="recipe_category" id="recipe_category" required="">
                                            <option value="">--Select Category--</option>
                                            <?php
                                            $cat_qry="SELECT * FROM tbl_category WHERE `status`='1' ORDER BY `category_name`";
                                            $cat_result=mysqli_query($mysqli,$cat_qry);
                                            while($cat_row=mysqli_fetch_array($cat_result))
                                            {
                                                ?>                                   
                                                <option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>                                       
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                        
                                        <input type="text" class="form-control" name="recipe_name" id="recipe_name" placeholder="Recipe Name" required>
                                        </div>

                                        <div class="col-md-12">

                                        <div class="row">
                                          
                                        

                                        <div class="form-group col-md-6">
                                        
                                        <input type="text" class="form-control" id="recipe_time" name="recipe_time" placeholder="Recipe Time" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                        
                                        <input type="text" class="form-control" id="recipe_person" name="recipe_person" placeholder="Recipe Person" required>
                                        </div>

                                      </div></div>

                                        <div class="form-group col-md-12">
                                        <select class="form-control" name="recipe_type" id="recipe_type" required>
                                            <option value="image">IMAGE</option>
                                            <option value="video">VIDEO</option>
                                        </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                        
                                        <input type="text" class="form-control" name="recipe_video" id="recipe_video" placeholder="Youtube video url.." >
                                        </div>

                                        <div class="form-group col-md-12">
                                        
                                        <input type="file" class="form-control" name="recipe_image" id="recipe_image" >
                                        </div>

                                        <div class="form-group col-md-12">
           <img src="" id="recipe_image_src" width="300px">
          </div>

                                        <div class="form-group col-md-12">
                                        
                                        <textarea type="email" class="ckeditor" name="recipe_description" id="recipe_description" style="height: 500px"></textarea>
                                        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        <button type="submit" name="recipe_update_btn" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- end edit Modal -->
<main class="dash-content">
  <div class="col-lg-12">
    <div class="col-lg-12">
      <h3 class="dash-title">Manage Recipes <a href="add_recipe.php" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float: right;"><i class="fas fa-plus"></i> Add Recipe</a> </h3>                    
    </div>
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
      <div class="col-lg-12">
        <div class="card easion-card">
          <div class="card-header">
            <div class="easion-card-icon">
              <i class="fas fa-table"></i>
            </div>
            <div class="easion-card-title">All Recipes</div>
          </div>
          <div class="card-body ">
           <table class="table stylish-table table-bordered">
            <thead>
              <tr>
                <th class="border-top-0">#</th>
                <th class="border-top-0">Recipe Name</th>
                <th class="border-top-0">Recipe Image</th>
                <th class="border-top-0">Category</th>
                <th class="border-top-0">Recipe Type</th>
                <th class="border-top-0">Edit</th>
                <th class="border-top-0">Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=0; while($row=mysqli_fetch_array($result)){ ?>
                <tr>

                  <td class="data"><?php echo $row['id'];?></td>
                  <td class="card-title"><?php echo $row['recipe_name'];?></td>

                  <td><img src="images/<?php echo $row['recipe_image'];?>" width="150" height="100" style="border-radius: 10px"></td>
                  <td class="card-title"><?php echo $row['category_name'];?></td>
                  <td class="card-title"><?php echo $row['recipe_type'];?></td>
                  <td>
                    
                      <button type="submit" name="edit_recipe_btn" class="btn btn-primary editbtn"><i class="fas fa-edit"></i> Edit</button>
                    
                  </td>
                  <td>
                    <input type="hidden" class="delete_id_value" value="<?php echo $row['id'];?>"/>
                    <a href="" class="delete_btn_ajax btn btn-dark"><i class="fas fa-trash"></i>
                    Delete</a></td>
                  </tr>
                  <?php $i++; } ?> 
                </tbody>
              </table>
            </div>
            <div class="col-md-12 col-xs-12 text-center">
              <div class="pagination_item_block">
                <nav>
                  <?php if(!isset($_POST["data_search"])){ include("pagination.php");}?>
                </nav>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

<?php include("includes/footer.php");?>  



<script type="text/javascript">

  $(document).ready(function (){

    $('.delete_btn_ajax').click(function (e){
      e.preventDefault();

      var deleteid = $(this).closest("tr").find('.delete_id_value').val();

      console.log(deleteid);

      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
       if (willDelete) {

        $.ajax({
          type:'POST',
          url:'code.php',
          data:{
            "delete_wallpaper_btn": 1,
            "delete_id": deleteid,
          },
          success:function(res){

            swal({
             title: "Deleted",
             icon: "success",
           }).then((result) => {
            location.reload();
          });

         }
       });

      }

    });
    });
  });


</script>

<script type="text/javascript">

  $(document).ready(function (){

    $('.editbtn').click(function (e){
     
      var data_id = $(this).closest('tr').find('.data').text();

      console.log(data_id);

      $.ajax({
        type: "POST",
        url: "code.php",
        data: {
          'recipe_edit_btn': true,
          'id': data_id,
        },
        success: function (response){

          console.log(response);

          $.each(response, function(key,value){

            $('#edit_id').val(value['id']);
            $('#recipe_name').val(value['recipe_name']);
            $('#recipe_time').val(value['recipe_time']);
            $('#recipe_person').val(value['recipe_person']);
            $('#recipe_type').val(value['recipe_type']);
            $('#recipe_video').val(value['recipe_video']);
            //$('#recipe_image').val(value['recipe_image']);
            $('#recipe_category').val(value['recipe_category']);
            //$('#recipe_description').val(value['recipe_description']);

            var image_url = value['recipe_image']
            var image_tag = "images/"

            //console.log(image_url);

            document.getElementById("recipe_image_src").src = image_tag+image_url;
            //document.getElementById("recipe_description").value = "ggggg";

            CKEDITOR.instances['recipe_description'].setData(value['recipe_description']);
          });

          $('#editmodel').modal('show');
        }
      });

    });
  });  


  $("#recipe_type").change(function () {
    var selected_option = $('#recipe_type').val();
    

    if (selected_option === 'video') {
        $('#recipe_video').attr('pk','image').show();
    }
    if (selected_option != 'video') {
        $("#recipe_video").removeAttr('pk').hide();
    }
})
  
</script>
