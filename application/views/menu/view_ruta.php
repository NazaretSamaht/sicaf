<div class='span-24 last'>
    <?php
  
    $tipo_flujo=$real['tipo_flujo'];
    unset($real['tipo_flujo']);

    $new_real = array();
    foreach ($real as $row) {
        $new_real[$row['paso_hecho']] = $row;
    }

    #d($original, $new_real);

    $new_original = array();
    $j = 0;
    foreach ($original as $i => $row) {
        $cargo = $row['descar'];
        $data_paso = array(
            'paso' => $row['paso'],
            'estatus' => $row['estatus'],
            'nombre' => "Sin Realizar",
            'fecha' => NULL,
            'observacion' => NULL
        );
        #LLENAMOS EL PASO CON EL REGISTRO CORRESPODIENTE DE $REAL
        if (isset($new_real[$row['paso']])){
            $row_real = $new_real[$row['paso']];
            $data_paso['nombre'] = "{$row_real['nomper']} {$row_real['apeper']}";
            $data_paso['fecha'] = date('d/m/Y', strtotime($row_real['fecha']));
            $data_paso['observacion'] = $row_real['observacion'];
        }
        #LLENAR PASO ACTUAL PARA MARCAR DE AMARILLO ESE INDICE
        else if (! isset($paso_actual)){
            $paso_actual = $j - 1;
        }
        
        $new_original[$j][$cargo][] = $data_paso;
        if (isset($original[$i+1]) && $original[$i+1]['descar'] != $cargo){
            $j++;
        }
    }

    #d($new_original, $paso_actual);
    
     ?>

    <div class='span-24 last'>
        <span class="verde leyenda"><b>Paso Realizado</b></span>
        <span class="amarillo leyenda"><b>Paso Actual</b></span>
        <span class="gris leyenda"><b>Paso No Realizado</b></span>
    </div>
    <div class="container">
        
        <div id="timelineContainer" class="timelineContainer">
            <div class="timelineToggle"><p><a class="expandAll">Expandir Todos</a></p></div>
                <?php foreach ($new_original as $iActual => $arr): ?>
                    <?php foreach ($arr as $cargo => $rows): ?>
                        <?php 
                        if ($iActual < $paso_actual) #VERDE
                            $class = "verde";
                        else if ($iActual == $paso_actual) #AMARILLO
                            $class = "amarillo";
                        else #GRIS
                            $class = "gris";
                        ?>
                        <div class='timelineMajor'>
                            <h2 class='timelineMajorMarker'><span class='<?php echo $class ?> title-major'><b><?php echo $cargo ?></b></span></h2>
                            <?php foreach ($rows as $row): ?>
                            <dl class='timelineMinor'>
                                <dt id='<?php echo $row['paso'] ?>' class="title-minor"><a><?php echo $row['estatus'] ?></a></dt>
                                <dd class='timelineEvent' id='<?php echo $row['paso'] ?>EX' style='display:none;''>
                                    <p style='font-weight: bold;'>
                                        <?php echo "{$row['nombre']} {$row['fecha']}" ?></br>
                                        Observaci&oacute;n:<?php echo $row['observacion'] ?>
                                    </p>
                                    <br class='clear'>
                                </dd>
                            </dl>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <br class="clear">
        </div><!-- /#timelineContainer -->

        <br>
        <br>
</div>

<style type="text/css">
.verde{
    background:#e6efc2 !important; 
    color:#264409 !important; 
    border:2px solid #c6d880 !important;
}
.amarillo{
    background:#fff6bf !important; 
    color:#514721 !important; 
    border:2px solid #ffd324 !important;
}
.gris{
    background:#ccc !important; 
    color:#fff !important; 
    border:2px solid #808080 !important;
}
.leyenda{
    -webkit-border-radius: 4px !important; 
    padding:3px !important;
}
.title-major{
    font-size:18px !important;
    font-family: Arial, Helvetica, sans-serif !important;
}
.title-minor{
    font-size:14px !important;
}
</style>