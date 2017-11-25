<html lang="es">
    
    <head>
        <title>Panel - Matriz</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="images/png" href="Imagenes/Favicon.ico" />
        
        <!-- Ficheros CSS -->
        <!-- General -->
        <link rel="stylesheet" type="text/css" href="CSS/fuentes.css" />
        <link rel="stylesheet" type="text/css" href="CSS/Logo.css" />
        <link rel="stylesheet" type="text/css" href="CSS/iconos.css" />
        <link rel="stylesheet" type="text/css" href="CSS/indicadores.css" />
        <link rel="stylesheet" type="text/css" href="CSS/tablas.css" />
        <link rel="stylesheet" type="text/css" href="CSS/cola.css" />
        <!-- Maquetacion -->
        <link rel="stylesheet" type="text/css" href="CSS/maqueta.css" />
        <link rel="stylesheet" type="text/css" href="CSS/maquetaObjetivo.css" />

        
        <!-- Librerias Javascript -->
        <script type="text/javascript" src="JavaScript/menu.js"></script>
        <script type="text/javascript" src="JavaScript/direccionar.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    
    
    <body> 
        

        <div class="Cabezera">
    
                <?php
                    
                include "..\Conexion\AccesoConsultoriaEjemplo.php";
                
                $sqlTitulo = "SELECT * FROM dbo.OBJETIVO_GENERAL";
                
                foreach ($conn->query($sqlTitulo) as $row) {
                    echo '<div class="CabezeraTitulo">Objetivos de '.$row[1].'</div>';
                    echo '<div class="CabezeraFecha">Del '.$row[3].' al '.$row[5].'</div>';
                }
                
                include "..\Conexion\CerrarConexion.php";
                
                ?>
            
            <div class="CabezeraLogo"><div class="Work">Work</div><div class="Matriz">Matriz</div></div>

        </div>
        
        <div class="Cuerpo">
            
            <div class="Estadisticas">
                
                <?php
                
                $filasObjetivos = 0;
                $columnasObjetivos = 17;
                $arrayObjetivos = array();
                
                include "..\Conexion\AccesoConsultoriaEjemplo.php";
                
                $sqlObjetivos = "SELECT * FROM dbo.OBJETIVO_DATOS ORDER BY FE_INICIO ASC, FE_FIN ASC";
                foreach ($conn->query($sqlObjetivos) as $row) {
                    
                    for($i=0;$i<=$columnasObjetivos;$i++){
                        $arrayObjetivos[$filasObjetivos][$i]=$row[$i];
                    }
                    $filasObjetivos++;
                }
                
                $sqlProgreso = "SELECT PORCENTAJE_PROGRESO FROM dbo.OBJETIVO_GENERAL";
                foreach ($conn->query($sqlProgreso) as $rowProgreso) {
                }
                
                include "..\Conexion\CerrarConexion.php";
                
                echo '<table>';
                echo '<th colspan="5">Detalle de los objetivos</th>';
                echo '<tr>';
                echo '<td class="tdTituloObjetivo"><div class="tablaObjetivoth">Objetivo</div></td>';
                echo '<td class="tdTituloIndicador"><div class="tablaObjetivoth">Estado</div></td>';
                echo '<td class="tdTituloIndicador"><div class="tablaObjetivoth">Progreso</div></td>';
                echo '<td class="tdTituloIndicador"><div class="tablaObjetivoth">Hitos</div></td>';
                echo '<td class="tdTituloCronograma"><div class="tablaObjetivoth">Cronograma</div></td>';
                echo '</tr>';
                
                for($i=0;$i<$filasObjetivos;$i++){
                    //Tipo objetivo
                    echo '<tr>';
                    echo '<td class="tdTipoObjetivo" colspan="5"><div class="Objetivo">'.$arrayObjetivos[$i][1].'</div></td>';
                    echo '</tr>';
                    
                    //Nombre del objetivo
                    echo '<tr>';
                    echo '<td id="Objetivo-'.$arrayObjetivos[$i][0].'" onclick=direccionar(this.id) class="tdObjetivo"><div class="Ejecucion">'.$arrayObjetivos[$i][2].'</div></td>';
                    
                    //Estado del objetivo
                    echo '<td class="tdIndicador">'.$arrayObjetivos[$i][8].'</td>';

                    //Progreso
                    if($arrayObjetivos[$i][8]==='No iniciado'){
                        echo '<td class="tdIndicador"><div class="IndicadorGris">- %</div></td>';
                    }
                    if($arrayObjetivos[$i][8]!='No iniciado'){
                        if($arrayObjetivos[$i][10]>=$arrayObjetivos[$i][11]){
                            echo '<td class="tdIndicador"><div class="IndicadorVerde">'.$arrayObjetivos[$i][10].' %</div></td>';
                        } else {
                            echo '<td class="tdIndicador"><div class="IndicadorRojo">'.$arrayObjetivos[$i][10].' %</div></td>';
                        }
                    }
                    //Semáforo
                    if($arrayObjetivos[$i][8]==='No iniciado'){
                        echo '<td class="tdIndicador"><div class="SemaforoGris"></div></td>';
                    }
                    if($arrayObjetivos[$i][8]!='No iniciado'){
                        if($arrayObjetivos[$i][10]>=$arrayObjetivos[$i][11]){
                            echo '<td class="tdIndicador"><div class="SemaforoVerde"></div></td>';
                        } else {
                            echo '<td class="tdIndicador"><div class="SemaforoRojo"></div></td>';
                        }
                    }
                    
                    //Cronograma
                    //En curso y con progreso mayor que el tiempo
                    if($arrayObjetivos[$i][10]>=$arrayObjetivos[$i][11] && $arrayObjetivos[$i][8]==='En curso'){
                       echo '<td class="tdCronograma"><div class="hrTemporal" style="margin-left: '.$arrayObjetivos[$i][14].'%; width: '.$arrayObjetivos[$i][17].'%"></div><div class="hrTemporalPlus" style="margin-left: '.$rowProgreso[0].'%; margin-right: '.$arrayObjetivos[$i][15].'%"></div><div class="hrProgresoVerde" style="margin-left: '.$arrayObjetivos[$i][14].'%; width: '.$arrayObjetivos[$i][16].'%"></div></td>'; 
                    } 
                    //Acabada en tiempo y en progreso
                    elseif($arrayObjetivos[$i][8]==='Acabado' && $arrayObjetivos[$i][10]==='100.0'){
                       echo '<td class="tdCronograma"><div class="hrTemporalAcabado" style="margin-left: '.$arrayObjetivos[$i][14].'%; width: '.$arrayObjetivos[$i][16].'%"></div><div class="hrProgresoVerde" style="margin-left: '.$arrayObjetivos[$i][14].'%; width: '.$arrayObjetivos[$i][16].'%"></div></td>'; 
                    }
                    //Que vaya tarde y no este acabada en tiempo
                    elseif($arrayObjetivos[$i][10]<$arrayObjetivos[$i][11] && $arrayObjetivos[$i][8]==='En curso'){
                       echo '<td class="tdCronograma"><div class="hrTemporal" style="margin-left: '.$arrayObjetivos[$i][14].'%; width: '.$arrayObjetivos[$i][17].'%"></div><div class="hrTemporalPlus" style="margin-left: '.$rowProgreso[0].'%; margin-right: '.$arrayObjetivos[$i][15].'%"></div><div class="hrProgresoRojo" style="margin-left: '.$arrayObjetivos[$i][14].'%; width: '.$arrayObjetivos[$i][16].'%"></div></td>'; 
                    }
                    //Acabada en tiempo pero tarde
                    elseif($arrayObjetivos[$i][8]==='Acabado' && $arrayObjetivos[$i][10]<$arrayObjetivos[$i][11]){
                       echo '<td class="tdCronograma"><div class="hrTemporalAcabado" style="margin-left: '.$arrayObjetivos[$i][14].'%; margin-right: '.$arrayObjetivos[$i][15].'%"></div><div class="hrProgresoRojo" style="margin-left: '.$arrayObjetivos[$i][14].'%; width: '.$arrayObjetivos[$i][16].'%"></div></td>'; 
                    }
                    //No iniciadas
                    else {
                       echo '<td class="tdCronograma"><div class="hrTemporalPlus" style="margin-left: '.$arrayObjetivos[$i][14].'%; margin-right: '.$arrayObjetivos[$i][15].'%"></div></td>';
                    }

                    echo '</tr>';
                    
                }
                
                echo '</table>';
                
                
                ?>
                
            </div>
        
        </div>
        
        <div class="Cola">
            <div class="TextoCola">Matriz</div>
            <a href="https://www.linkedin.com/company/11270469/" class="fa fa-linkedin"></a>
            <a href="mailto:caguilar@matrizconsulting.com" class="fa fa-envelope"></a> 
        </div>
           
    </body>
        
</html>

