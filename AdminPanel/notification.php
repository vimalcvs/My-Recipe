
<?php include("includes/header.php");

if($_SESSION['TYPE_USERNAME']==1){
        ?>
        <script type="text/javascript">
    
            // Written using ES5 JS for browser support
            window.addEventListener('DOMContentLoaded', function () {
                // Form elements
                    var title = 'Notification';
                    var message = 'In Mode Preview some process doesnt execute!';
                    var position = 'nfc-bottom-left';
                    var duration = '5000';
                    var theme = 'error';
                    var closeOnClick = false;
                    var displayClose = true;
            
                    if(!message) {
                        message = 'You did not enter a message...';
                    }
            
                    window.createNotification({
                        closeOnClick: closeOnClick,
                        displayCloseButton: displayClose,
                        positionClass: position,
                        showDuration: duration,
                        theme: theme
                    })({
                        title: title,
                        message: message
                    });
            });

        </script>
        <?php
    }    

  //'filters' => array(array('Area' => '=', 'value' => 'ALL')),
 
  
  if(isset($_POST['submit']) and $_SESSION['TYPE_USERNAME']!=2)
  {
    if($_FILES['big_picture']['name']!="")
    {   

        $big_picture=rand(0,99999)."_".$_FILES['big_picture']['name'];
        $tpath2='images/'.$big_picture;
        move_uploaded_file($_FILES["big_picture"]["tmp_name"], $tpath2);

        $file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/images/'.$big_picture;
          
        $content = array(
                         "en" => $_POST['notification_msg']   
                         );

        $fields = array(
                        'app_id' => ONESIGNAL_APP_ID,
                        'included_segments' => array('All'),                                            
                        'data' => array("foo" => "bar" , "launchURL" => $_POST['url']    ),
                        'contents' => $content,
                        'big_picture' =>$file_path                    
                        );
             
             
         $date = date("M-d-Y h:i:s");      
         $msg=$_POST['notification_msg'];          
         $image= $file_path;     
          $url=$_POST['url'];         
        
        $data = array(
            'date'=>$date,  
            'msg'  =>  $msg,
            'image'  =>  $image,
            'url'  =>  $url
            );

            $qry = Insert('tbl_notification',$data);
                        

        
        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.ONESIGNAL_REST_KEY));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        
    }
    else
    {

         $content = array(
                         "en" => $_POST['notification_msg']    
                         );

        $fields = array(
                        'app_id' => ONESIGNAL_APP_ID,
                        'included_segments' => array('All'),                                      
                        'data' => array("foo" => "bar","launchURL" => $_POST['url']  ),
                        'contents' => $content
                        );
                        
                        
                          $date = date("M,d,Y h:i:s A");      
         $msg=$_POST['notification_msg'];          
          $url=$_POST['url'];         
        
        
        $data = array(
            'date'=>$date,  
            'msg'  =>  $msg,
            'url'  =>  $url
            );

            $qry = Insert('tbl_notification',$data);

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.ONESIGNAL_REST_KEY));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);


    }
        
        $_SESSION['status']="Send Successfully";
     
        header( "Location:notification.php?add");
        exit; 
     
     
  }
  
   

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


                                        <form name="addeditcategory" method="post" enctype="multipart/form-data">
                                        <input class="form-control" type="hidden" name="edit_id" value="<?php echo $row['id']?>">
                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Message :- </label>
                                        <div class="col-md-10">
                                           <textarea name="notification_msg" id="notification_msg" class="form-control" required></textarea>
                                        </div>
                                        </div>
                                    </br>

                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Image :-<br/>(Optional)</label>
                                        <div class="col-md-10">
                                            <input type="file" class="form-control" name="big_picture" value="" id="fileupload">
                                        </div>
                                        </div>

                                        <input class="form-control" type="hidden" name="edit_id" value="<?php echo $row['id']?>">
                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Url :</label>
                                        <div class="col-md-10">
                                            <input type="text" name="url" id="url" url="form-control" class="form-control"  ></textarea>
                                        </div>
                                        </div>

                                    
                                        <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label"></label>
                                        <div class="col-md-10">
                                            <button type="submit" name="ads_update_btn" class="btn btn-primary">Submit</button>
                                        </div>
                                        </div>
                                        
                                        </form>
                                        
                                    
                                </div>
                            </div>
                        </div>
            </main>
<?php
include("includes/footer.php");
?>
