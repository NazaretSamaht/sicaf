
<?php
    $header = array("C&oacute;digo</br>Procedimiento", "Nombre </br>Procedimiento","Nombre </br>Analista", "C&eacute;dula </br>Analista", "Transferir a");
    $cad = "<tr>";
    foreach ($header as $arre)
        $cad.="<th>$arre</th>";

    $cad.="</tr>"
    ?>

    
    <body id="dt_example datatable">
       
        <div id="container" class="span-24 last">
            <form method='post' action='<?php echo site_url('pendiente/transferir');?>'>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
                
                <thead>
                    <?php
                    echo $cad;
                    ?>
                    
                </thead>
                
                <thead id="search" class="ui-state-default" >
                    <tr>
                        <th><input type="text" name="search_engine" value="Buscar C&oacute;digo" class="search_init"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Procedimiento" class="search_init"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Analista" class="search_init"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Analista" class="search_init"/></th>
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
            <div align='center'>
                <input type='submit' id='asignar' value='Aceptar'/>
            </div>
            </form>
        </div>
    </body>

