<?php

	function getCategory() {

		include_once "../includes/connection.php";

		$setting_qry = "SELECT * FROM tbl_settings where id = '1'";
		$result = mysqli_query($mysqli, $setting_qry);
		$row    = mysqli_fetch_assoc($result);
		$sort   = $row['category_order'];
		$order  = $row['category_sort'];

		$json_object = array();
		
		$query = "SELECT cid, category_name, category_image FROM tbl_category ORDER BY cid";
		$sql = mysqli_query($mysqli, $query);

		while ($data = mysqli_fetch_assoc($sql)) {
						
			$query = "SELECT COUNT(*) as num FROM tbl_recipe WHERE cat_id = '".$data['cid']."'";
			$total = mysqli_fetch_array(mysqli_query($mysqli, $query));
			$total = $total['num'];	

			$object['category_id'] = $data['cid'];
			$object['category_name'] = $data['category_name'];
			$object['category_image'] = $data['category_image'];
			$object['total_wallpaper'] = $total;
						 
			array_push($json_object, $object);
					
		}

		$set = $json_object;
					
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val = str_replace('\\/', '/', json_encode($set, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();

	}

	function getCategoryDetail($id, $offset) {

		include_once "../includes/connection.php";

		$qry = "SELECT * FROM tbl_settings where id = '1'";
		$result = mysqli_query($mysqli, $qry);
		$settings_row = mysqli_fetch_assoc($result);
		$load_more = $settings_row['limit_recent_wallpaper'];

		$id = $_GET['id'];
		$offset = isset($_GET['offset']) && $_GET['offset'] != '' ? $_GET['offset'] : 0;


		$all = mysqli_query($mysqli, "SELECT * FROM tbl_recipe ORDER BY id DESC");
		$count_all = mysqli_num_rows($all);
		$query = mysqli_query($mysqli, "SELECT w.id, w.recipe_name, w.recipe_image, w.recipe_video, w.recipe_type, w.recipe_time, w.recipe_person, w.recipe_views, w.recipe_details, w.recipe_ingredients, w.recipe_description,  w.recipe_featured, c.cid AS 'category_id', c.category_name FROM tbl_category c, tbl_recipe w WHERE c.cid = w.cat_id AND c.cid = $id ORDER BY w.id DESC LIMIT $offset, $load_more");
		$count = mysqli_num_rows($query);
		$json_empty = 0;
		if ($count < $load_more) {
			if ($count == 0) {
				$json_empty = 1;
			} else {
				$query = mysqli_query($mysqli, "SELECT w.id, w.recipe_name, w.recipe_image, w.recipe_video, w.recipe_type, w.recipe_time, w.recipe_person, w.recipe_views, w.recipe_details, w.recipe_ingredients, w.recipe_description,  w.recipe_featured, c.cid AS 'category_id', c.category_name FROM tbl_category c, tbl_recipe w WHERE c.cid = w.cat_id AND c.cid = $id ORDER BY w.id DESC LIMIT $offset, $count");
				$count = mysqli_num_rows($query);
				if (empty($count)) {
					$query = mysqli_query($mysqli, "SELECT w.id, w.recipe_name, w.recipe_image, w.recipe_video, w.recipe_type, w.recipe_time, w.recipe_person, w.recipe_views, w.recipe_details, w.recipe_ingredients, w.recipe_description,  w.recipe_featured, c.cid AS 'category_id', c.category_name FROM tbl_category c, tbl_recipe w WHERE c.cid = w.cat_id AND c.cid = $id ORDER BY w.id DESC LIMIT 0, $load_more");
					$num = 0;
				} else {
					$num = $offset;
				}
			}
		} else {
			$num = $offset;
		}
		$json = '[';
		while ($row = mysqli_fetch_array($query)) {
			$num++;
			$char ='"';
			$json .= '{
				"no": '.$num.',
				"RecipeId": "'.$row['id'].'", 
				"RecipeName": "'.$row['recipe_name'].'",
				"RecipeImage": "'.$row['recipe_image'].'",
				"RecipeVideo": "'.$row['recipe_video'].'",
				"RecipeType": "'.$row['recipe_type'].'",
				"RecipeTime": "'.$row['recipe_time'].'",
				"RecipePerson": "'.$row['recipe_person'].'",
				"RecipeViews": "'.$row['recipe_views'].'",
				"RecipeDetails": "'.$row['recipe_details'].'",
				"RecipeIngredients": "'.$row['recipe_ingredients'].'",
				"RecipeDescription": "'.$row['recipe_description'].'",
				"RecipeFeatured": "'.$row['recipe_featured'].'",
				"category_id": "'.$row['category_id'].'",
				"category_name": "'.$row['category_name'].'"
			},';
		}

		$json = substr($json,0, strlen($json)-1);

		if ($json_empty == 1) {
			$json = '[]';
		} else {
			$json .= ']';
		}

		header('Content-Type: application/json; charset=utf-8');
		echo $json;

		mysqli_close($mysqli);

	}	

	function getRecent($offset) {

		include_once "../includes/connection.php";

		$qry = "SELECT * FROM tbl_settings where id = '1'";
		$result = mysqli_query($mysqli, $qry);
		$settings_row = mysqli_fetch_assoc($result);
		$load_more = $settings_row['limit_recent_wallpaper'];

		$offset = isset($_GET['offset']) && $_GET['offset'] != '' ? $_GET['offset'] : 0;
		$all = mysqli_query($mysqli, "SELECT * FROM tbl_recipe ORDER BY id DESC");
		$count_all = mysqli_num_rows($all);
		$query = mysqli_query($mysqli, "SELECT w.id, w.recipe_name, w.recipe_image, w.recipe_video, w.recipe_type, w.recipe_time, w.recipe_person, w.recipe_views, w.recipe_details, w.recipe_ingredients, w.recipe_description,  w.recipe_featured, c.cid AS 'category_id', c.category_name FROM tbl_category c, tbl_recipe w WHERE c.cid = w.cat_id ORDER BY w.id DESC LIMIT $offset, $load_more");
		$count = mysqli_num_rows($query);
		$json_empty = 0;
		if ($count < $load_more) {
			if ($count == 0) {
				$json_empty = 1;
			} else {
				$query = mysqli_query($mysqli, "SELECT w.id, w.recipe_name, w.recipe_image, w.recipe_video, w.recipe_type, w.recipe_time, w.recipe_person, w.recipe_views, w.recipe_details, w.recipe_ingredients, w.recipe_description,  w.recipe_featured, c.cid AS 'category_id', c.category_name FROM tbl_category c, tbl_recipe w WHERE c.cid = w.cat_id ORDER BY w.id DESC LIMIT $offset, $count");
				$count = mysqli_num_rows($query);
				if (empty($count)) {
					$query = mysqli_query($mysqli, "SELECT w.id, w.recipe_name, w.recipe_image, w.recipe_video, w.recipe_type, w.recipe_time, w.recipe_person, w.recipe_views, w.recipe_details, w.recipe_ingredients, w.recipe_description, w.recipe_featured, c.cid AS 'category_id', c.category_name FROM tbl_category c, tbl_recipe w WHERE c.cid = w.cat_id ORDER BY w.id DESC LIMIT 0, $load_more");
					$num = 0;
				} else {
					$num = $offset;
				}
			}
		} else {
			$num = $offset;
		}
		$json = '[';
		while ($row = mysqli_fetch_array($query)) {
			$num++;
			$char ='"';
			$json .= '{
				"no": '.$num.',
				"RecipeId": "'.$row['id'].'", 
				"RecipeName": "'.$row['recipe_name'].'",
				"RecipeImage": "'.$row['recipe_image'].'",
				"RecipeVideo": "'.$row['recipe_video'].'",
				"RecipeType": "'.$row['recipe_type'].'",
				"RecipeTime": "'.$row['recipe_time'].'",
				"RecipePerson": "'.$row['recipe_person'].'",
				"RecipeViews": "'.$row['recipe_views'].'",
				"RecipeDetails": "'.$row['recipe_details'].'",
				"RecipeIngredients": "'.$row['recipe_ingredients'].'",
				"RecipeDescription": "'.$row['recipe_description'].'",
				"RecipeFeatured": "'.$row['recipe_featured'].'",
				"category_id": "'.$row['category_id'].'",
				"category_name": "'.$row['category_name'].'"
			},';
		}

		$json = substr($json,0, strlen($json)-1);

		if ($json_empty == 1) {
			$json = '[]';
		} else {
			$json .= ']';
		}

		header('Content-Type: application/json; charset=utf-8');
		echo $json;

		mysqli_close($mysqli);

	}


	function getFeatured($offset) {

		include_once "../includes/connection.php";

		$qry = "SELECT * FROM tbl_settings where id = '1'";
		$result = mysqli_query($mysqli, $qry);
		$settings_row = mysqli_fetch_assoc($result);
		$load_more = $settings_row['limit_recent_wallpaper'];

		$offset = isset($_GET['offset']) && $_GET['offset'] != '' ? $_GET['offset'] : 0;
		$all = mysqli_query($mysqli, "SELECT * FROM tbl_recipe ORDER BY id DESC");
		$count_all = mysqli_num_rows($all);
		$query = mysqli_query($mysqli, "SELECT w.id, w.recipe_name, w.recipe_image, w.recipe_video, w.recipe_type, w.recipe_time, w.recipe_person, w.recipe_views, w.recipe_details, w.recipe_ingredients, w.recipe_description,  w.recipe_featured, c.cid AS 'category_id', c.category_name FROM tbl_category c, tbl_recipe w WHERE c.cid = w.cat_id AND w.recipe_featured = 'yes' ORDER BY w.id DESC LIMIT $offset, $load_more");
		$count = mysqli_num_rows($query);
		$json_empty = 0;
		if ($count < $load_more) {
			if ($count == 0) {
				$json_empty = 1;
			} else {
				$query = mysqli_query($mysqli, "SELECT w.id, w.recipe_name, w.recipe_image, w.recipe_video, w.recipe_type, w.recipe_time, w.recipe_person, w.recipe_views, w.recipe_details, w.recipe_ingredients, w.recipe_description,  w.recipe_featured, c.cid AS 'category_id', c.category_name FROM tbl_category c, tbl_recipe w WHERE c.cid = w.cat_id AND w.recipe_featured = 'yes' ORDER BY w.id LIMIT $offset, $count");
				$count = mysqli_num_rows($query);
				if (empty($count)) {
					$query = mysqli_query($mysqli, "SELECT w.id, w.recipe_name, w.recipe_image, w.recipe_video, w.recipe_type, w.recipe_time, w.recipe_person, w.recipe_views, w.recipe_details, w.recipe_ingredients, w.recipe_description,  w.recipe_featured, c.cid AS 'category_id', c.category_name FROM tbl_category c, tbl_recipe w WHERE c.cid = w.cat_id AND w.recipe_featured = 'yes' ORDER BY w.id LIMIT 0, $load_more");
					$num = 0;
				} else {
					$num = $offset;
				}
			}
		} else {
			$num = $offset;
		}
		$json = '[';
		while ($row = mysqli_fetch_array($query)) {
			$num++;
			$char ='"';
			$json .= '{
				"no": '.$num.',
				"RecipeId": "'.$row['id'].'", 
				"RecipeName": "'.$row['recipe_name'].'",
				"RecipeImage": "'.$row['recipe_image'].'",
				"RecipeVideo": "'.$row['recipe_video'].'",
				"RecipeType": "'.$row['recipe_type'].'",
				"RecipeTime": "'.$row['recipe_time'].'",
				"RecipePerson": "'.$row['recipe_person'].'",
				"RecipeViews": "'.$row['recipe_views'].'",
				"RecipeDetails": "'.$row['recipe_details'].'",
				"RecipeIngredients": "'.$row['recipe_ingredients'].'",
				"RecipeDescription": "'.$row['recipe_description'].'",
				"RecipeFeatured": "'.$row['recipe_featured'].'",
				"category_id": "'.$row['category_id'].'",
				"category_name": "'.$row['category_name'].'"
			},';
		}

		$json = substr($json,0, strlen($json)-1);

		if ($json_empty == 1) {
			$json = '[]';
		} else {
			$json .= ']';
		}

		header('Content-Type: application/json; charset=utf-8');
		echo $json;

		mysqli_close($mysqli);

	}

	function getSearch($search, $offset) {

		include_once "../includes/connection.php";

		$qry = "SELECT * FROM tbl_settings where id = '1'";
		$result = mysqli_query($mysqli, $qry);
		$settings_row = mysqli_fetch_assoc($result);
		$load_more = $settings_row['limit_recent_wallpaper'];

		$search = $_GET['search'];
		$offset = isset($_GET['offset']) && $_GET['offset'] != '' ? $_GET['offset'] : 0;


		$all = mysqli_query($mysqli, "SELECT * FROM tbl_recipe ORDER BY id DESC");
		$count_all = mysqli_num_rows($all);
		$query = mysqli_query($mysqli, "SELECT w.id, w.recipe_name, w.recipe_image, w.recipe_video, w.recipe_type, w.recipe_time, w.recipe_person, w.recipe_views, w.recipe_details, w.recipe_ingredients, w.recipe_description,  w.recipe_featured, c.cid AS 'category_id', c.category_name FROM tbl_category c, tbl_recipe w WHERE c.cid = w.cat_id AND (c.category_name LIKE '%$search%' OR w.recipe_name LIKE '%$search%') ORDER BY w.id DESC LIMIT $offset, $load_more");
		$count = mysqli_num_rows($query);
		$json_empty = 0;
		if ($count < $load_more) {
			if ($count == 0) {
				$json_empty = 1;
			} else {
				$query = mysqli_query($mysqli, "SELECT w.id, w.recipe_name, w.recipe_image, w.recipe_video, w.recipe_type, w.recipe_time, w.recipe_person, w.recipe_views, w.recipe_details, w.recipe_ingredients, w.recipe_description,  w.recipe_featured, c.cid AS 'category_id', c.category_name FROM tbl_category c, tbl_recipe w WHERE c.cid = w.cat_id AND (c.category_name LIKE '%$search%' OR w.recipe_name LIKE '%$search%') ORDER BY w.id DESC LIMIT $offset, $count");
				$count = mysqli_num_rows($query);
				if (empty($count)) {
					$query = mysqli_query($mysqli, "SELECT w.id, w.recipe_name, w.recipe_image, w.recipe_video, w.recipe_type, w.recipe_time, w.recipe_person, w.recipe_views, w.recipe_details, w.recipe_ingredients, w.recipe_description,  w.recipe_featured, c.cid AS 'category_id', c.category_name FROM tbl_category c, tbl_recipe w WHERE c.cid = w.cat_id AND (c.category_name LIKE '%$search%' OR w.recipe_name LIKE '%$search%') ORDER BY w.id DESC LIMIT 0, $load_more");
					$num = 0;
				} else {
					$num = $offset;
				}
			}
		} else {
			$num = $offset;
		}
		$json = '[';
		while ($row = mysqli_fetch_array($query)) {
			$num++;
			$char ='"';
			$json .= '{
					"no": '.$num.',
				"RecipeId": "'.$row['id'].'", 
				"RecipeName": "'.$row['recipe_name'].'",
				"RecipeImage": "'.$row['recipe_image'].'",
				"RecipeVideo": "'.$row['recipe_video'].'",
				"RecipeType": "'.$row['recipe_type'].'",
				"RecipeTime": "'.$row['recipe_time'].'",
				"RecipePerson": "'.$row['recipe_person'].'",
				"RecipeViews": "'.$row['recipe_views'].'",
				"RecipeDetails": "'.$row['recipe_details'].'",
				"RecipeIngredients": "'.$row['recipe_ingredients'].'",
				"RecipeDescription": "'.$row['recipe_description'].'",
				"RecipeFeatured": "'.$row['recipe_featured'].'",
				"category_id": "'.$row['category_id'].'",
				"category_name": "'.$row['category_name'].'"
			},';
		}

		$json = substr($json,0, strlen($json)-1);

		if ($json_empty == 1) {
			$json = '[]';
		} else {
			$json .= ']';
		}

		header('Content-Type: application/json; charset=utf-8');
		echo $json;

		mysqli_close($mysqli);

	}

	function viewCount($id) {

		$id = $_GET['id'];

		include_once "../includes/connection.php";

		$jsonObj = array();	

		$query = "SELECT * FROM tbl_recipe WHERE id = $id";
		$sql = mysqli_query($mysqli, $query) or die(mysqli_error());

		while ($data = mysqli_fetch_assoc($sql)) {
						 
			$row['id'] = $data['id'];
			$row['recipe_views'] = $data['recipe_views'];
			 
			array_push($jsonObj, $row);
					
		}

		$view_qry = mysqli_query($mysqli, " UPDATE tbl_recipe SET recipe_views = recipe_views + 1 WHERE id = $id ");

		$set['result'] = $jsonObj;
					
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val = str_replace('\\/', '/', json_encode($set, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();			

	}

	function getRecipeDetails($id) {

		$id = $_GET['id'];

		include_once "../includes/connection.php";

		$query = "SELECT * FROM tbl_recipe WHERE id = $id LIMIT 1";			
		$resouter = mysqli_query($mysqli, $query);

		$set = array();
	    $total_records = mysqli_num_rows($resouter);
	    if($total_records >= 1) {
	      	while ($link = mysqli_fetch_array($resouter, MYSQLI_ASSOC)){
	        $set = $link;
	      }
	    }

	    header('Content-Type: application/json; charset=utf-8');
	    echo $val = str_replace('\\/', '/', json_encode($set));	

	}
	
	function getAllData() {

		include_once "../includes/connection.php";

		$query = "SELECT * FROM tbl_ads LIMIT 1";			
		$resouter = mysqli_query($mysqli, $query);

		$set = array();
	    $total_records = mysqli_num_rows($resouter);
	    if($total_records >= 1) {
	      	while ($link = mysqli_fetch_array($resouter, MYSQLI_ASSOC)){
	        $set = $link;
	      }
	    }

	    header('Content-Type: application/json; charset=utf-8');
	    echo $val = str_replace('\\/', '/', json_encode($set));	

	}	



	function getPrivacyPolicy() {

		include_once "../includes/connection.php";

		$query = "SELECT privacy_policy FROM tbl_settings LIMIT 1";			
		$resouter = mysqli_query($mysqli, $query);

		$set = array();
	    $total_records = mysqli_num_rows($resouter);
	    if($total_records >= 1) {
	      	while ($link = mysqli_fetch_array($resouter, MYSQLI_ASSOC)){
	        $set = $link;
	      }
	    }

	    header('Content-Type: application/json; charset=utf-8');
	    echo $val = str_replace('\\/', '/', json_encode($set));	

	}	

?>