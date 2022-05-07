<?php
    class manejador_archivos{
        public static function GuardarJSON($array,$nombreArchivo){

            $success = false;
            $file = fopen($nombreArchivo, "w");
            if ($file) {
                $json = json_encode($array, JSON_PRETTY_PRINT);
                fwrite($file, $json);
                $success = true;
            }
    
        }

        public static function LeerJson($archivo){
            if(file_exists($archivo)){
                $file = fopen($archivo, "r");
                $json = fread($file, filesize($archivo));
                $array = json_decode($json, true);

                return $array;
            }else{
                return array();
            }
        }

        public static function LeerCSV($archivo){
            $file = fopen($archivo, "r");
            $archivoDevolver=null;
            while(!feof($file)){
                $archivoDevolver = fgets($file);
            }
    
            fclose($file);
            return $archivoDevolver;
        }

        public static function UltimoID($archivo, $idEmpezar = 0){
            if(!empty(manejador_archivos::LeerJson($archivo))){
                return $idEmpezar + count(manejador_archivos::LeerJson($archivo));
            }

            return $idEmpezar;
        }
    }

?>