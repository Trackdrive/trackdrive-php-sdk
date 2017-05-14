<?php

	require_once "model.php";

	header('Content-Type: application/javascript');

	$td = new TrackDrive_API('username','TrackDrive_token');
	$response = array();
	$arrData = array();
	if(isset($_POST['operation'])){
		foreach($_POST as $k => $v){
		    if(is_int(stripos($k,'field-'))){ $arrData[] = array(str_ireplace("field-","",$k)=>$v); }
		}

		if(isset($_POST['secure_token'])){
			$_POST['type'] = "/secure/".$_POST['secure_token']."/".$_POST['type'];
		}

		if($_POST['operation'] == 'add'){
			$response = $td->add($_POST['type'],$arrData);

		}elseif($_POST['operation'] == 'edit'){
			$response = $td->edit($_POST['type'],$_POST['id'],$arrData);

		}elseif($_POST['operation'] == 'delete'){
			$response = $td->remove($_POST['type'],$_POST['id']);

		}else{
			$response = $td->view($_POST['type'],(isset($_POST['id'])?$_POST['id']: NULL),$arrData);
		}

	}else{
		foreach($_GET as $k => $v){
		    if(is_int(stripos($k,'field-'))){ 
		    	$arrData[] = array(str_ireplace("field-","",$k)=>$v); 
		    }
		}
		$response = $td->view($_GET['type'],(isset($_GET['id']) && strlen($_GET['id']) > 0 ?$_GET['id']: NULL),$arrData);
	}

	$td = null;

	if(isset($_GET['callback'])){
        echo $_GET['callback'].'('.json_encode($response).')';
    }else{
        echo json_encode($response);
    }

?>