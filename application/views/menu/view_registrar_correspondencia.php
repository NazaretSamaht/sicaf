
<fieldset>
    <legend></legend>
    
    <form method="post" action="<?php echo site_url('correspondencia') ?>">
	<div class='titulo_form'>REGISTRO DE CORRESPONDENCIA</div>
        <?php //echo 'el mensaje:'.$taquilla; 
        
        
        ?>
	<div align='right'><b>Fecha:</b><?php echo date("d").'/'.date("m").'/'.date("Y");   ?></div>
        <div>
            <?php 
                echo validation_errors(); 
                
            ?>
        </div>
       
           <?php
              // var_dump($_SESSION['messages']);
                if (isset($_SESSION['messages'])){
                       foreach ($_SESSION['messages'] as $class=>$reg){
                           foreach ($reg as $i){
                               echo "<div class='$class'>$i</div>";
                           }
                       }
                       unset($_SESSION['messages']);
                }

           ?>
    <fieldset>
        <legend>REMITENTE</legend>
        <div align="center">
           <b>UNIDAD ADMINISTRATIVA</b></br>
            <input type="text" name="remitente" VALUE="<?php echo set_value('remitente'); ?>"/>
            
        </div>
    </fieldset>
    <fieldset>
        <legend>DESTINATARIO</legend>
        <div align="center">
            <table>
                <tr>
                    <td>
                        <b>TIPO DE UNIDAD</b></br>
                        <select name="tipo_destino" id="tipo_destino">
                            <option value="">--SELECCIONAR--</option>
                            <option value="1">DIRECCI&Oacute;N</option>
                            <option value="2">DIVISI&Oacute;N</option>
                            <option value="3">COORDINACI&Oacute;N</option>
                        </select>
                    </td>
                    <td><b>UNIDAD ADMINISTRATIVA</b></br><select name="destino" id="destino"><option value="seleccionar">--SELECCIONAR--</option></select></td>
                    
                </tr>
            </table>
        </div>
         
    </fieldset>
    <fieldset>
        <legend>CORRESPONDENCIA</legend>
        <div align="center">
            <table>
                <tr>
                    <td><b>N&Uacute;MERO DE OFICIO</b></br><input type="text" name="nro_oficio" VALUE="<?php echo set_value('nro_oficio'); ?>"/></td>
                    <td><b>ASUNTO</b></br><input type="text" name="asunto" size="100px" VALUE="<?php echo set_value('asunto'); ?>"/></td>
                </tr>
                <tr>
                    <td>
                        <b>TIPO DE CORRESPONDENCIA</b></br>
                        <SELECT name="tipo_correspondencia" id="tipo_correspondencia">
                            <option name="">--SELECCIONAR--</option>
                            <?php 
                                foreach ($data as $row) {
                                    echo "<option value='{$row['id']}'>{$row['correspondencia']}</option>";
                                }
                            ?>
                        </SELECT>
                    </td>
                    
                </tr>

            </table>
        </div>
    </fieldset>
    <fieldset id="implicado">
        <legend>IMPLICADO</legend>
        <div align="center">
            <table>
                <tr>
                    <td><b>C&Eacute;DULA DE IDENTIDAD</b></br><input type="text" name="ci" id="ci"/></td>
                    <td><b>NOMBRE(S) Y APELLIDO(S)</b></br><input type="text" name="nombre" id="nombre" size="60" readonly/></td>
                </tr>
                <tr>
                    <td><b>CARGO</b></br><input type="text" name="cargo" id="cargo" size="40" readonly /></td>
                     <td><b>UBICACI&Oacute;N ADMINISTRATIVA</b></br><input type="text" name="ubi_adm" id="ubi_adm" size="40" readonly /></td>
                </tr>
                <tr>
                    <td><b>N&Oacute;MINA</b></br><textarea name="tipo_nomina" id="tipo_nomina" rows="4" cols="30" style="height:100px;" readonly /></textarea></td>
                    <td><b>ENTREGO CARNET</b><input type="checkbox" name="carnet"/></td>
                </tr>
            </table>
            
        </div>
    </fieldset>
    <div align="center">
        <span><input type="submit" value="REGISTRAR"/></span>
    </div>
    
	
    
    
</form>
</fieldset>