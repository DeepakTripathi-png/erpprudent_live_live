<?php 

function pr($data,$exit = 0)
{
        echo("<pre>");

        print_r($data);
        echo("</pre>");

        if($exit == 1){
        	exit;
        }
}
function convertDateTime($value =''){
	return new DateTime($value);
}

function display_no_character($value = ''){
	if($value == "" ||  $value == null ){
		$value = "--";
	}
	return $value;
}


function is_valid_array($data = []){
	if(count($data) > 0 && is_array($data)){
		return true;
	}
	return false;
}


function digitalSignature($file_path = '',$location = '',$signer = '',$certpwd ='',$certid='',$customerPrefix='',$digital_signature_url = ''){
	// checksum = sha256 (APIKEY + timestamp)
	// uuid = generate unique in your system
	// signloc = location for signature
	// signannotation = approved ny name  
	// uploadfile = upload pdf
	// certid = certificate id (Shared by Truecopy once it’s configured on your domain
	// certpwd = corresponding certificate password
	// timestamp = The time at the instant of signing expressed as: DDMMYYYYHH:mm:ss NOTE: The timestamp should be in sync with IST
	// signer = identifier of the signer account that is being used to sign. Shared by Truecopy

	// Endpoint URL
	$url = $digital_signature_url;
	// Parameters to be sent in the request

	// $file_path = "/var/www/html/extra_work/true_copy/salary_slip.pdf";
	$absolute_path = realpath($file_path);

	$file = new CURLFile($absolute_path, mime_content_type($absolute_path), basename($absolute_path));

	$api_key = "72ACC113118AA458";
	$time = (int) date("i");
	$current_timestamp = date("dmYH").":".($time+30).date(":s");
	$checksum = hash('sha256', $api_key.$current_timestamp);
	$uuid = "AROM".mt_rand(1000000000, 9999999999);
	$fields = array(
	    'certid' => $certid,
	    'certpwd' => $certpwd,
	    'uuid' => $uuid,
	    'timestamp' => $current_timestamp,
	    'checksum' => $checksum,
	    'signer' => $signer,
	    'uploadfile' => $file,
	    'signloc' => $location,
	    'signannotation' => 'Approved by ABC',
	    'hidetick' => 'true',
	    'signsize' => ''
	);
	// Initialize cURL session
	$ch = curl_init();

	// Set the cURL options
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// Execute the cURL session
	$response = curl_exec($ch);

	// Check for errors
	if(curl_errno($ch)) {
	    echo 'Error: ' . curl_error($ch);
	}

	// Close cURL session
	curl_close($ch);
	// Print the response from the server
	// echo $response;	
	$myfile = fopen($file_path, "w") or die("Unable to open file!");
	fwrite($myfile, $response);
	fclose($myfile);
	// exit();
}
function formateFormDate($date =''){
	$date=date_create($date);
	$date = date_format($date,"Y-m-d");
	return $date;
}


?>