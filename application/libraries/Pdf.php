<?php

include 'mpdf/mpdf.php';

class Pdf extends mPDF {
    
    function acuse_recibo ($html){
        
        $this->WriteHTML($html);
//        echo $html;
//        exit();
        $this->Output();
    }
}
?>
