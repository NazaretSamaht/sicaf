
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_solicitud extends CI_Model {
    
    public $sigesp;
    
    function __construct(){
        parent::__construct();
        $this->sigesp=$this->load->database('sigesp', TRUE);
    }
    
    function select_tpersonal(){
        
        $query = $this->db->query('SELECT * FROM t_personal;');
        $row=$query->result_array();
        return $row;
    }
    
    function cantidades_max(){
        $query = $this->db->query('SELECT id, max_cant FROM documento order by id;')->result_array();
        return $query;
    }


    function guardar_solicitud($post,$usuario){
        $fecha=date("Y").'/'.date("m").'/'.date("d");
        //var_dump($post);
        //echo $fecha;
        //$post['tipo_nomina']=str_replace("\n", "</br>", $post['tipo_nomina']);
        $this->db->trans_start();
        //$this->db->query('Y OTRA CONSULTA SQL MAS...');
        $sql="insert into solicitud (cedula, motivo, fecha_solicitud, tipo_nomina, ubi_adm, observacion) values ('".$post["ci"]."','".$post["motivo"]."','".$fecha."','{$post["tipo_nomina"]}', '{$post["ubi_adm"]}', '{$post["observacion"]}') returning id;";
        $result=  pg_query($this->db->conn_id,$sql);
        //echo 'sql:'.$sql.'</br>';
        $id_solicitud=  pg_fetch_array($result);
        //echo 'id_solicitud:'.$id_solicitud;
        /*echo '<pre>';
        print_r($post);
        echo "</pre>";*/
        $query = $this->db->query("SELECT * from solicit_datos where cedula::text='{$post['ci']}';")->result_array();
        if ($query != null){
            $this->db->query("update solicit_datos set tlf_celular='{$post['cel']}' where cedula::text='{$post['ci']}';");
            $this->db->query("update solicit_datos set tlf_habitacion='{$post['tlf']}' where cedula::text='{$post['ci']}';");
            $this->db->query("update solicit_datos set correo='{$post['correo']}' where cedula::text='{$post['ci']}';");
            $this->db->query("update solicit_datos set nominas='{$post['tipo_nomina']}' where cedula::text='{$post['ci']}';");
        }else{
            $this->db->query("insert into solicit_datos (cedula, tlf_celular, tlf_habitacion, correo, nominas) values ({$post['ci']},'{$post['cel']}','{$post['tlf']}','{$post['correo']}', '{$post['tipo_nomina']}');");
        }
        
        
        if (isset($post['tramite'])){
           
            foreach  ($post['tramite'] as $reg){
                $sql=$this->db->query("select * from flujos where paso=1 and id_documento=$reg;");
                $row=$sql->result_array();
                //echo var_dump($reg);
                //echo $row[0]['id'];
                
                
                    $sql="insert into solicitud_documento (id_solicitud, id_documento, terminado, id_flujos, cant_proc) values ({$id_solicitud['id']},$reg,0,{$row[0]['id']}, {$post['n_'.$reg]}) returning id;";
                    //recordar cambiar el ultimo 1 por el id de flujo q correspopnda segun corresponda realmente, por ahora sera el 1 xq es const de jub
                    $result=  pg_query($this->db->conn_id,$sql);
                    $id_procedimiento=  pg_fetch_array($result);
                    $array['tramite'][$reg]=(array)$this->db->query("select * from documento where id={$reg}")->row();
                    if (($reg==6)||($reg==2)){
                        $tipo_flujo=1;
                    }else{
                        $tipo_flujo=0;
                    }
                    $this->db->query("insert into procedimiento_estatus (id_estatus, id_procedimiento, paso, cedula, tipo_flujo) values (1,{$id_procedimiento['id']},1,'{$usuario['cedper']}',$tipo_flujo);");
                
            }
            if (isset($post['copia'])){
                $this->db->query('insert into solicitud_t_copia (id_solicitud, id_t_copia) values ('.$id_solicitud['id'].','.$post['copia'].');');
                //echo 'insert into solicitud_t_copia (id_solicitud, id_t_copia) values ('.$id_solicitud['id'].','.$post['copia'].');';
                $array['tramite']['7']['copia']= (array) $this->db->query("select * from t_copia where id={$post["copia"]}")->row();
            }
            if (isset($post['const_trab'])){
                $this->db->query('insert into solicitud_t_const_trab (id_solicitud, id_t_const_trab) values ('.$id_solicitud['id'].','.$post['const_trab'].');');
                //echo 'insert into solicitud_t_copia (id_solicitud, id_t_copia) values ('.$id_solicitud['id'].','.$post['copia'].');';
                $array['tramite']['2']['const_trab']= (array) $this->db->query("select * from t_const_trab where id={$post["const_trab"]}")->row();
            }
            if (isset($post['const_jub'])){
                $this->db->query('insert into solicitud_t_const_jub (id_solicitud, id_t_const_jub) values ('.$id_solicitud['id'].','.$post['const_jub'].');');
                //echo 'insert into solicitud_t_copia (id_solicitud, id_t_copia) values ('.$id_solicitud['id'].','.$post['copia'].');';
                $array['tramite']['4']['const_jub']= (array) $this->db->query("select * from t_const_jub where id={$post["const_jub"]}")->row();
            }
            
          
        }
        if (isset($post['forma'])){
            
            foreach ($post['forma'] as $reg){
                //var_dump($arr);
                $sql=$this->db->query("select * from flujos where paso=1 and id_documento=$reg;");
                $row=$sql->result_array();
                
                    $sql="insert into solicitud_documento (id_solicitud, id_documento, terminado, id_flujos, cant_proc) values ({$id_solicitud['id']},$reg,0,{$row[0]['id']}, {$post['n_'.$reg]})returning id;"; 
                    $result=  pg_query($this->db->conn_id,$sql);
                    $id_procedimiento=  pg_fetch_array($result);
                    $array['forma'][$reg]=(array) $this->db->query("select * from documento where id={$reg}")->row();
                    if (($reg==8)||($reg==9)){
                        $tipo_flujo=1;
                    }else{
                        $tipo_flujo=0;
                    }
                    $this->db->query("insert into procedimiento_estatus (id_estatus, id_procedimiento, paso, cedula, tipo_flujo) values (1,{$id_procedimiento['id']},1,'{$usuario['cedper']}',$tipo_flujo);");
                
            }
        }
        
        if (isset($post['prest'])){
                $this->db->query('insert into solicitud_documento (id_solicitud, id_documento) values ('.$id_solicitud['id'].','.$post['prest'].');');  
                $array['prest']= (array) $this->db->query("select * from documento where id={$post["prest"]}")->row();
                
                
        }
        
       // exit();
        if (isset($post['adicional'])){
            
            foreach ($post['adicional'] as $indice=>$reg){
               
                if ($reg==22){
                    $this->db->query("insert into solicitud_extra(id_solicitud, otro) values ({$id_solicitud['id']},'{$post['otro']}')");
                }else
                    $this->db->query('insert into solicitud_documento (id_solicitud, id_documento) values ('.$id_solicitud['id'].','.$reg.');'); 
                    $array['adicional'][$reg]= (array)$this->db->query("select * from documento where id={$reg}")->row();
                    
            }

        
        }


        $this->db->trans_complete();
        
        if ($this->db->trans_status()){
            //si la transacci�n no da errores, construyo el arreglo con los datos necesitados
            $array['id']=$id_solicitud['id'];
            $array['ci']=$post['ci'];
            $array['nombres']=$post['nombre'];
            $array['ubi_adm']=$post['ubi_adm'];
            $array['fecha']= date("d").'/'.date("m").'/'.date("Y");
            $array['otro']=$post['otro'];
            $array['correo']=$post['correo'];
            return $array;
        }else{
           return $array['id']=0; 
        }
        
        
    }
    
    function select_recaudos(){
        $query = $this->db->query('SELECT * FROM recaudos_documento;');
        $row=$query->result_array();
        return $row;
    }
    
    function select_srecaudos(){
        $query = $this->db->query('SELECT * FROM recaudos_sub_documento;');
        $row=$query->result_array();
        return $row;
    }
    
    function unique_persona($cedula) {
        $sql = "SELECT COUNT(cedper) total from sno_personal WHERE cedper = '$cedula'";
        return $this->db->query($sql)->row('total');
    }

    function get_personal_datos($ci) {

        //verifico si la persona esta retirada o activa(jubilado, pensionado, regular)
        
        $query=$this->sigesp->query("select sno_personalnomina.staper, sno_personal.cedper, noo.codnom, noo.descripcion
                    FROM sno_personal
                    INNER JOIN sno_personalnomina ON sno_personalnomina.codper=sno_personal.codper
                    inner join nominas_org as noo on noo.codnom=sno_personalnomina.codnom
                    where cedper = '$ci' and sno_personalnomina.staper ='1'");
        $row_estatus = $query->row_array();
        $row_num=$query->num_rows();
        if ($row_num != '0'){
           //si trae algo, esta activado sino esta retirado
            //también debo revisar la descripción de la nómina, si trae jubilado o pensionado

            $row = $this->sigesp->query("SELECT DISTINCT sno_personal.nomper ||' '|| sno_personal.apeper as nombre, sno_personal.fecingper as f_ingreso,
            CASE WHEN sno_personal.telmovper isnull or sno_personal.telmovper='0414' or sno_personal.telmovper='0412' or sno_personal.telmovper='0416' or sno_personal.telmovper='0424' or sno_personal.telmovper='0426' 
            THEN l_sicaf.tlf_celular ELSE sno_personal.telmovper end as cel,
            CASE WHEN sno_personal.telhabper isnull or sno_personal.telhabper='0212' THEN l_sicaf.tlf_habitacion else sno_personal.telhabper end as tlf,
            sno_personal.codper, sno_personal.dirper as direccion, sno_personalnomina.horper, sno_personalnomina.minorguniadm,sno_personalnomina.ofiuniadm,
            sno_personalnomina.uniuniadm,sno_personalnomina.depuniadm,sno_personalnomina.prouniadm,sno_personalnomina.codemp,sno_personalnomina.codnom,sno_personalnomina.codcar, 
            sno_unidadadmin.desuniadm as ubi_adm, sno_personal.estper, sno_personal.cauegrper,sno_personalnomina.staper,noo.codnom, noo.descripcion as tipo_nomina, 
            CASE WHEN sno_personalnomina.descasicar isnull THEN sno_cargo.descar ELSE sno_personalnomina.descasicar END as cargo,
            case when sno_personal.coreleper isnull or sno_personal.coreleper='' THEN l_sicaf.correo ELSE sno_personal.coreleper END as correo,
            CASE WHEN sno_personal.fecegrper = '1900-01-01' THEN 'SIN FECHA' ELSE sno_personal.fecegrper::character varying END as f_egreso
        
            FROM sno_personal
            left JOIN dblink('dbname=sicaf port=5432 host=localhost user=postgres password=postgres'::text, 'select cedula, tlf_habitacion, tlf_celular, correo from solicit_datos'::text) l_sicaf (cedula integer, tlf_habitacion character varying, tlf_celular character varying, correo character varying) 
            on l_sicaf.cedula::text=sno_personal.cedper::text
            INNER JOIN sno_personalnomina ON sno_personalnomina.codper=sno_personal.codper
            INNER JOIN sno_unidadadmin ON sno_unidadadmin.ofiuniadm=sno_personalnomina.ofiuniadm and sno_unidadadmin.uniuniadm=sno_personalnomina.uniuniadm and sno_unidadadmin.depuniadm=sno_personalnomina.depuniadm 
                and sno_unidadadmin.prouniadm=sno_personalnomina.prouniadm
            INNER JOIN sno_cargo ON sno_cargo.codemp=sno_personalnomina.codemp and sno_cargo.codnom=sno_personalnomina.codnom and sno_cargo.codcar=sno_personalnomina.codcar
            inner join nominas_org as noo on noo.codnom=sno_personalnomina.codnom
            where cedper = '$ci' and sno_personalnomina.staper ='1';")->row(); 
        }else{
            $row = $this->sigesp->query("SELECT DISTINCT sno_personal.nomper ||' '|| sno_personal.apeper as nombre, sno_personal.fecingper as f_ingreso,
                CASE WHEN sno_personal.telmovper isnull or sno_personal.telmovper='0414' or sno_personal.telmovper='0412' or sno_personal.telmovper='0416' or sno_personal.telmovper='0424' or sno_personal.telmovper='0426' 
            THEN l_sicaf.tlf_celular ELSE sno_personal.telmovper end as cel,
            CASE WHEN sno_personal.telhabper isnull or sno_personal.telhabper='0212' THEN l_sicaf.tlf_habitacion else sno_personal.telhabper end as tlf,
            sno_personal.codper, sno_personal.dirper as direccion, sno_personalnomina.horper, sno_personalnomina.minorguniadm,sno_personalnomina.ofiuniadm,
            sno_personalnomina.uniuniadm,sno_personalnomina.depuniadm,sno_personalnomina.prouniadm,sno_personalnomina.codemp,sno_personalnomina.codnom,sno_personalnomina.codcar, 
            sno_unidadadmin.desuniadm as ubi_adm, sno_personal.estper, sno_personal.cauegrper,sno_personalnomina.staper,noo.codnom, noo.descripcion, 'RETIRADO' AS tipo_nomina,
            CASE WHEN sno_personalnomina.descasicar isnull THEN sno_cargo.descar ELSE sno_personalnomina.descasicar END as cargo,
            case when sno_personal.coreleper isnull or sno_personal.coreleper='' THEN l_sicaf.correo ELSE sno_personal.coreleper END as correo,
            CASE WHEN sno_personal.fecegrper = '1900-01-01' THEN 'SIN FECHA' ELSE sno_personal.fecegrper::character varying END as f_egreso

            FROM sno_personal
            left JOIN dblink('dbname=sicaf port=5432 host=localhost user=postgres password=postgres'::text, 'select cedula, tlf_habitacion, tlf_celular, correo from solicit_datos'::text) l_sicaf (cedula integer, tlf_habitacion character varying, tlf_celular character varying, correo character varying) 
            on l_sicaf.cedula::text=sno_personal.cedper::text
            INNER JOIN sno_personalnomina ON sno_personalnomina.codper=sno_personal.codper
            INNER JOIN sno_unidadadmin ON sno_unidadadmin.ofiuniadm=sno_personalnomina.ofiuniadm and sno_unidadadmin.uniuniadm=sno_personalnomina.uniuniadm and sno_unidadadmin.depuniadm=sno_personalnomina.depuniadm 
                and sno_unidadadmin.prouniadm=sno_personalnomina.prouniadm
            INNER JOIN sno_cargo ON sno_cargo.codemp=sno_personalnomina.codemp and sno_cargo.codnom=sno_personalnomina.codnom and sno_cargo.codcar=sno_personalnomina.codcar
            inner join nominas_org as noo on noo.codnom=sno_personalnomina.codnom
            where cedper = '$ci';")->row(); 
        }
        
        
        return (array) $row;
        
        /*
         
         */
    }
    
    
}

/* End of file modelSolicitud.php */
/* Location: ./application/models/model_solicitud.php */