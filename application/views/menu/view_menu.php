
			<table class="span-24 last"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFF">
			<tr>
				<td width="100%" colspan="2" height="40" valign="middle"><span class="titulo">Opciones del Sistema</span></td>
                                
			</tr>
			<tr>
                          <td colspan="3" align="left" valign="top" class="sub">
<?php 
      $solic='';
      $cons='';
      $track='';
      $cerrar='';
      $org='';
      $pend='';
      $prom='';
      $trans='';
      $pend_tot='';
      $proc='';
      $corr='';
      $usuario=$this->session->userdata('usuario_sicaf');
      /*echo "<pre>";
      print_r($usuario);
      echo "</pre>";*/
      //var_dump($usuario);
  if ($usuario['rrhh']==TRUE){
    //echo "entro rrhh</br>";
     //echo "des={$usuario['desactualizado']}";
    if (isset($usuario['desactualizado'])){
      //echo "entro desactualizado";
      if ($usuario['desactualizado']==TRUE){
        $usuario['rrhh']=FALSE;

        $cerrar='1';
      }
      else{
        $usuario['cargo']=trim($usuario['cargo']);
        //echo "entro usuarios";
        
         if ($usuario['tipo_unidad']=='c'){
          //perfil de coordinación, se debe verificar el cargo, se supone que el cargo ya debe estar por ya paso por lo del desactualizado

          if ($usuario['cargo']=='AGENTE DE ATENCION INTEGRAL'){
            //agente de atención
            $solic='1';
            $cons='1';
            $track='1';
            $cerrar='1';
            $pend='1';
            $proc='1';
            $pend_tot='1';
            $corr='1';
          }
          else if (($usuario['cargo']=='ANALISTA DE PERSONAL III')||($usuario['cargo']=='ASISTENTE DE ANALISTA IV')||($usuario['cargo']=='ANALISTA DE PERSONAL II')||($usuario['cargo']=='ASISTENTE ADMINISTRATIVO III')){
            //analista estandar, de archivo
            $cons='1';
            $track='1';
            $cerrar='1';
            $pend='1';
            $proc='1';
            $pend_tot='1';
          }
          else if (($usuario['cargo']=='JEFE TECNICO ADMINISTRATIVO VI')||($usuario['cargo']=='JEFE TECNICO ADMINISTRATIVO III')||($usuario['cargo']=='JEFE TECNICO ADMINISTRATIVO IV')){
            //COORDINADOR
            $cons='1';
            $track='1';
            $cerrar='1';
            $pend='1';
            $proc='1';
            $prom='1';
            $trans='1';$solic='1';$pend_tot='1';
          }
          else if (($usuario['cargo']=='ARCHIVISTA')||($usuario['cargo']=='ARCHIVISTA I')||($usuario['cargo']=='ARCHIVISTA II')||($usuario['cargo']=='ARCHIVISTA III')){
            //ANALISTA DE ARCHIVO
            $cons='1';
            $track='1';
            $cerrar='1';
            $pend='1';
            $proc='1';
            $pend_tot='1';
          }
          else{
            $_SESSION ['messages']['success'][] = "Usted no esta autorizado para entrar al Sistema";
            $cerrar='1';
          }

          
        }
        if ($usuario['tipo_unidad']=='d'){
          if ($usuario['cargo']=='JEFE DE DIVISION'){
              //agente de atención
              $solic='1';
              $cons='1';
              $track='1';
              $cerrar='1';
              $pend='1';
              $proc='1';
              $prom='1';
              $trans='1';$pend_tot='1';
          }
          else{
            $_SESSION ['messages']['success'][] = "Usted no esta autorizado para entrar al Sistema";
            $cerrar='1';
          }
        }
        if ($usuario['tipo_unidad']=='dd'){
          if ($usuario['cargo']=='DIRECTOR'){
              //agente de atención
              $solic='1';
              $cons='1';
              $track='1';
              $cerrar='1';
              $pend='1';
              $proc='1';
              $prom='1';$pend_tot='1';
          }
          else if ($usuario['cargo']=='ADMINISTRADOR'){
            $solic='1';
            $cons='1';
            $track='1';
            $cerrar='1';
            $org=1;$proc='1';$prom='1';$trans='1';$pend_tot='1';$corr='1';

          }
          else if ($usuario['cargo']=='SECRETARIA'){
            $solic='1';
            $cons='1';
            $track='1';
            $cerrar='1';
            $pend='1';
            $proc='1';$prom='1';$pend_tot='1';
          }
          else {
            $_SESSION ['messages']['success'][] = "Usted no esta autorizado para entrar al Sistema 1";
            $cerrar='1';
          }
        }
      }
    }
    
  }else{
      $_SESSION ['messages']['success'][] = "Usted no esta autorizado para entrar al Sistema 2";
      $cerrar='1';
  }


  if ($solic=='1'){
    $solic='<span id="" class="span-8"></span><a href="'.site_url("solicitud").'  " ><i class="fa fa-clipboard fa-lg"></i>&nbsp;&nbsp;Solicitar Procedimiento</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  if ($cons=='1'){
    $cons='<span id="" class="span-8"></span><a href="'.site_url("consulta").'" ><i class="fa fa-list-alt fa-lg"></i>&nbsp;&nbsp;Consultar Solicitudes</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  if ($track=='1'){
    $track='tracking';
  }
  if ($cerrar=='1'){
    $cerrar='<span id="" class="span-8"></span><a href="'.site_url("usuario/cerrar_sesion").'" ><i class="fa fa-key fa-lg"></i>&nbsp;&nbsp;Cerrar Sesi&oacute;n</a>';
  }
  if ($org=='1'){
    $org='<span id="" class="span-8"></span><a href="'.site_url("administracion/organizar_usuarios").'" ><i class="fa fa-group fa-lg"></i>&nbsp;&nbsp;Organizar Usuarios</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  if ($pend=='1'){
    $pend='<span id="" class="span-8"></span><a href="'.site_url("pendiente").'" ><i class="fa fa-check-square-o fa-lg"></i>&nbsp;&nbsp;Procedimientos Pendientes</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  if ($proc=='1'){
    $proc='<span id="" class="span-8"></span><a href="'.site_url("consulta/procedimientos").'" ><i class="fa fa-list-ul fa-lg"></i>&nbsp;&nbsp;Consultar Procedimientos</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  if ($prom=='1'){
    $prom='<span id="" class="span-8"></span><a href="'.site_url("consulta/totales_analistas").'" ><i class="fa fa-tasks fa-lg"></i>&nbsp;&nbsp;Consultar Totales de Analistas</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  if ($trans=='1'){
    $trans='<span id="" class="span-8"></span><a href="'.site_url("pendiente/transferir").'" ><i class="fa fa-exchange fa-lg"></i>&nbsp;&nbsp;Transferir Procedimientos</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  if ($pend_tot=='1'){
    $pend_tot='<span id="" class="span-8"></span><a href="'.site_url("pendiente/todos_pendientes").'" ><i class="fa fa-check-square fa-lg"></i>&nbsp;&nbsp;Todos los Pendientes </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  if ($corr=='1'){
    $corr='<span id="" class="span-8"></span><a href="'.site_url("correspondencia").'" ><i class="fa fa-file-archive-o fa-lg"></i>&nbsp;&nbsp;Registrar Correspondencia </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
echo $solic;echo $corr;echo $cons;echo $proc;echo $pend; echo $pend_tot; echo $trans; echo $prom; echo $org;echo $cerrar;

?>
                                
                                
                                <!--<span id="" class="span-8"></span><a href="<?php //echo site_url($track); ?>" >Generar Tracking</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                                
                                
                                

                                </td>
				</tr> 
                                <tr>
                                    <td>
                                        <hr class="gris">
                                    </td>
                                </tr>
                           <tr>
                                <td colspan="2" style="font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight: bold;color: #333;" align="right"><b>
                                       <?php
                                       if (isset($_SESSION['messages'])){
                                           foreach ($_SESSION['messages'] as $class=>$reg){
                                               foreach ($reg as $i){
                                                   echo "<div class='$class'>$i</div>";
                                               }
                                           }
                                           unset($_SESSION['messages']);
                                        }
                                        echo "Id_unidad:{$usuario['id_unidad']}</br>";
                                       echo "Tipo de Unidad:{$usuario['tipo_unidad']}</br>";
                                        echo "Cargo:{$usuario['cargo']}</br>";
                                       /*echo "<pre>";
                                       print_r($usuario);
                                       echo "</pre>";*/
                                       //var_dump($usuario);
									   
                                       ?>
                                        
                                    </b></td>
                            </tr>
			
			</table>




<?php


?>