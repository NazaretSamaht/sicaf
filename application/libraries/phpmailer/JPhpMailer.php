<?php

/**
 * JPhpMailer class file.
 *
 * @version alpha 2 (2010-6-3 16:42)
 * @author jerry2801 <jerry2801@gmail.com>
 * @required PHPMailer v5.1
 *
 * A typical usage of JPhpMailer is as follows:
 * <pre>
 * Yii::import('ext.phpmailer.JPhpMailer');
 * $mail=new JPhpMailer;
 * $mail->IsSMTP();
 * $mail->Host='smpt.163.com';
 * $mail->SMTPAuth=true;
 * $mail->Username='yourname@yourdomain';
 * $mail->Password='yourpassword';
 * $mail->SetFrom('name@yourdomain.com','First Last');
 * $mail->Subject='PHPMailer Test Subject via smtp, basic with authentication';
 * $mail->AltBody='To view the message, please use an HTML compatible email viewer!';
 * $mail->MsgHTML('<h1>JUST A TEST!</h1>');
 * $mail->AddAddress('whoto@otherdomain.com','John Doe');
 * $mail->Send();
 * </pre>
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'class.phpmailer.php';

class JPhpMailer extends PHPMailer {
    public $CI;

    function __construct() {
        $this->IsSMTP();
        $this->CI= & get_instance();
        $this->SMTPAuth = true;
        $this->SMTPSecure = 'ssl';
        $this->Port = 465;
        $this->SMTPKeepAlive = true;
        $this->Mailer = "smtp";
        $this->CharSet = 'utf-8';
        $this->SMTPDebug = 0;
        $this->Host = 'smtp.gmail.com';
        $this->Username = 'sicaf.prueba@gmail.com';
        $this->Password = 'pruebasicafprueba';
        $this->SetFrom('sicaf.prueba@gmail.com', 'SICAF - PRUEBA');
    }
    
    function prueba($user) {
        $this->Subject='INSERTO';
        $this->MsgHTML("Probando el correo,$user");
        $this->AddAddress('samaht15@gmail.com');
        
        return $this->Send();
        
        
    }

    function correo_registro_usuario($correo, $ci, $pass) {
        $this->Subject='REGISTRO DE NUEVO USUARIO DEL SICAF';
        //$correo='samaht15@gmail.com';
        $data['ci']=$ci;
        $data['pass']=$pass;
        $texto=$this->CI->load->view('correo/view_registro_usuario', $data,true);
        $this->MsgHTML($texto);
        $this->AddAddress($correo);
        return $this->Send();
    }
    
    function correo_registro_solicitud($data){
       
        $this->Subject='REGISTRO DE SOLICITUDES DEL SICAF';
        //$correo='samaht15@gmail.com';
        $this->CI->load->model('model_solicitud', 'sol', true);
        $data['recaudo']=  $this->CI->sol->select_recaudos();
        $correo=$data['correo'];
        $header['arrayCss'] = array('estilo_planilla.css','estilo_recibo.css?x=3');
        $texto=$this->CI->load->view('correo/header_correo', $header, true);
        $texto.=$this->CI->load->view('correo/view_registro_solicitud', $data, true);
        $this->MsgHTML($texto);
        $this->AddAddress($correo);
//        echo 'entro al correo</br>';
//        echo $envia=$this->Send();
        return $this->Send();

    }

}
