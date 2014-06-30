<style type="text/css">
    .barcode {
        padding: 1.5mm;
        margin: 0;
        vertical-align: top;
        color: #000000;
    }
    .barcodecell {
        text-align: center;
        vertical-align: middle;
        padding: 0;
    }
    .celdas{
        border: 1px solid orange;
        padding: 4px;
        border-spacing: 2px;
    }
    table { 
        border-spacing: 4px;
        border-collapse: separate;
        width:100%;
    }
    .tamano{
        width: 342px;
    }
    


}
</style>
<div>
    <div align="center" style="font-size:20px; padding-top:30px;padding-bottom:30px;"><b>ACUSE DE RECIBO</b></div>
    <div>
        <div>
<?php 
    $i=0;
    foreach ($arr as $a) {
        $i++;
        if ($i==1){
          

?>
            <table style="padding-bottom:20px;">
                <tr>
                    <td class="celdas"><b>N&uacute;mero de Solicitud:</b><?php echo $a['id_solicitud']; ?></td>
                    <td class="celdas"><b>Fecha de Solicitud:</b><?php echo $a['fecha_solicitud']; ?></td>
                </tr>
            </table>
        </div>
        
        <div style="font-size:18px;">
            <b>Datos Personales</b>
        </div>
        <div>
            <table  style="padding-bottom:20px;">
                <tr>
                    <td class="celdas"><b>Nombre y Apellido:</b><?php echo $a['nombre_apellido']; ?></td>
                    <td class="celdas" ><b>C&eacute;dula:</b><?php echo $a['cedula']; ?>
                    </td>
                </tr>
                <tr>
                   <td class="celdas"><b>Direcci&oacute;n de Habitaci&oacute;n:</b><?php echo $a['dirper']; ?></td>
                   <td class="celdas"><b>Tel&eacute;fono Celular: </b><?php echo $a['tlf_celular']; ?></br> <b> Tel&eacute;fono Local: </b><?php echo $a['tlf_habitacion']; ?></td> 
                </tr>
                <tr>
                    <td class="celdas"><b>Correo:</b><?php echo $a['correo']; ?></td>
                    <td class="celdas"><b>Ubicaci&oacute;n Administrativa:</b><?php echo $a['ubi_adm']; ?></td>
                </tr>
                <tr>
                    <td class="celdas"><b>N&oacute;minas:</b><?php echo $a['nominas']; ?></td>
                    <td class="celdas"><b>C&oacute;digo de Barras:</b><barcode code="<?php echo $a['id']; ?>" type="C93" size="0.8" class="barcode" text="1" /></td>
                </tr>
                
            </table>
        </div>
        
    </div>
   
    <div style="font-size:18px;">
        <b>Procedimientos Solicitados</b>
     </div>
     <div>
         <table style="text-align:center; padding-bottom:120px;">
             <tr>
                 <td class="celdas"><b>N&uacute;mero</b></td>
                 <td class="celdas"><b>Tipo</b></td>
                 <td class="celdas"><b>Procedimiento</b></td>
                 <td class="celdas"><b>Copias</b></td>
                 <td class="celdas"><b>Recaudos</b></td>
                 <td class="celdas"><b>Plazo</b></td>
             </tr>
         
<?php 
        }
        if ($a['t_jub']!=''){
            $a['t_jub']='-'.$a['t_jub'];
        }
        if ($a['t_trab']!=''){
            $a['t_trab']='-'.$a['t_trab'];
        }
        
        ?>
        <tr>
            <td class="celdas"><?php echo $a['id']; ?></td>
            <td class="celdas"><?php echo $a['t_doc']; ?></td>
            <?php 
            if ($a['procedimiento']=='CONSTANCIA DE TRABAJO'){
                echo "<td class='celdas'>{$a['procedimiento']} {$a['t_trab']}</td>";
            } elseif ($a['procedimiento']=='CONSTANCIA JUBILADO') {
                echo "<td class='celdas'>{$a['procedimiento']} {$a['t_jub']} </td>";
            }ELSE{
                echo "<td class='celdas'>{$a['procedimiento']}</td>"; 
            }
            ?>
            
            <td class="celdas"><?php echo $a['cant_proc']; ?></td>
            <td class="celdas"><?php echo $a['recaudos']; ?></td>
            <td class="celdas"><?php echo $a['plazo']; ?></td>
        </tr>
    
       
   <?php }
?>
        </table>
    </div>
    <div align="center">
        <span><b>Firma y Sello</b></span>
    </div>
    
</div>
