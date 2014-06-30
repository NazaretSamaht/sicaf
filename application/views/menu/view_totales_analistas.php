
<?php
    $header = array("Analista", "Total Diario","Total Mensual", "Total Anual", "Total Pendientes");
    $cad = "<tr>";
    foreach ($header as $arre)
        $cad.="<th>$arre</th>";

    $cad.="</tr>"
    ?>


    <body id="dt_example datatable">

        <div id="container" class="span-24 last">
            <input type="hidden" value="<?php echo $fecha_total; ?>" id="fecha_total">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
                
                <thead>
                    <?php
                    echo $cad;
                    ?>
                    
                </thead>
                
                <thead id="search" class="ui-state-default" >
                    <tr>
                        <th><input type="text" name="search_engine" value="Buscar Analista" class="search_init"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Diario" class="search_init" /></th>
                        <th><input type="text" name="search_browser" value="Buscar Mensual" class="search_init" /></th>
                        <th><input type="text" name="search_platform" value="Buscar Anual" class="search_init" /></th>
                        <th><input type="text" name="search_version" value="Buscar Pendientes" class="search_init" /></th>
                        
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
