<?php

//------------------ Value to connect server ------------------------
$databaseServer = "ahealth.camdtseexuim.ap-southeast-1.rds.amazonaws.com";
$databaseUsername = "ahealth";
$databasePassword = "jarbill";
$databaseName = "test";


//------------------------- Type of user ------------------------------------
$userType;


//------------------ function for connect and check user on database --------------------------
function checkUser($username, $password){
    $conn = mysqli_connect($GLOBALS['databaseServer'],$GLOBALS['databaseUsername'],$GLOBALS['databasePassword'],$GLOBALS['databaseName']);

    if(mysqli_connect_errno()){
        die("<h1>Page Error : Cannot connect to server</h1>");
    }

    mysqli_set_charset($conn,'utf8');

    $username = mysqli_real_escape_string($conn,$username);
    $password = mysqli_real_escape_string($conn,$password);

    $query = "SELECT * FROM nurse_login WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    $dbusername = "";
    $dbpassword = "";


    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $dbusername = $row['username'];
        $dbpassword = $row['password'];
        $GLOBALS['userType'] = "nurse";
    }else{
        $query = "SELECT * FROM admin_login WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            $GLOBALS['userType'] = "admin";
        }
    }

    mysqli_close($conn);

    if($username == $dbusername && $password == $dbpassword) return true;
    return false;
}



function getPatientData($firstname, $lastname, $hn){
    $conn = mysqli_connect($GLOBALS['databaseServer'], $GLOBALS['databaseUsername'], $GLOBALS['databasePassword'], $GLOBALS['databaseName']);

    if(!$conn){
        die("<h1>Page Error : Cannot connect to server</h1>");
    }

    mysqli_set_charset($conn, "utf8");

    $hn = mysqli_real_escape_string($conn,$hn);

    $data = array();

    if(isset($hn) && $hn !== ""){
        $query = "SELECT thaiFirstName, thaiLastName, englishFirstName, englishLastName FROM user, patient WHERE patient.HN = '$hn' AND patient.username = user.username";
    }else if(isset($firstname) && isset($lastname) && $firstname !== "" && $lastname !== ""){
        $query = "SELECT thaiFirstName, thaiLastName, englishFirstName, englishLastName, HN FROM user, patient WHERE ((user.thaiFirstName = '$firstname'
                  AND user.thaiLastName = '$lastname') OR (englishFirstName = '$firstname' AND englishLastName = '$lastname')) AND user.username = patient.username";
    }else{
        return "unknown";
    }

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $num_fields = mysqli_num_fields($result);
        while($row = mysqli_fetch_array($result)){
            for($i = 0; $i < $num_fields; $i++){
                $data[mysqli_fetch_field_direct($result, $i)->name] = $row[$i];
            }
        }
    }else if(mysqli_num_rows($result) == 0){
        mysqli_close($conn);
        return "unknown";
    }

    if(isset($hn) && $hn !== ""){
        $query = "SELECT * FROM InspectionResult WHERE HN = '$hn' ORDER BY Date DESC, Time DESC";
    }else if(isset($firstname) && isset($lastname) && $firstname !== "" && $lastname !== ""){
        $query = "SELECT * FROM InspectionResult WHERE HN = (SELECT HN FROM patient WHERE username = (SELECT username FROM user WHERE (user.thaiFirstName = '$firstname' AND user.thaiLastName = '$lastname') OR
                  (user.englishFirstName = '$firstname' AND user.englishLastName = '$lastname'))) ORDER BY Date DESC, Time DESC";
    }

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $num_fields = mysqli_num_fields($result);
        $row = mysqli_fetch_array($result);
        for($i = 0; $i < $num_fields; $i++){
            $data[mysqli_fetch_field_direct($result, $i)->name] = $row[$i];
        }
    }

    mysqli_close($conn);
    return $data;
}



function savePatientData($data){
    $conn = mysqli_connect($GLOBALS['databaseServer'], $GLOBALS['databaseUsername'], $GLOBALS['databasePassword'], $GLOBALS['databaseName']);

    if(!$conn){
        die("<h1>Page Error : Cannot connect to server</h1>");
    }

    mysqli_set_charset($conn, "utf8");

    parse_str($data, $obj);

    if(count($obj) > 0){
        $query = "SELECT * FROM patient WHERE HN = '{$obj['HN']}'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) == 0){
            mysqli_close($conn);
            if(isset($obj['patientFirstName']) && isset($obj['patientLastName']) && $obj['patientFirstName'] !== "" && $obj['patientLastName'] !== "")
                return "defined";
            else
                return "unknown";
        }

        $column = "";
        $val = "";
        date_default_timezone_set("Asia/Bangkok");

        foreach($obj as $key => $value){
            if($key == "patientFirstName" || $key == "patientLastName" || $key == "Other") continue;
            if(fnmatch("date*",$key)) $value = date("Y-m-d",strtotime(str_replace("/","-",$value)));
            if($key == "Date"){
                $column .= "$key,";
                $val .= "'".date("Y-m-d")."',";
            }else if($key == "Time"){
                $column .= "$key";
                $val .= "'".date("H:i:s")."'";
            }else{
                $column .= "$key,";
                $val .= "'$value',";
            }
        }

        $query = "INSERT INTO InspectionResult($column) VALUES ($val)";
        mysqli_query($conn,$query);
    }

    mysqli_close($conn);
    return "success";
}

























//--------------------------------------   ยังมีปัญหาอยู่ว่าจะทำดีไหม  ----------------------------------------------


//---------------------------- Create form component from typeComponent -----------------------------
function checkTypeComponent($typeComponent, $qname_question){
    switch($typeComponent){
        case "Header":
?>
            <label class="label-subheader">
                <?php echo $qname_question; ?>
            </label>
            <br>
<?php
            break;
        case "MultipleChoice": break;
        case "OpenAnswer": break;
        case "Mutiple+Open": break;
        case "Mutiple_Answer": break;
        case "Yes_No_Question":
?>
            <label class="checkbox-style label-body">
                <input type="checkbox"> <?php echo $qname_question; ?>
            </label>
<?php
            break;
    }
}


//------------------------------ Generate dynamic form ----------------------------------------
function generateNurseForm(){
    $conn = mysqli_connect($GLOBALS['databaseServer'],$GLOBALS['databaseUsername'],$GLOBALS['databasePassword'],$GLOBALS['databaseName']);

    if(!$conn){
        die("<h1>Page Error : Cannot connect to server</h1>");
    }

    mysqli_set_charset($conn,'utf8');

    $query = "SELECT QID, QName, QTName FROM Question, QuestionType WHERE Question.QTID = QuestionType.QTID AND Question.QHeader IS NULL";

    $head = mysqli_query($conn, $query);

    if(mysqli_num_rows($head) > 0){
        while($row = mysqli_fetch_assoc($head)){

            $qid = $row['QID'];
            $qname = $row['QName'];
            $qtname = $row['QTName'];

?>
            <div class="form-group">
                <label class="col-md-12 margin-bottom-zero label-header"><?php echo $qname ?></label>
            </div>
<?php
            $query = "SELECT QID, QName, QTName FROM Question, QuestionType WHERE Question.QTID = QuestionType.QTID AND Question.QHeader = '$qid'";

            $question = mysqli_query($conn, $query);

            if(mysqli_num_rows($question) > 0){
                while($row_question = mysqli_fetch_assoc($question)){

                    $qid_question = $row_question['QID'];
                    $qname_question = $row_question['QName'];
                    $qtname_question = $row_question['QTName'];
//                    $input_question = $row_question['Input'];

                    checkTypeComponent($qtname_question, $qname_question);

//                    echo "'$qid_question' '$qname_question' '$qtname_question' '$input_question'<br>";
                }
            }


        }
    }

    mysqli_close($conn);
}

?>

