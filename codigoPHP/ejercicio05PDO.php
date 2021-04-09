<!Doctype HTML>
<html>
    <head>
        <title>Cristina Manjon</title>
        <meta charset="UTF-8">
        <meta name="author" content="Cristina Manjon Lacalle">
        
    </head>
    <body>
        
 <?php 


        require_once '../config/configDBPDO_1&1.php';                          //Importamos la conexion a la base de datos
        
            try {
               
                $miDB = new PDO(HOST,USER,PASSWORD);                            //Establecer una conexión con la base de datos 
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //La clase PDO permite definir la fórmula que usará cuando se produzca un error, utilizando el atributo PDO::ATTR_ERRMODE
                    
                    //Creo las ariables de las consultas y las PREPARO para en un futuro ejecutarlas
                    $consulta1 =$miDB->prepare("INSERT INTO Departamento(CodDepartamento, DescDepartamento, VolumenNegocio) VALUES('COM' , 'Departamento de comercio',5)");
                    $consulta2 =$miDB->prepare("INSERT INTO Departamento(CodDepartamento, DescDepartamento, VolumenNegocio) VALUES('ING' , 'Departamento de ingles',15)");
                    $consulta3 =$miDB->prepare("INSERT INTO Departamento(CodDepartamento, DescDepartamento, VolumenNegocio) VALUES('EMP' , 'Departamento de empresa',20)");
                    
                    //Como es mas de una sentencia desactivo el modo autocommit
                    $miDB->beginTransaction();                                      
                    
                    //Ejecuto todas la consultas 
                    $consulta1->execute();
                    $consulta2->execute();
                    $consulta3->execute();
              
                    //Si se han ejecutado y no ha saltado ningun error hare el commit
                    $miDB->commit();                                            
                    
                    //Muestro un mensaje de que todo se ha ejecutado perfectamente
                    echo "<p>La inserccion de los registros se ha hecho correctamente</p>";
                    
                    
                    
                    //--------------------MUESTRO LA TABLA----------------------
                    $consulta = "SELECT * FROM Departamento";                   //Guardamos en la variable la consulta que queremos hacer
                    $resultadoConsulta = $miDB->prepare($consulta);               //Guardamos en resultado la consulta y la base de datos en la que se va a ejecutar
                    $resultadoConsulta->execute();                              //Ejecutamos la consulta
                    echo "<p><strong>Codigo  | Descripcion  | Volumen </strong></p>"; //Muestro la tabla
                    while ($oDepartamento = $resultadoConsulta->fetchObject()) {//El fetchObject obtiene la siguiente fila(o la fila buscada si coincide) y la devuelve como objeto.
                        echo "$oDepartamento->CodDepartamento     | ";              
                        echo "$oDepartamento->DescDepartamento    | ";
                        echo "$oDepartamento->VolumenNegocio   <br>";
                   
                    }
                

                echo "<p style='background-color: lightgreen;'> SE HA ESTABLECIDO LA CONEXION </p><br>"; //Salta el mensaje de conexion establecida   
            
            }catch (PDOException $e) {                                          //Pero se no se ha podido ejecutar saltara la excepcion
                $miDB->rollback();                                              //Si hubo error revierte los cambios
                $error = $e->getCode();                                         //guardamos en la variable error el error que salta
                $mensaje = $e->getMessage();                                    //guardamos en la variable mensaje el mensaje del error que salta
                
                echo "ERROR $error";                                            //Mostramos el error
                echo "<p style='background-color: coral>Se ha producido un error! .$mensaje</p>"; //Mostramos el mensaje de error

            }finally{                                                           //Para finalizar cerramos la base de datos
                unset($miDB);
            }
                
            ?>

        <!--        Ultima modificacion 09-04-2021     --> 
        <!--        No los he copiado, los he hecho yo -->
  
    </body>
</html>


