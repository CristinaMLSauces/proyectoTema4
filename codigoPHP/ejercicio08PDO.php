<!Doctype HTML>
<html>
    <head>
        <title>Cristina Manjon</title>
        <meta charset="UTF-8">
        <meta name="author" content="Cristina Manjon Lacalle">
        
    </head>
    <body>
        
 <?php 

        require_once '../config/configDBPDO_1&1.php';                               //Importamos la conexion a la base de datos
       
        //PRIMERA PARTE INTENTANMOS LA CONEXION CON LA BASE DE DATOS Y SI NO FUNCIONA CAPTURA EL ERROR
            try {
               
                $miDB = new PDO(HOST,USER,PASSWORD);                            //Establecer una conexión con la base de datos 
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //La clase PDO permite definir la fórmula que usará cuando se produzca un error, utilizando el atributo PDO::ATTR_ERRMODE
            
            }catch (PDOException $e) {                                          //Pero se no se ha podido ejecutar saltara la excepcion
                $error = $e->getCode();                                         //guardamos en la variable error el error que salta
                $mensaje = $e->getMessage();                                    //guardamos en la variable mensaje el mensaje del error que salta

                echo "ERROR $error";                                            //Mostramos el error
                echo "<p style='background-color: coral>Se ha producido un error! .$mensaje</p>"; //Mostramos el mensaje de error
                
            }
            
        //SEGUNDA PARTE , IMPORTAMOS EL ARCHIVO XML PARA QUE SE SUBA TODO Y SI DA FALLO HACEMOS UN ROLLBACK
            
            //---------PRIMERO CREAMOS LA ESTRUCTURA DE LA TABLA------------------
            try{                                                               //Preparamos la consulta de crear la tabla
                $consultaBorrar = $miDB->prepare('TRUNCATE Departamento');
                $consultaBorrar->execute();                                      //Ejecutamos la consulta
                
            //-------- LUEGO CARGAMOS LOS DATOS DE LA TABLA---------
   
                $miDB->beginTransaction();                                      //Desctivamos el modo 'autocommit'.
                $consultaInsertar = 'INSERT INTO Departamento VALUES (:CodDepartamento, :DescDepartamento,:FechaBaja,:VolumenNegocio)';   //Guardamos en la variable la consulta que vamos a ir ejecutando
            
                $resultadoConsulta = $miDB->prepare($consultaInsertar);         // Prepara la consulta de Insertar
                
                //https://www.php.net/manual/es/book.dom.php
                $documentoXML = new DOMDocument("1.0", "utf-8");                //Instanciamos un objeto de la clas DOM
                $documentoXML ->load("../tmp/Departamento.xml");               //Con load podemos cargar el archivo desde la ruta especificada
                
                //getElementsByTagName Esta función devuelve una nueva instancia de la clase DOMNodeList que contiene los elementos con el nombre de etiqueta local buscado.
                //https://www.php.net/manual/es/domdocument.getelementsbytagname.php
                $numeroDepartamentos = $documentoXML->getElementsByTagName('Departamento')->count(); // saca el numero de elementos Departamento que hay en el documento xml
                
                for ($numeroDepartamento = 0; $numeroDepartamento<$numeroDepartamentos; $numeroDepartamento++){                         //utilizando el numero de departamentos los recorro con un for
                                                                                                                                        //nodeValue se utiliza para obtener el valor de este nodo
                    $CodDepartamento=$documentoXML->getElementsByTagName("CodDepartamento")->item($numeroDepartamento)->nodeValue;      //Guarda el valor del elemento cógido de departamento
                    $DescDepartamento=$documentoXML->getElementsByTagName("DescDepartamento")->item($numeroDepartamento)->nodeValue;    //Guarda el valor del elemento de la descripción 
                    $FechaBaja=$documentoXML->getElementsByTagName("FechaBaja")->item($numeroDepartamento)->nodeValue;                  //Guarda el valor del elemento de la fecha de baja
                    
                    if(empty($FechaBaja)){                                      //Si el elemento de la feha de baja está vacío
                        $FechaBaja = null;                                      //Le asignamos el valor de null para que no de error a la hora de insertar en la base de datos
                    }
                    $VolumenNegocio=$documentoXML->getElementsByTagName("VolumenNegocio")->item($numeroDepartamento)->nodeValue;        //Guardamos el valor del elemento del volumen de negocio
                    
                    //Asignamos al array parametros los diferentes valores de los campos guardados
                    $parametros = [":CodDepartamento" => $CodDepartamento,
                                   ":DescDepartamento" => $DescDepartamento,
                                   ":FechaBaja" => $FechaBaja,
                                   ":VolumenNegocio" => $VolumenNegocio];
                    $resultadoConsulta -> execute($parametros);//Ejecutamos la consulta con los parámetros

                }
                 $miDB->commit();                                               //Hacemos commit con los cambios
                echo "<p style='color:green;'>IMPORTACION REALIZADA CORRECTAMENTE</p>";
              
             //----------Y POR ULTIMO MUESTRO LA TABLA------------   
                
                
            $consultaSelect = "SELECT * FROM Departamento"; //Guardamos en la variable la consulta que queremos hacer
            $resultadoConsulta = $miDB->query($consultaSelect); //Guardamos en resultado la consulta y la base de datos en la que se va a ejecutar
            $resultadoConsulta->execute(); //Ejecutamos la consulta
            
            //No se hace con un exec por que no es una consulta de actulizacion
            echo "Número de registros en la tabla Departamento: " .$resultadoConsulta->rowCount(); //Si la última sentencia SQL ejecutada por el objeto PDOStatement asociado fue una sentencia SELECT, algunas bases de datos podrían devolver el número de filas devuelto por dicha sentencia.
            
            echo "<p><strong>Codigo  | Descripcion  | Volumen </strong></p>";
            $odepartamento = $resultadoConsulta->fetchObject(); 
            
            while ($odepartamento) {                                            //El fetchObject obtiene la siguiente fila y la devuelve como objeto.
                echo "<p>$odepartamento->CodDepartamento     |  ";              //Mostramos el reguistro de la fila de CodDepartamento
                echo " $odepartamento->DescDepartamento      |  ";
                echo " $odepartamento->VolumenNegocio    </p>";
             $odepartamento = $resultadoConsulta->fetchObject();
            }
 
            }catch (PDOException $excepcion) {                                  //Pero se no se ha podido ejecutar saltara la excepcion
                $miDB->rollBack();                                              //Hacemos el rollback por que si ha habido algun error en la insercion
                
                $error = $excepcion->getCode();                                 //guardamos en la variable error el error que salta
                $mensaje = $excepcion->getMessage();                            //guardamos en la variable mensaje el mensaje del error que salta

                echo "ERROR $error";                                            
                echo "<p style='background-color: coral;'>Se ha producido un error! .$mensaje</p>"; 

            }finally{                                                           //Para finalizar cerramos la base de datos
                unset($miDB);
            }
                
            ?>

         
  
    </body>
</html>


