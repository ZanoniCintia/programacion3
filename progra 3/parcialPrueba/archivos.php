<?php
class File
{
    public static function SerializarObjeto($file,$object)
    {
        $response= false;
        $pFile = fopen($file,'a+');
        if ($pFile!=false || $pFile!=null)
        {
            $rta = fwrite($pFile,serialize($object). '@');
            if ($rta>0)
            {
                $response=true;
            }
        }
        fclose($pFile);
        return $response;
    }

    public static function DeserializarObjeto($file)
    {
        $response=false;
        $pFile=fopen($file,'r');
        if ($pFile!=false)
        {
            $serializado=fread($pFile,filesize($file));
            $var=explode('@',$serializado);
            $array = array();
            foreach ($var as $string)
            {
                $object = unserialize($string);
                if ($object != false)
                {
                    array_push($array,$object);
                }
            }
            $response=$array;
        }
        fclose($pFile);
        return $response;
    }

    public static function GuardarTxt($file,$object)
    {
        $response=false;
        $pFile = fopen($file,'a+');
        if ($pFile != null)
        {
            $rta = fwrite($pFile,serialize($object). PHP_EOL);
            var_dump($rta);
            if ($rta>0)
            {
                $response = true;
            }        
        }
        fclose($pFile);   
        return $response;
    }

    public static function TraerTxt($file)
    {
        $pFile = fopen($file,'r');
        $response = false;
        if(!is_null($pFile))
        {
            $response = array();
            while(!feof($pFile))
            {
                $var = fgets($pFile);
                array_push($response,unserialize($var));
            }           
            
            array_pop($response);
        }
        fclose($pFile);

        return $response;
    }

    public static function TraerJSON($archivo)
    {
        $file = fopen($archivo, 'a+');
        if(filesize($archivo)!=0)
        {
            $arrayString = fread($file, filesize($archivo));
            $arrayJSON = json_decode($arrayString);
            fclose($file);
            return $arrayJSON;
        }else{
            fclose($file);
            return NULL;
        }
    }

    public static function guardarJSON($archivo, $objeto)
    {
        $arrayJson= File::TraerJSON($archivo);
        if (is_null($arrayJson))
        {
            $arrayJson = array();
        }
        array_push($arrayJson, $objeto);
        $file = fopen($archivo, 'w');
        $rta = fwrite($file, json_encode($arrayJson));
        fclose($file);
        return $rta;
    }

    public static function reemplazarJSON($archivo,$objeto)
    {
        $file = fopen($archivo, 'w');
        $rta = fwrite($file, json_encode($objeto));
        fclose($file);
        return $rta;
    }
    
    public static function leerJSONtxt($archivo, $mode = 'r')
    {
        $file = fopen($archivo, $mode);

        $rta = fgets($file);


        fclose($file);
        return $rta;
    }

}

?>