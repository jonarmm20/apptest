<?php
include_once('config.php');

/**
 * 
 */
class Connection
{
	protected $db;
	function __construct()
	{
		$this->db = new mysqli(DB_HOST, DB_USER, DB_PASS);
		$this->db->select_db(DB_NAME);
		if ($this->db->connect_errno) {
			die('Connect Error: ' . $this->db->connect_errno);
			return;
		}
		$this->db->set_charset(DB_CHARSET);
	}


	public function executeSQL($sql)
	{
		$execute = $this->db->query($sql);
		return $this->affected();
	}

	public function getSQL($sql)
	{
		$execute = $this->db->query($sql);
		if ($this->affected() > 0) {
			return $array = $execute->fetch_all(MYSQLI_ASSOC);
		}
		return $this->affected();
	}

	public function getREG($sql)
	{
		$execute = $this->db->query($sql);
		if ($this->affected() > 0) {
			return $array = $execute->fetch_array(MYSQLI_ASSOC);
		}
		return $this->affected();
	}


	public function affected()
	{
		return $this->db->affected_rows;
	}

	function duplicate_user($usuario, $tabla){
		$sql = "SELECT * FROM $tabla WHERE usuario = '$usuario';";
		$duplicate = $this->executeSQL($sql);
		return $this->affected();
	}

	function duplicate_user_update($usuario, $tabla, $id){
		$sql = "SELECT * FROM $tabla WHERE usuario = '$usuario' AND id != '$id';";
		$duplicate = $this->executeSQL($sql);
		return $this->affected();
	}

	function duplicate_email($email, $tabla){
		$sql = "SELECT * FROM $tabla WHERE email = '$email';";
		$duplicate = $this->executeSQL($sql);
		return $this->affected();
	}

	function duplicate_email_update($email, $tabla, $id){
		$sql = "SELECT * FROM $tabla WHERE email = '$email' AND id != '$id';";
		$duplicate = $this->executeSQL($sql);
		return $this->affected();
	}

	function JM_encrypt($string)
	{
	    return $encrypt = openssl_encrypt($string, "AES-128-ECB", OPENSSL);
	}

	function JM_decrypt($string)
	{
	    return $decrypted = openssl_decrypt($string, "AES-128-ECB", OPENSSL);
	}

	function generar_psw($longitud = 10)
	{
		return $psswd = substr(microtime(), 1, $longitud);
	}

	function clean_string($string)
	{
		$string = str_ireplace("SELECT","",$string);
		$string = str_ireplace("COPY","",$string);
		$string = str_ireplace("DELETE","",$string);
		$string = str_ireplace("DROP","",$string);
		$string = str_ireplace("DUMP","",$string);
		$string = str_ireplace(" OR ","",$string);
		$string = str_ireplace("%","",$string);
		$string = str_ireplace("LIKE","",$string);
		// $string = str_ireplace("/","",$string);
		$string = str_ireplace("|","",$string);
		$string = str_ireplace("--","",$string);
		$string = str_ireplace("^","",$string);
		$string = str_ireplace("[","",$string);
		$string = str_ireplace("]","",$string);
		$string = str_ireplace("!","",$string);
		$string = str_ireplace("¡","",$string);
		$string = str_ireplace("?","",$string);
		$string = str_ireplace("=","",$string);
		$string = str_ireplace("&","",$string);
		$string = str_ireplace("<","",$string);
		$string = str_ireplace(">","",$string);
		// $string = str_replace("data:image/jpeg;base64,", "", $string);
		// $string = str_replace("data:image/png;base64,", "", $string);
		$string = str_ireplace("script","",$string);
		return trim($string);
	}

	function is_email($email)
	{
		 $matches = null;
  		return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $email, $matches));
	}

	function count_carcteres($str)
	{
		return strlen($str);
	}


}


		
?>