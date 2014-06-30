<fieldset>
    <legend></legend>
    
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
					<td><b>TIPO DE PERSONAL</b></br>
                                            <?php
                                            $br = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                            foreach ($t_personal as $array) {
                                                if ($array['id'] == 3) {
                                                    $br = '</td><td>';
                                                }
                                                else
                                                    $br = '';
                                                echo $array["personal"] . ' <input type="radio" name="tp_personal" value="' . $array['id'] . '"/> '.$br ;
                                            }
                                            ?>
					</td>
				</tr>
                                <tr>
                                    <td>
                                        <b>MOTIVO DE LA SOLICITUD</b></br>
                                        <input type="text" name="motivo" id="motivo" size="50" maxlength="100" VALUE="<?php echo set_value('motivo'); ?>" onKeyUp="this.value=this.value.toUpperCase();"/>
                                    </td>
                                    <td>
                                        <b>TIEMPO DE SERV.</b></br>
                                        A&ntilde;o Ingr.:<input type="text" name="f_ingreso" id="f_ingreso" size="4" value="0000" readonly/>
                                        A&ntilde;o Egr.:<input type="text" name="f_egreso" id="f_egreso" size="4" value="0000" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>NOMBRE(S) Y APELLIDO(S)</b></br>
                                        <input type="text" name="nombre" id="nombre" value="<?php echo $usuario['nomper'].' '.$usuario['apeper']; ?>" readonly/>
                                        
                                    </td>
                                    <td>
                                        <b>C. I.</b></br>
                                        <input type="text" name="ci" id="ci" value="<?php echo $usuario['cedper']; ?>" readonly />
                                    </td>
                                    <td>
                                        <b>UBICACI&Oacute;N ADMINISTRATIVA</b></br>
                                        <input type="text" name="ubi_adm" id="ubi_adm" value="<?php echo $usuario['uniadm']; ?>" readonly />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>N° TELEF&Oacute;NICO</b></br>
                                        <input type="text" name="tlf" id="tlf" value="02123832876" readonly />
                                    </td>
                                    <td>
                                        <b>N° TLF. CELULAR</b></br>
                                        <input type="text" name="cel" id="cel" value="04125891701" readonly />
                                    </td>
                                    <td>
                                        <b>CORREO ELECTR.</b></br>
                                        <input type="text" name="correo" id="correo" value="correo@gamil.com" readonly />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>DIRECCI&Oacute;N DE HABITACI&Oacute;N</b></br>
                                        <input type="text" name="direccion" id="direccion" value="kkhh" size="50" readonly />
                                    </td>
                                </tr>
			</table>
		</div>
	</fieldset>
        <fieldset>
            <legend class='sub_form'>SOLICITUD / TR&Aacute;MITE QUE REALIZA</legend>
            <table>
                <tr>
                    <td>ANTECEDENTE DE SERVICIO <input type="radio" name="tramite" value="1" class="tramite"/></td>
                
                    <td>TRAYECTO EN EL CARGO <input type="radio" name="tramite" value="2" class="tramite"/></td>
                
                    <td>CONSTANCIA DE TRABAJO <input type="radio" name="tramite" value="3" class="tramite"/></td>
                
                    <td>CONST. JUBILADO / PENS. <input type="radio" name="tramite" value="4" class="tramite"/></td>
                </tr>
                <tr>
                    <td>FAOV <input type="radio" name="tramite" value="5" class="tramite"/></td>
                
                    <td>COPIA RESOLUCI&Oacute;N JUB / PENSI&Oacute;N <input type="radio" name="tramite" value="6" class="tramite"/></td>
                
                    <td>COPIA EXPED. ADMITIVO <input type="radio" name="tramite" value="7" class="tramite"/></td>
                </tr>
            </table>
            <div>
                <table>
                    <tr>
                        <td>
                            COPIA SIMPLE <input type="radio" name="copia" value="simple"/>
                            COPIA CERTIF. <input type="radio" name="copia" value="certif"/>
                        </td>
                    </tr>
                </table>
             </div>
            
        </fieldset>
        <fieldset>
            <legend class='sub_form'>FORMAS IVSS</legend>
            <table>
                <tr>
                    <td>14-02 (REGISTRO ASEGURADO) <input type="radio" name="formas" value="1"/></td>
                
                    <td>14-03 (PART. DE RETIRO) <input type="radio" name="formas" value="2"/></td>
                
                    <td>14-100 (CONST. TRABAJO) <input type="radio" name="formas" value="3"/></td>
                </tr>
            </table>
        </fieldset>
        <fieldset>
            <legend class="sub_form">PRESTACIONES</legend>
            <TABLE>
                <tr>
                    <td>LIQUIDACI&Oacute;N DE PREST. SOCIALES <input type="radio" name="prest" value="1" id="liquidacion"/></td>
                
                    <td>ANTICIPOS DE PRESTACIONES (FIDEICOMISO) <input type="radio" name="prest" value="2" id="fideicomiso"/></td>
                </tr>
            </TABLE>
        </fieldset>
        <fieldset>
            <legend class="sub_form">SOLICITUD ADICIONAL</legend>
            <table>
                <tr>
                    <td>CONSIGNAR DOC. PARA EXPEDIENTE <input type="radio" name="adicional" value="1" id="exp"/></td>
                    <td>HOMOLOGACI&Oacute;N DE JUB. / PENS. <input type="radio" name="adicional" value="2" id="homolog"/></td>
                    <td>SOLIC. VARIAS HCM <input type="radio" name="adicional" value="3" id="hcm"/></td>
                </tr>
                <tr>
                    <td>PENSI&Oacute;N DE SOBREV. <input type="radio" name="adicional" value="4" id="pension"/></td>
                    <td>GASTOS MORTUORIOS <input type="radio" name="adicional" value="5" id="gastos"/></td>
                
                    <td>PAGO DE PRIMA <input type="radio" name="adicional" value="6" id="pago"/></td>
                </tr>
                <tr id="primas">
                    <td colspan="3">
                        <fieldset>
                            <legend>TIPO DE PRIMA</legend>
                            ESTUDIO <input type="radio" name="prima" value="1" id="estudio"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            HIJO <input type="radio" name="prima" value="2" id="hijo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            MATRIMONIO <input type="radio" name="prima" value="3" id="matrimonio"/>
                        </fieldset>
                     </td>
                </tr>
                <tr>
                    <td>OTRO <input type="radio" name="adicional" value="7" id="otro_adicional"/>
                        <input type="text" size="20" maxlength="20" name="otro" id="otro" onKeyUp="this.value=this.value.toUpperCase();"/></td>
                </tr>
                <tr>
                    <td colspan="2">DETALLE <input type="text" name="detalle" size ="100" maxlength="150" onKeyUp="this.value=this.value.toUpperCase();"/></td>
                </tr>
            </table>
            
        </fieldset>
        
</fieldset>
<fieldset>
    <fieldset>
        <legend class="sub_form">DOCUMENTOS Y RECAUDOS</legend>
        <table>
            <tr>
                <td>COPIA AMPLIADA Y LEGIBLE DE LA C. I. <input type="checkbox" name="r_ci" id="r_ci" value="ci"/></td>
            </tr>
            <tr id="r_anticipo">
                <td>
                    <fieldset>
                        <legend>ANTICIPO DE PRESTACIONES (FIDEICOMISO)</legend>
                        <table style="font-size: 10px;">
                            <tr>
                                <td>GENERALES</td>
                                <td>MOTIVOS (ART. 144 L.O.T.T.T)</td>
                            </tr>
                            <tr>
                                <td>OFICIO DE SOLICITUD <input type="checkbox" name="r_oficio" id="r_oficio" value="r_oficio"/></td>
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
                                                PRESUP. OBRA <input type="checkbox" name="r_presup" value="a_1"/>
                                            </td>
                                            <td>
                                                GRAVAMEN <input type="checkbox" name="r_gravamen" value="b_1"/>
                                            </td>
                                            <td>
                                                CONST. ESTUDIO / PLANILLA INSCRIP. <input type="checkbox" name="r_const" value="c_1"/>
                                            </td>
                                            <td>
                                                INFORME M&Eacute;DICO <input type="checkbox" name="r_informe" value="d_1"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                OFER. DE VENTA <input type="checkbox" name="r_ofer" value="a_2"/>
                                            </td>
                                            <td>
                                                DOC. HIPOTECA <input type="checkbox" name="r_doc" value="b_2"/>
                                            </td>
                                            <td>
                                                PRESUP. O FACT. CERTIF. <input type="checkbox" name="r_facturas" value="c_2"/>
                                            </td>
                                            <td>
                                                PRESUP. DEL CENTRO M&Eacute;DICO <input type="checkbox" name="r_centro" value="d_2"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PRESUP. REP. <input type="checkbox" name="r_rep" value="a_3"/></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
            <tr id="r_pension">
                <td>
                    <fieldset>
                        <legend>PENSION DE SOBREVIVIENTE</legend>
                        <table style="font-size: 10px;">
                            <tr>
                                <td>ORIG. Y COPIA ACTA DE DEFUNCI&Oacute;N <input type="checkbox" name="r_acta" value="r_acta" id="r_acta"/></td>
                                <td>ORIG. DOCUMENTOS HEREDEROS &Uacute;NICOS Y UNIVERSALES <input type="checkbox" name="r_herederos" value="r_herederos" id="r_herederos"/></td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
            <tr id="r_mortuorio">
                <td>
                    <fieldset>
                        <legend>GASTOS MORTUORIOS</legend>
                        <table style="font-size: 10px;">
                            <tr>
                                <td>ORIG. Y COPIA ACTA DE DEFUNCI&Oacute;N <input type="checkbox" name="r_defuncion" id="r_defuncion" value="r_defuncion"/></td>
                                <td>ORIG. Y COPIA(S) PARTIDA(S) DE NACIMIENTO <input type="checkbox" name="r_partida" id="r_partida" value="r_partida"/></td>
                            </tr>
                            <tr>
                                <td>ORIG. Y COPIA CONST. CONCUBINATO </br>(SI FUNC. /TRABA. FALLECIDO MANTENIA UNI&Oacute;N CONCUBINARIA) 
                                    <input type="checkbox" name="r_concubinato" id="r_concubinato" value="r_concubinato"/></td>
                                <td>COPIA(S) C.I. HEREDEROS <input type="checkbox" name="r_ci_hered" id="r_ci_hered" value="r_ci_hered"/></td>
                            </tr>
                            <tr>
                                <td>COPIA(S) RECIBOS PAGO DEL TRAB. <input type="checkbox" name="r_recibos" id="r_recibos" value="r_recibos"/></td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
            <tr id="r_matrimonio">
                <td>
                    <fieldset style="font-size: 10px;">
                        <legend>BONIFICACI&Oacute;N POR MATRIMONIO</legend>
                        ORIGINAL Y COPIA DE ACTA DE MATRIMONIO <input type="checkbox" name="r_acta_matrim" id="r_acta_matri"/>
                    </fieldset>
                </td>
            </tr>
            <tr id="r_hijo">
                <td>
                    <fieldset style="font-size: 10px;">
                        <legend>BONIFICACI&Oacute;N POR NACIMIENTO DE HIJO</legend>
                        ORIGINAL Y COPIA DE PARTIDA DE NACIMIENTO <input type="checkbox" name="r_partida" id="r_partida"/>
                    </fieldset> 
                </td>
            </tr>
            <tr>
                <td>
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
                </td>
            </tr>
        </table>
    </fieldset>
</form>
</fieldset>