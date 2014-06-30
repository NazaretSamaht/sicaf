<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Solicitud extends CI_Controller {
    
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
	    $header['arrayCss'] = array('style2.css','estilo_planilla.css');
        $header['arrayJs'] = array('javascript.js', 'planilla.js');
        $header['title'] = 'Planilla &Uacute;nica de Solicitud';
        $this->load->view('header_control', $header);
        
        $data['usuario'] = $this->session->userdata('usuario_sicaf');
        $this->load->view('menu/view_menu', $data);
        
        //echo "dsdfsfd";
        
        if ((isset($_POST)) && !empty($_POST)) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<fieldset class="error">', '</fieldset>');
            $this->form_validation->set_rules('motivo', 'MOTIVO DE LA SOLICITUD', "trim|min_length[6]");
            if ((!isset($_POST['tramite']))&&(!isset($_POST['forma']))&&(!isset($_POST['prest']))&&(!isset($_POST['adicional']))){
                //envio un error por tramite, aunque realmente no es una regla apegada a este campo
                $this->form_validation->set_rules('tramite', 'SOLICITUD, FORMA IVSS, PRESTACIONES &oacute; SOLICITUD ADICIONAL', "required");
                //regla de validación para el campo de cédula, a veces será obvio que se cumpla, pero cuando se trabaja desde el ambiente del analista de taquilla, se pide obligatoriamente
                $this->form_validation->set_rules('ci', 'C&Eacute;DULA DE IDENTIDAD', "required");
                
            }else{
                if (isset($_POST['tramite'])){
                    if (isset($_POST['tramite']['expediente'])){
                        $this->form_validation->set_rules('copia', 'TIPO DE COPIA', "required");
                    }
                    if (isset($_POST['tramite']['constancia_trabajo'])){
                        $this->form_validation->set_rules('const_trab', 'TIPO DE CONSTANCIA DE TRABAJO', "required");
                    }
                    if (isset($_POST['tramite']['constancia_jubilado'])){
                        $this->form_validation->set_rules('const_jub', 'TIPO DE CONSTANCIA DE JUBILADO', "required");
                    }
                }
                if (isset($_POST['adicional'])){
                    if (isset($_POST['prima'])){
                        if ((!isset($_POST['adicional']['estudio']))&&(!isset($_POST['adicional']['hijo']))&&(!isset($_POST['adicional']['hogar']))&&(!isset($_POST['adicional']['antiguedad']))){
                            $this->form_validation->set_rules('estudio', 'TIPO DE PRIMA', "required");
                        }
                        
                    }
                    if (isset($_POST['hcm'])){
                        if ((!isset($_POST['adicional']['inclusion']))&&(!isset($_POST['adicional']['exclusion']))&&(!isset($_POST['adicional']['reclamos']))&&(!isset($_POST['adicional']['reembolsos']))){
                           $this->form_validation->set_rules('inclusion', 'TIPO DE SOLICITUDES DE HCM', "required");
                        }
                        
                    }
                    if (isset($_POST['adicional']['otro'])){
                        $this->form_validation->set_rules('otro', 'CAMPO DE TEXTO DE OTRO', "trim, required");
                    }
                }
            }
            
            if ($this->form_validation->run() !== FALSE){
                //se guardan los datos y se obtienen los recaudos
                $arr=$this->sol->guardar_solicitud($_POST,$data['usuario']);
                if ($arr['id']!=0){
                    
                    
                    
//                    $_SESSION ['messages']['info'][] = "Recuerde llevar los recaudos especif&iacute;cados en la planilla para aprobar su solicitud, si lo desea pueda descargar su planilla con los recaudos: </br> EL LINK";
//                    $_SESSION ['messages']['error'][] = "Recuerde llevar los recaudos especif&iacute;cados en la planilla para aprobar su solicitud, si lo desea pueda descargar su planilla con los recaudos: </br> EL LINK";
//                    $_SESSION ['messages']['notice'][] = "Recuerde llevar los recaudos especif&iacute;cados en la planilla para aprobar su solicitud, si lo desea pueda descargar su planilla con los recaudos: </br> EL LINK";
//                    echo '<pre>';
//                    print_r($arr);
//                    echo '</pre>';
                    //$_POST['correo']='samaht15@gmail.com';
                    //$this->load->view('correo/view_registro_solicitud', $data,false);
                    $this->load->library('phpmailer/JPhpMailer');
                    if (!empty($_POST['correo'])){
                        $mail=new JPhpMailer();
                        
                        if (!$mail->correo_registro_solicitud($arr))
                           $_SESSION ['messages']['notice'][] = "El Correo no pudo enviarse";
                        else{
                          
                          $_SESSION ['messages']['info'][] = "El Correo con los datos de sus solicitudes ha sido enviado con éxito al correo:".$_POST['correo'];  
                        }
                            
                    }else{
                        $_SESSION ['messages']['notice'][] = "Usted no posee correo registrado";
                    }
                    //llamo a la funcion para imprimir el comprobante
                    
                    $_SESSION ['messages']['success'][] = "La Solicitud se ha realizado con &Eacute;xito ";
                    
                    $_SESSION ['messages']['info'][] = "<a href='".site_url("pdf/acuse_recibo/{$arr['id']}")."' target='_blank'><b><i class='fa fa-print fa-lg'></i>&nbsp;&nbsp;Imprimir Acuse de Recibo</b></a>"; 
                    //<a target='_blank'  href='".site_url('solicitud/recibo')."'>Imprimir Acuse de Recibo</a>
                }else{
                    
                    $_SESSION ['messages']['error'][] = "No pudo realizarse el Registro";
                }

            }
            
        }
       /* echo "<pre>";
        print_r($data['usuario']);
        echo "</pre>";*/
        if ($data['usuario']['rrhh']==TRUE){
                $data['cantidad']=$this->sol->cantidades_max();
                $this->load->view('menu/view_planilla_taquilla',$data);
        }
              
        else{
            //cargo las cantidades

            $this->load->view('menu/view_planilla',$data);
        }
           
        
        $this->load->view('footer_control');
    }
   function ajax_get_datos(){
       $resp['error']=0;
        if (! isset($_GET) || empty($_GET)){
            $resp['error']=1;
            
        }else{
            $resp['resp'] = $this->sol->get_personal_datos($_GET['ci']);
        }
//                    echo '<pre>';
//                    print_r($arr);
//                    echo '</pre>';
        echo json_encode($resp);
        
    }

    function recibo($data){
        $header['arrayCss'] = array('estilo_planilla.css','estilo_recibo.css?x=3');
        $this->load->view('correo/header_correo', $header);
        $this->load->view('correo/view_registro_solicitud',$data);
        
    }
    
    
    

    
}


/* End of file solicitud.php */
/* Location: ./application/controllers/solicitud.php */