<div class='span-24 last' align='center'>
    <?php
   /*echo "<pre>";
    print_r($original);
    echo "</pre>";
     echo "<pre>";
    print_r($real);
    echo "</pre>";
    $pos = count($original);
    $espacios=intval($pos/3);
    echo $espacios;*/
    //cuento el original
    $pos_o = count($original);
    //cuento el real
    $pos_r = count($real);
    $dif=$pos_o-$pos_r;

    if($dif!=0){
        //echo "entro";
        //eso significa que el arreglo de real no esta completo, entonces yo debo completarlo, con posiciones vacias para que se muestre igual
        for ($i=$pos_r; $i<=$pos_o ; $i++) { 
            $real[$i]['paso_hecho']=$i+1;
            $real[$i]['estatus_hecho']=0;
        }
    }
    /* echo "<pre>";
    print_r($real);
    echo "</pre>";*/
    foreach ($real as $id_r => $value_r) {
        if ($value_r['estatus_hecho']!=0){
            $nombres="{$value_r['nomper']} {$value_r['apeper']}</br>";
            $marcado="<i class='fa fa-check-square-o fa-2x'></i> </br><i class='fa fa-arrow-down fa-2x'></i>";
            $fecha="{$value_r['fecha']}";
        }else{
            $nombres='';
            $marcado="<i class='fa fa-square-o fa-2x'></i>";
            $fecha='';
        }
    
    foreach ($original as $id => $value) {
        

        if (($value['paso']<=3)&&($value['paso']==$value_r['paso_hecho'])){
            echo "<div class='span-6' style='float:left; '>
                <div style='border:black 1px solid;'>{$value['descar']}</br>{$value['estatus']}</div></br>
            <i class='fa fa-arrow-down fa-2x'></i></br>$marcado</br>
            <div style='border:black 1px solid;'>$nombres</br>$fecha</div></div>
            <div class='span-1'><i class='fa fa-long-arrow-right fa-3x' style='margin-top:70px;'></i></div>";
            if ($value['paso']==3){
                echo "<div class='span-1' last><i class='fa fa-long-arrow-down fa-3x' style='margin-top:80px;'></i>
                </br></br><i class='fa fa-long-arrow-down fa-3x'></i></br></br><i class='fa fa-long-arrow-down fa-3x'></i></div></div>";
            }
        }
        /*if ((($value['paso']>3)&&($value['paso']<=6))&&($value['paso']==$value_r['paso_hecho'])){
            echo "<div class='span-6' style='float:right; '>
                <div style='border:black 1px solid;'>{$value['descar']}</br>{$value['estatus']}</div></br>
            <i class='fa fa-arrow-down fa-2x'></i></br>$marcado</br>
            <div style='border:black 1px solid;'>$nombres</br>$fecha</div></div>
            <div class='span-1' style='float:right;'><i class='fa fa-long-arrow-left fa-3x' style='margin-top:70px;'></i></div>";
            if ($value['paso']==6){
                echo "<div class='span-1'><i class='fa fa-long-arrow-down fa-3x' style='margin-top:80px; margin-left:50px;'></i>
                </br></br><i class='fa fa-long-arrow-down fa-3x' style='margin-left:50px;'></i></div></br></br>";
            }
        }
        if ((($value['paso']>6)&&($value['paso']<=9))&&($value['paso']==$value_r['paso_hecho'])){
            echo "<div class='span-6' style='float:left; '>
                <div style='border:black 1px solid;'>{$value['descar']}</br>{$value['estatus']}</div></br>
            <i class='fa fa-arrow-down fa-2x'></i></br>$marcado</br>
            <div style='border:black 1px solid;'>$nombres</br>$fecha</div></div>
            <div class='span-1' style='float:left;'><i class='fa fa-long-arrow-right fa-3x' style='margin-top:70px;'></i></div>";
            if ($value['paso']==9){
                echo "<div class='span-1'><i class='fa fa-long-arrow-down fa-3x' style='margin-top:80px;'></i>
                </br></br><i class='fa fa-long-arrow-down fa-3x'></i></br></br><i class='fa fa-long-arrow-down fa-3x'></i></div>";
            }
        }
        if ((($value['paso']>9)&&($value['paso']<=12))&&($value['paso']==$value_r['paso_hecho'])){
            echo "<div class='span-6' style='float:right; '>
                <div style='border:black 1px solid;'>{$value['descar']}</br>{$value['estatus']}</div></br>
            <i class='fa fa-arrow-down fa-2x'></i></br>$marcado</br>
            <div style='border:black 1px solid;'>$nombres</br>$fecha</div></div>
            <div class='span-1' style='float:right;'><i class='fa fa-long-arrow-left fa-3x' style='margin-top:70px;'></i></div>";
            if ($value['paso']==12){
                echo "<div class='span-1'><i class='fa fa-long-arrow-down fa-3x' style='margin-top:80px;'></i>
                </br></br><i class='fa fa-long-arrow-down fa-3x'style='margin-left:50px;'></i></div>";
            }
        }
        if (($value['paso']==13)&&($value['paso']==$value_r['paso_hecho'])){
            echo "<div class='span-6' style='float:left; '>
                <div style='border:black 1px solid;'>{$value['descar']}</br>{$value['estatus']}</div></br>
            <i class='fa fa-arrow-down fa-2x'></i></br>$marcado</br>
            <div style='border:black 1px solid;'>$nombres</br>$fecha</div></div>
            </div>";
        }*/
        
    }
    }
     ?>
     <!--<p><i class="fa fa-camera-retro fa-lg"></i> fa-camera-retro</p>-->

</div>