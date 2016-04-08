<?php
    session_start();

    include("../connection/dbManager.php");

    if(!$_SESSION['username'] || $_SESSION['userType'] !== "nurse"){
        header('Location: http://localhost/PhpStormWorkspace/projectSADB/login/login.php');
    }

    if(isset($_GET['q'])){
        if($_GET['q'] == "search" && $_POST){
            $firstName = $_POST['patientFirstName'];
            $lastName = $_POST['patientLastName'];
            $HN = $_POST['HN'];

            $data = getPatientData($firstName, $lastName, $HN);
        }
    }
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../../bootstrap/css/datepicker.css" type="text/css">
    <script src="../../jquery.min.js" type="text/javascript"></script>
    <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../bootstrap/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="../../jquery.toaster.js" type="text/javascript"></script>
    <script src="../login/utility.js" type="text/javascript"></script>
    <link rel="stylesheet" href="nurseFormCss.css" type="text/css">
    <title>ประวัติการตรวจพิเศษทางเดินอาหารของผู้ป่วย</title>
</head>

<body>
    <div class="container full-height">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12" id="head-name">
                <label>ประวัติการตรวจพิเศษทางเดินอาหารของผู้ป่วย</label>
            </div>
        </div>

        <form class="form-horizontal" id="form-header" method="post" action="nurseForm.php?q=search">
            <div class="form-group">
                <label class="col-md-4 margin-bottom-zero label-header">ชื่อผู้ป่วย<br><br><input class="form-control margin-top-zero" type="text" name="patientFirstName" required value="<?php if(isset($data['thaiFirstName'])) echo $data['thaiFirstName']; else if(isset($data['englishFirstName'])) echo $data['englishFirstName']; else echo ""; ?>" ></label>
                <label class="col-md-4 margin-bottom-zero label-header">นามสกุลผู้ป่วย<br><br><input class="form-control margin-top-zero" type="text" name="patientLastName" required value="<?php if(isset($data['thaiFirstName'])) echo $data['thaiLastName']; else if(isset($data['englishFirstName'])) echo $data['englishLastName']; else echo ""; ?>" ></label>
                <label class="col-md-3 margin-bottom-zero label-header">HN<br><br><input class="form-control margin-top-zero" type="text" name="HN" required value="<?php if(isset($data['HN'])) echo $data['HN']; else if(isset($data['thaiFirstName']) || isset($data['englishFirstName'])) echo $HN; else echo "";?>" ></label>
                <div class="col-md-1">
                    <br><br><button type="summit" class="form-control button-style margin-top-three" id="button-search"><span class="glyphicon glyphicon-search"></span></button>
                </div>
            </div>
        </form>
        <?php
            if(isset($data) && gettype($data) == "string"){
                if($data == "unknown"){
                ?>
                <script>$.toaster({priority: 'success', title: '', message: 'ผู้ป่วยไม่มีรายชื่อภายในระบบ'});</script>
            <?php
                }
            }else if(isset($data) && gettype($data) == "array" && count($data) <= 4){
            ?>
                 <script>$.toaster({priority: 'success', title: '', message: 'ผู้ป่วยไม่มีผลการตรวจภายในระบบ'});</script>
            <?php
            }
            ?>
        <br>

        <form class="form-horizontal" id="form-body" method="post" >

            <div class="form-group">
                <label class="col-md-12 margin-bottom-zero label-header">ข้อบ่งชี้</label><br><br>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 margin-top-bottom-three">
                            <label class="checkbox-inline"><input type="checkbox" class="indicator-check" name="Dysphagia" value="y" <?php if(isset($data['Dysphagia'])) echo "checked";?>> Dysphagia</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three">
                            <label class="checkbox-inline"><input type="checkbox" class="indicator-check" name="GERD" value="y" <?php if(isset($data['GERD'])) echo "checked";?>> GERD</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three">
                            <label class="checkbox-inline"><input type="checkbox" class="indicator-check" name="Non_cardiac_chest_pain" value="y" <?php if(isset($data['Non_cardiac_chest_pain'])) echo "checked";?>> Non-cardiac chest pain</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three">
                            <label class="checkbox-inline"><input type="checkbox" class="indicator-check" name="Chronic_ENT_problem" value="y" <?php if(isset($data['Chronic_ENT_problem'])) echo "checked";?>> Chronic ENT problem</label>
                        </div>

                        <div class="col-md-3 margin-top-bottom-three padding-top-seven">
                            <label class="checkbox-inline"><input type="checkbox" class="indicator-check" name="Globus" value="y" <?php if(isset($data['Globus'])) echo "checked";?>> Globus</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three padding-top-seven">
                            <label class="checkbox-inline"><input type="checkbox" class="indicator-check" name="Dyspepsia" value="y" <?php if(isset($data['Dyspepsia'])) echo "checked";?>> Dyspepsia</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three padding-top-seven">
                            <label class="checkbox-inline"><input type="checkbox" class="indicator-check" name="Bloating" value="y" <?php if(isset($data['Bloating'])) echo "checked";?>> Bloating</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three padding-top-seven">
                            <label class="checkbox-inline"><input type="checkbox" class="indicator-check" name="Belching" value="y" <?php if(isset($data['Belching'])) echo "checked";?>> Belching</label>
                        </div>

                        <div class="col-md-3 margin-top-bottom-three padding-top-seven">
                            <label class="checkbox-inline"><input type="checkbox" class="indicator-check" name="Constipation" value="y" <?php if(isset($data['Constipation'])) echo "checked";?>> Constipation</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three padding-top-seven">
                            <label class="checkbox-inline"><input type="checkbox" class="indicator-check" name="Incontinence" value="y" <?php if(isset($data['Incontinence'])) echo "checked";?>> Incontinence</label>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-1 destroy-padding-left margin-top-bottom-three padding-top-seven">
                                <label class="checkbox-inline control-label"><input type="checkbox" id="indicator" name="Other" value="y" <?php if(isset($data['Other_disaster'])) echo "checked";?>> อื่นๆ </label>
                            </div>
                            <div class="col-md-11 padding-top-ten padding-left-twenty-five"><input class="form-control" type="text" placeholder="โปรดระบุ" id="indicator-text" name="Other_disaster" value="<?php if(isset($data['Other_disaster'])) echo $data['Other_disaster'];?>" <?php if(!isset($data['Other_disaster'])) echo "disabled"?> ></div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="form-group">
                <label class="col-md-12 margin-bottom-zero label-header">ผลการตรวจ</label><br><br>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-egd" name="yesNoEGD" value="y" <?php if(isset($data['yesNoEGD'])) echo "checked"?> > EGD</label></div>
                        <div class="col-md-7">
                            <div class="col-md-1 destroy-padding-right "><label class="label-body padding-top-seven yesECDComponent">วันที่</label></div>
                            <div class="col-md-5">
                                <input type="text" class="form-control yesECDComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesEGD" value="<?php if(isset($data['dateYesEGD']) && $data['yesNoEGD'] == "y") echo date("d/m/Y", strtotime($data['dateYesEGD']));?>" <?php if(!isset($data['yesNoEGD']) || $data['yesNoEGD'] != "y") echo "disabled"; ?>>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row margin-top-ten">
                        <label class="col-md-12 label-body">ผลการส่องกล้อง</label>
                        <div class="col-md-12">
                            <textarea class="form-control yesECDComponent" rows="5" name="resultYesEGD" <?php if(!isset($data['yesNoEGD']) || $data['yesNoEGD'] != "y") echo "disabled"; ?> ><?php if(isset($data['resultYesEGD']) && $data['yesNoEGD'] == "y") echo $data['resultYesEGD']; else echo "";?></textarea>
                        </div>
                    </div>
                </div>
                <br>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-colonoscopy" name="yesNoColonoscopy" value="y" <?php if(isset($data['yesNoColonoscopy'])) echo "checked"?>> Colonoscopy</label></div>
                        <div class="col-md-7">
                            <div class="col-md-1 destroy-padding-right "><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-5">
                                <input type="text" class="form-control yesColonoscopyComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesColonoscopy" value="<?php if(isset($data['dateYesColonoscopy']) && $data['yesNoColonoscopy'] == "y") echo date("d/m/Y", strtotime($data['dateYesColonoscopy']));?>" <?php if(!isset($data['yesNoColonoscopy']) || $data['yesNoColonoscopy'] != "y") echo "disabled"; ?>>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row margin-top-ten">
                        <label class="col-md-12 label-body">ผลการส่องกล้อง</label>
                        <div class="col-md-12">
                            <textarea class="form-control yesColonoscopyComponent" rows="5" name="resultYesColonoscopy" <?php if(!isset($data['yesNoColonoscopy']) || $data['yesNoColonoscopy'] != "y") echo "disabled"; ?>><?php if(isset($data['resultYesColonoscopy']) && $data['yesNoColonoscopy'] == "y") echo $data['resultYesColonoscopy']; else echo "";?></textarea>
                        </div>
                    </div>
                </div>
                <br>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-esophagogram" name="yesNoEsophagogram" value="y" <?php if(isset($data['yesNoEsophagogram'])) echo "checked"?> > Esophagogram</label></div>
                        <div class="col-md-7">
                            <div class="col-md-1 destroy-padding-right "><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-5">
                                <input type="text" class="form-control yesEsophagogramComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesEsophagogram" value="<?php if(isset($data['dateYesEsophagogram']) && $data['yesNoEsophagogram'] == "y") echo date("d/m/Y", strtotime($data['dateYesEsophagogram']));?>" <?php if(!isset($data['yesNoEsophagogram']) || $data['yesNoEsophagogram'] != "y") echo "disabled"; ?>>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row margin-top-ten">
                        <label class="col-md-12 label-body">ผล</label>
                        <div class="col-md-12">
                            <textarea class="form-control yesEsophagogramComponent" rows="5" name="resultYesEsophagogram" <?php if(!isset($data['yesNoEsophagogram']) || $data['yesNoEsophagogram'] != "y") echo "disabled"; ?>><?php if(isset($data['resultYesEsophagogram']) && $data['yesNoEsophagogram'] == "y") echo $data['resultYesEsophagogram']; else echo "";?></textarea>
                        </div>
                    </div>
                </div>
                <br>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-esophagel" name="yesNoEsophagealtransit" value="y" <?php if(isset($data['yesNoEsophagealtransit'])) echo "checked"?>> Esophageal transit</label></div>
                        <div class="col-md-7">
                            <div class="col-md-1 destroy-padding-right "><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-5">
                                <input type="text" class="form-control yesEsophagelComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesEsophagealtransit" value="<?php if(isset($data['dateYesEsophagealtransit']) && $data['yesNoEsophagealtransit'] == "y") echo date("d/m/Y", strtotime($data['dateYesEsophagealtransit']));?>" <?php if(!isset($data['yesNoEsophagealtransit']) || $data['yesNoEsophagealtransit'] != "y") echo "disabled"; ?>>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row margin-top-ten">
                        <label class="col-md-12 label-body">ผล</label>
                        <div class="col-md-12">
                            <textarea class="form-control yesEsophagelComponent" rows="5" name="resultYesEsophagealtransit" <?php if(!isset($data['yesNoEsophagealtransit']) || $data['yesNoEsophagealtransit'] != "y") echo "disabled"; ?>><?php if(isset($data['resultYesEsophagealtransit']) && $data['yesNoEsophagealtransit'] == "y") echo $data['resultYesEsophagealtransit']; else echo "";?></textarea>
                        </div>
                    </div>
                </div>
                <br>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-gastric" name="yesNoGastric" value="y" <?php if(isset($data['yesNoGastric'])) echo "checked"?>> Gastric Emptying</label></div>
                        <div class="col-md-7">
                            <div class="col-md-1 destroy-padding-right "><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-5">
                                <input type="text" class="form-control yesGastricComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesGastric" value="<?php if(isset($data['dateYesGastric']) && $data['yesNoGastric'] == "y") echo date("d/m/Y", strtotime($data['dateYesGastric']));?>" <?php if(!isset($data['yesNoGastric']) || $data['yesNoGastric'] != "y") echo "disabled"; ?>>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row margin-top-ten">
                        <label class="col-md-12 label-body">ผล</label>
                        <div class="col-md-12">
                            <textarea class="form-control yesGastricComponent" rows="5" name="resultYesGastric" <?php if(!isset($data['yesNoGastric']) || $data['yesNoGastric'] != "y") echo "disabled"; ?> ><?php if(isset($data['resultYesGastric']) && $data['yesNoGastric'] == "y") echo $data['resultYesGastric']; else echo "";?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input class="check-esophageal-manometry" type="checkbox" name="yesNoEsophagealmanometry" value="y" <?php if(isset($data['yesNoEsophagealmanometry'])) echo "checked"?>> Esophageal manometry</label></div>
                        <div class="col-md-4">
                            <div class="col-md-2 padding-top-seven destroy-padding-right"><label class="label-body">วันที่ </label></div>
                            <div class="col-md-10 padding-right-thirty-five">
                                <input type="text" class="form-control check-esophageal-manometry-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateEsophageal" name="esophageal_manometry[]" value="<?php if(isset($data['dateEsophageal']) && $data['yesNoEsophagealmanometry'] == "y") echo date("d/m/Y", strtotime($data['dateEsophageal']));?>" <?php if(!isset($data['yesNoEsophagealmanometry']) || $data['yesNoEsophagealmanometry'] != "y") echo "disabled";?>>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="col-md-1 padding-top-seven destroy-padding-right"><label class="label-body">DX </label></div>
                            <div class="col-md-11"><input type="text" class="form-control check-esophageal-manometry-component" name="dxEsophageal" value="<?php if(isset($data['dxEsophageal']) && $data['yesNoEsophagealmanometry'] == "y") echo $data['dxEsophageal'];?>" <?php if(!isset($data['yesNoEsophagealmanometry']) || $data['yesNoEsophagealmanometry'] != "y") echo "disabled";?>></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-4"><label class="checkbox-inline"><input class="check-impedance-off" type="checkbox" name="yesNoImpedanceOff" value="y" <?php if(isset($data['yesNoImpedanceOff'])) echo "checked"?>> Impedance pH monitoring off Rx</label></div>
                        <div class="col-md-3"><label class="radio-inline"><input type="radio" class="check-impedance-off-component" name="negPos_imp_off" value="n" <?php if(isset($data['negPos_imp_off']) && $data['yesNoImpedanceOff'] == "y" && $data['negPos_imp_off'] == "n") echo "checked"?> <?php if(!isset($data['yesNoImpedanceOff']) || $data['yesNoImpedanceOff'] != "y") echo "disabled"?>> Negative</label></div>
                        <div class="col-md-3"><label class="radio-inline"><input type="radio" class="check-impedance-off-component" name="negPos_imp_off" value="p" <?php if(isset($data['negPos_imp_off']) && $data['yesNoImpedanceOff'] == "y" && $data['negPos_imp_off'] == "p") echo "checked"?> <?php if(!isset($data['yesNoImpedanceOff']) || $data['yesNoImpedanceOff'] != "y") echo "disabled"?>> Positive</label></div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-4"><label class="checkbox-inline"><input class="check-impedance-on" type="checkbox" name="yesNoImpedanceOn" value="y" <?php if(isset($data['yesNoImpedanceOn'])) echo "checked"?>> Impedance pH monitoring on Rx</label></div>
                        <div class="col-md-3"><label class="radio-inline"><input type="radio" class="check-impedance-on-component" name="negPos_imp_on" value="n" <?php if(isset($data['negPos_imp_on']) && $data['yesNoImpedanceOn'] == "y" && $data['negPos_imp_on'] == "n") echo "checked"?> <?php if(!isset($data['yesNoImpedanceOn']) || $data['yesNoImpedanceOn'] != "y") echo "disabled"?>> Negative</label></div>
                        <div class="col-md-3"><label class="radio-inline"><input type="radio" class="check-impedance-on-component" name="negPos_imp_on" value="p" <?php if(isset($data['negPos_imp_on']) && $data['yesNoImpedanceOn'] == "y" && $data['negPos_imp_on'] == "p") echo "checked"?> <?php if(!isset($data['yesNoImpedanceOn']) || $data['yesNoImpedanceOn'] != "y") echo "disabled"?>> Positive</label></div>
                    </div>
                </div>


                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-anorectalmanometry" name="yesNoAnorectal" value="y" <?php if(isset($data['yesNoAnorectal'])) echo "checked"?>> Anorectal manometry</label></div>
                        <div class="col-md-4">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-10">
                                <input type="text" class="form-control check-anorectalmanometry-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateAnorectal"  value="<?php if(isset($data['dateAnorectal']) && $data['yesNoAnorectal'] == "y") echo date("d/m/Y", strtotime($data['dateAnorectal']));?>" <?php if(!isset($data['yesNoAnorectal']) || $data['yesNoAnorectal'] != "y") echo "disabled"?>>
                            </div>
                        </div>
                        <div class="col-md-2"><label class="checkbox-inline"><input type="checkbox" class="check-anorectalmanometry-component" name="animus_anorectal" value="y" <?php if(isset($data['animus_anorectal']) && $data['yesNoAnorectal'] == "y") echo "checked"?> <?php if(!isset($data['yesNoAnorectal']) || $data['yesNoAnorectal'] != "y") echo "disabled"?>> anismus</label></div>
                        <div class="col-md-2"><label class="checkbox-inline"><input type="checkbox" class="check-anorectalmanometry-component" name="normal_anorectal" value="y" <?php if(isset($data['normal_anorectal']) && $data['yesNoAnorectal'] == "y") echo "checked"?> <?php if(!isset($data['yesNoAnorectal']) || $data['yesNoAnorectal'] != "y") echo "disabled"?>> normal</label></div>
                    </div>
                    <div class="row margin-top-ten">
                        <div class="col-md-7 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Other</label></div>
                            <div class="col-md-10 destroy-padding-left"><input type="text" class="form-control check-anorectalmanometry-component" name="other_anorectal" value="<?php if(isset($data['other_anorectal']) && $data['yesNoAnorectal'] == "y") echo $data['other_anorectal']?>" <?php if(!isset($data['yesNoAnorectal']) || $data['yesNoAnorectal'] != "y") echo "disabled"?>></div>
                        </div>
                        <div class="col-md-5 margin-top-ten padding-left-twenty-five">
                            <div class="col-md-2 col-md-offset-2 destroy-padding-right"><label class="label-body padding-top-seven">BET</label></div>
                            <div class="col-md-3 destroy-padding-left"><input type="text" class="form-control check-anorectalmanometry-component" name="bet_anorectal" value="<?php if(isset($data['bet_anorectal']) && $data['yesNoAnorectal'] == "y") echo $data['bet_anorectal']?>" <?php if(!isset($data['yesNoAnorectal']) || $data['yesNoAnorectal'] != "y") echo "disabled"?>></div>
                            <div class="col-md-2 destroy-padding-left"><label class="label-body padding-top-seven">min</label></div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                    <div class="row margin-top-ten">
                        <div class="col-md-3 margin-top-ten">
                            <div class="col-md-2"><label class="label-body padding-top-seven">S1</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-anorectalmanometry-component" name="s1_anorectal" value="<?php if(isset($data['s1_anorectal']) && $data['yesNoAnorectal'] == "y") echo $data['s1_anorectal']?>" <?php if(!isset($data['yesNoAnorectal']) || $data['yesNoAnorectal'] != "y") echo "disabled"?>></div>
                        </div>
                        <div class="col-md-3 col-md-offset-1 margin-top-ten">
                            <div class="col-md-2"><label class="label-body padding-top-seven">S2</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-anorectalmanometry-component" name="s2_anorectal" value="<?php if(isset($data['s2_anorectal']) && $data['yesNoAnorectal'] == "y") echo $data['s2_anorectal']?>" <?php if(!isset($data['yesNoAnorectal']) || $data['yesNoAnorectal'] != "y") echo "disabled"?>></div>
                        </div>
                        <div class="col-md-3 col-md-offset-1 margin-top-ten">
                            <div class="col-md-2"><label class="label-body padding-top-seven">S3</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-anorectalmanometry-component" name="s3_anorectal" value="<?php if(isset($data['s3_anorectal']) && $data['yesNoAnorectal'] == "y") echo $data['s3_anorectal']?>" <?php if(!isset($data['yesNoAnorectal']) || $data['yesNoAnorectal'] != "y") echo "disabled"?>></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-colonic-transit" name="yesNoCTT" value="y" <?php if(isset($data['yesNoCTT'])) echo "checked"?>> Colonic transit time (CTT)</label></div>
                        <div class="col-md-4">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-10">
                                <input type="text" class="form-control check-colonic-transit-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateCTT" value="<?php if(isset($data['dateCTT']) && $data['yesNoCTT'] == "y") echo date("d/m/Y", strtotime($data['dateCTT']));?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-top-ten">
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-12 destroy-padding-right"><label class="label-body padding-top-seven">Day 1</label></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Rt</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-colonic-transit-component" name="rt_day1" value="<?php if(isset($data['rt_day1']) && $data['yesNoCTT'] == "y") echo $data['rt_day1']?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Dt</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-colonic-transit-component" name="dt_day1" value="<?php if(isset($data['dt_day1']) && $data['yesNoCTT'] == "y") echo $data['dt_day1']?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>></div>
                        </div>
                        <div class="col-md-3 margin-top-ten">
                            <div class="col-md-4"><label class="label-body padding-top-seven">Sigmoid</label></div>
                            <div class="col-md-8"><input type="text" class="form-control check-colonic-transit-component" name="sigmoid_day1" value="<?php if(isset($data['sigmoid_day1']) && $data['yesNoCTT'] == "y") echo $data['sigmoid_day1']?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">R</label></div>
                            <div class="col-md-8 destroy-padding-left"><input type="text" class="form-control check-colonic-transit-component" name="r_day1" value="<?php if(isset($data['r_day1']) && $data['yesNoCTT'] == "y") echo $data['r_day1']?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>></div>
                        </div>
                    </div>
                    <div class="row margin-top-ten">
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-12 destroy-padding-right"><label class="label-body padding-top-seven">Day 3</label></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Rt</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-colonic-transit-component" name="rt_day3" value="<?php if(isset($data['rt_day3']) && $data['yesNoCTT'] == "y") echo $data['rt_day3']?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Dt</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-colonic-transit-component" name="dt_day3" value="<?php if(isset($data['dt_day3']) && $data['yesNoCTT'] == "y") echo $data['dt_day3']?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>></div>
                        </div>
                        <div class="col-md-3 margin-top-ten">
                            <div class="col-md-4"><label class="label-body padding-top-seven">Sigmoid</label></div>
                            <div class="col-md-8"><input type="text" class="form-control check-colonic-transit-component" name="sigmoid_day3" value="<?php if(isset($data['sigmoid_day3']) && $data['yesNoCTT'] == "y") echo $data['sigmoid_day3']?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">R</label></div>
                            <div class="col-md-8 destroy-padding-left"><input type="text" class="form-control check-colonic-transit-component" name="r_day3" value="<?php if(isset($data['r_day3']) && $data['yesNoCTT'] == "y") echo $data['r_day3']?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>></div>
                        </div>
                    </div>
                    <div class="row margin-top-ten">
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-12 destroy-padding-right"><label class="label-body padding-top-seven">Day 5</label></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Rt</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-colonic-transit-component" name="rt_day5"  value="<?php if(isset($data['rt_day5']) && $data['yesNoCTT'] == "y") echo $data['rt_day5']?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Dt</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-colonic-transit-component" name="dt_day5"  value="<?php if(isset($data['dt_day5']) && $data['yesNoCTT'] == "y") echo $data['dt_day5']?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>></div>
                        </div>
                        <div class="col-md-3 margin-top-ten">
                            <div class="col-md-4"><label class="label-body padding-top-seven">Sigmoid</label></div>
                            <div class="col-md-8"><input type="text" class="form-control check-colonic-transit-component" name="sigmoid_day5"  value="<?php if(isset($data['sigmoid_day5']) && $data['yesNoCTT'] == "y") echo $data['sigmoid_day5']?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">R</label></div>
                            <div class="col-md-8 destroy-padding-left"><input type="text" class="form-control check-colonic-transit-component" name="r_day5"  value="<?php if(isset($data['r_day5']) && $data['yesNoCTT'] == "y") echo $data['r_day5']?>" <?php if(!isset($data['yesNoCTT']) || $data['yesNoCTT'] != "y") echo "disabled"?>></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-12 margin-top-ten"><label class="checkbox-inline"><input type="checkbox" class="check-biofeedback" name="yesNoBiofeedback" value="y" <?php if(isset($data['yesNoBiofeedback'])) echo "checked"?>> Biofeedback</label></div>
                    </div>
                    <div class="row margin-top-ten">
                        <div class="col-md-6 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">ทำครั้งที่ 1 วันที่</label></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control check-biofeedback-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="date1_biofeedback" value="<?php if(isset($data['date1_biofeedback']) && $data['yesNoBiofeedback'] == "y") echo date("d/m/Y", strtotime($data['date1_biofeedback']));?>" <?php if(!isset($data['yesNoBiofeedback']) || $data['yesNoBiofeedback'] != "y") echo "disabled"?>>
                            </div>
                        </div>
                        <div class="col-md-6 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">ทำครั้งที่ 2 วันที่</label></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control check-biofeedback-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="date2_biofeedback" value="<?php if(isset($data['date2_biofeedback']) && $data['yesNoBiofeedback'] == "y") echo date("d/m/Y", strtotime($data['date2_biofeedback']));?>"  <?php if(!isset($data['yesNoBiofeedback']) || $data['yesNoBiofeedback'] != "y") echo "disabled"?>>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-top-ten">
                        <div class="col-md-6 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">ทำครั้งที่ 3 วันที่</label></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control check-biofeedback-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="date3_biofeedback" value="<?php if(isset($data['date3_biofeedback']) && $data['yesNoBiofeedback'] == "y") echo date("d/m/Y", strtotime($data['date3_biofeedback']));?>" <?php if(!isset($data['yesNoBiofeedback']) || $data['yesNoBiofeedback'] != "y") echo "disabled"?>>
                            </div>
                        </div>
                        <div class="col-md-6 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">ทำครั้งที่ 4 วันที่</label></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control check-biofeedback-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="date4_biofeedback" value="<?php if(isset($data['date4_biofeedback']) && $data['yesNoBiofeedback'] == "y") echo date("d/m/Y", strtotime($data['date4_biofeedback']));?>" <?php if(!isset($data['yesNoBiofeedback']) || $data['yesNoBiofeedback'] != "y") echo "disabled"?>>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-12"><label class="checkbox-inline"><input type="checkbox" class="check-antroduodenal" name="yesNoAntroduodenal" value="y" <?php if(isset($data['yesNoAntroduodenal'])) echo "checked"?> > Antroduodenal manometry</label></div>
                    </div>
                    <div class="row margin-top-twenty">
                        <div class="col-md-4">
                            <div class="col-md-3 destroy-padding-right"><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-9 destroy-padding-left">
                                <input type="text" class="form-control yesAntroduodenalComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateAntroduodenal" value="<?php if(isset($data['dateAntroduodenal']) && $data['yesNoAntroduodenal'] == "y") echo date("d/m/Y", strtotime($data['dateAntroduodenal']));?>" <?php if(!isset($data['yesNoAntroduodenal']) || $data['yesNoAntroduodenal'] != "y") echo "disabled"?>>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Findings</label></div>
                            <div class="col-md-10 destroy-padding-left"><input type="text" class="form-control yesAntroduodenalComponent" name="findAntroduodenal" value="<?php if(isset($data['findAntroduodenal']) && $data['yesNoAntroduodenal'] == "y") echo $data['findAntroduodenal']?>" <?php if(!isset($data['yesNoAntroduodenal']) || $data['yesNoAntroduodenal'] != "y") echo "disabled"?>></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-12"><label class="checkbox-inline"><input type="checkbox" class="check-pudendal" name="yesNoPudendal" value="y" <?php if(isset($data['yesNoPudendal'])) echo "checked"?> > Pudendal nerve latency test</label></div>
                    </div>
                    <div class="row margin-top-twenty">
                        <div class="col-md-4">
                            <div class="col-md-3 destroy-padding-right"><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-9 destroy-padding-left">
                                <input type="text" class="form-control yesPudendalComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="datePudendal" value="<?php if(isset($data['datePudendal']) && $data['yesNoPudendal'] == "y") echo date("d/m/Y", strtotime($data['datePudendal']));?>" <?php if(!isset($data['yesNoPudendal']) || $data['yesNoPudendal'] != "y") echo "disabled"?>>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Findings</label></div>
                            <div class="col-md-10 destroy-padding-left"><input type="text" class="form-control yesPudendalComponent" name="findPudendal" value="<?php if(isset($data['findPudendal']) && $data['yesNoPudendal'] == "y") echo $data['findPudendal']?>" <?php if(!isset($data['yesNoPudendal']) || $data['yesNoPudendal'] != "y") echo "disabled"?>></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-breath-test" name="yesNoBreath" value="y" <?php if(isset($data['yesNoBreath'])) echo "checked"?> > Breath test</label></div>
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="yesBreathTestComponent" name="Glucose" value="y" <?php if(isset($data['Glucose']) && $data['yesNoBreath'] == "y") echo "checked";?> <?php if(!isset($data['yesNoBreath']) || $data['yesNoBreath'] != "y") echo "disabled"?> > Glucose</label></div>
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="yesBreathTestComponent" name="Lactulose" value="y" <?php if(isset($data['Lactulose']) && $data['yesNoBreath'] == "y") echo "checked";?> <?php if(!isset($data['yesNoBreath']) || $data['yesNoBreath'] != "y") echo "disabled"?> > Lactulose</label></div>
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="yesBreathTestComponent" name="Fructose" value="y" <?php if(isset($data['Fructose']) && $data['yesNoBreath'] == "y") echo "checked";?> <?php if(!isset($data['yesNoBreath']) || $data['yesNoBreath'] != "y") echo "disabled"?> > Fructose</label></div>
                    </div>
                    <div class="row margin-top-twenty">
                        <div class="col-md-4">
                            <div class="col-md-3 destroy-padding-right"><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-9 destroy-padding-left">
                                <input type="text" class="form-control yesBreathTestComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateBreath" value="<?php if(isset($data['dateBreath']) && $data['yesNoBreath'] == "y") echo date("d/m/Y", strtotime($data['dateBreath']));?>" <?php if(!isset($data['yesNoBreath']) || $data['yesNoBreath'] != "y") echo "disabled"?>>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-offset-1"><label class="radio-inline"><input type="radio" class="yesBreathTestComponent" name="negPos_breath" value="n" <?php if(isset($data['negPos_breath'])  && $data['yesNoBreath'] == "y" && $data['negPos_breath'] == "n") echo "checked"?> <?php if(!isset($data['yesNoBreath']) || $data['yesNoBreath'] != "y") echo "disabled"?>> Negative</label></div>
                        <div class="col-md-3"><label class="radio-inline"><input type="radio" class="yesBreathTestComponent" name="negPos_breath" value="p" <?php if(isset($data['negPos_breath'])  && $data['yesNoBreath'] == "y" && $data['negPos_breath'] == "p") echo "checked"?> <?php if(!isset($data['yesNoBreath']) || $data['yesNoBreath'] != "y") echo "disabled"?>> Positive</label></div>
                        <div class="col-md-1"></div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-forty">
                    <div class="row">
                        <div class="col-md-12"><label class="label-body">อื่นๆ</label></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><textarea class="form-control" rows="5" placeholder="โปรดระบุ" name="other_result"><?php if(isset($data['other_result'])) echo $data['other_result']?></textarea></div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="Date" value="">

            <div class="row padding-bottom-fifty">
                <div class="col-md-2 col-md-offset-10">
                    <button type="button" id="save-button" class="btn btn-block btn-default">Save</button>
                </div>
            </div>

        </form>
        <script>
            $("#save-button").click(function(){
                var dataJson =  $("#form-header,#form-body").serializeArray();

                $.ajax({
                    url: "patientData.php",
                    type: 'post',
                    data: dataJson,
                    success: function(result){
                        var a = JSON.parse(result);
                        if(a == "success"){
                            window.location = "http://localhost/PhpStormWorkspace/projectSADB/nurse/nurseForm.php";
                        }else if(a == "unknown"){
                            $.toaster({ priority : 'success', title : '', message : 'ผู้ป่วยไม่มีรายชื่อภายในระบบ'});
                        }
                    }
                });
            });
        </script>
    </div>


    <script>

        $(document).ready(function(){

            $(".datepicker").datepicker();

            $("#indicator").change(function(){
                if($("#indicator").prop("checked") == true){
                    $("#indicator-text").removeAttr("disabled");
                }else{
                    $("#indicator-text").val("").attr("disabled",true);
                }
            });

            $(".check-egd").change(function(){
                if($(".check-egd").prop("checked") == true){
                    $(".yesECDComponent").removeAttr("disabled");
                }else{
                    $(".yesECDComponent").attr("disabled",true);
                }
            });

            $(".check-colonoscopy").change(function(){
                if($(".check-colonoscopy").prop("checked") == true){
                    $(".yesColonoscopyComponent").removeAttr("disabled");
                }else{
                    $(".yesColonoscopyComponent").attr("disabled",true);
                }
            });

            $(".check-esophagogram").change(function(){
                if($(".check-esophagogram").prop("checked") == true){
                    $(".yesEsophagogramComponent").removeAttr("disabled");
                }else{
                    $(".yesEsophagogramComponent").attr("disabled",true);
                }
            });

            $(".check-esophagel").change(function(){
                if($(".check-esophagel").prop("checked") == true){
                    $(".yesEsophagelComponent").removeAttr("disabled");
                }else{
                    $(".yesEsophagelComponent").attr("disabled",true);
                }
            });

            $(".check-esophageal-manometry").change(function(){
                if($(".check-esophageal-manometry").prop('checked') == true){
                    $(".check-esophageal-manometry-component").removeAttr("disabled");
                }else{
                    $(".check-esophageal-manometry-component").attr("disabled",true);
                }
            });

            $(".check-impedance-off").change(function(){
                if($(".check-impedance-off").prop('checked') == true){
                    $(".check-impedance-off-component").removeAttr("disabled");
                }else{
                    $(".check-impedance-off-component").attr("disabled",true);
                }
            });

            $(".check-impedance-on").change(function(){
                if($(".check-impedance-on").prop('checked') == true){
                    $(".check-impedance-on-component").removeAttr("disabled");
                }else{
                    $(".check-impedance-on-component").attr("disabled",true);
                }
            });

            $(".check-gastric").change(function(){
                if($(".check-gastric").prop("checked") == true){
                    $(".yesGastricComponent").removeAttr("disabled");
                }else{
                    $(".yesGastricComponent").attr("disabled",true);
                }
            });

            $(".check-anorectalmanometry").change(function(){
                if($(".check-anorectalmanometry").prop('checked') == true){
                    $(".check-anorectalmanometry-component").removeAttr("disabled");
                }else{
                    $(".check-anorectalmanometry-component").attr("disabled",true);
                }
            });

            $(".check-colonic-transit").change(function(){
                if($(".check-colonic-transit").prop('checked') == true){
                    $(".check-colonic-transit-component").removeAttr("disabled");
                }else{
                    $(".check-colonic-transit-component").attr("disabled",true);
                }
            });

            $(".check-biofeedback").change(function(){
                if($(".check-biofeedback").prop('checked') == true){
                    $(".check-biofeedback-component").removeAttr("disabled");
                }else{
                    $(".check-biofeedback-component").attr("disabled",true);
                }
            });

            $(".check-antroduodenal").change(function(){
                if($(".check-antroduodenal").prop('checked') == true){
                    $(".yesAntroduodenalComponent").removeAttr("disabled");
                }else{
                    $(".yesAntroduodenalComponent").attr("disabled",true);
                }
            });

            $(".check-pudendal").change(function(){
                if($(".check-pudendal").prop('checked') == true){
                        $(".yesPudendalComponent").removeAttr("disabled");
                }else{
                    $(".yesPudendalComponent").attr("disabled",true);
                }
            });

            $(".check-breath-test").change(function(){
                if($(".check-breath-test").prop('checked') == true){
                        $(".yesBreathTestComponent").removeAttr("disabled");
                }else{
                    $(".yesBreathTestComponent").attr("disabled",true);
                }
            });

        });

    </script>
</body>
</html>