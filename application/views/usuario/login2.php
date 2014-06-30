<div class="span-24 last">
    <div class="span-10">
        <form method="post" action="<?php echo site_url('usuario/iniciar_sesion') ?>">
            <fieldset>
                <legend><b>Usuarios Registrados</b></legend>
    <table>
        
        
        <tr>
            <td>Nombre de Usuario:</td><td><input type="text" name="usuario" value="<?php echo set_value("usuario") ?>"/><?php echo form_error('usuario'); ?></td>
        </tr>
        <tr>
            <td>Contrase&ntilde;a:</td><td><input type="password" name="clave" value="<?php echo set_value("clave") ?>"/><?php echo form_error('clave'); ?></td>
        </tr>
        <tr>
            <td>C&eacute;dula:</td><td><input type="text" name="cedula" value="<?php echo set_value("ci") ?>" class="formatoNumerico"/><?php echo form_error('ci'); ?></td>
        </tr>
    </table>
    <div align="center">
    <label align="center">
        <input type="submit" value="Aceptar" name="aceptar"/>
    </label>
    </div>
       </fieldset>
</form>
    </div>
    
    <div class="span-14 last">
        <form method="post" action="<?php echo site_url('usuario/control_usuario') ?>">
         <fieldset> 
             <legend><b>Nuevos Usuarios</b></legend>
    <table>
        
        <tr>
            <td>Nombre:</td><td><input type="text" name="nombre_u" value="<?php echo set_value("nombre_u") ?>" maxlength="20" class="formatoTexto"/><?php echo form_error('nombre_u'); ?></td>
            <td>Apellido:</td><td><input type="text" name="apellido_u" value="<?php echo set_value("apellido_u") ?>" maxlength="20" class="formatoTexto"/><?php echo form_error('apellido_u'); ?></td>
        </tr>
        <tr>
            <td>C&eacute;dula:</td><td><input type="text" name="ci" value="<?php echo set_value("ci") ?>" maxlength="8" class="formatoNumerico"/><?php echo form_error('ci'); ?></td>
            <td>Usuario:</td><td><input type="text" name="usuario" value="<?php echo set_value("usuario") ?>" maxlength="10"/><?php echo form_error('usuario'); ?></td>
        </tr>
        <tr>
            <td>Contrase&ntilde;a:</td><td><input type="password" name="clave" id="clave" value="<?php echo set_value("clave") ?>" maxlength="10"/><?php echo form_error('clave'); ?></td>
            <td>Repetir Contrase&ntilde;a:</td><td><input type="password" name="rclave" id="rclave" value="<?php echo set_value("rclave") ?>" maxlength="10"/><?php echo form_error('rclave'); ?></td>
        </tr>
        <tr>
            <td>Correo Electr&oacute;nico:</td><td><input type="text" name="correo" value="<?php echo set_value("correo") ?>" maxlength="20" class="formatoEmail"/><?php echo form_error('correo'); ?></td>
            <td>Tel&eacute;fono Celular:</td><td><input type="text" name="tlf" value="<?php echo set_value("tlf") ?>" maxlength="12" class="formatoNumerico"/><?php echo form_error('tlf'); ?></td>
        </tr>
        
    </table>
             <p alin="center">
             Tipo de Usuario:    <select name="t_usuario" id="t_usuario"><option value="0">-- Seleccionar --</option><option value="1">Funcionario P&uacute;blico Interno de la Alcald&iacute;a</option>
                    <option value="2">Funcionario P&uacute;blico Externo</option></select></td>
             </p>
    
             <div id="div">
                 
             </div>
             <div id="div_div">
                 
             </div>
             
             
             </fieldset>
</form>
    </div>
</div>
