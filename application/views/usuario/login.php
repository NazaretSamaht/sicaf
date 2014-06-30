<div class="span-24 last">
    <div class="span-10">
        <form method="post">
            <fieldset>
                <legend><b>Usuarios Registrados</b></legend>
                <table>


                    <tr>
                        <td>C&eacute;dula de Usuario:</td><td><input type="text" name="usuario" max="8" class="formatoNumerico" value="<?php echo set_value("usuario") ?>"/></td>
                    </tr>
                    <tr>
                        <td>Contrase&ntilde;a:</td><td><input type="password" name="password" value="123456"/></td>
                    </tr>

                </table>
                <div id="divLogin">
                    <?php echo validation_errors() ?>
                </div>
                <div align="center">
                    <label align="center">
                        <input type="submit" value="Aceptar" name="aceptar"/>
                    </label>
                </div>
                
            </fieldset>
        </form>
    </div>

    <div class="span-14 last">

        <fieldset> 
            <legend><b>Nuevos Usuarios</b></legend>
            <table>
                <th>Introduzca su Cédula</th>
                <tr>
                    <td><div class="inputSpinner">
                            <input type="text" name="ci" class="formatoNumerico" max="8" id ="ci" value="<?php echo set_value("ci") ?>"/><span class="spinner"></span>
                        </div>
                        <?php echo form_error('ci'); ?>
                    </td>
                </tr>

            </table>
            <form method="post" action="<?php echo site_url('usuario/crear_usuario') ?>">
                <div id="divError" style="display:none"></div>
                <div id="divResult" style="display:none">
                    <table>
                        <tr>
                            <td>Nombres y Apellidos:</td>
                            <td id="nombres"></td>
                        </tr>
                        
<!--                        <tr>
                            <td>Cargo</td>
                            <td id="cargo"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td id="email"></td>
                        </tr>-->
                        <tr>
                            <td>Contraseña</td>
                            <td><input type="password" id="password" /></td>
                        </tr>                        
                        <tr>
                            <td>Repetir contraseña</td>
                            <td><input type="password" id="password_repeat" /></td>
                        </tr>                        
                        <tr>
                            <td colspan="2" id="tdBoton"><input type="submit" value="Crear usuario" id="crearUsuario" /> </td>
                        </tr>
                    </table>
                </div>
            </form>
            


        </fieldset>

    </div>
</div>
