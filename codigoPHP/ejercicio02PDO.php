<!Doctype HTML>
<html>
    <head>
        <title>Cristina Manjon</title>
        <meta charset="UTF-8">
        <meta name="author" content="Cristina Manjon Lacalle">
        
    </head>
    <body>
        <h3>Conexión a la base de datos</h3>
       <?php 
        require_once '../config/configDBPDO.php';
        
            //Establecer una conexión con la base de datos 
            $miDB = new PDO(HOST,USER,PASSWORD);
                //La clase PDO permite definir la fórmula que usará cuando se produzca un error, utilizando el atributo PDO::ATTR_ERRMODE
                
                ////Le ponemos de parametro - > PDO::ERRMODE_EXCEPTION. Cuando se produce un error lanza una excepción utilizando el manejador propio PDOException.
                //https://www.php.net/manual/es/pdo.error-handling.php
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //https://www.php.net/manual/es/pdo.constants.php
       try {
         
            $consulta = "SELECT * FROM Departamento";           //Guardamos en la variable la consulta que queremos hacer
            $resultadoConsulta = $miDB->query($consulta);       //Guardamos en resultado la consulta y la base de datos en la que se va a ejecutar
            $resultadoConsulta->execute();                      //Ejecutamos la consulta
            
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
         echo "<p style='background-color: lightgreen;'> SE HA ESTABLECIDO LA CONEXION </p><br>";       //Salta el mensaje de conexion establecida      
            
       } 
       catch (PDOException $e) {     //Pero se no se ha podido ejecutar saltara la excepcion
        $error = $e->getCode();      //guardamos en la variable error el error que salta
        $mensaje = $e->getMessage(); //guardamos en la variable mensaje el mensaje del error que salta

        echo "ERROR $error";        //Mostramos el error
        echo "<p style='background-color: coral>Se ha producido un error! $mensaje</p>"; //Mostramos el mensaje de error
        
        }finally{           //Para finalizar cerramos la base de datos
            unset($miDB);
        }

   
        
        //Ultima modificacion 08-04-2021
        
       ?>
        
    </body>
</html>

