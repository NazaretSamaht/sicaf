<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consulta extends CI_Controller {
    
    public $usuario;
    public $clave;
    
    public function __construct() {
        parent::__construct();
        if (! $this->session->userdata('usuario_sicaf')){
            redirect(site_url('usuario/control_usuario'));
        }
        $this->load->model('model_solicitud', 'sol', true);
    }

    public function index() {
	$header['arrayCss'] = array('estilo_planilla.css','demo_page.css','demo_table_jui.css','ui-lightness/jquery-ui-1.8.4.custom.css');
        $header['arrayJs'] = array('planilla.js','jquery.dataTables.min.js','consulta.js','TableTools.js','ZeroClipboard.js', 'jquery.dataTables.min.js');
        $header['title'] = 'Consulta de Solicitudes';
        $this->load->view('header_control', $header);
        $usuario2=$this->session->userdata('usuario_sicaf');
        $data['usuario']=$usuario2;
        $this->load->view('menu/view_menu',$data);
        $this->load->view('menu/view_solicitud_documento');
        
        $this->load->view('footer_control');
    }
    
    public function solicitudes_documentos(){
        $this->load->model('model_consulta','cons');
        echo $this->cons->solicitud_documento();
    }
    
    public function documentos($id){
        $this->load->model('model_consulta','cons');
        $header['arrayCss'] = array('estilo_planilla.css','demo_page.css','demo_table_jui.css','ui-lightness/jquery-ui-1.8.4.custom.css');
        $header['arrayJs'] = array('javascript.js', 'planilla.js','jquery.dataTables.min.js','consulta.js','consulta_documentos.js');
        $header['title'] = 'Consulta de Documentos';
        $this->load->view('header_control', $header);
        $usuario2=$this->session->userdata('usuario_sicaf');
        $data['usuario']=$usuario2;
        $data1['id_solicitud']=$id;
        //consulta otros datos necesarios de la solicitud para mostrarlos a modo de referencia
        $data1['datos']=$this->cons->datos_solicitud($id);
        //var_dump($data1);
        $this->load->view('menu/view_menu',$data);
        $this->load->view('menu/view_documento',$data1);
        
        $this->load->view('footer_control');
        
    }
    
    public function documentos_solicitud($id_solicitud){
        $this->load->model('model_documento','doc');
        echo $this->doc->documentosxsolicitud($id_solicitud);
    }
    
    public function procedimientos(){
        $header['arrayCss'] = array('estilo_planilla.css','demo_page.css','demo_table_jui.css','ui-lightness/jquery-ui-1.8.4.custom.css');
        $header['arrayJs'] = array('planilla.js','jquery.dataTables.min.js','procedimiento.js?z=1','TableTools.js','ZeroClipboard.js');
        $header['title'] = 'Consulta de Procedimientos';
        $this->load->view('header_control', $header);
        $usuario2=$this->session->userdata('usuario_sicaf');
        $data['usuario']=$usuario2;
        $this->load->view('menu/view_menu',$data);
        $this->load->view('menu/view_procedimiento');
        
        $this->load->view('footer_control');
    }


    public function procedimientos_todos(){
        $this->load->model('model_procedimiento','proc');
        echo $this->proc->procedimientos();
    }
    public function ruta($id_procedimiento){
        $this->load->model('model_ruta','ruta');
        $header['arrayCss'] = array('estilo_planilla.css','demo_page.css','demo_table_jui.css','ui-lightness/jquery-ui-1.8.4.custom.css','screen2.css','responsive.css','colorbox.css');
        $header['arrayJs'] = array('javascript.js', 'planilla.js','jquery.dataTables.min.js','colorbox.js','timeliner.min.js','timeliner_ruta.js', 'timeliner.js');
        $header['title'] = 'Ruta de Documento';
        $this->load->view('header_control', $header);
        $usuario2=$this->session->userdata('usuario_sicaf');
        $data['usuario']=$usuario2;
        //teniendo el id del procedimiento me traigo todos los datos de la solicitud
        $this->load->view('menu/view_menu',$data);
        //me traigo todos los movimientos del procedimiento
        $data['real']=$this->ruta->flujo_real($id_procedimiento);
        /*echo "<pre>";
        print_r($data['real']);
        echo "</pre>";*/
        //echo "tipo_flujo:{$data['real']['tipo_flujo']}";
        $data['original']=$this->ruta->flujo_original($id_procedimiento,$data['real']['tipo_flujo']);
        
        $this->load->view('menu/view_ruta',$data);
        
        $this->load->view('footer_control');
    }
    
    public function totales_analistas(){
        $header['arrayCss'] = array('estilo_planilla.css','demo_page.css','demo_table_jui.css','ui-lightness/jquery-ui-1.8.4.custom.css');
        $header['arrayJs'] = array('planilla.js','jquery.dataTables.min.js','totales.js','TableTools.js','ZeroClipboard.js','datepicker.js');
        $header['title'] = 'Consulta de Totales por Analista';
        $this->load->view('header_control', $header);
        $usuario2=$this->session->userdata('usuario_sicaf');
        $data['usuario']=$usuario2;
        $this->load->view('menu/view_menu',$data);
        $this->load->view('menu/view_buscar_total');
        if ((isset($_POST)) && !empty($_POST)) {
            
            $this->load->view('menu/view_totales_analistas',$_POST);
        }
        
        
        $this->load->view('footer_control');
    }
    
    public function analistas_totales($fecha_total){
        $this->load->model('model_totales','tot');
        echo $this->tot->totales($fecha_total);
    }
    
}


/* End of file consulta.php */
/* Location: ./application/controllers/consulta.php */