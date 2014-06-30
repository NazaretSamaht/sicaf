<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
    
    public $usuario;
    public $clave;
    
    public function __construct() {
        parent::__construct();//var_dump($this->session->userdata('usuario_sicaf'));exit();
        if (! $this->session->userdata('usuario_sicaf')){
            redirect(site_url('usuario/control_usuario'));
        }

        
        
        //$this->load->model('model_menu', 'menu', true);
    }

    public function index() {
        
        $header['arrayCss'] = array('style2.css');
        $header['arrayJs'] = array('javascript.js');
        $header['title'] = 'Bienvenido';
        $this->load->view('header_control',$header);

        $usuario2=$this->session->userdata('usuario_sicaf');
        $data['usuario']=$usuario2;
        if ($data['usuario']['rrhh']==TRUE){
            //es de recursos humanos
            if (($data['usuario']['id_unidad']!='')||($data['usuario']['id_unidad']!=NULL)){
              //el usuario es de recursos humanos, ahora se debe averiguar de que parte y que acceso tiene
                $data['usuario']['desactualizado']=FALSE;
           }else{
               //aunque es de recursos humanos no posee una unidad organizada
                $_SESSION ['messages']['error'][] = "Debe asignars&eacute;le una unidad dentro del sistema para acceder a su perfil correctamente, contacte al administrador"; 
                $data['usuario']['desactualizado']=TRUE;
               
           }
        }
        //var_dump($data);
        //exit();
        $this->session->set_userdata('usuario_sicaf',$data['usuario']);
        $this->load->view('menu/view_menu',$data);
        $this->load->view('footer_control');
        
    }
    
    public function solicitud(){
//        echo 'holamundo';
//       $header['arrayCss'] = array('style2.css');
//       $header['arrayJs'] = array('javascript.js','javascript.js','javascript.js','javascript.js','javascript.js');
//       $header['title'] = 'Planilla &Uacute;nica de Solicitud';
//       $this->load->view('header_control',$header); 
//       $data['usuario']=$this->session->userdata('usuario_sicaf');
//       //aqui valido si el usuario pertenece a RRHH
//       if (($data['usuario']['unidad']=='DIVISION DE GESTION DE RECURSOS HUMANOS')&&($data['usuario']['cargo']=='ANALISTA DE PERSONAL VI')){
//           //es un analista de taquilla
//            $data['msj']='es taquillero';
//            $this->load->view('menu/view_planilla_taquilla',$data);
//       }else{
//           $data['msj']='no es taquillero';
//          $this->load->view('menu/view_planilla_taquilla',$data); 
//       }
//       
//       $this->load->view('footer_control');
    }

    
}


/* End of file menu.php */
/* Location: ./application/controllers/menu.php */