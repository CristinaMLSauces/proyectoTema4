<!Doctype HTML>
<html>
    <head>
        <title>Cristina Manjon</title>
        <meta charset="UTF-8">
        <meta name="author" content="Cristina Manjon Lacalle">
        
    </head>
    <body>
        <h3>Conexión a la base de datos con la cuenta usuario y tratamiento de errores</h3>
       <?php 
        require_once '../config/configDBPDO.php';
            //Establecer una conexión con la base de datos 
            $miDB = new PDO(HOST,USER,PASSWORD);
            //La clase PDO permite definir la fórmula que usará cuando se produzca un error, utilizando el atributo PDO::ATTR_ERRMODE
            //Le ponemos de parametro - > PDO::ERRMODE_EXCEPTION. Cuando se produce un error lanza una excepción utilizando el manejador propio PDOException.
            //https://www.php.net/manual/es/pdo.error-handling.php
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //https://www.php.net/manual/es/pdo.constants.php
       try {
        $aAtributos=[
            "AUTOCOMMIT",
            "CASE",
            "CLIENT_VERSION",
            "CONNECTION_STATUS",
            "DRIVER_NAME",
            "ERRMODE",
            "ORACLE_NULLS",
            "PERSISTENT",
            "SERVER_INFO",
            "SERVER_VERSION",
            "CLIENT_VERSION",
            "ERRMODE",
         
           
        ];
        
            foreach( $aAtributos as $resultado){                                //Recorremos el array de atributos
                echo "<strong> PDO::ATTR_$resultado </strong>";                 //Enucuiamos el atributo que vamos a mostrar
                echo $miDB->getAttribute(constant("PDO::ATTR_$resultado"))."<br>";  //Lo mostramos
            }
        
            echo "<p style='background-color: lightgreen;'> SE HA ESTABLECIDO LA CONEXION </p><br>";  //Si no ha habido ningun error se muestra la conexion establecida
        
        
       } 
       catch (PDOException $e) {     //Pero se no se ha podido ejecutar saltara la excepcion
        $error = $e->getCode();      //guardamos en la variable error el error que salta
        $mensaje = $e->getMessage(); //guardamos en la variable mensaje el mensaje del error que salta

        echo "ERROR $error";        //Mostramos el error
        echo "<p style='background-color: coral>Se ha producido un error! $mensaje</p>"; //Mostramos el mensaje de error
        
        }finally{           //Para finalizar cerramos la base de datos
            unset($miDB);
        }

        
        
  //------------------CON CONEXION ERRONEA------------------------
  

       try {
           
            //Establecer una conexión con la base de datos 
            $miDB = new PDO(HOST,USER,'PASSWORD');
            //La clase PDO permite definir la fórmula que usará cuando se produzca un error, utilizando el atributo PDO::ATTR_ERRMODE
            //Le ponemos de parametro - > PDO::ERRMODE_EXCEPTION. Cuando se produce un error lanza una excepción utilizando el manejador propio PDOException.
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //Creamos el array con los posibles atributos de PDO   
            //https://www.php.net/manual/es/pdo.getattribute.php
            
        $aAtributos=[
            "AUTOCOMMIT",
            "CASE",
            "CLIENT_VERSION",
            "CONNECTION_STATUS",
            "DRIVER_NAME",
            "ERRMODE",
            "ORACLE_NULLS",
            "PERSISTENT",
            "SERVER_INFO",
            "SERVER_VERSION",
            "CLIENT_VERSION",
            "TIMEOUT",
            "ERRMODE",
            
           ];
        
            foreach( $aAtributos as $resultado){
                echo "<strong> PDO::ATTR_$resultado </strong>";
                echo $miDB->getAttribute(constant("PDO::ATTR_$resultado"))."<br>";
            }
        
            echo "<p style='background-color:ligthgreen;'> SE HA ESTABLECIDO LA CONEXION </p>";
        
        
       } 
       catch (PDOException $e) {
        $error = $e->getCode();
        $mensaje = $e->getMessage();

        echo "ERROR $error";
        echo "<p style='background-color:coral;'>Se ha producido un error! $mensaje</p>";
        
        }finally{
            unset($miDB);
        }   
        
        
       ?>
        
    </body>
</html>

