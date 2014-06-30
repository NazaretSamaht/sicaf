
<fieldset>
    <legend></legend>
    
    <form method="post" action="<?php echo site_url('solicitud') ?>">
	<div class='titulo_form'>PLANILLA &Uacute;NICA DE SOLICITUD</div>
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
		<legend class='sub_form'>IDENTIFICACI&Oacute;N DEL SOLICITANTE</legend>
		<div align="center">
			<table>
				<tr>
                                    <td>
                                        <b>C&Eacute;DULA DE IDENTIDAD</b></br>
                                        <input type="text" name="ci" id="ci"/>
                                    </td>
                                    <td>
                                        <b>NOMBRE(S) Y APELLIDO(S)</b></br>
                                        <input type="text" name="nombre" id="nombre" size="60" readonly/>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>N&SmallCircle; TELEF&Oacute;NICO DE HABITACI&Oacute;N</b></br>
                                        <input type="text" name="tlf" id="tlf"  class="formatoTelefonoLocal"/> Ejemplo: 02121111111
                                    </td>
                                    <td>
                                        <b>N&SmallCircle; TELEF&Oacute;NICO CELULAR</b></br>
                                        <input type="text" name="cel" id="cel"  class="formatoTelefonoCelular"/> Ejemplo: 04121111111
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>
                                        <b>TIEMPO DE SERVICIO</b></br>
                                        A&Ntilde;O INGRESO:<input type="text" name="f_ingreso" id="f_ingreso" size="10"  readonly/>
                                        A&Ntilde;O EGRESO:<input type="text" name="f_egreso" id="f_egreso" size="10"  readonly/>
                                    </td>
                                    <td>
                                        <b>CARGO</b></br>
                                        <input type="text" name="cargo" id="cargo" size="40" readonly />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>UBICACI&Oacute;N ADMINISTRATIVA</b></br>
                                        <input type="text" name="ubi_adm" id="ubi_adm" size="40" readonly />
                                    </td>
                                    <td>
                                        <b>CORREO ELECTR&Oacute;NICO</b></br>
                                        <input type="text" name="correo" id="correo"  class="formatoEmail" maxlength="50"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>DIRECCI&Oacute;N DE HABITACI&Oacute;N</b></br>
                                        <input type="text" name="direccion" id="direccion" size="60" readonly />
                                    </td>
                                    <td>
                                        <b>MOTIVO DE LA SOLICITUD</b></br>
                                        <input type="text" name="motivo" id="motivo" size="50" maxlength="100" VALUE="<?php echo set_value('motivo'); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>N&Oacute;MINA:</b></br>
                                        <textarea name="tipo_nomina" id="tipo_nomina" rows="4" cols="30" style="height:100px;" readonly /></textarea>
                                    </td>
                                    
                                </tr> 
                                
			</table>
		</div>
	</fieldset>
        <fieldset>
            <legend class='sub_form'>SOLICITUD / TR&Aacute;MITE QUE REALIZA</legend>
            <table>
                <?php 
                    /*echo "<pre>";
                    print_r($cantidad);
                    echo "</pre>";*/
                    $i=0;
                    while ($i<count($cantidad)){
                        if($cantidad[$i]['max_cant']!=1){
                            $cantidad[$i]['campo']="<select name='n_{$cantidad[$i]['id']}'>";
                            for ($j=1; $j <= $cantidad[$i]['max_cant']; $j++) { 
                                $cantidad[$i]['campo'].="<option value='$j'>$j</option>";
                            }
                            $cantidad[$i]['campo'].="</select>";
                        }else{
                            $cantidad[$i]['campo']="<input type='text' value='1' name='n_$i' readonly/>";
                        }
                    $i++;    
                    }
                    
                ?>
                <tr class="activo_opciones">
                    <td>TRAYECTORIA EN EL CARGO <input type="checkbox" name="tramite[trayecto]" value="1" class="tramite" id="trayecto"/>
                        <span id="n_trayecto">CANTIDAD 
                            <?php
                                for ($i=0; $i < count($cantidad); $i++) { 
                                    if ($cantidad[$i]['id']==1){
                                        echo $cantidad[$i]['campo'];
                                    }
                                 } 
                                    
                               
                                
                            ?>
                        </span>
                    </td>

                    <td>CONSTANCIA DE TRABAJO <input type="checkbox" name="tramite[constancia_trabajo]" value="2" class="tramite" id="const_trab"/>
                        <span id="n_const_trab">CANTIDAD 
                            <?php
                                for ($i=0; $i < count($cantidad); $i++) { 
                                    if ($cantidad[$i]['id']==2){
                                        echo $cantidad[$i]['campo'];
                                    }
                                 } 
                                    
                                /* echo "<pre>";
                                print_r($cantidad);
                                echo "</pre>";*/
                                
                            ?>
                        </select></span></td>
                    
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div  id="tipo_const_trab" class="toolactivo tool">
                           - SIMPLE <input type="radio" name="const_trab" value="1"/>
                           - COMPUESTA <input type="radio" name="const_trab" value="2"/>
                        </div>
                    </td>
                 </tr>
                <tr class="jubilado_opciones">
                    <td>ANTECEDENTE DE SERVICIO <input type="checkbox" name="tramite[antecedente]" value="3" class="tramite" id="antecedente"/>
                        <span id="n_antecedente">CANTIDAD 
                            <?php
                                for ($i=0; $i < count($cantidad); $i++) { 
                                    if ($cantidad[$i]['id']==3){
                                        echo $cantidad[$i]['campo'];
                                    }
                                 } 
                                    
                                
                                
                            ?>
                        </select></span></td>
                    <td>CONSTANCIA JUBILADO <input type="checkbox" name="tramite[constancia_jubilado]" value="4" class="tramite" id="const_jub"/>
                        <span id="n_const_jub">CANTIDAD 
                            <?php
                                for ($i=0; $i < count($cantidad); $i++) { 
                                    if ($cantidad[$i]['id']==4){
                                        echo $cantidad[$i]['campo'];
                                    }
                                 } 
                                    
                                
                                
                            ?>
                        </select></span></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div  id="tipo_const_jub" class="toolactivo tool">
                           - SIMPLE <input type="radio" name="const_jub" value="1"/>
                           - ANUAL <input type="radio" name="const_jub" value="2"/>
                        </div>
                    </td>
                 </tr>
                <tr class="jubilado_opciones">
                    <td>COPIA RESOLUCI&Oacute;N <input type="checkbox" name="tramite[resolucion]" value="5" class="tramite"/></td>
                </tr>
                <tr class='act_jub_opc'>
                    <td>CONSTANCIA FAOV <input type="checkbox" name="tramite[faov]" value="6" class="tramite" id="faov"/>
                        <span id="n_const_faov">CANTIDAD 
                            <?php
                                for ($i=0; $i < count($cantidad); $i++) { 
                                    if ($cantidad[$i]['id']==6){
                                        echo $cantidad[$i]['campo'];
                                    }
                                 } 
                                    
                                
                                
                            ?>
                        </select></span></td>
                    <td>COPIA EXPEDIENTE ADMINISTRATIVO <input type="checkbox" name="tramite[expediente]" value="7" class="tramite" id="exp"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div  id="tipo_copia" class="toolactivo tool">
                           - COPIA SIMPLE <input type="radio" name="copia" value="1"/>
                           - COPIA CERTIFICADA <input type="radio" name="copia" value="2"/>
                        </div>
                    </td>
                 </tr>
                 
            </table>
        </fieldset>
        <fieldset>
            <legend class='sub_form'>FORMAS IVSS</legend>
            <table class="activo_opciones">
                <tr>
                    <td>14-02 (REGISTRO ASEGURADO) <input type="checkbox" name="forma[1402]" value="8" id="14-02"/>
                        <span id="n_14-02">CANTIDAD 
                            <?php
                                for ($i=0; $i < count($cantidad); $i++) { 
                                    if ($cantidad[$i]['id']==8){
                                        echo $cantidad[$i]['campo'];
                                    }
                                 } 
                                    
                                
                                
                            ?>
                        </select></span></td>
                    <td>14-03 (PARTIDA DE RETIRO) <input type="checkbox" name="forma[1403]" value="9" id="14-03"/>
                        <span id="n_14-03">CANTIDAD 
                            <?php
                                for ($i=0; $i < count($cantidad); $i++) { 
                                    if ($cantidad[$i]['id']==9){
                                        echo $cantidad[$i]['campo'];
                                    }
                                 } 
                                    
                                
                                
                            ?>
                        </select></span></td>
                    <td>14-100 (CONSTANCIA TRABAJO) <input type="checkbox" name="forma[14100]" value="10" id="14-100"/>
                        <span id="n_14-100">CANTIDAD 
                            <?php
                                for ($i=0; $i < count($cantidad); $i++) { 
                                    if ($cantidad[$i]['id']==10){
                                        echo $cantidad[$i]['campo'];
                                    }
                                 } 
                                    
                                
                                
                            ?>
                        </select></span></td>
                    <td>RECTIFICACI&Oacute;N DE IVSS<input type="checkbox" name="forma[rectificacion]" value="11"/></td>
                </tr>
            </table>
        </fieldset>
        <fieldset>
            <legend class="sub_form">PRESTACIONES</legend>
            <TABLE>
                <tr>
                    <td id="liq">LIQUIDACI&Oacute;N DE PRESTACIONES SOCIALES <input type="radio" name="prest" value="12" id="liquidacion"/></td>
                
                    <td id="fid">ANTICIPOS DE PRESTACIONES (FIDEICOMISO) <input type="radio" name="prest" value="13" id="fideicomiso"/></td>
                </tr>
                <tr>
                    <td>
                        <div id="r_liquidacion" class="tooliqui rtool">
                           - CARTA DE SOLICITUD DE FINIQUITO</br>
                           - CONSTANCIA DE CESE DE CONTRALORIA
                        </div>
                    </td>
                    <td>
                       <div id="r_anticipo" class="tanticipo rtool">
                            <table class="border_table">

                                <tr>
                                    <td>GENERALES</td>
                                    <td>MOTIVOS (ART&Iacute;CULO 144 L.O.T.T.T)</td>
                                </tr>
                                <tr>
                                    <td>- OFICIO DE SOLICITUD </td>
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
                                                    - PRESUPUESTO OBRA
                                                </td>
                                                <td>
                                                    - GRAVAMEN
                                                </td>
                                                <td>
                                                    - CONSTANCIA DE ESTUDIO / PLANILLA INSCRIPCI&Oacute;N
                                                </td>
                                                <td>
                                                    - INFORME M&Eacute;DICO
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    - OFERTA DE VENTA
                                                </td>
                                                <td>
                                                    - DOCUMENTO HIPOTECA
                                                </td>
                                                <td>
                                                    - PRESUPUESTO O </BR>FACTURA CERTIFICADA
                                                </td>
                                                <td>
                                                    - PRESUPUESTO DEL CENTRO M&Eacute;DICO
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>- PRESUPUESTO REPUESTO</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                          </div> 
                    </td>
                </tr>
            </TABLE>
        </fieldset>
        <fieldset>
            <legend class="sub_form">SOLICITUD ADICIONAL</legend>
            <table>
                <tr>
                    <td class="activo_opciones">PAGO DE PRIMA <input type="checkbox" name="prima" value="prima" id="pago"/></td>
                    <td class="act_jub_opc">GASTOS MORTUORIOS <input type="checkbox" name="adicional[gastos]" value="15" class="gastos"/></td>
                </tr>
                <tr >
                    <td>
                        <div id="primas" class="toolhcm tool">
                          <table>  
                              <tr>
                                <td>- PROFESIONALIZACI&Oacute;N <input type="checkbox" name="adicional[estudio]" value="14" id="estudio"/></td>
                                <td>- HIJO <input type="checkbox" name="adicional[hijo]" value="48" id="hijo"/></td>
                              </tr>
                              <tr>
                                  <td></td>
                                  <td>
                                      <div id="r_hijo" class="thogar rtool_i">
                                          - ORIGINAL Y COPIA DE PARTIDA DE NACIMIENTO 
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>- HOGAR <input type="checkbox" name="adicional[hogar]" value="49" id="matrimonio"/></td>
                                  <td>- ANTIG&Uuml;EDAD <input type="checkbox" name="adicional[antiguedad]" value="50" id="antiguedad"/></td>
                              </tr>
                              <tr>
                                  <td>
                                      <div id="r_matrimonio" class="thogar rtool_i">
                                        - ORIGINAL Y COPIA DE ACTA DE MATRIMONIO
                                      </div>
                                  </td>
                                  <td>
                                      <div id="r_antig" class="thogar rtool_i">
                                          - ORIGINAL Y SOPORTES DE TRAYECTORIA
                                      </div>
                                  </td>
                              </tr>
                          </table>
                        </div>
                     </td>
                </tr>
                <tr class="activo_opciones">
                    <td>BONIFICACI&Oacute;N DE MATRIMONIO<input type="checkbox" name="adicional[bono_matrimonio]" value="23" id="b_matrimonio"/></td>
                    <td>BONIFICACI&Oacute;N POR NACIMIENTO DE HIJO<input type="checkbox" name="adicional[bono_hijo]" value="24" id="b_hijo"/></td>
                </tr>
                <tr>
                    <td>
                        <div id="r_bmatrimonio" class="tbmatrimonio rtool_i">
                            - ORIGINAL Y COPIA DE ACTA DE MATRIMONIO</br>
                            - ORIGINAL Y COPIA DE UNI&Oacute;N ESTABLE</br>
                        </div>
                    </td>
                    <td>
                        <div id="r_bhijo" class="treclamo rtool_i">
                            - ORIGINAL Y COPIA DE PARTIDA DE NACIMIENTO 
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="jubilado_opciones">HOMOLOGACI&Oacute;N DE JUBILADO / PENSIONADO <input type="checkbox" name="adicional[homolo]" value="16" id="homolog"/></td>  
                    
                </tr>
                <tr class="activo_opciones">
                   <td>SOLICITUD DE JUBILACI&Oacute;N <input type="checkbox" name="adicional[jubilacion]" value="17" id="jubilacion"/></td>
                   <td>SOLICITUDES VARIAS HCM <input type="checkbox" name="hcm" value="hcm" id="hcm"/></td>
                   
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="opciones_hcm toolhcm tool">
                            <table>
                                <tr>
                                    <td>- SOLICITAR INCLUSI&Oacute;N DE FAMILIARES <input type="checkbox" name="adicional[inclusion]" value="18" id="inclusion"/></td>
                                    <td>- SOLICITAR EXCLUSI&Oacute;N FAMILIAR <input type="checkbox" name="adicional[exclusion]" value="51" id="exclusion"/></br></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div id="r_inclusion" class="tinclusion rtool_i">
                                            - COPIA DE PARTIDA</br>DE NACIMIENTO</br>
                                            - PLANILLA HCM </br>
                                            - DOCUMENTOS FILIATORIOS </br>
                                            - 5 FOTOCOPIAS DE LA C&Eacute;DULA </br>
                                        </div>
                                    </td>
                                    <td>
                                        <div id="r_exclusion" class="texclusion rtool_i">
                                            - CARTA DE SOLICITUD DE EXCLUSI&Oacute;N</br>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>- RECLAMOS <input type="checkbox" name="adicional[reclamos]" value="52" id="reclamos"/></td>
                                    <td>- REEMBOLSOS <input type="checkbox" name="adicional[reembolsos]" value="53" id="poliza"/></td>
                                </tr>
                                <tr>
                                    <td><div id="r_reclamos" class="treclamo rtool_i">- OFICIO DEL RECLAMO</div></td>
                                    <td>
                                        <div id="r_poliza" class="treembolso rtool_i">
                                            - ORIGINAL Y 2 COPIAS DE PLANILLA DE REEMBOLSOS</br>
                                            - ORIGINAL Y 4 COPIAS DE SOPORTES M&Eacute;DICOS Y FACTURAS</br>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td class="activo_opciones">CONSIGNAR DOCUMENTOS PARA EXPEDIENTE <input type="checkbox" name="adicional[consignar]" value="20" id="exp"/></td>
                    <td class="act_jub_opc">NOTIFICACI&Oacute;N DE DEFUNCI&Oacute;N/ PENSI&Oacute;N DE SOBREVIVIENTE<input type="checkbox" name="adicional[notificacion]" value="21" class="gastos"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div id="r_mortuorio" class="tmortuorio rtool_i">
                           - ORIGINAL Y COPIA ACTA DE DEFUNCI&Oacute;N </br>
                           - ORIGINAL Y COPIA(S) PARTIDA(S) DE NACIMIENTO </br>
                           - ORIGINAL Y COPIA CONSTANCIA CONCUBINATO </br>(SI FUNCIONARIO /TRABAJADOR FALLECIDO MANTENIA UNI&Oacute;N CONCUBINARIA) </br>
                           - COPIA(S) C&Eacute;DULA(S) DE HEREDEROS </br>
                           - DECLARACI&Oacute;N DE &Uacute;NICOS UNIVERSALES HEREDEROS
                        </div>
                    </td>
                </tr>
                <tr class="activo_opciones">
                    <td>SOLICITUD DE VACACIONES <input type="checkbox" name="adicional[vacaciones]" value="46" id="vac"/></td>
                    <td>REPOSOS <input type="checkbox" name="adicional[reposo]" value="47" id="reposo"/></td>
                </tr>
                <tr>
                    <td>
                        <div id="r_vacaciones" class="tvaca rtool_i">
                           - PLANILLA DE SOLICITUD DE VACACIONES </br>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>OTRO: <input type="checkbox" name="adicional[otro]" value="22" id="otro_adicional"/>
                        <input type="text" size="20" maxlength="20" name="otro" id="otro"/></td>
                </tr>
                <tr>
                    <td colspan="2">OBSERVACI&Oacute;N: <input type="text" name="observacion" size ="100" maxlength="150" /></td>
                </tr>
            </table>
            
        </fieldset>
        
</fieldset>
<fieldset>
    <fieldset>
        <legend class="sub_form" >DOCUMENTOS Y RECAUDOS</legend>
        <p><b>PARA TODAS LAS SOLICITUDES: </b> COPIA AMPLIADA Y LEGIBLE DE LA C&Eacute;DULA DE IDENTIDAD</p></br>
        
    </fieldset>
    <fieldset>
        <table align="center">
            <tr>
                <td></td><td><b>FECHA DE SOLICITUD </b></td><td></td>
            </tr>
            <tr>
                <td></td><td></td><td></td>
            </tr>
            <tr>
                <td></td><td><div  style="font-style: 10px !important;"><?php echo date("d").'/'.date("m").'/'.date("Y");   ?></div></td><td></td>
            </tr>
            <tr>
                <td></td><td></td><td></td>
            </tr>
            <tr>
                <td></td><td><input type="submit" value="REGISTRAR"/></td><td></td>
            </tr>
        </table>
    </fieldset>
</form>
</fieldset>