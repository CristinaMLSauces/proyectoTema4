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
        
        $ok = true;
            
                                                                                //Declaro el array fuera del try 
                $aDepnuevos[0]=["CodDepartamento" => "EEF",                     //Creo un array numerico y guardo los registros que voy a querer en cada indice del array
                                 "DescDepartamento" => "Departamento de educacion fisica",
                                 "VolumenNegocio" => 3];
            
                $aDepnuevos[1]=["CodDepartamento" => "NAT", 
                                 "DescDepartamento" => "Departamento de naturales",
                                 "VolumenNegocio" => 9];
            
                $aDepnuevos[2]=["CodDepartamento" => "CIE", 
                                 "DescDepartamento" => "Departamento de ciencia",
                                 "VolumenNegocio" => 10];
          
            try {
               
                $miDB = new PDO(HOST,USER,PASSWORD);                            //Establecer una conexión con la base de datos 
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //La clase PDO permite definir la fórmula que usará cuando se produzca un error, utilizando el atributo PDO::ATTR_ERRMODE

                $sql = 'INSERT INTO Departamento (CodDepartamento,DescDepartamento,VolumenNegocio) VALUES (:CodDepartamento, :DescDepartamento,:VolumenNegocio)'; //Guardo la consulta en una variable
               
                $consulta = $miDB->prepare($sql);                               //Con prepare dejamos preparada la consulta para ejecutarla en un futuro
                
                
                $miDB->beginTransaction();                                      //Quitamos el modo autocommit por que se ejecuta mas de una sentencia
                
                foreach($aDepnuevos as $departamento){ // recorro el array de departamentosnuevos 
                   $parametros = [ ":CodDepartamento" => $departamento['CodDepartamento'], // guardo en el elemento el valor del codigo de departamento del array $departamento dependiendo ed la posicion
                                ":DescDepartamento" => $departamento['DescDepartamento'],      // guardo en el elemento el valor de la descripcion del departamento del array $departamento dependiendo ed la posicion
                                ":VolumenNegocio" => $departamento['VolumenNegocio'] ];        // guardo en el elemento el valor del volumen de negocio del departamento del array $departamento dependiendo de la posicion
                
                    $consulta->execute($parametros); // ejecuto la consulta con los datos del departamento que esta en la posicion $nDepartamento
                }
                $miDB->commit();                                                //Hago commit para aplicar los cambios

                //--------------------Muestro la tabla----------------------
                $consulta = "SELECT * FROM Departamento";                   //Guardamos en la variable la consulta que queremos hacer
                $resultadoConsulta = $miDB->prepare($consulta);               //Guardamos en resultado la consulta y la base de datos en la que se va a ejecutar
                $resultadoConsulta->execute();                              //Ejecutamos la consulta
                echo "<p><strong>Codigo  | Descripcion  | Volumen </strong></p>"; //Muestro la tabla
                while ($oDepartamento = $resultadoConsulta->fetchObject()) {//El fetchObject obtiene la siguiente fila(o la fila buscada si coincide) y la devuelve como objeto.
                    echo "$oDepartamento->CodDepartamento     | ";              
                    echo "$oDepartamento->DescDepartamento    | ";
                    echo "$oDepartamento->VolumenNegocio   <br>";
                 }
                 
                echo "<p style='background-color: lightgreen;'> La insercion se ha hecho con exito</p><br>"; //Salta el mensaje de conexion establecida  
            }catch (PDOException $e) {
                $miDB->rollBack();                                              //Si no se han podido cargar todos los registros hacemos rollback
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


