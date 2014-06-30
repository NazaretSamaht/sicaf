<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pdf extends CI_Controller {
    
    public $usuario;
    public $clave;
    
    public function __construct() {
        parent::__construct();
        if (! $this->session->userdata('usuario_sicaf')){
            redirect(site_url('usuario/control_usuario'));
        }
        $this->load->model('model_pdf', 'pdf', true);
    }

    public function acuse_recibo($id_solicitud){
        $this->load->library('mpdf/mpdf');
        //$data['id_solicitud']=$id_solicitud;
        $data['arr']=$this->pdf->datos_recibo($id_solicitud);
        /*echo "<pre>";
        print_r($data);
        echo "</pre>";*/
        $header['arrayCss'] = array('estilo_planilla.css','estilo_recibo.css?x=3', 'bootstrap.css');
        //$this->load->view('correo/header_correo', $header);
        //$this->load->view('pdf/view_registro_solicitud',$data);
        $html=$this->load->view('correo/header_correo', $header,true);
        $html.=$this->load->view('pdf/view_registro_solicitud',$data,true);
        $mpdf=new mPDF(); 
        $url=base_url('application/css/bootstrap.css');

        $mpdf->WriteHTML($html);
        //echo $b;
        $mpdf->Output();
        exit;/**/

    }

   
    
    
    

    
}


/* End of file pdf.php */
/* Location: ./application/controllers/pdf.php */