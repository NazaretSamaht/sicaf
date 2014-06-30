
<?php
    $header = array("C&oacute;digo de </br>Solicitud","C&eacute;dula", "Nombre y Apellido", "N&oacute;mina", "Fecha de Solicitud", "Observaci&oacute;n", "Procedimientos", "Opciones");
    $cad = "<tr>";
    foreach ($header as $arre)
        $cad.="<th>$arre</th>";

    $cad.="</tr>"
    ?>


    <body id="dt_example datatable">

        <div id="container" class="span-24 last">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
                
                <thead>
                    <?php
                    echo $cad;
                    ?>
                    
                </thead>
                
                <thead id="search" class="ui-state-default" >
                    <tr>
                        <th><input type="text" name="search_engine" value="Buscar C&oacute;digo" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar C&eacute;dula" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_browser" value="Buscar Nombre-Apellido" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_browser" value="Buscar N&oacute;mina" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_platform" value="Buscar Fecha" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_version" value="Buscar Observaci&oacute;n" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_version" value="Buscar Procedimientos" class="search_init" style=" width:100%;"/></th>
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
