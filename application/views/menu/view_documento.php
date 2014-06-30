
<?php
    $header = array("Tipo de Procedimiento","Procedimiento", "Copias", "Recaudos", "Plazo de Entrega", "Estatus", "Opciones");
    $cad = "<tr>";
    foreach ($header as $arre)
        $cad.="<th>$arre</th>";

    $cad.="</tr>"
    ?>

    <div>
        <fieldset>
            <legend> <?php echo "C&oacute;digo de Solicitud: $id_solicitud </br>";?></legend>
        
            <?php 
               // var_dump($datos);
                echo "Solicitante: {$datos['nombre_apellido']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; C&eacute;dula: {$datos['cedula']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha de Solicitud: {$datos['fecha_solicitud']}";
            ?>
        </fieldset>
    </div>
    <body id="dt_example datatable">
        <input type="hidden" value="<?php echo $id_solicitud; ?>" id="id_solicitud">
        <div id="container" class="span-24 last">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="dt_documentos" width="100%">
                
                <thead>
                    <?php
                    echo $cad;
                    ?>
                    
                </thead>
                
                <thead id="search" class="ui-state-default" >
                    <tr>
                        <th><input type="text" name="search_engine" value="Buscar Tipo" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Procedimiento" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_browser" value="Buscar Recaudos" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_platform" value="Buscar Copias" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_platform" value="Buscar Plazo" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_version" value="Buscar Estatus" class="search_init"  style=" width:100%;"/></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="dataTables_empty">Cargando data desde el servidor</td>
                    </tr>
                </tbody>
                <tfoot>
                    <?php
                    echo $cad;
                    ?>
                </tfoot>
            </table>
        </div>
    </body>

