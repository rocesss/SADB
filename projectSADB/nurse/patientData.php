<?php

    include("../connection/dbManager.php");

    if(isset($_GET['q']) && $_GET['q'] == "search"){
        header("Location: http://localhost/PhpStormWorkspace/projectSADB/nurse/nurseForm.php?q=search&fn="
            .urlencode(trim($_POST['patientFirstName']))."&ln=".urlencode(trim($_POST['patientLastName']))."&hn=".urlencode(trim($_POST['HN'])));
    }else{
        $data = file_get_contents("php://input");
        $state = savePatientData($data);
        echo json_encode($state);
    }
?>