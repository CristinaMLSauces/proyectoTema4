<!Doctype HTML>
<html>
    <head>
        <title>Cristina Manjon</title>
        <meta charset="UTF-8">
        <meta name="author" content="Cristina Manjon Lacalle">
        
    </head>
    <body>
        
 <?php 

        require_once '../config/configDBPDO_1&1.php';                           //Importamos la conexion a la base de datos
       
            try {
               
                $miDB = new PDO(HOST,USER,PASSWORD);                            //Establecer una conexión con la base de datos 
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //La clase PDO permite definir la fórmula que usará cuando se produzca un error, utilizando el atributo PDO::ATTR_ERRMODE

                $consulta = "Select * from Departamento";                       //Guardo la consulta en una variable
                $resultadoconsulta=$miDB->prepare($consulta);                   // Para las consultas preparadas utilizo prepare
                $resultadoconsulta->execute();                                  // Ejecutamos la consulta
                
                //https://www.php.net/manual/es/class.domdocument.php
                $documentoXML = new DOMDocument("1.0", "utf-8");                //Creamos un nuevo docuemtno xml, 
                $documentoXML->formatOutput = true;                             //Da formato a la salida con identación y espacios extra.
                
                $root = $documentoXML ->createElement("Departamentos");         //Creo el nodo raiz 
                $documentoXML ->appendChild($root);                             //Agrega un hijo a una lista existente de hijos o crea una nueva lista de hijos
                
                
                $oDepartamento = $resultadoconsulta->fetchObject();             //Posiciona el puntero en la primera linea y lo devuelve como objeto
                
                while($oDepartamento){                                          //Recorremos lo que devuelve la consulta
                $departamento = $root->appendChild($documentoXML->createElement('Departamento'));  //Creo el nodo de departamento
                $departamento->appendChild($documentoXML->createElement('CodDepartamento',$oDepartamento->CodDepartamento)); //Voy guardando los hijos del nodo en el documento xml
                $departamento->appendChild($documentoXML->createElement('DescDepartamento',$oDepartamento->DescDepartamento));
                $departamento->appendChild($documentoXML->createElement('FechaBaja',$oDepartamento->FechaBaja));
                $departamento->appendChild($documentoXML->createElement('VolumenNegocio',$oDepartamento->VolumenNegocio));
                $oDepartamento = $resultadoconsulta->fetchObject();             //lo guardo como objeto y avanzo el puntero
            }
                
            
                if($documentoXML->save("../tmp/Departamento.xml")){ 
                    echo "<p style='color:green;'>EXPORTACION REALIZADA CORRECTAMENTE</p>";
                    highlight_file("../tmp/Departamento.xml");
                    //header("Content-Disposition: attachment; filename=" . "Departamentos.xml"); // Descargar el fichero a local
                }else{
                    echo "<p style='color:red;'>ERROR EN LA EXPORTACION</p>";
                }
                
                
                
            }catch (PDOException $e) {                                          //Pero se no se ha podido ejecutar saltara la excepcion
                $error = $e->getCode();                                         //guardamos en la variable error el error que salta
                $mensaje = $e->getMessage();                                    //guardamos en la variable mensaje el mensaje del error que salta

                echo "ERROR $error";                                            //Mostramos el error
                echo "<p style='background-color: coral>Se ha producido un error! .$mensaje</p>"; //Mostramos el mensaje de error

            }finally{                                                           //Para finalizar cerramos la base de datos
                unset($miDB);
            }
                
            ?>

         
  
    </body>
</html>


