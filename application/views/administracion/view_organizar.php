<div class="span-24 last">
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
		<form method="post" action="<?php echo site_url('administracion/organizar_usuarios') ?>">
			<div class='span-5' align='center'>
				<fieldset>
					<span>Seleccione la c&eacute;dula del usuario que desea organizar en una unidad administrativa</span>
					<select name='cedulas' id='cedulas'>
						<option value=''>--SELECCIONAR--</option>
					
					<?php 
						foreach ($cedulas as $row) {
							echo "<option value='{$row['cedula']}_{$row['descasicar']}'".set_select('cedulas',$row['cedula'].'_'.$row['descasicar']).">{$row['cedula']}</option>";
						}
					?>
					</select>
				</fieldset>
			</div>
			<div class='span-18 last' align='center'>
				<fieldset>
					<span>Seleccione la unidad administrativa en espec&iacute;fico a la que pertenece la c&eacute;dula del usuario seleccionado</span>
					<div align='left'>
						<b>Direcci&oacute;n:</b></br>
						Despacho del Director <input type='radio' name='unidad' value='1_dd' <?php echo set_radio('unidad', '1_dd'); ?>/>
					</div>
					<div  align='left'>
						<b>Divisi&oacute;n:</b></br>
						<?php 
							$cont=0;
							foreach ($divisiones as $row1) {
								$cont++;
								if (($cont==3)||($cont==6)||($cont==9))
									$cad='</br>';
								else
									$cad='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
								echo "{$row1['division']} <input type='radio' name='unidad' value='{$row1['id']}_d' ".set_radio('unidad', $row1['id'].'_d')."/>$cad";
							}
						?>
					</div>
					<div align='left'>
						<b>Coordinaci&oacute;n:</b></br>
						<?php 
							$cont1=0;
							foreach ($coord as $row2) {
								$cont1++;
								if (($cont1==3)||($cont1==6)||($cont1==9)||($cont1==12)||($cont1==15)||($cont1==18))
									$cad='</br>';
								else
									$cad='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
								echo "{$row2['coordinacion']} <input type='radio' name='unidad' value='{$row2['id']}_c' ".set_radio('unidad', $row2['id'].'_c')."/>$cad";
							}
						?>
					</div>
				</fieldset>
			</div>
			<div align='center'>
				<input type='submit' value='Aceptar'/>
			</div>
		</form>
	</fieldset>
	
	

				
				
	
</div>