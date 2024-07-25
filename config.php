<?php
$base_url 		= "http://localhost/www.ordermatix.com/apps/v2/";
$seller_url 	= 'x=v7dj45698=!as7k/';
$buyer_url 		= 'panel/';
$url 			= explode("/",$_SERVER["REQUEST_URI"]); 

/*
panduan URL:

1. notification: ntf[0]
2. ID: ntf[1]
3. pengacak: ntf[3]
*/
$ntf = explode("-", @$_GET['ntf']);

//set timezone jadi default
date_default_timezone_set('UTC');

//get filename
$url = $_SERVER['PHP_SELF'];
$filename = pathinfo(parse_url($url, PHP_URL_PATH));

//ini kalau mau ambil nama file aja
$file 	= $filename['filename'];

//ini kalau mau ambil extension. Kalau nggak mau extension, dicomment aja trs uncomment bawahnya
//$ext 	= '.'.$filename['extension'];
$ext 	= '';

//ini untuk query string URL
$param = explode("?", $_SERVER['REQUEST_URI']);

//echo $path_parts['dirname'];
//echo echo $path_parts['filename'];
//echo $path_parts['filename'];
//echo $path_parts['extension'];

//encrypt querystring
class Encryption{

    /**
    * 
    * Retourne la chaîne de caracère encodéé en MIME base64
    * ----------------------------------------------------
    * @param string
    * @return string
    *
    **/
    public static function safe_b64encode($string='') {
        $data = base64_encode($string);
        $data = str_replace(['+','/','='],['-','_',''],$data);
        return $data;
    }

    /**
    * 
    * Retourne la chaîne de caracère MIME base64 décodée
    * -------------------------------------------------
    * @param string
    * @return string
    *
    **/
    public static function safe_b64decode($string='') {
        $data = str_replace(['-','_'],['+','/'],$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    /**
    *
    * Crypte une chaîne de caractères avec un algorithme de cryptage aes-256 mode cbc
    * Le crypatage s'effectue avec une clé définie dans le fichier core.php
    * ------------------------------------------------------------------------------------------
    * @param string
    * @return string
    *
    **/
    public static function encode($value=false){ 
        if(!$value) return false;
        $iv_size = openssl_cipher_iv_length('aes-256-cbc');
        $iv = openssl_random_pseudo_bytes($iv_size);
        $crypttext = openssl_encrypt($value, 'aes-256-cbc', 'ayamgoreng', OPENSSL_RAW_DATA, $iv);
        return self::safe_b64encode($iv.$crypttext); 
    }

    /**
    *
    * Decrypte une chaîne de caractères
    * ---------------------------------
    * @param string
    * @return string
    *
    **/
    public static function decode($value=false){
        if(!$value) return false;
        $crypttext = self::safe_b64decode($value);
        $iv_size = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($crypttext, 0, $iv_size);
        $crypttext = substr($crypttext, $iv_size);
        if(!$crypttext) return false;
        $decrypttext = openssl_decrypt($crypttext, 'aes-256-cbc', 'ayamgoreng', OPENSSL_RAW_DATA, $iv);
        return rtrim($decrypttext);
    }
}


function input_data($data){
$filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
return $filter;
}

$db_server        = '127.0.0.1';
$db_user          = 'satukode_user_ikanku';
$db_password      = 'DatabaseIkanku@123';
$db_name          = 'satukode_db_ikanku';
$conn 			  = new mysqli($db_server,$db_user,$db_password,$db_name) or die (mysqli_error());
?>