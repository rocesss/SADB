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
            $HN = $_POST['hn'];

            $data = getPatientData($firstName, $lastName, $HN);
        }else if($_GET['q'] == "save"){
            $treatment = $_POST['treatment'];
//            echo print_r($treatment);
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
    <script src="../login/utility.js" type="text/javascript"></script>
    <link rel="stylesheet" href="nurseFormCss.css" type="text/css">
    <title>For Nurse</title>
</head>

<body>
    <div class="container full-height">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12" id="head-name">
                <label>For Nurse</label>
            </div>
        </div>

        <form class="form-horizontal" id="form-header" method="post" action="nurseForm.php?q=search">
            <div class="form-group">
                <label class="col-md-4 margin-bottom-zero label-header">Patient Firstname<br><br><input class="form-control margin-top-zero" type="text" name="patientFirstName" value="<?php if(isset($data['patient_firstname'])) echo $data['patient_firstname']; else echo ""; ?>" ></label>
                <label class="col-md-4 margin-bottom-zero label-header">Patient Lastname<br><br><input class="form-control margin-top-zero" type="text" name="patientLastName" value="<?php if(isset($data['patient_lastname'])) echo $data['patient_lastname']; else echo ""; ?>" ></label>
                <label class="col-md-3 margin-bottom-zero label-header">HN<br><br><input class="form-control margin-top-zero" type="text" name="hn" value="<?php if(isset($data['hn'])) echo $data['hn']; else echo ""; ?>" ></label>
                <div class="col-md-1">
                    <br><br><button type="summit" class="form-control button-search margin-top-three" id="button-search"><span class="glyphicon glyphicon-search"></span></button>
                </div>
            </div>
        </form>
        <br>

        <form class="form-horizontal" id="form-body" method="post" >
            <div class="form-group">
                <label class="col-md-12 margin-bottom-zero label-header">การตรวจ</label><br><br>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4"><label class="checkbox-inline"><input type="checkbox" name="treatment[]" value="esophageal_manometry" <?php if(isset($data['treat_esophageal'])) echo "checked";?> > Esophageal manometry</label></div>
                        <div class="col-md-4"><label class="checkbox-inline"><input type="checkbox" name="treatment[]" value="impedance_off" <?php if(isset($data['treat_imp_off'])) echo "checked";?>> Impedance pH monitoring off Rx</label></div>
                        <div class="col-md-4"><label class="checkbox-inline"><input type="checkbox" name="treatment[]" value="impedance_on" <?php if(isset($data['treat_imp_on'])) echo "checked";?>> Impedance pH monitoring on Rx</label></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label class="checkbox-inline"><input type="checkbox" name="treatment[]" value="anorectal_manometry" <?php if(isset($data['treat_anorectal'])) echo "checked";?>> Anorectal manometry</label></div>
                        <div class="col-md-4"><label class="checkbox-inline"><input type="checkbox" name="treatment[]" value="antroduodenal_manonetry" <?php if(isset($data['treat_antroduodenal'])) echo "checked";?>> Antroduodenal manometry</label></div>
                        <div class="col-md-4"><label class="checkbox-inline"><input type="checkbox" name="treatment[]" value="pudendal" <?php if(isset($data['treat_pudendal'])) echo "checked";?>> Pudendal nerve latency test</label></div>
                    </div>
                </div>
            </div>
            <br>

            <div class="form-group">
                <label class="col-md-12 margin-bottom-zero label-header">Breath test</label><br><br>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2"><label class="checkbox-inline"><input type="checkbox" name="breathTest[]" value="glucose" <?php if(isset($data['breath_glucose'])) echo "checked";?>> Glucose</label></div>
                        <div class="col-md-2"><label class="checkbox-inline"><input type="checkbox" name="breathTest[]" value="lactulose" <?php if(isset($data['breath_lactulose'])) echo "checked";?>> Lactulose</label></div>
                        <div class="col-md-2"><label class="checkbox-inline"><input type="checkbox" name="breathTest[]" value="fructose" <?php if(isset($data['breath_fructose'])) echo "checked";?>> Fructose</label></div>
                    </div>
                </div>
            </div>
            <br>

            <div class="form-group">
                <label class="col-md-12 margin-bottom-zero label-header">ข้อบ่งชี้</label><br><br>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 margin-top-bottom-three">
                            <label class="radio-inline"><input type="radio" class="indicator-check" name="indicator" value="dysphagia" <?php if(isset($data['indicator']) && $data['indicator'] == "dysphagia") echo "checked";?>> Dysphagia</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three">
                            <label class="radio-inline"><input type="radio" class="indicator-check" name="indicator" value="gerd" <?php if(isset($data['indicator']) && $data['indicator'] == "gerd") echo "checked";?>> GERD</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three">
                            <label class="radio-inline"><input type="radio" class="indicator-check" name="indicator" value="nonCardiacChest" <?php if(isset($data['indicator']) && $data['indicator'] == "nonCardiacChest") echo "checked";?>> Non-cardiac chest pain</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three">
                            <label class="radio-inline"><input type="radio" class="indicator-check" name="indicator" value="chronicEnt" <?php if(isset($data['indicator']) && $data['indicator'] == "chronicEnt") echo "checked";?>> Chronic ENT problem</label>
                        </div>

                        <div class="col-md-3 margin-top-bottom-three padding-top-seven">
                            <label class="radio-inline"><input type="radio" class="indicator-check" name="indicator" value="globus" <?php if(isset($data['indicator']) && $data['indicator'] == "globus") echo "checked";?>> Globus</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three padding-top-seven">
                            <label class="radio-inline"><input type="radio" class="indicator-check" name="indicator" value="dyspepsia" <?php if(isset($data['indicator']) && $data['indicator'] == "dyspepsia") echo "checked";?>> Dyspepsia</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three padding-top-seven">
                            <label class="radio-inline"><input type="radio" class="indicator-check" name="indicator" value="bloating" <?php if(isset($data['indicator']) && $data['indicator'] == "bloating") echo "checked";?>> Bloating</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three padding-top-seven">
                            <label class="radio-inline"><input type="radio" class="indicator-check" name="indicator" value="belching" <?php if(isset($data['indicator']) && $data['indicator'] == "belching") echo "checked";?>> Belching</label>
                        </div>

                        <div class="col-md-3 margin-top-bottom-three padding-top-seven">
                            <label class="radio-inline"><input type="radio" class="indicator-check" name="indicator" value="constipation" <?php if(isset($data['indicator']) && $data['indicator'] == "constipation") echo "checked";?>> Constipation</label>
                        </div>
                        <div class="col-md-3 margin-top-bottom-three padding-top-seven">
                            <label class="radio-inline"><input type="radio" class="indicator-check" name="indicator" value="incontinence" <?php if(isset($data['indicator']) && $data['indicator'] == "incontinence") echo "checked";?>> Incontinence</label>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-1 destroy-padding margin-top-bottom-three padding-top-seven">
                                <label class="radio-inline control-label"><input type="radio" id="indicator" name="indicator" value="other" <?php if(isset($data['indicator']) && $data['indicator'] == "other") echo "checked";?>> อื่นๆ </label>
                            </div>
                            <div class="col-md-11 padding-top-ten"><input class="form-control" type="text" placeholder="โปรดระบุ" id="indicator-text" name="indicator-other" value="<?php if(isset($data['indicator_other']) && isset($data['indicator']) && $data['indicator'] == "other") echo $data['indicator_other'];?>" <?php if(!isset($data['indicator']) || $data['indicator'] != "other") echo "disabled"?> ></div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="form-group">
                <label class="col-md-12 margin-bottom-zero label-header">ผลการตรวจ</label><br><br>
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-md-2 label-body padding-top-seven">EGD</label>
                        <div class="col-md-2"><label class="radio-inline"><input type="radio" class="noECD" name="yesNoEGD" value="noEGD" <?php if(isset($data['yesNoEGD']) && $data['yesNoEGD'] != "y") echo "checked"; ?>> ไม่เคย</label></div>
                        <div class="col-md-1"><label class="radio-inline"><input type="radio" class="yesECD" name="yesNoEGD" value="yesEGD" <?php if(isset($data['yesNoEGD']) && $data['yesNoEGD'] == "y") echo "checked"; ?>> เคย</label></div>
                        <div class="col-md-7">
                            <div class="col-md-1 destroy-padding-right "><label class="label-body padding-top-seven yesECDComponent">วันที่</label></div>
                            <div class="col-md-5">
                                <input type="text" class="form-control yesECDComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesEGD" value="<?php if(isset($data['dateYesEGD']) && $data['yesNoEGD'] == "y") echo date("d/m/Y", strtotime($data['dateYesEGD']));?>" <?php if(!isset($data['yesNoEGD']) || $data['yesNoEGD'] != "y") echo "disabled"; ?>>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 label-body">ผลการส่องกล้อง</label>
                        <div class="col-md-12">
                            <textarea class="form-control yesECDComponent" rows="3" name="resultCameraYesEGD" <?php if(!isset($data['yesNoEGD']) || $data['yesNoEGD'] != "y") echo "disabled"; ?> ><?php if(isset($data['resultYesEGD']) && $data['yesNoEGD'] == "y") echo $data['resultYesEGD']; else echo "";?></textarea>
                        </div>
                    </div>
                </div>
                <br>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <label class="col-md-2 label-body padding-top-seven">Colonoscopy</label>
                        <div class="col-md-2"><label class="radio-inline"><input type="radio" class="noColonoscopy" name="yesNoColonoscopy" value="noColonoscopy" <?php if(isset($data['yesNoColonoscopy']) && $data['yesNoColonoscopy'] != "y") echo "checked"; ?>> ไม่เคย</label></div>
                        <div class="col-md-1"><label class="radio-inline"><input type="radio" class="yesColonoscopy" name="yesNoColonoscopy" value="yesColonoscopy" <?php if(isset($data['yesNoColonoscopy']) && $data['yesNoColonoscopy'] == "y") echo "checked"; ?>> เคย</label></div>
                        <div class="col-md-7">
                            <div class="col-md-1 destroy-padding-right "><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-5">
                                <input type="text" class="form-control yesColonoscopyComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesColonoscopy" value="<?php if(isset($data['dateYesColonoscopy']) && $data['yesNoColonoscopy'] == "y") echo date("d/m/Y", strtotime($data['dateYesColonoscopy']));?>" <?php if(!isset($data['yesNoColonoscopy']) || $data['yesNoColonoscopy'] != "y") echo "disabled"; ?>>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 label-body">ผลการส่องกล้อง</label>
                        <div class="col-md-12">
                            <textarea class="form-control yesColonoscopyComponent" rows="3" name="resultCameraYesColonoscopy" <?php if(!isset($data['yesNoColonoscopy']) || $data['yesNoColonoscopy'] != "y") echo "disabled"; ?>><?php if(isset($data['resultYesColonoscopy']) && $data['yesNoColonoscopy'] == "y") echo $data['resultYesColonoscopy']; else echo "";?></textarea>
                        </div>
                    </div>
                </div>
                <br>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <label class="col-md-2 label-body padding-top-seven">Esophagogram</label>
                        <div class="col-md-2"><label class="radio-inline"><input type="radio" class="noEsophagogram" name="yesNoEsophagogram" value="noEsophagogram" <?php if(isset($data['yesNoEsophagogram']) && $data['yesNoEsophagogram'] != "y") echo "checked"; ?>> ไม่เคย</label></div>
                        <div class="col-md-1"><label class="radio-inline"><input type="radio" class="yesEsophagogram" name="yesNoEsophagogram" value="yesEsophagogram" <?php if(isset($data['yesNoEsophagogram']) && $data['yesNoEsophagogram'] == "y") echo "checked"; ?>> เคย</label></div>
                        <div class="col-md-7">
                            <div class="col-md-1 destroy-padding-right "><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-5">
                                <input type="text" class="form-control yesEsophagogramComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesEsophagogram" value="<?php if(isset($data['dateYesEsophagogram']) && $data['yesNoEsophagogram'] == "y") echo date("d/m/Y", strtotime($data['dateYesEsophagogram']));?>" <?php if(!isset($data['yesNoEsophagogram']) || $data['yesNoEsophagogram'] != "y") echo "disabled"; ?>>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 label-body">ผล</label>
                        <div class="col-md-12">
                            <textarea class="form-control yesEsophagogramComponent" rows="3" name="resultCameraYesEsophagogram" <?php if(!isset($data['yesNoEsophagogram']) || $data['yesNoEsophagogram'] != "y") echo "disabled"; ?>><?php if(isset($data['resultYesEsophagogram']) && $data['yesNoEsophagogram'] == "y") echo $data['resultYesEsophagogram']; else echo "";?></textarea>
                        </div>
                    </div>
                </div>
                <br>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <label class="col-md-2 label-body padding-top-seven">Esophagel transit</label>
                        <div class="col-md-2"><label class="radio-inline"><input type="radio" class="noEsophagel" name="yesNoEsophagel" value="noEsophagel" <?php if(isset($data['yesNoEsophagel']) && $data['yesNoEsophagel'] != "y") echo "checked"; ?>> ไม่เคย</label></div>
                        <div class="col-md-1"><label class="radio-inline"><input type="radio" class="yesEsophagel" name="yesNoEsophagel" value="yesEsophagel" <?php if(isset($data['yesNoEsophagel']) && $data['yesNoEsophagel'] == "y") echo "checked"; ?>> เคย</label></div>
                        <div class="col-md-7">
                            <div class="col-md-1 destroy-padding-right "><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-5">
                                <input type="text" class="form-control yesEsophagelComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesEsophagel" value="<?php if(isset($data['dateYesEsophagel']) && $data['yesNoEsophagel'] == "y") echo date("d/m/Y", strtotime($data['dateYesEsophagel']));?>" <?php if(!isset($data['yesNoEsophagel']) || $data['yesNoEsophagel'] != "y") echo "disabled"; ?>>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 label-body">ผล</label>
                        <div class="col-md-12">
                            <textarea class="form-control yesEsophagelComponent" rows="3" name="resultCameraYesEsophagel" <?php if(!isset($data['yesNoEsophagel']) || $data['yesNoEsophagel'] != "y") echo "disabled"; ?>><?php if(isset($data['resultYesEsophagel']) && $data['yesNoEsophagel'] == "y") echo $data['resultYesEsophagel']; else echo "";?></textarea>
                        </div>
                    </div>
                </div>
                <br>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input class="check-esophageal-manometry" type="checkbox" <?php if(isset($data['dateEsophageal']) || isset($data['dxEsophageal'])) echo "checked"?>> Esophageal manometry</label></div>
                        <div class="col-md-4">
                            <div class="col-md-2 padding-top-seven destroy-padding-right"><label class="label-body">วันที่ </label></div>
                            <div class="col-md-10">
                                <input type="text" class="form-control check-esophageal-manometry-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesEsophagel" name="esophageal_manometry[]" value="<?php if(isset($data['dateEsophageal'])) echo date("d/m/Y", strtotime($data['dateEsophageal']));?>" <?php if(!isset($data['dateEsophageal'])) echo "disabled";?>>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="col-md-1 padding-top-seven destroy-padding-right"><label class="label-body">DX </label></div>
                            <div class="col-md-11"><input type="text" class="form-control check-esophageal-manometry-component" name="esophageal_manometry[]" value="<?php if(isset($data['dxEsophageal'])) echo $data['dxEsophageal'];?>" <?php if(!isset($data['dxEsophageal'])) echo "disabled";?>></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <div class="col-md-4"><label class="checkbox-inline"><input class="check-impedance-off" type="checkbox" <?php if(isset($data['negPos_imp_off'])) echo "checked"?>> Impedance pH monitoring off Rx</label></div>
                        <div class="col-md-3"><label class="radio-inline"><input type="radio" class="check-impedance-off-component" name="impedanceOff" value="negativeImpedanceOff" <?php if(isset($data['negPos_imp_off']) && $data['negPos_imp_off'] == "n") echo "checked"?> <?php if(!isset($data['negPos_imp_off'])) echo "disabled"?>> Negative</label></div>
                        <div class="col-md-3"><label class="radio-inline"><input type="radio" class="check-impedance-off-component" name="impedanceOff" value="positiveImpedanceOff" <?php if(isset($data['negPos_imp_off']) && $data['negPos_imp_off'] == "y") echo "checked"?> <?php if(!isset($data['negPos_imp_off'])) echo "disabled"?>> Positive</label></div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <div class="col-md-4"><label class="checkbox-inline"><input class="check-impedance-on" type="checkbox" <?php if(isset($data['negPos_imp_on'])) echo "checked"?>> Impedance pH monitoring on Rx</label></div>
                        <div class="col-md-3"><label class="radio-inline"><input type="radio" class="check-impedance-on-component" name="impedanceOn" value="negativeImpedanceOn" <?php if(isset($data['negPos_imp_on']) && $data['negPos_imp_on'] == "n") echo "checked"?> <?php if(!isset($data['negPos_imp_on'])) echo "disabled"?>> Negative</label></div>
                        <div class="col-md-3"><label class="radio-inline"><input type="radio" class="check-impedance-on-component" name="impedanceOn" value="positiveImpedanceOn" <?php if(isset($data['negPos_imp_on']) && $data['negPos_imp_on'] == "y") echo "checked"?> <?php if(!isset($data['negPos_imp_on'])) echo "disabled"?>> Positive</label></div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <label class="col-md-2 label-body padding-top-seven">Gastric Emptying</label>
                        <div class="col-md-2"><label class="radio-inline"><input type="radio" class="noGastric" name="yesNoGastricEmptying" value="noGastricEmptying" <?php if(isset($data['yesNoGastric']) && $data['yesNoGastric'] != "y") echo "checked"; ?>> ไม่เคย</label></div>
                        <div class="col-md-1"><label class="radio-inline"><input type="radio" class="yesGastric" name="yesNoGastricEmptying" value="yesGastricEmptying" <?php if(isset($data['yesNoGastric']) && $data['yesNoGastric'] == "y") echo "checked"; ?>> เคย</label></div>
                        <div class="col-md-7">
                            <div class="col-md-1 destroy-padding-right "><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-5">
                                <input type="text" class="form-control yesGastricComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesGastricEmptying" value="<?php if(isset($data['dateYesGastric']) && $data['yesNoGastric'] == "y") echo date("d/m/Y", strtotime($data['dateYesGastric']));?>" <?php if(!isset($data['yesNoColonoscopy']) || $data['yesNoColonoscopy'] != "y") echo "disabled"; ?>>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12 label-body">ผล</label>
                        <div class="col-md-12">
                            <textarea class="form-control yesGastricComponent" rows="3" name="resultCameraYesGastricEmptying" <?php if(!isset($data['yesNoColonoscopy']) || $data['yesNoColonoscopy'] != "y") echo "disabled"; ?> ><?php if(isset($data['resultYesGastric']) && $data['yesNoGastric'] == "y") echo $data['resultYesGastric']; else echo "";?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-anorectalmanometry" <?php if(isset($data['dateAnorectal'])) echo "checked"?>> Anorectal manometry</label></div>
                        <div class="col-md-4">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-10">
                                <input type="text" class="form-control check-anorectalmanometry-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="anorectal_manometry[]"  value="<?php if(isset($data['dateAnorectal'])) echo date("d/m/Y", strtotime($data['dateAnorectal']));?>" <?php if(!isset($data['dateAnorectal'])) echo "disabled"?>>
                            </div>
                        </div>
                        <div class="col-md-2"><label class="checkbox-inline"><input type="checkbox" class="check-anorectalmanometry-component" name="anorectal_manometry[]" <?php if(isset($data['animus_anorectal'])) echo "checked"?> <?php if(!isset($data['dateAnorectal'])) echo "disabled"?>> anismus</label></div>
                        <div class="col-md-2"><label class="checkbox-inline"><input type="checkbox" class="check-anorectalmanometry-component" name="anorectal_manometry[]" <?php if(isset($data['normal_anorectal'])) echo "checked"?> <?php if(!isset($data['dateAnorectal'])) echo "disabled"?>> normal</label></div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Other</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-anorectalmanometry-component" name="anorectal_manometry[]" value="<?php if(isset($data['other_anorectal'])) echo $data['other_anorectal']?>" <?php if(!isset($data['dateAnorectal'])) echo "disabled"?>></div>
                        </div>
                        <div class="col-md-5 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">BET</label></div>
                            <div class="col-md-3 destroy-padding-left"><input type="text" class="form-control check-anorectalmanometry-component" name="anorectal_manometry[]" value="<?php if(isset($data['bet_anorectal'])) echo $data['bet_anorectal']?>" <?php if(!isset($data['dateAnorectal'])) echo "disabled"?>></div>
                            <div class="col-md-2 destroy-padding-left"><label class="label-body padding-top-seven">min</label></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">S1</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-anorectalmanometry-component" name="anorectal_manometry[]" value="<?php if(isset($data['s1_anorectal'])) echo $data['s1_anorectal']?>" <?php if(!isset($data['dateAnorectal'])) echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">S2</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-anorectalmanometry-component" name="anorectal_manometry[]" value="<?php if(isset($data['s2_anorectal'])) echo $data['s2_anorectal']?>" <?php if(!isset($data['dateAnorectal'])) echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">S3</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-anorectalmanometry-component" name="anorectal_manometry[]" value="<?php if(isset($data['s3_anorectal'])) echo $data['s3_anorectal']?>" <?php if(!isset($data['dateAnorectal'])) echo "disabled"?>></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-colonic-transit" <?php if(isset($data['dateColonic'])) echo "checked"?>> Colonic transit time (CTT)</label></div>
                        <div class="col-md-4">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-10">
                                <input type="text" class="form-control check-colonic-transit-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="date_colonic_transit" value="<?php if(isset($data['dateColonic'])) echo date("d/m/Y", strtotime($data['dateColonic']));?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-12 destroy-padding-right"><label class="label-body padding-top-seven">Day 1</label></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Rt</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-colonic-transit-component" name="colonic_transit_day1[]" value="<?php if(isset($data['rt_day1'])) echo $data['rt_day1']?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Dt</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-colonic-transit-component" name="colonic_transit_day1[]" value="<?php if(isset($data['dt_day1'])) echo $data['dt_day1']?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>></div>
                        </div>
                        <div class="col-md-3 margin-top-ten">
                            <div class="col-md-4"><label class="label-body padding-top-seven">Sigmoid</label></div>
                            <div class="col-md-8"><input type="text" class="form-control check-colonic-transit-component" name="colonic_transit_day1[]" value="<?php if(isset($data['sigmoid_day1'])) echo $data['sigmoid_day1']?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">R</label></div>
                            <div class="col-md-8 destroy-padding-left"><input type="text" class="form-control check-colonic-transit-component" name="colonic_transit_day1[]" value="<?php if(isset($data['r_day1'])) echo $data['r_day1']?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-12 destroy-padding-right"><label class="label-body padding-top-seven">Day 3</label></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Rt</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-colonic-transit-component" name="colonic_transit_day3[]" value="<?php if(isset($data['rt_day3'])) echo $data['rt_day3']?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Dt</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-colonic-transit-component" name="colonic_transit_day3[]" value="<?php if(isset($data['dt_day3'])) echo $data['dt_day3']?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>></div>
                        </div>
                        <div class="col-md-3 margin-top-ten">
                            <div class="col-md-4"><label class="label-body padding-top-seven">Sigmoid</label></div>
                            <div class="col-md-8"><input type="text" class="form-control check-colonic-transit-component" name="colonic_transit_day3[]" value="<?php if(isset($data['sigmoid_day3'])) echo $data['sigmoid_day3']?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">R</label></div>
                            <div class="col-md-8 destroy-padding-left"><input type="text" class="form-control check-colonic-transit-component" name="colonic_transit_day3[]" value="<?php if(isset($data['r_day3'])) echo $data['r_day3']?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-12 destroy-padding-right"><label class="label-body padding-top-seven">Day 5</label></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Rt</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-colonic-transit-component" name="colonic_transit_day5[]"  value="<?php if(isset($data['rt_day5'])) echo $data['rt_day5']?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Dt</label></div>
                            <div class="col-md-10"><input type="text" class="form-control check-colonic-transit-component" name="colonic_transit_day5[]"  value="<?php if(isset($data['dt_day5'])) echo $data['dt_day5']?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>></div>
                        </div>
                        <div class="col-md-3 margin-top-ten">
                            <div class="col-md-4"><label class="label-body padding-top-seven">Sigmoid</label></div>
                            <div class="col-md-8"><input type="text" class="form-control check-colonic-transit-component" name="colonic_transit_day5[]"  value="<?php if(isset($data['sigmoid_day5'])) echo $data['sigmoid_day5']?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>></div>
                        </div>
                        <div class="col-md-2 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">R</label></div>
                            <div class="col-md-8 destroy-padding-left"><input type="text" class="form-control check-colonic-transit-component" name="colonic_transit_day5[]"  value="<?php if(isset($data['r_day5'])) echo $data['r_day5']?>" <?php if(!isset($data['dateColonic'])) echo "disabled"?>></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 margin-top-ten"><label class="checkbox-inline"><input type="checkbox" class="check-biofeedback" <?php if(isset($data['date1_biofeedback'])) echo "checked"?>> Biofeedback</label></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">ทำครั้งที่ 1 วันที่</label></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control check-biofeedback-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="biofeedback[]" value="<?php if(isset($data['date1_biofeedback'])) echo date("d/m/Y", strtotime($data['date1_biofeedback']));?>" <?php if(!isset($data['date1_biofeedback'])) echo "disabled"?>>
                            </div>
                        </div>
                        <div class="col-md-6 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">ทำครั้งที่ 2 วันที่</label></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control check-biofeedback-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="biofeedback[]" value="<?php if(isset($data['date2_biofeedback'])) echo date("d/m/Y", strtotime($data['date2_biofeedback']));?>"  <?php if(!isset($data['date1_biofeedback'])) echo "disabled"?>>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">ทำครั้งที่ 3 วันที่</label></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control check-biofeedback-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="biofeedback[]" value="<?php if(isset($data['date3_biofeedback'])) echo date("d/m/Y", strtotime($data['date3_biofeedback']));?>" <?php if(!isset($data['date1_biofeedback'])) echo "disabled"?>>
                            </div>
                        </div>
                        <div class="col-md-6 margin-top-ten">
                            <div class="col-md-4 destroy-padding-right"><label class="label-body padding-top-seven">ทำครั้งที่ 4 วันที่</label></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control check-biofeedback-component datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="biofeedback[]" value="<?php if(isset($data['date4_biofeedback'])) echo date("d/m/Y", strtotime($data['date4_biofeedback']));?>" <?php if(!isset($data['date1_biofeedback'])) echo "disabled"?>>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-antroduodenal" <?php if(isset($data['yesNoAntroduodenal'])) echo "checked"?> > Antroduodenal manometry</label></div>
                        <div class="col-md-2"><label class="radio-inline"><input type="radio" class="check-antroduodenal-component" id="noAntroduodenal" name="yesNoAntroduodenal" value="noAntroduodenal" <?php if(isset($data['yesNoAntroduodenal']) && $data['yesNoAntroduodenal'] == "n") echo "checked"?> <?php if(!isset($data['yesNoAntroduodenal'])) echo "disabled"?>> ไม่เคย</label></div>
                        <div class="col-md-1"><label class="radio-inline"><input type="radio" class="check-antroduodenal-component" id="yesAntroduodenal" name="yesnoAntroduodenal" value="yesAntroduodenal" <?php if(isset($data['yesNoAntroduodenal']) && $data['yesNoAntroduodenal'] == "y") echo "checked"?> <?php if(!isset($data['yesNoAntroduodenal'])) echo "disabled"?>> เคย</label></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 margin-top-ten">
                            <div class="col-md-3 destroy-padding-right"><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-9 destroy-padding-left">
                                <input type="text" class="form-control yesAntroduodenalComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesAntroduodenal" value="<?php if(isset($data['dateAntroduodenal'])) echo date("d/m/Y", strtotime($data['dateAntroduodenal']));?>" <?php if(!isset($data['yesNoAntroduodenal']) || $data['yesNoAntroduodenal'] != "y") echo "disabled"?>>
                            </div>
                        </div>
                        <div class="col-md-8 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Findings</label></div>
                            <div class="col-md-10 destroy-padding-left"><input type="text" class="form-control yesAntroduodenalComponent" name="findYesAntroduodenal" value="<?php if(isset($data['findAntroduodenal'])) echo $data['findAntroduodenal']?>" <?php if(!isset($data['yesNoAntroduodenal']) || $data['yesNoAntroduodenal'] != "y") echo "disabled"?>></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-pudendal" <?php if(isset($data['yesNoPudendal'])) echo "checked"?> > Pudendal nerve latency test</label></div>
                        <div class="col-md-2"><label class="radio-inline"><input type="radio" class="check-pudendal-component" id="noPudendal" name="yesNoPudendal" value="noPudendal" <?php if(isset($data['yesNoPudendal']) && $data['yesNoPudendal'] == "n") echo "checked"?> <?php if(!isset($data['yesNoPudendal'])) echo "disabled"?>> ไม่เคย</label></div>
                        <div class="col-md-1"><label class="radio-inline"><input type="radio" class="check-pudendal-component" id="yesPudendal" name="yesnoPudendal" value="yesPudendal" <?php if(isset($data['yesNoPudendal']) && $data['yesNoPudendal'] == "y") echo "checked"?> <?php if(!isset($data['yesNoPudendal'])) echo "disabled"?>> เคย</label></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 margin-top-ten">
                            <div class="col-md-3 destroy-padding-right"><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-9 destroy-padding-left">
                                <input type="text" class="form-control yesPudendalComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesPudendal" value="<?php if(isset($data['datePudendal'])) echo date("d/m/Y", strtotime($data['datePudendal']));?>" <?php if(!isset($data['yesNoPudendal']) || $data['yesNoPudendal'] != "y") echo "disabled"?>>
                            </div>
                        </div>
                        <div class="col-md-8 margin-top-ten">
                            <div class="col-md-2 destroy-padding-right"><label class="label-body padding-top-seven">Findings</label></div>
                            <div class="col-md-10 destroy-padding-left"><input type="text" class="form-control yesPudendalComponent" name="findYesPudendal" value="<?php if(isset($data['findPudendal'])) echo $data['findPudendal']?>" <?php if(!isset($data['yesNoPudendal']) || $data['yesNoPudendal'] != "y") echo "disabled"?>></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <div class="col-md-3"><label class="checkbox-inline"><input type="checkbox" class="check-breath-test" <?php if(isset($data['yesNoBreath'])) echo "checked"?> > Breath test</label></div>
                        <div class="col-md-2"><label class="radio-inline"><input type="radio" class="check-breath-test-component" id="noBreathTest" name="yesNoBreathTest" value="noBreathTest" <?php if(isset($data['yesNoBreath']) && $data['yesNoBreath'] == "n") echo "checked"?> <?php if(!isset($data['yesNoBreath'])) echo "disabled"?>> ไม่เคย</label></div>
                        <div class="col-md-1"><label class="radio-inline"><input type="radio" class="check-breath-test-component" id="yesBreathTest" name="yesnoBreathTest" value="yesBreathTest" <?php if(isset($data['yesNoBreath']) && $data['yesNoBreath'] == "y") echo "checked"?> <?php if(!isset($data['yesNoBreath'])) echo "disabled"?>> เคย</label></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 margin-top-ten">
                            <div class="col-md-3 destroy-padding-right"><label class="label-body padding-top-seven">วันที่</label></div>
                            <div class="col-md-9 destroy-padding-left">
                                <input type="text" class="form-control yesBreathTestComponent datepicker" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-language="th" name="dateYesBreathTest" value="<?php if(isset($data['dateBreath'])) echo date("d/m/Y", strtotime($data['dateBreath']));?>" <?php if(!isset($data['yesNoBreath']) || $data['yesNoBreath'] != "y") echo "disabled"?>>
                            </div>
                        </div>
                        <div class="col-md-2 margin-top-ten"><label class="radio-inline"><input type="radio" class="yesBreathTestComponent" name="breathTest" value="negativeBreathTest" <?php if(isset($data['negPos_breath']) && $data['negPos_breath'] == "n") echo "checked"?> <?php if(!isset($data['yesNoBreath']) || $data['yesNoBreath'] != "y") echo "disabled"?>> Negative</label></div>
                        <div class="col-md-2 margin-top-ten"><label class="radio-inline"><input type="radio" class="yesBreathTestComponent" name="breathTest" value="positiveBreathTest" <?php if(isset($data['negPos_breath']) && $data['negPos_breath'] == "y") echo "checked"?> <?php if(!isset($data['yesNoBreath']) || $data['yesNoBreath'] != "y") echo "disabled"?>> Positive</label></div>
                    </div>
                </div>

                <div class="col-md-12 margin-top-twenty">
                    <div class="row">
                        <div class="col-md-12"><label class="label-body">อื่นๆ</label></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><textarea class="form-control" rows="5" placeholder="โปรดระบุ" name="otherResultTreatment"><?php if(isset($data['other_result'])) echo $data['other_result']?></textarea></div>
                    </div>
                </div>
            </div>

            <div class="row padding-bottom-fifty">
                <div class="col-md-2 col-md-offset-10">
                    <button type="button" id="save-button" class="btn btn-block btn-default">Save</button>
                </div>
            </div>

        </form>
        <script>
            $("#save-button").click(function(){
                var dataJson = $("#form-header,#form-body").serializeArray();

                $.ajax({
                    url: "patientData.php",
                    type: 'post',
                    data: dataJson,
                    success: function(dat){
                        console.log(dat);
                        var json = JSON.parse(dat)
                        console.log(json['patientFirstName']);
                    }
                });
            });
        </script>

<!--        <form class="form-horizontal" id="form-body">-->
<!--            --><?php ////generateNurseForm(); ?>
<!--        </form>-->
    </div>
    <script>

        $(document).ready(function(){
            if(getUrlVars()["q"] == "search"){
                $("#form-body").slideDown(1000);
            }

            $(".datepicker").datepicker();

            $("#indicator").focus(function(){
               $("#indicator-text").removeAttr("disabled");
            });

            $(".indicator-check").focus(function(){
                $("#indicator-text").attr("disabled",true);
            });

            $(".yesECD").focus(function(){
                $(".yesECDComponent").removeAttr("disabled");
            });

            $(".noECD").focus(function(){
                $(".yesECDComponent").attr("disabled",true);
            });

            $(".yesColonoscopy").focus(function(){
                $(".yesColonoscopyComponent").removeAttr("disabled");
            });

            $(".noColonoscopy").focus(function(){
                $(".yesColonoscopyComponent").attr("disabled",true);
            });


            $(".yesEsophagogram").focus(function(){
                $(".yesEsophagogramComponent").removeAttr("disabled");
            });

            $(".noEsophagogram").focus(function(){
                $(".yesEsophagogramComponent").attr("disabled",true);
            });


            $(".yesEsophagel").focus(function(){
                $(".yesEsophagelComponent").removeAttr("disabled");
            });

            $(".noEsophagel").focus(function(){
                $(".yesEsophagelComponent").attr("disabled",true);
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

            $(".yesGastric").focus(function(){
                $(".yesGastricComponent").removeAttr("disabled");
            });

            $(".noGastric").focus(function(){
                $(".yesGastricComponent").attr("disabled",true);
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
                    $(".check-antroduodenal-component").removeAttr("disabled");
                    if($("#yesAntroduodenal").prop('checked') == true){
                        $(".yesAntroduodenalComponent").removeAttr("disabled");
                    }
                }else{
                    $(".check-antroduodenal-component").attr("disabled",true);
                    $(".yesAntroduodenalComponent").attr("disabled",true);
                }
            });

            $("#yesAntroduodenal").focus(function(){
                $(".yesAntroduodenalComponent").removeAttr("disabled");
            });

            $("#noAntroduodenal").focus(function(){
                $(".yesAntroduodenalComponent").attr("disabled",true);
            });

            $(".check-pudendal").change(function(){
                if($(".check-pudendal").prop('checked') == true){
                    $(".check-pudendal-component").removeAttr("disabled");
                    if($("#yesPudendal").prop('checked') == true){
                        $(".yesPudendalComponent").removeAttr("disabled");
                    }
                }else{
                    $(".check-pudendal-component").attr("disabled",true);
                    $(".yesPudendalComponent").attr("disabled",true);
                }
            });

            $("#yesPudendal").focus(function(){
                $(".yesPudendalComponent").removeAttr("disabled");
            });

            $("#noPudendal").focus(function(){
                $(".yesPudendalComponent").attr("disabled",true);
            });

            $(".check-breath-test").change(function(){
                if($(".check-breath-test").prop('checked') == true){
                    $(".check-breath-test-component").removeAttr("disabled");
                    if($("#yesBreathTest").prop('checked') == true){
                        $(".yesBreathTestComponent").removeAttr("disabled");
                    }
                }else{
                    $(".check-breath-test-component").attr("disabled",true);
                    $(".yesBreathTestComponent").attr("disabled",true);
                }
            });

            $("#yesBreathTest").focus(function(){
                $(".yesBreathTestComponent").removeAttr("disabled");
            });

            $("#noBreathTest").focus(function(){
                $(".yesBreathTestComponent").attr("disabled",true);
            });

        });

    </script>
</body>
</html>