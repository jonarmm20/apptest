<?php 
	include_once($_SERVER['DOCUMENT_ROOT']."/scangoo/config/connection.php");

/**
 * 
 */
class Login extends Connection
{
	
	function __construct()
	{
		parent::__construct();
	}

	function login($user, $clave){

		$sql = "SELECT * FROM administradores where usuario = '$user';";
		$usuario = $this->getREG($sql);
		if (is_array($usuario)) {
			$clave = $this->JM_encrypt($clave);
				if ($usuario['clave']== $clave) {
					$_SESSION['login'] = $usuario['usuario'];
					$_SESSION['user'] = array(
										"nombres"=>$usuario['nombres'],
										"apellidos"=>$usuario['apellidos']
										);
				

			}else{ echo "Clave Incorrecta";}

		}else{ echo "Usuario Incorrecta";}
		
	}

	function logout(){
		session_start();
		unset($_SESSION['login']);
		unset($_SESSION['user']);
		session_destroy();
	}

}

 ?>