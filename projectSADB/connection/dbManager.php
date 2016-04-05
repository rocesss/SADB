<?php

//------------------ Value to connect server ------------------------
$databaseServer = "ahealth.camdtseexuim.ap-southeast-1.rds.amazonaws.com";
$databaseUsername = "ahealth";
$databasePassword = "jarbill";
$databaseName = "ahealth";


//------------------------- Type of user ------------------------------------
$userType;


//------------------ function for connect and check user on database --------------------------
function checkUser($username, $password){
    $conn = mysqli_connect($GLOBALS['databaseServer'],$GLOBALS['databaseUsername'],$GLOBALS['databasePassword'],$GLOBALS['databaseName']);

    if(!$conn){
        die("<h1>Page Error : Cannot connect to server</h1>");
    }

    mysqli_set_charset($conn,'utf8');

    $query = "SELECT * FROM userpass WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    mysqli_close($conn);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $dbusername = $row['username'];
        $dbpassword = $row['password'];
        $GLOBALS['userType'] = $row['type'];

        if($username == $dbusername && $password == $dbpassword) return true;
    }

    return false;
}


function getPatientData($firstname, $lastname, $hn){
    $conn = mysqli_connect($GLOBALS['databaseServer'], $GLOBALS['databaseUsername'], $GLOBALS['databasePassword'], $GLOBALS['databaseName']);

    if(!$conn){
        die("<h1>Page Error : Cannot connect to server</h1>");
    }

    mysqli_set_charset($conn, "utf8");

    $query = "SELECT * FROM dummyNurseForm WHERE patient_firstname = '$firstname' AND patient_lastname = '$lastname' AND hn = '$hn'";

    $result = mysqli_query($conn, $query);
    $data = array();

    mysqli_close($conn);

    if(mysqli_num_rows($result) > 0){
        $num_fields = mysqli_num_fields($result);
        while($row = mysqli_fetch_array($result)){
            for($i = 0; $i < $num_fields; $i++){
                $data[mysqli_fetch_field_direct($result, $i)->name] = $row[$i];
            }
        }
    }
    return $data;
}

function savePatientData($data){
    $conn = mysqli_connect($GLOBALS['databaseServer'], $GLOBALS['databaseUsername'], $GLOBALS['databasePassword'], $GLOBALS['databaseName']);

    if(!$conn){
        die("<h1>Page Error : Cannot connect to server</h1>");
    }

    mysqli_set_charset($conn, "utf8");

    parse_str($data,$test);

    return $test;

//    $query = "UPDATE dummyNurseForm SET(treatment='$treatment')";




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

