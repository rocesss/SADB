<?php

    include("../connection/dbManager.php");

    $data = file_get_contents("php://input");
    savePatientData($data);
?>