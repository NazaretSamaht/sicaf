
<?php 
if ($combo==1){
?>
<p>
    Cargo: <select name="cargo" id="cargo"><option value="0">-- Seleccionar Cargo--</option>
        <?php
        foreach ($cargos as $array) {
            echo '<option value="' . $array["id"] . '">' . $array['cargo'] . '</option>';
        }
        ?>
    </select>
</p>

<?php
}
if ($combo==2){
?>
<p>
    Divisi&oacute;n: <select name="division" id="division"><option value="0">-- Seleccionar Divisi&oacute;n--</option>
    <?php
        foreach ($division as $array) {
            echo '<option value="' . $array["id"] . '">' . $array['division'] . '</option>';
        }
        ?>
    </select>
</p>

<div align="center">
    <label align="center">
        <input type="submit" value="Siguiente" name="siguiente"/>
    </label>
    </div>
<?php
    
}
if ($combo==3){
?>
<p>
    Divisi&oacute;n: <select name="division" id="division"><option value="0">-- Seleccionar Divisi&oacute;n--</option>
    <?php
        foreach ($division as $array) {
            echo '<option value="' . $array["id"] . '">' . $array['division'] . '</option>';
        }
        ?>
    </select>
</p>
<p>
    Coordinaci&oacute;n: <select name="division" id="coord"><option value="0">-- Seleccionar Coordinaci&oacute;n--</option>

    </select>
</p>

<div align="center">
    <label align="center">
        <input type="submit" value="Siguiente" name="siguiente"/>
    </label>
    </div>
<?php
    
}
if ($combo==4){
?>

<div align="center">
    <label align="center">
        <input type="submit" value="Siguiente" name="siguiente"/>
    </label>
    </div>
<?php
    
}if ($combo==0){
?>

<div align="center">

    </div>
<?php
    
}
?>