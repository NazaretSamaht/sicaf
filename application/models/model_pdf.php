
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pdf extends CI_Model {
    
    public $sigesp;
    
    function __construct(){
        parent::__construct();
        $this->sigesp=$this->load->database('sigesp', TRUE);
    }
    
    function datos_recibo($id_solicitud){
    	$sql="select sd.id, sd.id_solicitud, solicitud.fecha_solicitud, solicitud.cedula, documento.nombre as procedimiento, sd.cant_proc,
    	documento.plazo, t_documento.nombre as t_doc, solicitud.ubi_adm,
		v_personal.nombre_apellido, recaudos(documento.id), t_const_jub.nombre as t_jub, t_const_trab.nombre as t_trab,
		solicit_datos.nominas, v_personal.dirper, solicit_datos.tlf_celular,  solicit_datos.tlf_habitacion, solicit_datos.correo 
		from solicitud_documento as sd 
		inner join solicitud on solicitud.id=sd.id_solicitud
		inner join documento on documento.id=sd.id_documento
		inner join t_documento on t_documento.id=documento.id_t_documento
		inner join view_sno_personal as v_personal on v_personal.cedper=solicitud.cedula
		left join solicitud_t_const_jub on solicitud_t_const_jub.id_solicitud=sd.id_solicitud
		left join t_const_jub on t_const_jub.id=solicitud_t_const_jub.id_t_const_jub
		left join solicitud_t_const_trab on solicitud_t_const_trab.id_solicitud=sd.id_solicitud
		left join t_const_trab on t_const_trab.id=solicitud_t_const_trab.id_t_const_trab
		left join solicit_datos on solicit_datos.cedula::text=solicitud.cedula
		where sd.id_solicitud=$id_solicitud";
		$arreglo=$this->db->query($sql)->result_array();
		return $arreglo;
    }

    
    
}

/* End of file modelPdf.php */
/* Location: ./application/models/model_pdf.php */