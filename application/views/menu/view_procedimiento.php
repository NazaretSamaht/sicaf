
<?php
    $header = array("C&oacute;digo</br>Solicitud","C&oacute;digo</br>Procedimiento", "C&eacute;dula", "N&oacute;mina", "Nombre</br>Procedimiento", 
        "Copias", "Fecha</br>Solicitud", "&Uacute;ltimo</br>Estatus", "Unidad","Opciones");
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
                        <th><input type="text" name="search_engine" value="Buscar Solicitud" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Procedimiento" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_browser" value="Buscar C&eacute;dula" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_browser" value="Buscar N&oacute;mina" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_platform" value="Buscar Nombre" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_platform" value="Buscar Copias" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_version" value="Buscar Fecha" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_version" value="Buscar Estatus" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_version" value="Buscar Unidad" class="search_init" style=" width:100%;"/></th>
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
