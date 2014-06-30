
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_ruta extends CI_Model {
    
    public $sigesp;
    
    function __construct(){
        parent::__construct();
        
    }
    
    function flujo_original($id_procedimiento, $tipo_flujo){
        $sql="select estatus.id, estatus.estatus, flujos.paso, flujos.descar, flujos.tipo_flujo
            from flujos
            inner join solicitud_documento as sd on sd.id_documento=flujos.id_documento
            inner join estatus on estatus.id=flujos.id_estatus
            where sd.id=$id_procedimiento and tipo_flujo=$tipo_flujo order by paso asc";
            $arr=$this->db->query($sql)->result_array();
            return $arr;
    }

    function flujo_real($id_procedimiento){
        $sql="select pe.id_procedimiento, pe.id_estatus as estatus_hecho, pe.paso as paso_hecho, pe.cedula as cedula_rrhh, db.nomper, db.apeper, pe.fecha, pe.tipo_flujo, pe.observacion  
            from procedimiento_estatus as pe
            LEFT JOIN view_sno_personal as db on db.cedper=pe.cedula
            where pe.id_procedimiento = $id_procedimiento order by paso asc";
            //echo "$sql";
           $arr=$this->db->query($sql)->result_array();
           $prs=count($arr);
           if ($prs==0){
                $arr['tipo_flujo']=1;
           }else{
                $arr['tipo_flujo']=$arr[$prs-1]['tipo_flujo'];
           }
           //$arr['tipo_flujo']=$arr[$prs-1]['tipo_flujo'];
           return $arr;
    }
    
}

/* End of file modelRuta.php */
/* Location: ./application/models/model_ruta.php */