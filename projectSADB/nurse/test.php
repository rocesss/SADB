<?php
$json = $_SERVER['QUERY_STRING'];
parse_str($json);
echo $json;

?>