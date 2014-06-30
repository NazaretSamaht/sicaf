
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_tracking extends CI_Model {
    
    public $sigesp;
    
    function __construct(){
        parent::__construct();
        $this->sigesp=$this->load->database('sigesp', TRUE);
    }
    
    function select_division(){
        $query = $this->db->query('SELECT * FROM division;');
        $row=$query->result_array();
        return $row;
    }

    function get_personal_datos($ci) {
        $row = $this->sigesp->query("SELECT DISTINCT sno_personal.nomper ||' '|| sno_personal.apeper as nombre, sno_personal.fecingper as f_ingreso, sno_personal.telhabper as tlf, sno_personal.telmovper as cel,
        sno_personal.codper, sno_personal.dirper as direccion, sno_personalnomina.horper, sno_personalnomina.minorguniadm,sno_personalnomina.ofiuniadm,
        sno_personalnomina.uniuniadm,sno_personalnomina.depuniadm,sno_personalnomina.prouniadm,sno_personalnomina.codemp,sno_personalnomina.codnom,sno_personalnomina.codcar, 
        sno_unidadadmin.desuniadm as ubi_adm,  
        CASE WHEN sno_personalnomina.descasicar isnull THEN sno_cargo.descar ELSE sno_personalnomina.descasicar END as cargo,
        CASE WHEN sno_personal.coreleper isnull THEN sno_personal.coreleper2 ELSE sno_personal.coreleper END as correo,
        CASE WHEN sno_personal.fecegrper = '1900-01-01' THEN 'SIN FECHA' ELSE sno_personal.fecegrper::character varying END as f_egreso

        FROM sno_personal
        INNER JOIN sno_personalnomina ON sno_personalnomina.codper=sno_personal.codper
        INNER JOIN sno_unidadadmin ON sno_unidadadmin.ofiuniadm=sno_personalnomina.ofiuniadm and sno_unidadadmin.uniuniadm=sno_personalnomina.uniuniadm and sno_unidadadmin.depuniadm=sno_personalnomina.depuniadm 
                and sno_unidadadmin.prouniadm=sno_personalnomina.prouniadm
        INNER JOIN sno_cargo ON sno_cargo.codemp=sno_personalnomina.codemp and sno_cargo.codnom=sno_personalnomina.codnom and sno_cargo.codcar=sno_personalnomina.codcar
        where cedper = '$ci';")->row();
        return (array) $row;
    }
    
    function select_coord($division){
        $query = $this->db->query("SELECT * FROM coordinacion where id_division=$division;");
        $row=$query->result_array();
        return $row;
    }
    
    function select_doc($coord){
        $query = $this->db->query("SELECT * FROM documento where id_coord=$coord;");
        $row=$query->result_array();
        return $row;
    }
    
    function select_actor($division){
        $query = $this->db->query("SELECT * FROM cargos where id_division=$division;");
        $row=$query->result_array();
        return $row;
    }
    function select_accion($division){
        $query = $this->db->query("select division.id,id_actor,cargo,id_accion,accion 
                                from actor_accion
                                inner join cargos on cargos.id=actor_accion.id_actor
                                inner join division on division.id=cargos.id_division
                                inner join accion on accion.id=id_accion 
                                where division.id=$division");
        
        $row=$query->result_array();
//        var_dump($row);
        foreach ($row as $value) {
            $r[$value['cargo']][]=$value;
        }
        
        return $r;
    }
    function accion($division){
        $query = $this->db->query("select division.id,id_actor,cargo,id_accion,accion 
                                from actor_accion
                                inner join cargos on cargos.id=actor_accion.id_actor
                                inner join division on division.id=cargos.id_division
                                inner join accion on accion.id=id_accion 
                                where division.id=$division");
        
        $row=$query->result_array();

        
        return $row;
    }
    
}

/* End of file modelTracking.php */
/* Location: ./application/models/model_tracking.php */