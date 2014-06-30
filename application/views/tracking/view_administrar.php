<div class="span-24 last">
    <fieldset>
        <table>
            <tr>
                <td>Divisi&oacute;n:  <select name="division" id="division"><option value="00">--Seleccionar--</option>
                <?php
                    foreach ($division as $array) {
                        if ($array['id'] != '00')
                            echo '<option value="' . $array["id"] . '">' . $array['division'] . '</option>';
                    }
                    ?>
                </select><?php //echo form_error('estado'); ?>
                </td>
                <td>
                    Coordinaci&oacute;n:  <select name="coord" id="coord"><option value="00">--Seleccionar--</option></select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Documento:  <select name="doc" id="doc"><option value="00">--Seleccionar--</option></select>
                </td>
                
            </tr>
            <tr>
                
                
            </tr>
        </table>
        <div class="span-24 last">
            <div class="span-12">
                <fieldset>
                    <legend>Actor</legend>
                    <div id="actor">

                    </div>
                </fieldset>
            </div>
            <div class="span-12 last">
                <fieldset>
                    <legend>Acciones</legend>
                    <div id="accion">
                        
                    </div>
                </fieldset>
                
            </div>
            
        </div>
        <div class="span-24 last" >
            <fieldset>
                <legend>Ruta</legend>
                <div id="droppable" class="track cont_track">
                    
                </div>
            </fieldset>
        </div>
    </fieldset>  
    
</div>
