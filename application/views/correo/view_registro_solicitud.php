<?php 
 
?>
<div>
    <span class="titulo_form span-24 last">Acuse de Recibo</span>
    <div class="span-12">
        N&uacute;mero de Solicitud:<?php echo $id; ?>
    </div> 
    <div class="span-12 last">
        Fecha de Solicitud:<?php echo $fecha; ?>
    </div>
    <div class="span-24 last">
        <fieldset>
            <legend>Datos Personales</legend>
            <table>
                <tr>
                    <td>C&eacute;dula de Identidad:<?php echo $ci; ?></td>
                    <td>Nombre y Apellido:<?php echo $nombres; ?></td>
                </tr>
                <tr>
                    <td>Ubicaci&oacute;n Administrativa:<?php echo $ubi_adm; ?></td>
                </tr>
            </table>
        </fieldset>
    </div>
    <div class="span-24 last">
        <fieldset>
            <legend>Documentos Solicitados</legend>
            <table class="tablas">
                <tr class="td_tablas">
                    <td class="td_tablas span-1">Tipo de Documento</td>
                    <td class="td_tablas span-10">Documento</td>
                    <td class="td_tablas span-11">Recaudos</td>
                    <td class="td_tablas span-2">Plazo de Entrega</td>
                </tr>
                
    <?php //  
       /* echo '<pre>';
        print_r($adicional);
        echo '</pre></br>';*/
        /*echo '<pre>';
        print_r($recaudo);
        echo '</pre></br>';*/
        if (isset($tramite)){
            $i=count($tramite);
            ?>
            <tr>
            <td rowspan="<?php echo $i; ?>"  class="td_tablas">Tr&aacute;mites</td>    
            <?php 
        
            foreach ($tramite as $value) {
                
                
                if ($value['id']==7){
                    echo "<td class='td_tablas'>{$value['nombre']} (Tipo de Copia: {$value['copia']['nombre']})</td>"; 
                }
                if ($value['id']==2){
                    echo "<td class='td_tablas'>{$value['nombre']} (Tipo: {$value['const_trab']['nombre']})</td>"; 
                }
                if ($value['id']==4){
                    echo "<td class='td_tablas'>{$value['nombre']} (Tipo: {$value['const_jub']['nombre']})</td>"; 
                }
                if (($value['id']!=7)&&($value['id']!=2)&&($value['id']!=4)){
                    echo "<td class='td_tablas'>{$value['nombre']}</td>"; 
                }
                echo "<td class='td_tablas'>No Aplica</td> ";
                echo '<td class="td_tablas">'.$value['plazo'].'</td></tr>'; 
            }
            
            
        }
        if (isset($forma)){
            $i=count($forma);
            echo "<tr>
                    <td rowspan='$i' class='td_tablas'> Formas </td>";
            foreach ($forma as $value){
                
                echo "<td class='td_tablas'>{$value['nombre']}</td>";
                echo "<td class='td_tablas'>No Aplica</td>";
                echo "<td class='td_tablas'>{$value['plazo']}</td></tr>";
            }
            
        }
        if (isset($prest)){
            $i=count($prest);
            echo "<tr>
                    <td class='td_tablas'> Prestaciones </td>";

            //echo $recaudo[0]['id_documento'];
            
            
            echo "<td class='td_tablas'>{$prest['nombre']}</td>";
            echo "<td class='td_tablas'>";
            $k=count($recaudo);
            for ($j=0;$j<$k && $recaudo[$j]['id_documento'];$j++){
                if ($recaudo[$j]['id_documento']==$prest['id']){
                    echo "- {$recaudo[$j]['nombre']}</br>";
                }
            }
            echo "</td><td class='td_tablas'>{$prest['plazo']}</td>";
            echo "</tr>";
            
        }
        $cant_doc=0;
        $cant_docn=0;
        if (isset($adicional)){
            $i=  count($adicional);
            
//           if (isset($adicional[18])){
//                $cant_doc=$cant_doc+1;
//                $cant_docn=$cant_docn+ count($adicional[18]['sub_doc']);
//                
//            }
//            if (isset($adicional[14])){
//                $cant_doc=$cant_doc+1;
//                $cant_docn=$cant_docn+ count($adicional[14]['sub_doc']);
//
//            } 
//             
//            if ($cant_doc==1){
//                $i=$i+$cant_docn-1;
//            }
//            if ($cant_doc==2){
//                $i=$i+$cant_docn-2;
//            }
                
                echo "<tr>
                    <td rowspan='$i' class='td_tablas'>Solicitudes Adicionales</td>";
            
            
            foreach ($adicional as $value){
//               if (($value['id']==14)||($value['id']==18)){
//                  $k=count($value['sub_doc']);
//                  for ($j=0;$j<$k && $value['sub_doc'][$j]['id_documento'];$j++){
//                      if ($value['sub_doc'][$j]['id_documento']==$value['id']){
//                          echo "<td class='td_tablas'>{$value['nombre']} - {$value['sub_doc'][$j]['nombre']}</td>
//                                <td class='td_tablas'>";
//                          $l=count($s_recaudos);
//                          for ($m=0;$m<$l && $s_recaudos[$m]['id_sub_documento'];$m++){
//                              if ($s_recaudos[$m]['id_sub_documento']==$value['sub_doc'][$j]['id']){
//                                  echo "- {$s_recaudos[$m]['nombre']}</br>";
//                              }
//                          }
//                          
//                          echo "</td><td class='td_tablas'>{$value['sub_doc'][$j]['plazo']}</td>
//                              </tr>";
//                                
//                      }
//                  }
//               }else{
                   
                   echo "<td class='td_tablas'>{$value['nombre']}</td>";
                   echo "<td class='td_tablas'>";
                        $k=count($recaudo);
                    for ($j=0;$j<$k && $recaudo[$j]['id_documento'];$j++){
//                        echo 'entro'.$j.'</br>';
                        if ($recaudo[$j]['id_documento']==$value['id']){
                            echo "- {$recaudo[$j]['nombre']}</br>";
                        }else{
                            
                        }
                    }
                    echo "</td><td class='td_tablas'>{$value['plazo']}</td>";
                    echo "</tr>";
//               }
               
            } 
            
        }
        
        
    ?>
                
            </table>
        </fieldset>
    </div>
</div>











































