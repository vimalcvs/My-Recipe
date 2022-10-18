<?php 
	require("includes/connection.php");


    //load category data
    if (isset($_POST['checking_edit_btn'])) {

        $c_id = $_POST['cid'];
        $result_array = [];

        # code...
        $query = "SELECT * FROM tbl_category WHERE cid= '$c_id' ";
        $query_run = mysqli_query($mysqli, $query);

        if (mysqli_num_rows($query_run) > 0) 
        {

        foreach ($query_run as $row) {
                
            array_push($result_array, $row);
            header('Content-type: application/json');
            echo json_encode($result_array);

        }
            
       }

       else {
        echo $return = "<p>No Data</p>";
       }
    }

    //load recipe  data
    if (isset($_POST['recipe_edit_btn'])) {

        $c_id = $_POST['id'];
        $result_array = [];

        # code...
        $query = "SELECT * FROM tbl_recipe WHERE id= '$c_id' ";
        $query_run = mysqli_query($mysqli, $query);

        if (mysqli_num_rows($query_run) > 0) 
        {

        foreach ($query_run as $row) {
                
            array_push($result_array, $row);
            header('Content-type: application/json');
            echo json_encode($result_array);

        }
            
       }

       else {
        echo $return = "<p>No Data</p>";
       }
    }


    //delete category
    if (isset($_POST['delete_btn_set'])) 
    {
    	# code...
    	$del_id = $_POST['delete_id'];

    	$sql_quote="SELECT * FROM tbl_recipe WHERE `cat_id` = '$del_id'";
		$res_quote=mysqli_query($mysqli, $sql_quote);

			while ($row_quote=mysqli_fetch_assoc($res_quote)) {

				if($row_quote['recipe_image']!="")
				{
					unlink('images/'.$row_quote['recipe_image']);
					unlink('images/thumbs/'.$row_quote['recipe_image']);
				}

				Delete('tbl_recipe','id='.$row_quote['id']);

			}

    	$sqlCategory="SELECT * FROM `tbl_category` WHERE `cid` IN ($del_id)";
			$res_cat=mysqli_query($mysqli, $sqlCategory);
			while ($row_cat=mysqli_fetch_assoc($res_cat)){
				if($row_cat['category_image']!="")
				{
					unlink('images/'.$row_cat['category_image']);
				}

		}

    	$reg_query = "DELETE FROM tbl_category WHERE cid='$del_id' ";

    	$reg_query_run = mysqli_query($mysqli, $reg_query);
    }

    //add new category
    if (isset($_POST['save_data'])) 
    {

    	for ($i=0; $i < count($_FILES['cimage']['name']); $i++) { 
    		# code...
    	
    	$cname = $_POST['cname'];
    	$cimage = $_FILES['cimage']['name'][$i];


    	$query = "INSERT INTO tbl_category (category_name,category_image) VALUES ('$cname','$cimage')";
    	$query_run = mysqli_query($mysqli, $query);



    	if ($query_run) 
    	{
    		foreach ($_FILES['cimage']['name'] as $key => $val) {
    			# code...
    			move_uploaded_file($_FILES["cimage"]["tmp_name"][$key], "images/".$val);
    		}

    		
    		//move_uploaded_file($_FILES["cimage"]["tmp_name"], "images/".$_FILES["cimage"]["name"]);
    		$_SESSION['status'] = "Successfull saved category !";
    		header('Location: manage_category.php');

    	}else
    	{
    		$_SESSION['status'] = "Somting Went Wrong !";
    		header('Location: manage_category.php');
    	}
    	}

    }

    //update category
    if (isset($_POST['category_update_btn'])) {
    	# code...
    	$edit_id = $_POST['edit_id'];
    	$cname = $_POST['cname'];
    	$cimage = $_FILES['cimage']['name'];

        if($cimage!=""){
        	
        	$query = "UPDATE tbl_category SET category_name='$cname', category_image='$cimage' WHERE cid= '$edit_id' ";
        }else{
        	$query = "UPDATE tbl_category SET category_name='$cname' WHERE cid= '$edit_id' ";
        }
    	
    	$query_run = mysqli_query($mysqli, $query);

    	if ($query_run) {
    		move_uploaded_file($_FILES["cimage"]["tmp_name"], "images/".$_FILES["cimage"]["name"]);
    		$_SESSION['status'] = "Update category Successfully !";
    		header('Location: manage_category.php');
    	}else{

    		$_SESSION['status'] = "Somting Went Wrong !";
    		header('Location: manage_category.php');
    	}
    }

    //delete wallpaper
    if (isset($_POST['delete_wallpaper_btn'])) 
    {
    	# code...
    	$del_id = $_POST['delete_id'];

    	$sqlCategory="SELECT * FROM `tbl_recipe` WHERE `id` IN ($del_id)";
			$res_cat=mysqli_query($mysqli, $sqlCategory);
			while ($row_cat=mysqli_fetch_assoc($res_cat)){
				if($row_cat['recipe_image']!="")
				{
					unlink('images/'.$row_cat['recipe_image']);
				}

		}

    	$reg_query = "DELETE FROM tbl_recipe WHERE id='$del_id' ";

    	$reg_query_run = mysqli_query($mysqli, $reg_query);
    }



    //update Ads setting
    if (isset($_POST['ads_update_btn'])) {
    	# code...
    	
    	$edit_id = $_POST['edit_id'];
    	$ads_status = $_POST['ads_status'];
    	$ads_type = $_POST['ads_type'];
    	$admob_banner_id = $_POST['admob_banner_id'];
    	$admob_inter_id = $_POST['admob_inter_id'];
    	$facebook_banner_id = $_POST['facebook_banner_id'];
    	$facebook_inter_id = $_POST['facebook_inter_id'];
        	
        $query = "UPDATE tbl_ads SET
        ads_status='$ads_status',
        ads_type='$ads_type',  
        admob_banner='$admob_banner_id', 
        admob_inter='$admob_inter_id', 
        facebook_banner='$facebook_banner_id', 
        facebook_inter='$facebook_inter_id'
        WHERE id= '$edit_id' ";

        //$query = "UPDATE tbl_ads SET admob_banner='$admob_banner_id', admob_inter='$admob_inter_id' WHERE id= '$edit_id' ";


    	$query_run = mysqli_query($mysqli, $query);

    	if ($query_run) {
    		//move_uploaded_file($_FILES["cimage"]["tmp_name"], "images/".$_FILES["cimage"]["name"]);
    		$_SESSION['status'] = "Update Successfully !";
    		header('Location: manage_ads.php');
    	}else{

    		$_SESSION['status'] = "Somting Went Wrong !";
    		header('Location: manage_ads.php');
    	}
    }

    //update setting
    if (isset($_POST['setting_update_btn'])) {
        # code...
        
        $edit_id = $_POST['edit_id'];
        $app_name = $_POST['app_name'];
        $app_logo = $_POST['app_logo'];
        $onesignal_app_id = $_POST['onesignal_app_id'];
        $onesignal_rest_key = $_POST['onesignal_rest_key'];
        $category_order = $_POST['category_order'];
        $category_sort = $_POST['category_sort'];
        $app_privacy_policy = $_POST['app_privacy_policy'];
            
        $query = "UPDATE tbl_settings SET
        app_name='$app_name',
        app_logo='$app_logo',  
        onesignal_app_id='$onesignal_app_id', 
        onesignal_rest_key='$onesignal_rest_key', 
        category_order='$category_order', 
        category_sort='$category_sort', 
        app_privacy_policy='$app_privacy_policy'
        WHERE id= '$edit_id' ";

        //$query = "UPDATE tbl_ads SET admob_banner='$admob_banner_id', admob_inter='$admob_inter_id' WHERE id= '$edit_id' ";


        $query_run = mysqli_query($mysqli, $query);

        if ($query_run) {
            //move_uploaded_file($_FILES["cimage"]["tmp_name"], "images/".$_FILES["cimage"]["name"]);
            $_SESSION['status'] = "Update Successfully !";
            header('Location: manage_setting.php');
        }else{

            $_SESSION['status'] = "Somting Went Wrong !";
            header('Location: manage_setting.php');
        }
    }


    //add new recipe
    if (isset($_POST['save_recipe'])) 
    {

    	$recipe_name = $_POST['recipe_name'];
    	$recipe_description = $_POST['recipe_description'];
    	$recipe_person = $_POST['recipe_person'];
    	$recipe_time = $_POST['recipe_time'];
    	$recipe_type = $_POST['recipe_type'];
        $recipe_category = $_POST['recipe_category'];
    	$recipe_video = $_POST['recipe_video'];
    	$recipe_image = $_FILES['recipe_image']['name'];



    	$query = "INSERT INTO tbl_recipe (
        recipe_name,
        recipe_video,
        recipe_description,
        recipe_person,
        recipe_time,
        recipe_image,
        recipe_type,
        cat_id
    ) VALUES (
    '$recipe_name',
    '$recipe_video',
    '$recipe_description',
    '$recipe_person',
    '$recipe_time',
    '$recipe_image',
    '$recipe_type',
    '$recipe_category')";


    	 $query_run = mysqli_query($mysqli, $query);

        //echo $query;



    	if ($query_run) 
    	{

    		move_uploaded_file($_FILES["recipe_image"]["tmp_name"], "images/".$_FILES["recipe_image"]["name"]);
    		$_SESSION['status'] = "Successfull saved Recipe data !";
    		header('Location: manage_wallpaper.php');

    	}else
    	{
    		$_SESSION['status'] = "Somting Went Wrong !";
    		header('Location: manage_wallpaper.php');
    	
    	}

    }

    
    //update recipe
    if (isset($_POST['recipe_update_btn'])) {
    	# code...
    	
    	$edit_id = $_POST['edit_id']; 
        $recipe_name = $_POST['recipe_name'];
    	$recipe_description = $_POST['recipe_description'];
    	$recipe_person = $_POST['recipe_person'];
    	$recipe_time = $_POST['recipe_time'];
    	$recipe_type = $_POST['recipe_type'];
        $recipe_category = $_POST['recipe_category'];
    	$recipe_video = $_POST['recipe_video'];
    	$recipe_image = $_FILES['recipe_image']['name'];

        if($recipe_image!=""){
            
        $query = "UPDATE tbl_recipe SET
        recipe_name='$recipe_name',
        recipe_description='$recipe_description', 
        recipe_person='$recipe_person', 
        recipe_time='$recipe_time', 
        recipe_type='$recipe_type', 
        cat_id='$recipe_category',
        recipe_video='$recipe_video',
        recipe_image = '$recipe_image'
        WHERE id= '$edit_id' ";

        }else{

        $query = "UPDATE tbl_recipe SET
        recipe_name='$recipe_name',
        recipe_description='$recipe_description', 
        recipe_person='$recipe_person', 
        recipe_time='$recipe_time', 
        recipe_type='$recipe_type', 
        cat_id='$recipe_category',
        recipe_video='$recipe_video'
        WHERE id= '$edit_id' ";
        }

    	$query_run = mysqli_query($mysqli, $query);

        echo $query_run;

    	if ($query_run) {
    		move_uploaded_file($_FILES["recipe_image"]["tmp_name"], "images/".$_FILES["recipe_image"]["name"]);
    		$_SESSION['status'] = "Update category Successfully !";
    		header('Location: manage_wallpaper.php');
    	}else{

    		$_SESSION['status'] = "Somting Went Wrong !";
    		header('Location: manage_wallpaper.php');
    	}
    }

    //update featured recipe
    if (isset($_POST['add_featured_btn'])) {
        # code...
        
        $edit_id = $_POST['edit_id']; 
        


        $query = "UPDATE tbl_recipe SET
        recipe_featured='yes'
        WHERE id= '$edit_id' ";

        $query_run = mysqli_query($mysqli, $query);

        echo $query_run;

        if ($query_run) {
            $_SESSION['status'] = "Add to featured Successfully !";
            header('Location: manage_wallpaper.php');
        }else{

            $_SESSION['status'] = "Somting Went Wrong !";
            header('Location: manage_wallpaper.php');
        }
    }

    //update featured recipe
    if (isset($_POST['remove_featured_btn'])) {
        # code...
        
        $edit_id = $_POST['edit_id']; 

        $query = "UPDATE tbl_recipe SET
        recipe_featured='no'
        WHERE id= '$edit_id' ";

        $query_run = mysqli_query($mysqli, $query);

        echo $query_run;

        if ($query_run) {
            $_SESSION['status'] = "Remove from featured Successfully !";
            header('Location: manage_wallpaper.php');
        }else{

            $_SESSION['status'] = "Somting Went Wrong !";
            header('Location: manage_wallpaper.php');
        }
    }

    //update admin profile
    if (isset($_POST['profile_update_btn'])) {
        # code...
        
        $edit_id = $_POST['edit_id'];
        $username = $_POST['username']; 
        $password = $_POST['password']; 
        $email = $_POST['email']; 

        $query = "UPDATE tbl_admin SET
        username='$username',
        password='$password',
        email='$email'
        WHERE id= '$edit_id' ";

        $query_run = mysqli_query($mysqli, $query);

        echo $query_run;

        if ($query_run) {
            $_SESSION['status'] = "Update Successfully !";
            header('Location: profile.php');
        }else{

            $_SESSION['status'] = "Somting Went Wrong !";
            header('Location: profile.php');
        }
    }



?>