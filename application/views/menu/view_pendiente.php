
<?php
    $header = array("C&oacute;digo</br>Proc.", "C&oacute;digo</br>Solicitud","Procedimiento", "Copias", "C&eacute;dula", "Nombre y Apellido", "N&oacute;mina", "Fecha de</br>Solicitud", "Origen", "Destino", "Acci&oacute;n");
    $cad = "<tr>";
    foreach ($header as $arre)
        $cad.="<th>$arre</th>";

    $cad.="</tr>"
    ?>

    
    <body id="dt_example datatable">
       
        <div id="container" class="span-24 last">
            <form method='post' action='<?php echo site_url('pendiente');?>'>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
                
                <thead>
                    <?php
                    echo $cad;
                    ?>
                    
                </thead>
                
                <thead id="search" class="ui-state-default" >
                    <tr>
                        <th><input type="text" name="search_engine" value="Buscar C&oacute;digo" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar C&oacute;digo" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Procedimiento" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Copias" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_browser" value="Buscar C&eacute;dula" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Nombre Apellido" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar N&oacute;mina" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_version" value="Buscar Fecha" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_version" value="Buscar Origen" class="search_init"  style=" width:100%;"/></th>
                        <th><input type="text" name="search_version" value="Buscar Destino" class="search_init"  style=" width:100%;"/></th>
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

