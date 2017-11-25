<?php

   $serverName = "WIN-OUVEI4V1R4S\MATRIZWORK";  
   $database = "ConsultoriaEjemplo";  

   // Get UID and PWD from application-specific files.   
   $uid = file_get_contents("..\Credenciales\UIX_ConsultoriaEjemplo_Lectura.txt");  
   $pwd = file_get_contents("..\Credenciales\PWD_ConsultoriaEjemplo_Lectura.txt");

   try {  
      $conn = new PDO( "sqlsrv:server=$serverName;Database = $database", $uid, $pwd);   
      $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );   
   }  

   catch( PDOException $e ) {  
      die( "Error conectando a su base de datos" );   
   }  
   
 
?>