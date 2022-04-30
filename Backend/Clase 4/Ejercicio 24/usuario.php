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
	public $id;
	public $fechaRegistro;
	public $foto;

	public function __construct($name,$pass,$email,$nombreFoto=null)
	{
		$this->nombre=$name;
		$this->clave=$pass;
		$this->mail=$email;
		$this->id++;
		$this->fechaRegistro=date('m-d-Y h:i:s a', time());
		$this->foto = $nombreFoto;

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
        return "$usuario->nombre,$usuario->mail,$usuario->clave,$usuario->id,$usuario->foto\n";
    }

    public static function LeerCSV($archivo){
        $file = fopen($archivo, "r");
        $devolver = array();
        while (($arAux = fgetcsv($file)) !== FALSE) 
		{
			$userAux= new Usuario($arAux[0],$arAux[1],$arAux[2],$arAux[5]);
			array_push($devolver, $userAux);
		}

        fclose($file);
		return $devolver;
    }

	public static function LeerJson($archivo="usuarios.json"){
        if(file_exists($archivo)){
			$file = fopen($archivo, "r");

			$json = fread($file, filesize($archivo));
			$users = json_decode($json, true);
			return $users;
		}else{
			return array();
		}
    }

	public static function LeerJsonUsuarios($archivo="usuarios.json"){
        if(file_exists($archivo)){
			$file = fopen($archivo, "r");

			$json = fread($file, filesize($archivo));
			$users = json_decode($json, true);
			$arrayUsuarios = array();
			foreach($users as $u){
				$userAux = new Usuario($u["nombre"],$u["clave"],$u["mail"],$u["foto"]);
				array_push($arrayUsuarios,$userAux);
			}
			fclose($file);
			return $arrayUsuarios;
		}else{
			return array();
		}
    }

	public 	static function MostrarUsuariosLista($usuarios){
		echo '<ul>';
		$img = "<img src='fotos/";

		foreach($usuarios as $u){
			echo '<li>';
			echo "$u->nombre,$u->mail,$u->clave,$u->foto\n";
			$foto=$u->foto;
			echo $img.$u->foto."'>";
			echo '</li>';
		}

		echo '</ul>';
	}

	public static function GuardarJSON($usersArray){
		$success = false;
		$filename = "usuarios.json";
		$file = fopen($filename, "w");
		if ($file) {
			$json = json_encode($usersArray, JSON_PRETTY_PRINT);
			fwrite($file, $json);
			echo $json;
			$success = true;
		}

	}

}


?>