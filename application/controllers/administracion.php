<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administracion extends CI_Controller {
    
    public $usuario;
    public $clave;
    
    public function __construct() {
        parent::__construct();
        if (! $this->session->userdata('usuario_sicaf')){
            redirect(site_url('usuario/control_usuario'));
        }
        $this->load->model('model_organizar', 'org', true);
        
        
        //$this->load->model('model_menu', 'menu', true);
    }

    public function organizar_usuarios() {
        $header['arrayCss'] = array('style2.css','estilo_planilla.css');
        $header['arrayJs'] = array('javascript.js', 'planilla.js');
        $header['title'] = 'Organizaci&oacute;n de Usuarios';
        $this->load->view('header_control', $header);
        $data['usuario'] = $this->session->userdata('usuario_sicaf');
        $this->load->view('menu/view_menu', $data);
        $data['cedulas']= $this->org->cargar_cedulas();
        $data['divisiones']= $this->org->cargar_divisiones();
        $data['coord']= $this->org->cargar_coord();
        
        if ((isset($_POST)) && !empty($_POST)) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<fieldset class="error">', '</fieldset>');
            //echo $_POST['cedulas'];
            
                $this->form_validation->set_rules('cedulas', 'CÉDULA', "required");
            
            
            
            
            $this->form_validation->set_rules('unidad', 'UNIDAD ADMINISTRATIVA', "required");
            if ($this->form_validation->run() !== FALSE){
                //se guardan los datos de la organizacion del usuario
                 $arr=$this->org->guardar_org($_POST);
                if ($arr){
                    $_SESSION ['messages']['success'][] = "El Usuario ha sido organizado con &Eacute;xito";
                    //$data['msj']="El Usuario ha sido organizado con &Eacute;xito";
                    //redirect(site_url('administracion/organizar_usuarios', refresh));
                    //$this->load->view('administracion/view_organizar', $data); 
                }
                
                

             
           } 
         }
        // var_dump($_SESSION);exit();
            $this->load->view('administracion/view_organizar', $data); 
            //redirect(site_url('administracion/organizar_usuarios', refresh));
        
        
        
        $this->load->view('footer_control');
    }
    


    
}


/* End of file administracion.php */
/* Location: ./application/controllers/administracion.php */