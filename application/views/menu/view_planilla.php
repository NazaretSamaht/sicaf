<fieldset>
    <legend></legend>
    <?php echo 'usuario:'.$usuario['codper']; ?>
    <form method="post" action="<?php echo site_url('solicitud') ?>">
	<div class='titulo_form'>PLANILLA &Uacute;NICA DE SOLICITUD</div>
	<div align='right'><b>Fecha:</b><?php echo date("d").'/'.date("m").'/'.date("Y");   ?></div>
        <div>
            <?php echo validation_errors(); ?>
        </div>
	<fieldset>
		<legend class='sub_form'>IDENTIFICACI&Oacute;N DEL SOLICITANTE</legend>
		<div align="center">
			<table>
				<tr>
                                    <td>
                                        <b>NOMBRE(S) Y APELLIDO(S)</b></br>
                                        <input type="text" name="nombre" id="nombre" value="<?php echo $usuario['nom_ape']; ?>" readonly/>
                                        
                                    </td>
                                    <td>
                                        <b>C&Eacute;DULA DE IDENTIDAD</b></br>
                                        <input type="text" name="ci" id="ci" value="<?php echo $usuario['cedper']; ?>" readonly />
                                    </td>
                                    <td>
                                        <b>UBICACI&Oacute;N ADMINISTRATIVA</b></br>
                                        <input type="text" name="ubi_adm" id="ubi_adm" value="<?php echo $usuario['unidad']; ?>" readonly />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>N° TELEF&Oacute;NICO DE HABITACI&Oacute;N</b></br>
                                        <input type="text" name="tlf" id="tlf" value="<?php echo $usuario['local']; ?>" class="formatoTelefonoLocal"/>
                                    </td>
                                    <td>
                                        <b>N° TELEF&Oacute;NICO CELULAR</b></br>
                                        <input type="text" name="cel" id="cel" value="<?php echo $usuario['celular']; ?>" class="formatoTelefonoCelular"/>
                                    </td>
                                    <td>
                                        <b>CORREO ELECTR&Oacute;NICO</b></br>
                                        <input type="text" name="correo" id="correo" value="<?php echo $usuario['correo']; ?>" class="formatoEmail" maxlength="25"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>TIEMPO DE SERVICIO</b></br>
                                        A&Ntilde;O INGRESO:<input type="text" name="f_ingreso" id="f_ingreso" size="10" value="<?php echo $usuario['ingreso'] ?>" readonly/>
                                        A&Ntilde;O EGRESO:<input type="text" name="f_egreso" id="f_egreso" size="10" value="<?php echo $usuario['egreso'] ?>" readonly/>
                                    </td>
                                    <td>
                                        <b>CARGO</b></br>
                                        <input type="text" name="cargo" id="cargo" value="<?php echo $usuario['cargo']; ?>" readonly />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>DIRECCI&Oacute;N DE HABITACI&Oacute;N</b></br>
                                        <input type="text" name="direccion" id="direccion" value="<?php echo $usuario['direccion']; ?>" size="60" readonly />
                                    </td>
                                    <td>
                                        <b>MOTIVO DE LA SOLICITUD</b></br>
                                        <input type="text" name="motivo" id="motivo" size="50" maxlength="100" VALUE="<?php echo set_value('motivo'); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        ACTIVO <input type="radio" name="tipo_personal" value="1" id="activo"/>
                                    </td>
                                    <td>
                                        RETIRADO <input type="radio" name="tipo_personal" value="2" id="jubilado"/>
                                    </td>
                                </tr> 
                                <tr>
                                    <td>
                                        <div class="activo_opciones toolactivo">
                                            
                                            FIJOS <input type="radio" name="tipo_activo" value="1" id="fijos"/>
                                            CONTRATADOS <input type="radio" name="tipo_activo" value="2" id="contratados"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="jubilado_opciones toolretirado">
                                            RENUNCIAS <input type="radio" name="tipo_retirado" value="1" id="renuncias"/>
                                            DESTITUIDOS <input type="radio" name="tipo_retirado" value="2" id="destituidos"/></br>
                                            JUBILADOS /PENSIONADOS <input type="radio" name="tipo_retirado" value="3" id="jubilados_pensionados"/>
                                            FALLECIDOS <input type="radio" name="tipo_retirado" value="4" id="fallecidos"/>
                                        </div>
                                    </td>
                                </tr>
			</table>
		</div>
	</fieldset>
        <fieldset>
            <legend class='sub_form'>SOLICITUD / TR&Aacute;MITE QUE REALIZA</legend>
            <table>
                
                <tr class="activo_opciones">
                    <td>TRAYECTO EN EL CARGO <input type="checkbox" name="tramite[trayecto]" value="1" class="tramite"/></td>
                    <td>CONSTANCIA DE TRABAJO <input type="checkbox" name="tramite[constancia_trabajo]" value="2" class="tramite"/></td>
                    
                </tr>
                <tr class="jubilado_opciones">
                    <td>ANTECEDENTE DE SERVICIO <input type="checkbox" name="tramite[antecedente]" value="3" class="tramite"/></td>
                    <td>CONSTANCIA JUBILADO / PENSI&Oacute;N <input type="checkbox" name="tramite[constancia_jubilado]" value="4" class="tramite"/></td>
                    <td>COPIA RESOLUCI&Oacute;N <input type="checkbox" name="tramite[resolucion]" value="5" class="tramite"/></td>
                </tr>
                <tr>
                    <td>CONSTANCIA FAOV <input type="checkbox" name="tramite[faov]" value="6" class="tramite"/></td>
                    <td>COPIA EXPEDIENTE ADMINISTRATIVO <input type="checkbox" name="tramite[expediente]" value="7" class="tramite" id="exp"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div  id="tipo_copia" class="toolactivo">
                            COPIA SIMPLE <input type="radio" name="copia" value="1"/>
                            COPIA CERTIFICADA <input type="radio" name="copia" value="2"/>
                        </div>
                    </td>
                 </tr>
            </table>
        </fieldset>
        <fieldset>
            <legend class='sub_form'>FORMAS IVSS</legend>
            <table>
                <tr>
                    <td>14-02 (REGISTRO ASEGURADO) <input type="checkbox" name="forma[1402]" value="8"/></td>
                    <td>14-03 (PARTIDA DE RETIRO) <input type="checkbox" name="forma[1403]" value="9"/></td>
                    <td>14-100 (CONSTANCIA TRABAJO) <input type="checkbox" name="forma[14100]" value="10"/></td>
                    <td>RECTIFICACI&Oacute;N DE IVSS<input type="checkbox" name="forma[rectificacion]" value="11"/></td>
                </tr>
            </table>
        </fieldset>
        <fieldset>
            <legend class="sub_form">PRESTACIONES</legend>
            <TABLE>
                <tr>
                    <td>LIQUIDACI&Oacute;N DE PRESTACIONES SOCIALES <input type="radio" name="prest" value="12" id="liquidacion"/></td>
                
                    <td>ANTICIPOS DE PRESTACIONES (FIDEICOMISO) <input type="radio" name="prest" value="13" id="fideicomiso"/></td>
                </tr>
            </TABLE>
        </fieldset>
        <fieldset>
            <legend class="sub_form">SOLICITUD ADICIONAL</legend>
            <table>
                <tr class="activo_opciones">
                    <td>PAGO DE PRIMA <input type="checkbox" name="adicional[prima]" value="14" id="pago"/></td>
                    <td>GASTOS MORTUORIOS <input type="checkbox" name="adicional[gastos]" value="15" class="gastos"/></td>
                </tr>
                <tr id="primas">
                    <td colspan="3">
                        <fieldset>
                            <legend>TIPO DE PRIMA</legend>
                            PROFESIONALIZACI&Oacute;N <input type="checkbox" name="prima[estudio]" value="1" id="estudio"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            HIJO <input type="checkbox" name="prima[hijo]" value="2" id="hijo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            HOGAR <input type="checkbox" name="prima[hogar]" value="3" id="matrimonio"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            ANTIG&Uuml;EDAD <input type="checkbox" name="prima[antiguedad]" value="4" id="antiguedad"/>
                        </fieldset>
                     </td>
                </tr>
                <tr class="jubilado_opciones">
                    <td>HOMOLOGACI&Oacute;N DE JUBILADO / PENSIONADO <input type="checkbox" name="adicional[homolo]" value="16" id="homolog"/></td>  
                    <td>SOLICTUD DE JUBILACI&Oacute;N <input type="checkbox" name="adicional[jubilacion]" value="17" id="jubilacion"/></td>
                </tr>
                <tr>
                   <td>SOLICITUDES VARIAS HCM <input type="checkbox" name="adicional[hcm]" value="18" id="hcm"/></td>
                   <td>PENSI&Oacute;N DE SOBREVIVIENTE <input type="checkbox" name="adicional[pension]" value="19" class="gastos"/></td> 
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="opciones_hcm toolhcm">
                            SOLICITAR INCLUSI&Oacute;N FAMILIAR <input type="checkbox" name="hcm[inclusion]" value="1" id="inclusion"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            SOLICITAR EXCLUSI&Oacute;N FAMILIAR <input type="checkbox" name="hcm[exclusion]" value="2" id="exclusion"/></br>
                            RECLAMOS <input type="checkbox" name="hcm[reclamos]" value="3" id="reclamos"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            INCLUSI&Oacute;N DE POLIZA O CAMBIOS EN LA POLIZA <input type="checkbox" name="hcm[poliza]" value="4" id="poliza"/>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>CONSIGNAR DOCUMENTOS PARA EXPEDIENTE <input type="checkbox" name="adicional[consignar]" value="20" id="exp"/></td>
                    <td>NOTIFICACI&Oacute;N DE DEFUNCI&Oacute;N <input type="checkbox" name="adicional[notificacion]" value="21" class="gastos"/></td>
                </tr>
                <tr>
                    <td>OTRO <input type="checkbox" name="adicional[otro]" value="22" id="otro_adicional"/>
                        <input type="text" size="20" maxlength="20" name="otro" id="otro"/></td>
                </tr>
                <tr>
                    <td colspan="2">DETALLE <input type="text" name="detalle" size ="100" maxlength="150" /></td>
                </tr>
            </table>
            
        </fieldset>
        
</fieldset>
<fieldset>
    <fieldset>
        <legend class="sub_form" >DOCUMENTOS Y RECAUDOS</legend>
        <p><b>PARA TODAS LAS SOLICITUDES: </b> COPIA AMPLIADA Y LEGIBLE DE LA C. I.</p></br>
        <div id="r_liquidacion">
            <fieldset>
                <legend>LIQUIDACI&Oacute;N DE PRESTACIONES SOCIALES</legend>
                <table>
                    <tr>
                        <td>CARTA DE SOLICTIUD DE FINIQUITO</td>
                        <td>CONSTANCIA DE CESE DE CONTRALORIA</td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div id="r_anticipo" >
            <fieldset>
                <legend>ANTICIPO DE PRESTACIONES (FIDEICOMISO)</legend>
            <table class="border_table">
                
                <tr>
                    <td>GENERALES</td>
                    <td>MOTIVOS (ART. 144 L.O.T.T.T)</td>
                </tr>
                <tr>
                    <td>OFICIO DE SOLICITUD </td>
                    <td>
                        <table>
                            <tr>
                                <td>LITERAL A</td>
                                <td>LITERAL B</td>
                                <td>LITERAL C</td>
                                <td>LITERAL D</td>
                            </tr>
                            <tr>
                                <td>
                                    PRESUP. OBRA
                                </td>
                                <td>
                                    GRAVAMEN
                                </td>
                                <td>
                                    CONST. ESTUDIO / PLANILLA INSCRIP.
                                </td>
                                <td>
                                    INFORME M&Eacute;DICO
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    OFER. DE VENTA
                                </td>
                                <td>
                                    DOC. HIPOTECA
                                </td>
                                <td>
                                    PRESUP. O FACT. CERTIF.
                                </td>
                                <td>
                                    PRESUP. DEL CENTRO M&Eacute;DICO
                                </td>
                            </tr>
                            <tr>
                                <td>PRESUP. REP.</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            </fieldset>
        </div>
        
        <table>
            <tr id="r_mortuorio">
                <td>
                    <fieldset>
                        <legend>GASTOS MORTUORIOS / PENSI&Oacute;N DE SOBREVIVIENTE / NOTIFICACI&Oacute;N DE MUERTE</legend>
                        <table>
                            <tr>
                                <td>ORIG. Y COPIA ACTA DE DEFUNCI&Oacute;N </td>
                                <td>ORIG. Y COPIA(S) PARTIDA(S) DE NACIMIENTO </td>
                            </tr>
                            <tr>
                                <td>ORIG. Y COPIA CONST. CONCUBINATO </br>(SI FUNC. /TRABA. FALLECIDO MANTENIA UNI&Oacute;N CONCUBINARIA) 
                                    </td>
                                <td>COPIA(S) C.I. HEREDEROS </td>
                            </tr>
                            <tr>
                                <td>COPIA(S) RECIBOS PAGO DEL TRAB. </td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
            <tr id="r_hcm">
                <td>
                    <fieldset>
                        <legend>SOLICITUDES VARIAS HCM</legend>
                        <table>
                            <tr id="r_inclusion">
                                <td>
                                    COPIA DE PARTIDA DE NACIMIENTO</br>
                                    PLANILLA HCM </br>
                                    PLANILLA IVSS </br>
                                </td>
                            </tr>
                            <tr id="r_reclamos">
                                <td>OFICIO DEL RECLAMO</td>
                            </tr>
                            <tr id="r_poliza">
                                <td>PLANILLA IVSS</td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
            <tr id="r_matrimonio">
                <td>
                    <fieldset>
                        <legend>BONIFICACI&Oacute;N POR MATRIMONIO</legend>
                        ORIGINAL Y COPIA DE ACTA DE MATRIMONIO 
                    </fieldset>
                </td>
            </tr>
            <tr id="r_hijo">
                <td>
                    <fieldset>
                        <legend>BONIFICACI&Oacute;N POR NACIMIENTO DE HIJO</legend>
                        ORIGINAL Y COPIA DE PARTIDA DE NACIMIENTO 
                    </fieldset> 
                </td>
            </tr>
            <tr>
                <td>
                    
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset>
        <table>
            <tr>
                <td>FIRMA SOLICITANTE </td><td>RECIBIDO POR </td><td>INSTRUCCI&Oacute;N</td>
            </tr>
            <tr>
                <td></br></br></td><td></br></br></td><td></br></br></td>
            </tr>
            <tr style="font-style: 10px;">
                <td>FECHA:___/___/____</td><td>FECHA:___/___/____</td><td>FECHA:___/___/____</td>
            </tr>
            <tr>
                <td></td><td><input type="submit" value="REGISTRAR"/></td><td></td>
            </tr>
        </table>
    </fieldset>
</form>
</fieldset>