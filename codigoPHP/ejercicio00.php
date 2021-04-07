<!Doctype HTML>
<html>
    <head>
        <title>Cristina Manjon</title>
        <meta charset="UTF-8">
        <meta name="author" content="Cristina Manjon Lacalle">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        
    </head>
    <body>

                <?php
        
           echo ("<p>SCRIPT DE CREAR</p>");
           echo highlight_file("../scriptDB/CrearDAW207DBDepartamentos.sql");
           echo ("<p>SCRIPT DE CARGA</p>");
           echo highlight_file("../scriptDB/CargaDAW207DBDepartamentos.sql");
           echo ("<p>SCRIPT DE BORRAR</p>");
           echo highlight_file("../scriptDB/BorraDAW207DBDepartamentos.sql");
           
        ?>
        
        
    </body>
</html>

