<?php
    // Show PHP errors
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);

    require_once 'privateCrud.php';

    $objUser = new Collection();
    $msg = "";
    $like_qty = "0";
    $view_qty = "0";
    $member_id = "1";
    
    $ingred = $_POST["ingred"];
    $unit = $_POST["unit"];
    $ingred=implode("\n", $ingred);
    $unit=implode("\n", $unit);
    
if(isset($_POST['btn_save'])){
    //strip_tags()->消除 PHP 或 HTML 標籤符號
    $name   = strip_tags($_POST['name']);
    $intro  = strip_tags($_POST['intro']);
    $qty  = strip_tags($_POST['qty']);
    $step  = strip_tags($_POST['step']);
    $valid = strip_tags($_POST['btn_save']);
    $create_date = date('Y-m-d');
    $picture = $_FILES["picture"]["name"];
    
    $target = "../images/private/".$_FILES['picture']['name'];
    if($_FILES['picture']['error'] == 0){
        if(move_uploaded_file($_FILES['picture']['tmp_name'], $target)){
          echo "Upload success!<br>";
        } else {
          echo "Upload fail!<br>";
        }
    }

    try{
        if($objUser->insert($picture, $name, $intro, $qty, $ingred, $unit, $step, $view_qty, $like_qty, $create_date, $member_id, $valid)){
        $objUser->redirect('private_list.php?inserted');
        // echo "success";
        }else{
        $objUser->redirect('private_list.php?error');
        }
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

if(!isset($_POST["picture"])){
    $target="../images/private/".basename($_FILES["picture"]["name"]);

    if(move_uploaded_file($_FILES["picture"]["tmp_name"], $target)){
        $msg = "Image uploaded successfully";
        echo $msg;
    }else{
        $msg = "there was a problem uploading image";
    }
}
?>
