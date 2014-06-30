<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Correspondencia extends CI_Controller {
    
    public $usuario;
    public $clave;
    
    public function __construct() {
        parent::__construct();
        if (! $this->session->userdata('usuario_sicaf')){
            redirect(site_url('usuario/control_usuario'));
        }
        $this->load->model('model_correspondencia', 'corr', true);
    }

    public function index() {
	    $header['arrayCss'] = array('reg_correspondencia.css');
        $header['arrayJs'] = array('reg_correspondencia.js');
        $header['title'] = 'Registro de Correspondencia';
        $this->load->view('header_control', $header);
        
        $data['usuario'] = $this->session->userdata('usuario_sicaf');
        $this->load->view('menu/view_menu', $data);
        
        //echo "dsdfsfd";
        
        if ((isset($_POST)) && !empty($_POST)) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<fieldset class="error">', '</fieldset>');
            $this->form_validation->set_rules('remitente', 'UNIDAD ADMINISTRATIVA DE REMITENTE', "trim|min_length[4]|alpha_numeric|required");
            $this->form_validation->set_rules('tipo_destino', 'TIPO DE UNIDAD DE DESTINATARIO', "required");
            $this->form_validation->set_rules('destino', 'UNIDAD ADMINISTRATIVA DE DESTINATARIO', "required");
            $this->form_validation->set_rules('tipo_correspondencia', 'TIPO DE CORRESPONDENCIA', "required");
            if (isset($_POST['tipo_correspondencia'])){
                if ($_POST['tipo_correspondencia']==1) {
                    $this->form_validation->set_rules('ci', 'C&Eacute;DULA DEL IMPLICADO', "required");
                }
            }
            
            if ($this->form_validation->run() !== FALSE){
                //se guardan los datos y se obtienen los recaudos
                $arr=$this->sol->guardar_solicitud($_POST,$data['usuario']);
                if ($arr['id']!=0){
                    
                    
                    $_SESSION ['messages']['success'][] = "La Solicitud se ha realizado con &Eacute;xito ";
                    
                    //$_SESSION ['messages']['info'][] = "<a href='".site_url("pdf/acuse_recibo/{$arr['id']}")."' target='_blank'><b><i class='fa fa-print fa-lg'></i>&nbsp;&nbsp;Imprimir Acuse de Recibo</b></a>"; 
                    //<a target='_blank'  href='".site_url('solicitud/recibo')."'>Imprimir Acuse de Recibo</a>
                }else{
                    
                    $_SESSION ['messages']['error'][] = "No pudo realizarse el Registro";
                }

            }
            
        }
      
        if ($data['usuario']['rrhh']==TRUE){
                $data['data']=$this->corr->correspondencia();
                $this->load->view('menu/view_registrar_correspondencia', $data);
        }
              
        
           
        
        $this->load->view('footer_control');
    }

    public function tipo_destino($tipo){
        if ($tipo==1){
            //es la direccion de recursos
            $data['unidad']=$this->corr->direccion();

        }
        elseif ($tipo==2) {
            //es división
            $data['unidad']=$this->corr->division();
        }
        elseif ($tipo==3) {
            //es COORDINACIÓN
            $data['unidad']=$this->corr->coord();
        }
        echo json_encode($data);
    }
  
    
    
    

    
}


/* End of file solicitud.php */
/* Location: ./application/controllers/solicitud.php */