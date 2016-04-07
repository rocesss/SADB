<?php
// ยังไม่ได้ทำการ encrypt ข้อมูลเพื่อค้น database
    session_start();

    include("../connection/dbManager.php");

//------------------ Client username and password --------------------
    $username;
    $password;

    if(isset($_POST['username'], $_POST['password'])){
        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);
    }else{
        header('Location: http://localhost/PhpStormWorkspace/projectSADB/login/login.php?login_attempt=1');
    }

    if(checkUser($username, $password)){
        $_SESSION['username'] = $username;
        $_SESSION['userType'] = $userType;

        if($userType == "nurse"){
            header('Location: http://localhost/PhpStormWorkspace/projectSADB/nurse/nurseForm.php');
        }else if($userType == "admin"){
            //---------------------- ต้องเอาออก ใส่มาเป็น dummy เรื่อง type เฉยๆ -------------------------

            header('Location: http://localhost/PhpStormWorkspace/projectSADB/login/login.php?type=admin');
        }else{
            header('Location: http://localhost/PhpStormWorkspace/projectSADB/login/login.php');
        }
    }else{
        header('Location: http://localhost/PhpStormWorkspace/projectSADB/login/login.php?login_attempt=1');
    }

?>



