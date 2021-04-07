<!Doctype HTML>
<html>
    <head>
        <title>Cristina Manjon</title>
        <meta charset="UTF-8">
        <meta name="author" content="Cristina Manjon Lacalle">
        
    </head>
    <body>
        <h3>Conexión a la base de datos con la cuenta usuario y tratamiento de errores MYSQLi</h3>
       <?php 
            require_once '../config/configDBMySQLi.php';
            //Establecer una conexión con la base de datos 
            $miDB = new mysqli();
            //$miDB->connect('equipo','usuario','password','basededatos');
            $miDB->connect(HOST,USER,PASSWORD,DBNAME);
            //Para comprobar el error, en caso de que se produzca cambiamos la funcion con ese tipo de 'bandera' para que habilite las excepciones
            //https://www.php.net/manual/es/mysqli-driver.report-mode.php
            mysqli_report(MYSQLI_REPORT_STRICT);
            
            try {
                //https://www.php.net/manual/es/mysqli.summary.php
                 
                
                   $info = $miDB->client_info;
                   echo "<strong> mysqli_get_client_info</strong>";
                   echo $info;
                
                
               
                 echo "<p style='background-color: lightgreen;'> SE HA ESTABLECIDO LA CONEXION </p><br>"; //Salta el mensaje de conexion establecida
                 
                
               } catch(mysqli_sql_exception $miException) { //salta la excepcion y la guardamos en la variable $miExcepcion
                    $error = $miException->getCode();      //guardamos en la variable error el error que salta
                    $mensaje = $miException->getMessage(); //guardamos en la variable mensaje el mensaje del error que salta
                    
                   
                    echo "ERROR $error";        //Mostramos el error
                    echo "<p style='background-color: coral;'>".$mensaje."</p>"; //Mostramos el mensaje de error
                    exit();

                }
                finally{
                    
                    $miDB->close(); // Cierra la conexion con la base de datos
                    
                
       }
       
      
  

        
        
  //------------------CON CONEXION ERRONEA------------------------
       
       
       
 
            
            try {
                  //Establecer una conexión con la base de datos 
                  $miDB = new mysqli();
                  //$miDB->connect('equipo','usuario','password','basededatos');
                  $miDB->connect(HOST,USER,PASSWORD,'DBNAME');
                  //Para comprobar el error, en caso de que se produzca cambiamos la funcion con ese tipo de 'bandera' para que habilite las excepciones
                  //https://www.php.net/manual/es/mysqli-driver.report-mode.php
             
                      //https://www.php.net/manual/es/mysqli.summary.php
                 
                
                   $info = $miDB->client_info;
                   echo "<strong> mysqli_get_client_info</strong>";
                   echo $info;
                
                
               
                 echo "<p style='background-color: lightgreen;'> SE HA ESTABLECIDO LA CONEXION </p><br>"; //Salta el mensaje de conexion establecida
                 
                
               } catch(mysqli_sql_exception $miException) { //salta la excepcion y la guardamos en la variable $miExcepcion
                    $error = $miException->getCode();      //guardamos en la variable error el error que salta
                    $mensaje = $miException->getMessage(); //guardamos en la variable mensaje el mensaje del error que salta
                    
                   
                    echo "ERROR $error";        //Mostramos el error
                    echo "<p style='background-color: coral;'>".$mensaje."</p>"; //Mostramos el mensaje de error
                    exit();
                }
                finally{
                    
                    $miDB->close(); // Cierra la conexion con la base de datos
                    
             

       }
              
       ?>
        
    </body>
</html>

