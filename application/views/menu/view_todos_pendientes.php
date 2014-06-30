
<?php
    $header = array("C&oacute;digo</br>Procedimiento", "C&eacute;dula</br>Solicitante", "N&oacute;mina","Procedimiento", "Fecha de</br>Solicitud", "Plazo", "Fecha de</br>Vencimiento", 
        "Responsable", "Acci&oacute;n</br>Pendiente", "Estatus", "D&iacute;as</br>Vencidos");
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
                        <th><input type="text" name="search_engine" value="Buscar N&oacute;mina" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Procedimiento" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Fecha Solicitud" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Plazo" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Fecha Vencimiento" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Responsable" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Acci&oacute;n" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Estatus" class="search_init" style=" width:100%;"/></th>
                        <th><input type="text" name="search_engine" value="Buscar Vencido" class="search_init" style=" width:100%;"/></th>
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

