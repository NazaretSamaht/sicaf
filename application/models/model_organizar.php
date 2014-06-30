
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_organizar extends CI_Model {
    
    public $sigesp;
    
    function __construct(){
        parent::__construct();
        $this->sigesp=$this->load->database('sigesp', TRUE);
    }

    public function cargar_cedulas() {
        $query = $this->db->query(  "select distinct(usuarios.cedula), ru.id_unidad, db.minorguniadm, db.ofiuniadm, db.uniuniadm, db.depuniadm, db.codper, db.descasicar
  from usuarios
  left join recursos_usuarios as ru on ru.cedula=usuarios.cedula
  join dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 'select codper, minorguniadm, ofiuniadm, uniuniadm, depuniadm, staper, descasicar from sno_personalnomina'::text) db (codper character varying, minorguniadm character varying, 
  ofiuniadm character varying, uniuniadm character varying,depuniadm character varying, staper character varying, descasicar character varying)
  on usuarios.cedula = trim(leading '0' from db.codper)  
  where id_unidad isnull and db.minorguniadm='0001' and db.ofiuniadm='09' and db.uniuniadm='00' and db.depuniadm between '51' and '53' and db.staper='1'");
        $row=$query->result_array();
        return $row;
    }

    public function cargar_divisiones() {
        $query = $this->db->query("select * from division;");
        $row=$query->result_array();
        return $row;
    }
    public function cargar_coord() {
        $query = $this->db->query("select * from coordinacion;");
        $row=$query->result_array();
        return $row;
    }
    
    public function trans($cedula) {
        $data=explode('_', $cedula);
        $ci=$data[0];
        $descasicar=trim($data[1]); 
        //echo "select id, descar from cargos_transferencia where trim(both ' ' from descar)='$descasicar';";
        $query = $this->db->query("select id, id_cargo, descar from cargos_transferencia where trim(both ' ' from descar)='$descasicar';");
       
        $row=$query->result_array();
        if (count($row)!=0){
            //ya el cargo esta transformado, devuelvo el id del cargo
            $id=$row['id_cargo'];
        }else{
            // necesita transformarse
            $id=0;
        }
        return $id;
        
    }
    public function guardar_org($post) {
        $data=explode('_', $post['unidad']);
        $id_unidad=$data[0];
        $tipo_unidad=trim($data[1]);
        $data=explode('_', $post['cedulas']);
        $ci=$data[0];
        //echo "insert into recursos_usuarios (cedula, id_unidad, tipo_unidad) values ('$ci', $id_unidad, '$tipo_unidad');";
        $query = $this->db->query("insert into recursos_usuarios (cedula, id_unidad, tipo_unidad) values ('$ci', $id_unidad, '$tipo_unidad');");
        
        if ($query){
            return TRUE;
        }
        return FALSE;
        
    }
    public function cargar_cargos($unidad) {
        $data=explode('_', $unidad);
        $id_unidad=$data[0];
        $tipo_unidad=$data[1];
        $query = $this->db->query("select cu.id, cu.id_cargo, cargos.cargo, coord.coordinacion, cu.tipo_unidad
                                    from cargos
                                    inner join cargos_unidades as cu on cargos.id=cu.id_cargo
                                    inner join coordinacion as coord on coord.id=cu.id_unidad
                                    where cu.tipo_unidad='$tipo_unidad' and cu.id_unidad=$id_unidad");
        $row=$query->result_array();
        return $row;
        
        
    }
    public function guardar_cargo($post) {
        $data=explode('_', $post['cargos_a']);
        $id_cargo=$data[1];
        $query = $this->db->query("insert into cargos_transferencia (id_cargo, descar) values ($id_cargo,{$post['cargo_ant']})");
         if ($query){
            return TRUE;
        }
        return FALSE;
        
    }

}

/* End of file modelUsuario.php */
/* Location: ./application/models/modelUsuario.php */
