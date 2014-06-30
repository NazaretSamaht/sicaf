<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pendiente extends CI_Controller {
    
    public $usuario;
    public $clave;
    
    public function __construct() {
        parent::__construct();
        if (! $this->session->userdata('usuario_sicaf')){
            redirect(site_url('usuario/control_usuario'));
        }
        $this->load->model('model_pendiente', 'pend', true);
        $this->load->model('model_transferir', 'trans', true);
        $this->load->model('model_todos_pendiente', 'tod', true);
    }

    public function index() {
        //documentos pendientes
	    $header['arrayCss'] = array('estilo_planilla.css','demo_page.css','demo_table_jui.css','ui-lightness/jquery-ui-1.8.4.custom.css');
        $header['arrayJs'] = array('javascript.js', 'planilla.js','jquery.dataTables.min.js','pendiente.js', 'TableTools.js','ZeroClipboard.js');
        $header['title'] = 'Procedimientos Pendientes';
        $this->load->view('header_control', $header);
        $usuario2=$this->session->userdata('usuario_sicaf');
        $data['usuario']=$usuario2;
        $this->load->view('menu/view_menu',$data);
        if ((isset($_POST))&&(! empty($_POST))){
            if (isset($_POST['analista'])){
                //var_dump($_POST);
                $arr=$this->pend->asignar_proc($_POST,$data['usuario']);
            }
            if (isset($_POST['enviar'])){
                $arr=$this->pend->ere_proc($_POST,$data['usuario'],'enviar');
            }
            if (isset($_POST['recibir'])){
                $arr=$this->pend->ere_proc($_POST,$data['usuario'],'recibir');
            }
            if (isset($_POST['entregar'])){
                $arr=$this->pend->ere_proc($_POST,$data['usuario'],'entregar');
            }
            if (isset($_POST['exp'])){
                $arr=$this->pend->ere_proc($_POST,$data['usuario'],'exp');
            }
            if (isset($_POST['aprobar'])){
                $arr=$this->pend->ere_proc($_POST,$data['usuario'],'aprobar');
            }
        }

       
        $this->load->view('menu/view_pendiente');
        
        $this->load->view('footer_control');
    }
    
    public function pendientes(){
        $usuario2=$this->session->userdata('usuario_sicaf');
        $data['usuario']=$usuario2;
        if (($data['usuario']['cargo']=='JEFE TECNICO ADMINISTRATIVO VI')||($data['usuario']['cargo']=='JEFE DE DIVISION')){
            //hago consulta de asignacion
            $data['analistas']=$this->pend->analistas_documentacion();
            
            
        }
        //necesito consultar si estan en true o false los registros del flujo, q camino esta tomando

        echo $this->pend->documento_pendientes($data);
    }

    public function transferir(){
        $header['arrayCss'] = array('estilo_planilla.css','demo_page.css','demo_table_jui.css','ui-lightness/jquery-ui-1.8.4.custom.css');
        $header['arrayJs'] = array('javascript.js', 'planilla.js','jquery.dataTables.min.js','transferir.js');
        $header['title'] = 'Transferir Procedimientos';
        $this->load->view('header_control', $header);
        $usuario2=$this->session->userdata('usuario_sicaf');
        $data['usuario']=$usuario2;
        $this->load->view('menu/view_menu',$data);
        $this->load->view('menu/view_transferir');
        if ((isset($_POST))&&(! empty($_POST))){
            //transfirió algo, me toca actualizar
            $arr=$this->trans->actualizar_asignar_proc($_POST,$data['usuario']);
        }
        $this->load->view('footer_control');
    }

    public function transferir_procedimientos(){
        $usuario2=$this->session->userdata('usuario_sicaf');
        $data['usuario']=$usuario2;
        //me traigo todos los analistas a los que se le puede transferir el procedimiento
        $data['analistas']=$this->pend->analistas_documentacion();

        echo $this->trans->transferir_proc($data);
    }

    public function todos_pendientes(){
        $header['arrayCss'] = array('estilo_planilla.css','demo_page.css','demo_table_jui.css','ui-lightness/jquery-ui-1.8.4.custom.css');
        $header['arrayJs'] = array('javascript.js', 'planilla.js','jquery.dataTables.min.js','todos_pendientes.js', 'TableTools.js', 'ZeroClipboard.js');
        $header['title'] = 'Procedimientos de todos los usuarios';
        $this->load->view('header_control', $header);
        $usuario2=$this->session->userdata('usuario_sicaf');
        $data['usuario']=$usuario2;
        $this->load->view('menu/view_menu',$data);
        $this->load->view('menu/view_todos_pendientes');
        
        $this->load->view('footer_control');
    }
    
   
    public function pendientes_general(){
        $usuario2=$this->session->userdata('usuario_sicaf');
        $data['usuario']=$usuario2;
        
        

        echo $this->tod->pendientes_general();
    }
    
    

    
}


/* End of file consulta.php */
/* Location: ./application/controllers/consulta.php */