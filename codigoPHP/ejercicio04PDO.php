<!Doctype HTML>
<html>
    <head>
        <title>Cristina Manjon</title>
        <meta charset="UTF-8">
        <meta name="author" content="Cristina Manjon Lacalle">
        
    </head>
    <body>
        
 <!--- Este ejercicio no necesita validacion de entrada, por lo que podemos quitar las partes de creacion de array de errores, y la parte de validar , y no 
 necesitamos la variable de entraOk por lo que podemos colocar nuestro formulario al principio para que se mantenga estatico , tampoco he creado un array para 
 solo declarar el campo de descripcion el programa solo hace la busqueda de la variable introducida y muestra donde esta con un select
 si dejaremos la excepcion para posibles errores a la hora de conectar con la base de datos--->
 
        <h3>Formulario de busqueda en la base de datos</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <fieldset style="width: 20%;"><br>

                    <label>Descripción Departamento</label>
                        <input type = "text" name = "DescDepartamento" value=
                            "<?php if (isset($_POST['DescDepartamento'])){ echo $_POST['DescDepartamento'];} ?>"><br><br>

                        <input type="submit" name="enviar" value="Buscar">
                </fieldset>
            </form>
        

       <?php 

        require_once '../core/210322ValidacionFormularios.php'; //Importamos la libreria de validacion
        require_once '../config/configDBPDO.php';//Importamos la conexion a la base de datos
                   
            $DescDepartamento = null;

            try {
               
                $miDB = new PDO(HOST,USER,PASSWORD);                            //Establecer una conexión con la base de datos 
                
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //La clase PDO permite definir la fórmula que usará cuando se produzca un error, utilizando el atributo PDO::ATTR_ERRMODE

            if (isset($_POST['enviar'])) {                                      //Cuando se pulsa el boton de buscar
                
                $DescDepartamento=$_REQUEST['DescDepartamento'];                //Guardamos en la variable lo que se ha introducido en el formulario
                                                                                //Tambien podriamos no guardar la variable y poner en la sentencia : '%{$_REQUEST['DescDepartamento']}%';";
                
                $consulta = "SELECT * FROM Departamento WHERE DescDepartamento LIKE '%$DescDepartamento%'";     //Guardamos en la variable la consulta que queremos hacer
                $resultadoConsulta = $miDB->query($consulta);                   //Como es una consulta de select utilizamos query, en $resultado consulta nos devuelve las filas afectadas 
                $resultadoConsulta->execute();                                  //Y luego la ejecutamos
              
                echo "<p><strong>Codigo  | Descripcion  | Volumen </strong></p>";
                       
                while ($odepartamento = $resultadoConsulta->fetchObject()) {    //El fetchObject obtiene la siguiente fila(o la fila buscada si coincide) y la devuelve como objeto.
                    echo "$odepartamento->CodDepartamento     | ";              
                    echo "$odepartamento->DescDepartamento    | ";
                    echo "$odepartamento->VolumenNegocio   <br>";
                 }
                    

            }
            echo "<p style='background-color: lightgreen;'> SE HA ESTABLECIDO LA CONEXION </p><br>"; //Salta el mensaje de conexion establecida   
            
            }catch (PDOException $e) {       //Pero se no se ha podido ejecutar saltara la excepcion
                $error = $e->getCode();      //guardamos en la variable error el error que salta
                $mensaje = $e->getMessage(); //guardamos en la variable mensaje el mensaje del error que salta

                echo "ERROR $error";         //Mostramos el error
                echo "<p style='background-color: coral>Se ha producido un error! .$mensaje</p>"; //Mostramos el mensaje de error

            }finally{                        //Para finalizar cerramos la base de datos
                unset($miDB);
            }
                
            ?>

         <!--        Ultima modificacion 08-04-2021-->
  
    </body>
</html>

