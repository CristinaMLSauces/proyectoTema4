<!Doctype HTML>
<html>
    <head>
        <title>Cristina Manjon</title>
        <meta charset="UTF-8">
        <meta name="author" content="Cristina Manjon Lacalle">
        
    </head>
    <body>
        
 <?php 


        require_once '../config/configDBPDO.php';                               //Importamos la conexion a la base de datos
        $ok = true;
            try {
               
                $miDB = new PDO(HOST,USER,PASSWORD);                            //Establecer una conexión con la base de datos 
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //La clase PDO permite definir la fórmula que usará cuando se produzca un error, utilizando el atributo PDO::ATTR_ERRMODE

                $miDB->beginTransaction();                                      //Deshabilita el modo autocommit

                    $consulta1 = "INSERT INTO Departamento(CodDepartamento, DescDepartamento, VolumenNegocio) VALUES('COM' , 'Departamento de comercio',5)";
                    $consulta2 = "INSERT INTO Departamento(CodDepartamento, DescDepartamento, VolumenNegocio) VALUES('ING' , 'Departamento de ingles',15)";
                    $consulta3 = "INSERT INTO Departamento(CodDepartamento, DescDepartamento, VolumenNegocio) VALUES('EMP' , 'Departamento de empresa',20)";
                    if($miDB->exec($consulta1) == 0) $ok = false;
                    if($miDB->exec($consulta2) == 0) $ok = false;
                    if($miDB->exec($consulta3) == 0) $ok = false;
              
                if ($ok){
                    echo "<p>La inserccion de los registros se ha hecho correctamente</p>";
                    
                    $miDB->commit();                                            // Si todo fue bien confirma los cambios
                    
                    //--------------------Muetsro la tabla----------------------
                    $consulta = "SELECT * FROM Departamento";                   //Guardamos en la variable la consulta que queremos hacer
                    $resultadoConsulta = $miDB->query($consulta);               //Guardamos en resultado la consulta y la base de datos en la que se va a ejecutar
                    $resultadoConsulta->execute();                              //Ejecutamos la consulta
                    echo "<p><strong>Codigo  | Descripcion  | Volumen </strong></p>"; //Muestro la tabla
                    while ($odepartamento = $resultadoConsulta->fetchObject()) {//El fetchObject obtiene la siguiente fila(o la fila buscada si coincide) y la devuelve como objeto.
                        echo "$odepartamento->CodDepartamento     | ";              
                        echo "$odepartamento->DescDepartamento    | ";
                        echo "$odepartamento->VolumenNegocio   <br>";
                   
                    }
                }else{ 
                    $dwes->rollback();                                          //Si algo fue mal revierte los cambios
                    echo "<p>No se han podido realizar los cambios.</p>";

                }

                echo "<p style='background-color: lightgreen;'> SE HA ESTABLECIDO LA CONEXION </p><br>"; //Salta el mensaje de conexion establecida   
            
            }catch (PDOException $e) {                                          //Pero se no se ha podido ejecutar saltara la excepcion
                $error = $e->getCode();                                         //guardamos en la variable error el error que salta
                $mensaje = $e->getMessage();                                    //guardamos en la variable mensaje el mensaje del error que salta

                echo "ERROR $error";                                            //Mostramos el error
                echo "<p style='background-color: coral>Se ha producido un error! .$mensaje</p>"; //Mostramos el mensaje de error

            }finally{                                                           //Para finalizar cerramos la base de datos
                unset($miDB);
            }
                
            ?>

        <!--        Ultima modificacion 08-04-2021--> 
  
    </body>
</html>


