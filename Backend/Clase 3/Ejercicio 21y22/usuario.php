<?php

/*Recibe los datos del usuario(clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder verificar si es un usuario registrado,
Retorna un :
“Verificado” si el usuario existe y coincide la clave también.
“Error en los datos” si esta mal la clave.
“Usuario no registrado si no coincide el mail“
Hacer los métodos necesarios en la clase usuario*/

class Usuario
{
	public $nombre;
	public $clave;
	public $mail;
	public $id = 0;
	public $fechaRegistro;

	public function __construct($name,$pass,$email)
	{
		$this->nombre=$name;
		$this->clave=$pass;
		$this->mail=$email;
		$this->id++;
		$this->fechaRegistro=date('m-d-Y h:i:s a', time());
	}

	public static function ChequearDatos($name,$pass,$email, $user){
		if($user->nombre == $name && $user->clave == $pass){
			return 1;
		}else if($user->nombre == $name){
			return 0;
		}else{
			return -1;
		}
	}

	public static function Login($name,$pass,$email){
		foreach(Usuario::LeerCSV("usuarios.csv") as $u){
			//echo $u->nombre;
			//echo $name;
			if(Usuario::ChequearDatos($name,$pass,$email,$u) == 1){
				echo "Verificado";
				return;
			}else if(Usuario::ChequearDatos($name,$pass,$email,$u) == 0){
				echo "Error en los datos";
				return;
			}
		}

		echo "Usuario no registrado";

	}

	public static function GuardarUsuario($usuario){
        $miArchivo = fopen("usuarios.csv","w");
        if(file_exists("usuarios.csv")){
            fwrite($miArchivo,ManejadorArchivos::ConvertToCSV($usuario));
            fclose($miArchivo);
            return true;
        }

        return false;
    }

    public static function ConvertToCSV($usuario){
        return "$usuario->nombre,$usuario->mail,$usuario->clave\n";
    }

    public static function LeerCSV($archivo){
        $file = fopen($archivo, "r");
        $devolver = array();
        while (($arAux = fgetcsv($file)) !== FALSE) 
		{
			$userAux= new Usuario($arAux[0],$arAux[1],$arAux[2]);
			array_push($devolver, $userAux);
		}

        fclose($file);
		return $devolver;
    }

	public static function MostrarUsuariosLista($usuarios){
		echo '<ul>';

		foreach($usuarios as $u){
			echo '<li>';
			echo "$u->nombre,$u->mail,$u->clave\n";
			echo '</li>';
		}

		echo '</ul>';
	}

	public static function GuardarJSON($usuario){
		//$archivo = fopen("usuarios.json", "a");
		$array = (array) $usuario;
		$jsonUser = json_encode($array);
		file_put_contents("usuarios.json", $jsonUser, FILE_APPEND);
	}

}


?>