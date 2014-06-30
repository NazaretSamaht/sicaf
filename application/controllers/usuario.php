
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {
    
    public $usuario;
    public $clave;
    
    public function __construct() {
        parent::__construct();
        $this->session->unset_userdata('usuario_sicaf');
        $this->load->model('model_usuario', 'usu', true);
    }

    public function index() {
        
        $header['arrayCss'] = array('style2.css');
        $header['arrayJs'] = array('javascript.js','opciones.js','validaciones.js');
        $header['title'] = 'Crear Usuario';
        
        
        $this->load->view('header',$header);
        $this->load->model('ModelUsuario','usu',true);
    }

    public function control_usuario() {

        $header['title'] = 'Control de Usuario';
        $header['arrayCss'] = array('usuarioStyle.css');
        $header['arrayJs'] = array('javascript.js','opciones.js','validaciones.js');
        
        $this->load->view('header_control', $header);
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        var_dump($_POST);*/
        if ((isset($_POST)) && !empty($_POST)) {
            //echo "entro";
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->form_validation->set_rules('usuario', 'Usuario', "required|trim||min_length[6]|max_length[8]|callback_user_check[{$_POST['password']}]");
            $this->form_validation->set_rules('password', 'Contraseña', 'required|trim');

            if ($this->form_validation->run() !== FALSE) {
                redirect(site_url('menu'));
            }
        }

        $this->load->view('usuario/login');
        $this->load->view('footer_control');
    }

    public function datos_usuario($ci = NULL) {

        $ci = trim($ci);
        $data['error'] = 1;
        $data['messages'] = array();
        if (strlen($ci) < 6){
            $data ['messages']['error'][] = 'La cédula debe contener al menos 6 caracteres.';
        }if (strlen($ci) > 8){
            $data ['messages']['error'][] = 'La cédula no debe sobrepasar los 8 caracteres.';
        }else if ($this->usu->existe_usuario($ci)){
            $data ['messages']['error'][] = 'Ya este usuario existe, ingrese con su contraseña.';
        }else if (! $data['usuario'] = $this->usu->select_basico($ci)){

            $data ['messages']['error'][] = 'Usuario inexistente en base de datos de Alcaldía.';
        }else{
            if ($data['usuario']['rrhh']==FALSE){
                $data ['messages']['error'][] = 'Este usuario no pertenece a Recursos Humanos.';
            }else{
                $data['error'] = 0;
            }
            
        }

        echo json_encode($data);
    }
    public function crear_usuario() {
        $_POST = $_GET;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Contraseña', 'required|trim|matches[password_repeat]|min_length[4]');
        $this->form_validation->set_rules('password_repeat', 'Repetir contraseña', 'required|trim');
        
        $data['messages'] = array();

        if ($data['error'] = ! $this->form_validation->run()){
            $data ['messages']['error'] = $this->form_validation->error_array_withot_index();
        }else{
            if ($usu = $this->usu->existe_usuario($_POST['user'])){
                $data ['messages']['notice'][]  = "Ya este usuario existe, ingrese con su contraseña.";
            }else{
                if ($this->usu->guardar_usuario($_POST['user'],$_POST['password'])){
                    $data ['messages']['success'][] = "Usuario creado con éxito";
                    $data ['messages']['info'][] = "Recuerde que su nombre de usuario será: {$_POST['user']}";
                    $this->load->library('phpmailer/JPhpMailer');
                    if (!empty($_POST['correo'])){
                        $mail=new JPhpMailer();
                        if (!$mail->correo_registro_usuario($_POST['correo'],$_POST['user'],$_POST['password']))
                            $data ['messages']['notice'][] = "El Correo no pudo enviarse";
                        else
                            $data ['messages']['info'][] = "El Correo con sus datos ha sido enviado con éxito al correo:".$_POST['correo'];
                    }else{
                        $data ['messages']['notice'][] = "Usted no posee correo registrado";
                    }
                    
                }
                
            }
           
        }

        echo json_encode($data);
    }

    private function _construir($post) {
        $this->load->helper("date");
        return array(
            'nombre' => $post['nombre'],
            'cedula' => $post['ci'],
            'fecha' => cambiaf_a_mysql($post['fecha']),  
            'correo' => $post['correo'],
            'usuario' => $post['user'],
            'clave' => MD5($post['clave'])
        );
    }
    
    function cargar_opciones($opcion){
        if ($opcion=='0')
            exit();
        if ($opcion=='1'){
          
          $data['combo']=1;
          $data['cargos']=  $this->usu->select_cargos();
          $data['division']=  $this->usu->select_divisiones();
          $this->load->view('usuario/interno',$data);  
        }
        if ($opcion=='2'){
          $data['t_personal']=  $this->usu->select_tpersonal();
          $this->load->view('usuario/externo',$data);  
        }
    }
    
    function cargar_ad($opcion){
        if ($opcion=='0')
            exit();
        if ($opcion=='2'){
         
          $data['combo']=2;
          $data['division']=  $this->usu->select_divisiones();
          $this->load->view('usuario/interno',$data);  
        }
        if (($opcion=='3')||($opcion=='4')){
            $data['combo']=3;
            $data['division']=  $this->usu->select_divisiones();
            $this->load->view('usuario/interno',$data);
        }
        if ($opcion=='5'){
           $data['combo']=4;
           $this->load->view('usuario/interno',$data);
        }
    }
    
    function cargar_coord($division){
        if ($division=='0')
            exit();
        else{
           $coord = $this->usu->select_coord($division); 
           echo '<option value="0">-- Seleccionar Coordinaci&oacute;n--</option>';
           foreach ($coord as $array) {
              echo '<option value="' .$array["id"] . '">' . $array['coordinacion'] . '</option>';
           }
        }
    }
    
    
    
    function username_check($str)
    {
        if ($this->usu->unique_usuario($str)){
           $this->form_validation->set_message('username_check', 'El %s ya existe');
            return FALSE; 
        }
        return TRUE;
        
    }

    function user_check($user, $pass) {

        if (!$usuario = $this->usu->existe_usuario($user)) {
            $this->form_validation->set_message('user_check', 'El %s no existe. Verifique e intente nuevamente.');
            return FALSE;
        }
        if ($usuario->password != md5($pass)) {
            $this->form_validation->set_message('user_check', 'Contraseña inválida.');
            return FALSE;
        }
        $usuario_sigesp = $this->usu->select_basico($user);
        //var_dump($usuario_sigesp); exit();
       
        /*if ($usuario_sigesp['rrhh']==FALSE){
            //esta pero no es de recursos humanos
            $this->form_validation->set_message('user_check', 'Usuario no perteneciente a Recursos Humanos.');
            return FALSE;
        }*/
        if ($usuario_sigesp){
                //var_dump($usuario_sigesp); exit();
            @$session = array(
                'cedper' => $user,
                'nom_ape' => $usuario_sigesp['nombre_apellido'],
                'ingreso' => $usuario_sigesp['ingreso'],
                'egreso' => $usuario_sigesp['egreso'],
                'local' => $usuario_sigesp['local'],
                'celular' => $usuario_sigesp['celular'],
                'codper' => $usuario_sigesp['codper'],
                'direccion' => $usuario_sigesp['direccion'],
                'horper' => $usuario_sigesp['horper'],
                'min' => $usuario_sigesp['minorguniadm'],
                'ofi' => $usuario_sigesp['ofiuniadm'],
                'uni' => $usuario_sigesp['uniuniadm'],
                'dep' => $usuario_sigesp['depuniadm'],
                'pro' => $usuario_sigesp['prouniadm'],
                'codemp' => $usuario_sigesp['codemp'],
                'codnom' => $usuario_sigesp['codnom'],
                'codcar' => $usuario_sigesp['codcar'],
                'unidad' => $usuario_sigesp['unidad'],
                'cargo' => $usuario_sigesp['cargo'],
                'correo' => $usuario_sigesp['correo'],
                'id_unidad' => $usuario_sigesp['id_unidad'],
                'tipo_unidad' => $usuario_sigesp['tipo_unidad'],
                'rrhh' => $usuario_sigesp['rrhh'],
                'desactualizado' => $usuario_sigesp['desactualizado'],
                

            );
        /*    if (($session['cedper']='') || ($session['cedper']=NULL) ){
                $this->form_validation->set_message('user_check', 'Contraseña inválida.');
                return false;
            }*/
            $this->session->set_userdata('usuario_sicaf', $session);
            return TRUE;
        }
        $this->form_validation->set_message('user_check', 'Usuario inexistente en base de datos de Alcaldía.');
        
    }
    
    function cerrar_sesion(){
        $this->session->sess_destroy();
        redirect(site_url('usuario/control_usuario'));
        
    }

}

/* End of file usuario.php */
/* Location: ./application/controllers/usuario.php */