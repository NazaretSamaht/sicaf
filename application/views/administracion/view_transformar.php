<div class='span-24 last' align='center'>
	<form method="post" action="<?php echo site_url('administracion/organizar_usuarios') ?>">
		<fieldset>
			<span>Como &uacute;ltimo paso, seleccione el cargo actual del usuario previamente organizado</span>
			<div class='span-12'>
				<?php 
				$data=explode('_', $cedulas);
				$cargo=$data[1];
				?>
				Cargo Antigüo: <input type='text' name='cargo_ant' value='<?php echo $cargo;?>' readonly/>
			</div>
			<div class='span-11 last'>
				Cargo Actual <select name='cargos_a'>
					<option value=''>--SELECCIONAR--</option>
					<?php 
						foreach ($cargos_a as $row) {
							echo "<option value='{$row['id']}_{$row['id_cargo']}'>{$row['cargo']}</option>";
						}
					?>
				</select>
			</div>
			<div class='span-24 last'>
				<input type='submit' value='Aceptar'/>
			</div>
		</fieldset>
	</form>
</div>