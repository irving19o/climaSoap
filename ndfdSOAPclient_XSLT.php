<?php

function getmicrotime() 
{ 
   list($usec, $sec) = explode(" ", microtime()); 
   return ((float)$usec + (float)$sec); 
}
 function object_2_array($resultado)
{
  $array[] = array();
  foreach ($result as $key=>$value)
  {
    if (is_object($value))
    {
      $array[$key]=object_2_array($value);
      return $array;
    }
    else
    {
      $array[$key]=$value;
    }
  }
  
}

//header("Content-Type: text/xml");



$parametros = array('latitude' => $_GET['lat'],
                    'longitude'  => $_GET['lon'],
                    'startDate' => $_GET['startDate'],
                    'numDays' => $_GET['numDays'],
                    'Unit' => $_GET['Unit'],
                    'format' => $_GET['format']);


$cliente = new SoapClient('ndfdXML.wsdl');




try{
  $resultado = $cliente->__soapCall("NDFDgenByDay",$parametros);

  $xml = simplexml_load_string($resultado);
     foreach($xml->data->parameters as $parametro)
     {
      for($i=0; $i<2; $i++)
      {
        echo $parametro->temperature[$i]->attributes()->type." temperature <br>";
        foreach($parametro->temperature[$i]->value as $temperatura)
        {
          echo $temperatura."<br>";
        }
       
      }  
     }
      function xml_attribute($object, $attribute)
{
    if(isset($object[$attribute]))
        return (string) $object[$attribute];
}
        
  } catch (SoapFault $fault) {
    echo "Error: " , $fault->faultcode, ", string: ", $fault->faultstring;
  }
?>
