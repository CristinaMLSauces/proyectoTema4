<!Doctype HTML>
<html>
    <head>
        <title>Cristina Manjon</title>
        <meta charset="UTF-8">
        <meta name="author" content="Cristina Manjon Lacalle">
        
    </head>
    <body>
        
	
       <?php 
 
		echo "<h2>Conexion desde Entorno de desarollo</h2>";
                highlight_file("../config/configDBPDO.php");
		echo "<h2>Conexion desde Entorno de desarollo EN CASA</h2>";
		highlight_file("../config/configDBPDO_CASA.php");
		echo "<h2>Conexion desde Entorno de explotacion 1&1</h2>";
		highlight_file("../config/configDBPDO_1&1.php");
		
       ?>
   
    </body>
</html>
