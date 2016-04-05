<?php

    include("../connection/dbManager.php");

    $data = file_get_contents("php://input");
//    parse_str($data);

    echo json_encode(savePatientData($data));

//    echo $treatment

?>