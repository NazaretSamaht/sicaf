<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<table>
    <tr>
        <td>
    Tipo de Personal </br>  
    <?php
    $br='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    foreach ($t_personal as $array) {
        if ($array['id']==3){
            $br='</br>';
        }else
           $br='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
        echo $array["personal"].' <input type="radio" name="'.$array["personal"].' value="'.$array['id'].'"/> '.$br;
    }
    ?>
        </td>
    </tr>

<tr>
    <td>
    A&ntilde;o Ingreso: <select name="a_ingreso">
        <option value="0">-- Seleccionar --</option>
        <?php
        $ano=date("Y");
        for ($i=2000;$i<=$ano;$i++){
            echo '<option value="'.$i.'">'.$i.'</option>';
        }
       
        ?>
        
    </select>
    </td>
    <td>
    A&ntilde;o Egreso: <select name="a_egreso">
        <option value="0">-- Seleccionar --</option>
        <?php
        $ano=date("Y");
        for ($i=2000;$i<=$ano;$i++){
            echo '<option value="'.$i.'">'.$i.'</option>';
        }
        ?>
        
    </select>
    </td>
</tr>
<tr>
    <td>
        Tel&eacute;fono Local: <input type="text" name="tlf" value="<?php echo set_value("tlf_local") ?>" maxlength="12" class="formatoNumerico"/><?php echo form_error('tlf_local'); ?>
    </td>
</tr>
<tr>
    <td>
        Ubicaci&oacute;n Administrativa: <input type="text" name="ubi_adm" value="<?php echo set_value("ubi_adm") ?>" maxlength="20" class="formatoTexto"/><?php echo form_error('ubi_adm'); ?>
    </td>
</tr>
</table>
<p>
        Direcci&oacute;n de Habitaci&oacute;n: </br><textarea name="direccion"  maxlength="200" style=" width: 500px; height: 100px;"><?php echo set_value("direccion") ?></textarea><?php echo form_error('direccion'); ?>
</p>
<div align="center">
    <label align="center">
        <input type="submit" value="Siguiente" name="siguiente"/>
    </label>
    </div>
