<div class='span-24 last'>
    <?php
  
    /*$pos = count($original);
    $espacios=intval($pos/3);
    echo $espacios;*/
    $tipo_flujo=$real['tipo_flujo'];
    unset($real['tipo_flujo']);
    #echo "<pre>";
    #print_r($original);
    #echo "</pre>";
    #echo "<pre>";
    #print_r($real);
    #echo "</pre>";
    /*echo "<pre>";
    print_r($real);
    echo "</pre>";*/ 
    $pos=count($original);
    $prs=count($real);
    
   //
    if ($pos!=$prs){
        //no tienen la misma cantidad de posiciones, tengo que rellenar el arreglo de real
        #echo $pos.'-'.$prs;
        for ($i=$prs; $i<$pos ; $i++) { 
           
                /*$real[$i-1]['estatus_hecho']=0;
                $real[$i-1]['paso_hecho']=0;
                $real[$i-1]['nomper']='Sin Realizar';
                $real[$i-1]['apeper']='';
                $real[$i-1]['fecha']='';
                $real[$i-1]['tipo_flujo']=$tipo_flujo;
                $real[$i-1]['observacion']='';*/
                $real[$i]['estatus_hecho']=0;
                $real[$i]['paso_hecho']=0;
                $real[$i]['nomper']='Sin Realizar';
                $real[$i]['apeper']='';
                $real[$i]['fecha']='';
                $real[$i]['tipo_flujo']=$tipo_flujo;
                $real[$i]['observacion']='';
        }
    }

    d($real);

     ?>

    <div class='span-24 last'>
        <span style='background:#e6efc2; color:#264409; border:2px solid #c6d880; -webkit-border-radius: 4px; padding:3px;'><b>Paso Realizado</b></span>
        <span style='background:#fff6bf; color:#514721; border:2px solid #ffd324;-webkit-border-radius: 4px;padding:3px;'><b>Paso Actual</b></span>
        <span style='background:#ccc; color:#fff; border:2px solid #808080;-webkit-border-radius: 4px;padding:3px;'><b>Paso No Realizado</b></span>
    </div>
    <div class="container">
        

        <div id="timelineContainer" class="timelineContainer">
            <div class="timelineToggle"><p><a class="expandAll">Expandir Todos</a></p></div>

            
                <?php 
                
                
                //$acuerdo=false;
                for ($i=0; $i < $pos; $i++) { 
                    
                    #echo "paso_hecho:".$real[$i]['paso_hecho'].'1</br>';
                    //var_dump($real[$i]['paso_hecho']);
                    if ($real[$i]['paso_hecho']!=0){
                        //tiene algo que esta hecho, a revisar que todas sus ramas esten hechas
                        //echo "tipo_flujo:$tipo_flujo";
                        //var_dump((($real[$i+1]['tipo_flujo']=='')||($real[$i+1]['tipo_flujo']==NULL)));
                        if (isset($real[$i+1]['paso_hecho'])){
                            #echo "entro";
                            if ($real[$i+1]['paso_hecho']==0){
                                $color="background:#fff6bf; color:#514721; border:2px solid #ffd324;";
                            
                            }else{
                                //if (($real[$i+1]['paso_hecho']==1)||($real[$i+1]['paso_hecho']==2)){}
                                $color="background:#e6efc2; color:#264409; border:2px solid #c6d880;";
                            }
                        }else{
                            $color="background:#fff6bf; color:#514721; border:2px solid #ffd324;";
                            
                        }
                        
                        
                    }else{
                        $color="background:#ccc; color:#fff; border:2px solid #808080;";
                        
                    }
                    
                    if ($real[$i]['fecha']==''){
                        $fecha='';
                    }else{
                        $fecha=date('d/m/Y h:i:s a',strtotime($real[$i]['fecha']));
                        
                        
                    }
                    //if (($original[$i]['tipo_flujo']==$tipo_flujo)&&($real[$i]['tipo_flujo']==$tipo_flujo)){

                    

                        echo "<div class='timelineMajor'>
                                    <h2 class='timelineMajorMarker'><span style='$color font-size:18px;font-family: Arial, Helvetica, sans-serif;'><b>{$original[$i]['descar']}</b></span></h2>
                                    <dl class='timelineMinor'>
                                        <dt id='{$original[$i]['paso']}' style='font-size:14px;'><a>{$original[$i]['estatus']}</a></dt>
                                        <dd class='timelineEvent' id='{$original[$i]['paso']}EX' style='display:none;''>
                                            <p style='font-weight: bold;'>{$real[$i]['nomper']} {$real[$i]['apeper']} ".$fecha."
                                            </br>Observaci&oacute;n:{$real[$i]['observacion']}</p>
                                            <br class='clear'>
                                        </dd>
                                    </dl>";

                        if ((isset($original[$i+1]))&&($original[$i]['descar']==$original[$i+1]['descar'])){
                            //if (isset($real[$i+1])){
                                //echo "fecha:{$real[$i+1]['fecha']}";
                                //var_dump(($real[$i+1]['fecha']=='')||($real[$i+1]['fecha']==NULL));
                               if (isset($real[$i+1]['fecha'])){
                                    if (($real[$i+1]['fecha']=='')||($real[$i+1]['fecha']==NULL)){
                                        //echo "entro";
                                        $fecha='';
                                    }else{
                                        $fecha=date('d/m/Y h:i:s a',strtotime($real[$i]['fecha']));
                                    }
                                }else{
                                    $fecha='';
                                    
                                }
                                if (isset($original[$i+1])){
                                    if (isset($real[$i+1])){
                                         echo "<dl class='timelineMinor'>
                                            <dt id='{$original[$i+1]['paso']}' style='font-size:14px;'><a>{$original[$i+1]['estatus']}</a></dt>
                                            <dd class='timelineEvent' id='{$original[$i+1]['paso']}EX' style='display:none;''>
                                                <p style='font-weight: bold;'>{$real[$i+1]['nomper']} {$real[$i+1]['apeper']} ".$fecha."
                                                </br>Observaci&oacute;n:{$real[$i+1]['observacion']}</p>
                                                <br class='clear'>
                                            </dd>
                                        </dl>";
                                    }else{
                                        echo "<dl class='timelineMinor'>
                                            <dt id='{$original[$i+1]['paso']}' style='font-size:14px;'><a>{$original[$i+1]['estatus']}</a></dt>
                                            <dd class='timelineEvent' id='{$original[$i+1]['paso']}EX' style='display:none;''>
                                                <p style='font-weight: bold;'>Sin Realizar
                                                </br>Observaci&oacute;n</p>
                                                <br class='clear'>
                                            </dd>
                                        </dl>";
                                    }
                                   
                                }
                                //if (($original[$i+1]['tipo_flujo']==$tipo_flujo)&&($real[$i+1]['tipo_flujo']==$tipo_flujo)){
                                    
                                    $i++;
                                //}
                            }

                        //}
                        echo "</div>";
                    //}
                }


                ?>

                <br class="clear">
        </div>

        <br>
        <br>
        
<?php 
    
?>

   



</div>