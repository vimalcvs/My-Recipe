<?php

$page_title="Manage Category";
$active_page="Category";


include("includes/header.php");
session_start();

if(isset($_POST['data_search']))
{

  $search_txt=strip_tags(htmlentities(trim($_POST['search_value'])));

  $qry="SELECT * FROM tbl_category                   
  WHERE tbl_category.`category_name` LIKE '%$search_txt%'
  ORDER BY tbl_category.`category_name`";

  $result=mysqli_query($mysqli,$qry); 

}
else
{
  //Get all Category 
  $tableName="tbl_category";   
  $targetpage = "manage_category.php"; 
  $limit = 10; 

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

  $qry="SELECT * FROM tbl_category ORDER BY tbl_category.`cid` DESC LIMIT $start, $limit";

  $result=mysqli_query($mysqli,$qry); 

}


if(isset($_GET['cid']))
{

  $imageUrl = 'images/'.$_GET['category_image'];

    //delete the image
  unlink('images/'.$_GET['category_image'].'');

  Delete('tbl_category','cid='.$_GET['category_image'].'');




  $_SESSION['msg']="12";
  header( "Location:manage_category.php");
  exit;

} 
?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="code.php" method="POST" enctype="multipart/form-data">

          <div class="form-group col-md-12">
            <label for="inputEmail4">Category Name</label>
            <input type="text" class="form-control" value="<?php echo $row['category_name']?>" name="cname" placeholder="">
          </div>
          <div class="form-group col-md-12">
            <label for="inputEmail4">Category Image</label>
            <input type="file" class="form-control" name="cimage[]" placeholder="" multiple>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        <button type="submit" name="save_data" class="btn btn-primary">Save changes</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="code.php" method="POST" enctype="multipart/form-data">

<input type="hidden" class="form-control" id="edit_id" name="edit_id" placeholder="">
          <div class="form-group col-md-12">
            <label for="inputEmail4">Category Name</label>
            <input type="text" class="form-control" id="cname" name="cname" placeholder="">
          </div>
          <div class="form-group col-md-12">
            <label for="inputEmail4">Category Image</label>
            <input type="file" class="form-control" id="cimage" name="cimage" placeholder="" multiple>
          </div>

          <div class="form-group col-md-12">
           <img src="" id="category_image_src" width="300px">
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        <button type="submit" name="category_update_btn" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- end Modal -->

<main class="dash-content">
  <div class="col-lg-12">
    <div class="col-lg-12">
      <h3 class="dash-title">Manage Category <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float: right;"><i class="fas fa-plus"></i> Add Category</a> </h3>                    
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
            <div class="easion-card-title">All Categories</div>
          </div>
          <div class="card-body ">
           <table class="table stylish-table table-bordered">
            <thead>
              <tr>
                <th class="border-top-0">#</th>
                <th class="border-top-0">Category Name</th>
                <th class="border-top-0">Category Image</th>
                <th class="border-top-0">Edit</th>
                <th class="border-top-0">Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=0; while($row=mysqli_fetch_array($result)){ ?>
                <tr>

                  <td class="data "><?php echo $row['cid'];?></td>
                  <td class="card-title"><?php echo $row['category_name'];?></td>
                  <td><img src="images/<?php echo $row['category_image'];?>" width="150" height="100" style="border-radius: 10px"></td>
                  <td>
                    
                    <button type="submit" name="edit_category_btn" class="btn btn-primary editbtn"><i class="fas fa-edit"> </i> Edit</button>
                   
                  </td>
                  <td>
                    <input type="hidden" class="delete_id_value" value="<?php echo $row['cid'];?>"/>
                    <a href="" class="delete_btn_ajax btn btn-dark"><i class="fas fa-trash"></i> Delete</a></td>
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
            "delete_btn_set": 1,
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
          'checking_edit_btn': true,
          'cid': data_id,
        },
        success: function (response){

          console.log(response);

          $.each(response, function(key,value){

            $('#edit_id').val(value['cid']);
            $('#cname').val(value['category_name']);
            //$('category_image_src').val(src['category_image']);

            var image_url = value['category_image']
            var image_tag = "images/"

            console.log(image_url);

            document.getElementById("category_image_src").src = image_tag+image_url;
          });

          $('#editmodel').modal('show');
        }
      });

    });
  });  
  
</script>
