<!Doctype HTML>
<html>
    <head>
        <title>Cristina Manjon</title>
        <meta charset="UTF-8">
        <meta name="author" content="Cristina Manjon Lacalle">

    </head>
    <body>
        <h3>Formulario e inserccion de datos en tabla</h3>
       <?php 
        require_once '../core/210322ValidacionFormularios.php';   //Importamos la libreria de validacion
        require_once '../config/configDBPDO_1&1.php';                               //Importamos la conexion a la base de datos
        
        
        $entradaOK = true;                                      //Declaramos una variable booleana para comprobar despues si se ejecuta la consulta
        
        $aErrores = [  'CodDepartamento' => null,               //Creamos el array de errores
                       'DescDepartamento' => null,];
        
        $aFormulario = [ 'CodDepartamento' => null,             //Creamos el array para guardar los datos que el usuario ha introducido
                         'DescDepartamento' => null,];
        
        if (isset($_POST['enviar'])) {                          //Si se ha pulsado el boton de enviar entonces :
            $CodDepartamento=$_REQUEST['CodDepartamento'];      //Guardamos en las variables el valor que han introducido en el formulario
            $DescDepartamento=$_REQUEST['DescDepartamento'];
            
            $aErrores['CodDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['CodDepartamento'], 3, 3, 1);  //Para validarlo le pones un min y max que coincida con ese campo
            $aErrores['DescDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['DescDepartamento'], 255, 1, 1); //Tambien le ponemos que el campo sera obligatorio con el 1 al final
            
            foreach($aErrores as $error){                       //Recorre el array en busca de errores, con que haya uno entra
                if($error != null){                
                   $entradaOK = false;                          //Y nos cambia la variable entrada a false
                }
            }
        }else{                                                  //Si el formulario no estaba completo, tambien cambiamos la entrada a false                                            
            $entradaOK = false;
        }
        
        if($entradaOK) {                                        //Si la variable entrada llega hasta aqui en true , entra
      
            //Como es un array asociativo podemos recorrelo con estos indices
            $aFormulario['CodDepartamento'] = strtoupper($_REQUEST['CodDepartamento']); //strtoupper devuelve el string con todos los caracteres alfabéticos convertidos a mayúsculas.
            $aFormulario['DescDepartamento'] = ucfirst($_REQUEST['DescDepartamento']);  //ucfirst devuelve una cadena con el primer caracter str en máyusculas, si el caracter es alfabético.
            
            try {
                //Establecer una conexión con la base de datos 
                $miDB = new PDO(HOST,USER,PASSWORD);
                //La clase PDO permite definir la fórmula que usará cuando se produzca un error, utilizando el atributo PDO::ATTR_ERRMODE
                //Le ponemos de parametro - > PDO::ERRMODE_EXCEPTION. Cuando se produce un error lanza una excepción utilizando el manejador propio PDOException.
                //https://www.php.net/manual/es/pdo.error-handling.php
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //-----------------------Hacemos la consulta-------------------------------------
                
//              
                $consulta = $miDB->prepare("INSERT INTO Departamento(CodDepartamento, DescDepartamento) VALUES('$CodDepartamento' ,'$DescDepartamento')");  //Preparamos al consulta y la guardamos en la variable
                $registrosConsulta =$consulta->execute();                                                      //Ejecutamos la consulta y en registrosconsulta guardamos las lineas afectadas en al tabla

                    if( $registrosConsulta >= 1){                //Si el numero de filas es por lo menos una , la inserccion se ha hecho
                        echo 'Inserción correcta <br>';
                    }
  
        //-------------------------Mostrar toda la tabla ----------------------------------           
                    
                $consulta = "SELECT * FROM Departamento";       //Guardamos en la variable la consulta que queremos hacer
                $resultadoConsulta = $miDB->prepare($consulta);   //Guardamos en resultado la consulta y la base de datos en la que se va a ejecutar
                $resultadoConsulta->execute();                  //Ejecutamos la consulta
            
                //No se hace con un exec por que no es una consulta de actulizacion
                echo "Número de registros en la tabla Departamento: " .$resultadoConsulta->rowCount(); 
                //Si la última sentencia SQL ejecutada por el objeto PDOStatement asociado fue una sentencia SELECT, algunas bases de datos podrían devolver el número de filas devuelto por dicha sentencia.
            
                echo "<p><strong>Codigo  | Descripcion  | Volumen </strong></p>";
                $oDepartamento = $resultadoConsulta->fetchObject(); 
                
                while ($oDepartamento) {                                    //El fetchObject obtiene la siguiente fila y la devuelve como objeto.
                    echo "<p>$oDepartamento->CodDepartamento     |  ";      //Mostramos el reguistro de la fila de CodDepartamento
                    echo " $oDepartamento->DescDepartamento      |  ";
                    echo " $oDepartamento->VolumenNegocio    </p>";
                    $oDepartamento = $resultadoConsulta->fetchObject();
                }
        //---------------------------Mostrar si la conexion se ha hecho------------------------------------
                
                echo "<p style='background-color: lightgreen;'> SE HA ESTABLECIDO LA CONEXION </p><br>"; //Salta el mensaje de conexion establecida      

        //----------------------------Cazar excepciones---------------------------------------        
                
            }catch (PDOException $e) {       //Pero se no se ha podido ejecutar saltara la excepcion
                $miDB->rollback();           //Si hubo error revierte los cambios
                $error = $e->getCode();      //guardamos en la variable error el error que salta
                $mensaje = $e->getMessage(); //guardamos en la variable mensaje el mensaje del error que salta

                echo "ERROR $error";         //Mostramos el error
                echo "<p style='background-color: coral>Se ha producido un error! .$mensaje</p>"; //Mostramos el mensaje de error
                //
        //---------------------------Cerrar la base de datos-----------------------------------
                
            }finally{                        //Para finalizar cerramos la base de datos
                unset($miDB);
            }
        } else {                             //Codigo que se ejecuta antes de rellenar el formulario o hay errores al enviar
            
        //------------------------------Formulario-------------------------------------------
            
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <fieldset style="width: 20%;">
                        <label>Código de Departamento Nuevo</label>
                        <input type = "text" name = "CodDepartamento" value=
                               "<?php if($aErrores['CodDepartamento'] == NULL && isset($_REQUEST['CodDepartamento'])){ echo $_REQUEST['CodDepartamento'];} ?>">
                                <?php if ($aErrores['CodDepartamento'] != NULL) { echo "   ⚠️".$aErrores['CodDepartamento'];} ?> <br> <br> <br>
                  

                        <label>Descripción Departamento Nuevo</label>
                        <input type = "text" name = "DescDepartamento" value=
                               "<?php if($aErrores['DescDepartamento'] == NULL && isset($_REQUEST['DescDepartamento'])){ echo $_REQUEST['DescDepartamento'];} ?>">
                                <?php if ($aErrores['DescDepartamento'] != NULL) { echo "   ⚠️".$aErrores['DescDepartamento'];}?>   <br><br>

                 
                        <input type="submit" name="enviar" value="Insertar">
                  
                </fieldset>
            </form>
        <?php } ?>  
  
        
        
        <!--        Ultima modificacion 09-04-2021-->
        <!--        No los he copiado, los he hecho yo -->
    </body>
</html>

