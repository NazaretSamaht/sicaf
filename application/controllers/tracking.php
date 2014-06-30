<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tracking extends CI_Controller {
    
    public $usuario;
    public $clave;
    
    public function __construct() {
        parent::__construct();
        if (! $this->session->userdata('usuario_sicaf')){
            redirect(site_url('usuario/control_usuario'));
        }
        $this->load->model('model_tracking', 'track', true);
    }

    public function index() {
	$header['arrayCss'] = array('style2.css','estilo_planilla.css','tracking.css');
        $header['arrayJs'] = array('javascript.js', 'planilla.js','combos.js');
        $header['title'] = 'Generar Tracking de Documento';
        $this->load->view('header_control', $header);
        
        $data['usuario'] = $this->session->userdata('usuario_sicaf');
        $this->load->view('menu/view_menu', $data);
        $data['division']=$this->track->select_division();
        $this->load->view('tracking/view_administrar', $data);
        $this->load->view('footer_control');
    }
    
    function combo_coord($division){
        echo "<option value='00'>--Seleccionar--</option>";

        if ($division) {
            //realizamos la consulta
            
            $coord = $this->track->select_coord($division);
            
            foreach ($coord as $array) {
                echo '<option value="' . $array["id"] . '">' . trim($array['coordinacion']) . '</option>';
            }
        }  
    }
    
    function combo_doc($coord){
        echo "<option value='00'>--Seleccionar--</option>";

        if ($coord) {
            //realizamos la consulta
            
            $doc = $this->track->select_doc($coord);
            
            foreach ($doc as $array) {
                echo '<option value="' . $array["id"] . '">' . trim($array['nombre']) . '</option>';
            }
        }  
    }
    
    function actor($division){
        

        if ($division) {
            //realizamos la consulta
            
            $actor = $this->track->select_actor($division);
            $num=count($actor);
            foreach ($actor as $array) {
                echo '<div  class="ui-widget-content draggable">'.$array["id"] . '.' . trim($array['cargo']).'</div>';
            }
        }  
    }
    
    function accion($division){
        

        if ($division) {
            //realizamos la consulta
            
            $accion = $this->track->select_accion($division);
//            echo '<pre>';
//            print_r($accion);
//            echo '</pre>';
            echo '<div class="accordion">';
            foreach ($accion as $indice=>$array) {
                echo '<H3>'.$indice.'</H3>';
                echo "<div>";
                foreach ($array as $row){
                    echo "<div class='ui-widget-content draggable'>{$row['id_accion']}.{$row['accion']}</div>";
                }
                echo "</div>";  
                
            }
            echo '</div>';
            
        }  
    }
    
    function track($division){
       

        if ($division) {
            //realizamos la consulta
            
            $actor = $this->track->select_actor($division);
            $num=count($actor);
            $accion = $this->track->accion($division);
            $num1=count($accion);
//            echo 'entro';
            echo '<table class="tablas">';
            for ($i=1;$i<=$num1;$i++) {
                
                echo "<tr>";
                
                    for ($j=1;$j<=$num;$j++){
                        echo "<td class='td_tablas td_track'></td>";
                    }
                echo"</tr>";
            }
            echo '</table>';
        }  
    }
    
    
    

    
}


/* End of file tracking.php */
/* Location: ./application/controllers/tracking.php */