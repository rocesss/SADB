<?php

    include("../connection/dbManager.php");

    $data = file_get_contents("php://input");
    $state = savePatientData($data);
    echo json_encode($state);
?>