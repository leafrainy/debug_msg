<?php
ini_set('display_errors',1);

include "Msg.class.php";

$config = array('CorpID' =>'xxxx' , 'Secret' =>'xxxxx');
$send = new Msg($config);

var_dump($send->sendMsg('要发的信息','要发给的人',应用id));

?>