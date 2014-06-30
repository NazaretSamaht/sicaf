
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_usuario extends CI_Model {
    
    public $sigesp;
    
    function __construct(){
        parent::__construct();
        $this->sigesp=$this->load->database('sigesp', TRUE);
    }


    function select_cargos(){
        
        $query = $this->db->query('SELECT * FROM cargos where id != 1;');
        $row=$query->result_array();
        return $row;
    }
    
    function select_divisiones(){
        
        $query = $this->db->query('SELECT * FROM division;');
        $row=$query->result_array();
        return $row;
    }
    
    function select_coord($division){
        
        $query = $this->db->query('SELECT * FROM coordinacion where id_division='.$division.';');
        $row=$query->result_array();
        return $row;
    }
    
    function select_tpersonal(){
        
        $query = $this->db->query('SELECT * FROM t_personal;');
        $row=$query->result_array();
        return $row;
    }
    
    function insertar($arr){
        
        $this->db->insert('usuario', $arr);
        echo $this->db->last_query();
    }
    
    function unique_usuario($usuario){
        $sql = "SELECT COUNT(id) total from usuario WHERE user = '$usuario'";
        return $this->db->query($sql)->row('total');
        
    }
   /*function existe_usuario($usuario, $clave){
        $sql = "SELECT count(*) AS existe from usuario WHERE usuario = '$usuario' and clave= MD5('$clave');";
        return $this->db->query($sql)->row('existe');
        
    }*/
    
    function existe_usuario($ci){
        $sql = "SELECT id, password from usuarios WHERE cedula = '$ci'";
        return $this->db->query($sql)->row();
    }
    function existe_ci($ci){
        $sql="select count(cedper) from sno_personal where cedper = '$ci';";
        
        return $this->sigesp->query($sql)->row('count');
    }
    
    function guardar_usuario($ci, $password){
        $usuario = array(
            'cedula' => $ci,
            'password' => md5($password)
        );
        return $this->db->insert('usuarios', $usuario);
    }
    
    function select_basico($ci){
       $sql="SELECT DISTINCT sno_personal.nomper ||' '|| sno_personal.apeper as nombre_apellido, sno_personal.fecingper as ingreso, sno_personal.telhabper as local, sno_personal.telmovper as celular,
sno_personal.codper, sno_personal.dirper as direccion, sno_personalnomina.horper, sno_personalnomina.minorguniadm,sno_personalnomina.ofiuniadm,
sno_personalnomina.uniuniadm,sno_personalnomina.depuniadm,sno_personalnomina.prouniadm,sno_personalnomina.codemp,sno_personalnomina.codnom,sno_personalnomina.codcar, 
sno_unidadadmin.desuniadm as unidad, sno_personalnomina.staper,sno_dt_spg.codnom, sno_dt_spg.descripcion,
CASE WHEN sno_personalnomina.descasicar isnull THEN sno_cargo.descar ELSE sno_personalnomina.descasicar END as cargo,
CASE WHEN sno_personal.coreleper isnull THEN sno_personal.coreleper ELSE sno_personal.coreleper END as correo,
CASE WHEN sno_personal.fecegrper = '1900-01-01' THEN 'SIN FECHA' ELSE sno_personal.fecegrper::character varying END as egreso

FROM sno_personal
INNER JOIN sno_personalnomina ON sno_personalnomina.codper=sno_personal.codper
INNER JOIN sno_unidadadmin ON sno_unidadadmin.ofiuniadm=sno_personalnomina.ofiuniadm and sno_unidadadmin.uniuniadm=sno_personalnomina.uniuniadm and sno_unidadadmin.depuniadm=sno_personalnomina.depuniadm 
    and sno_unidadadmin.prouniadm=sno_personalnomina.prouniadm
INNER JOIN sno_cargo ON sno_cargo.codemp=sno_personalnomina.codemp and sno_cargo.codnom=sno_personalnomina.codnom and sno_cargo.codcar=sno_personalnomina.codcar
inner join sno_dt_spg on sno_dt_spg.codnom=sno_personalnomina.codnom
where cedper = '$ci' and sno_personalnomina.staper ='1';"; 

//echo $sql;
     $row = (array)$this->sigesp->query($sql)->row();

/*echo '<pre>';
print_r($row);
echo "</pre>";exit();*/
    
        //

    if ($ci=='20410863'){
            $row['minorguniadm']='0001';$row['ofiuniadm']='09';$row['uniuniadm']='00';$row['depuniadm']='51';
            $row['cargo']='ADMINISTRADOR';
    }
    if ($ci=='16431332'){
            $row['minorguniadm']='0001';$row['ofiuniadm']='09';$row['uniuniadm']='00';$row['depuniadm']='51';
            $row['cargo']='AGENTE DE ATENCION INTEGRAL';
    }
    if ($ci=='18770231'){
            $row['minorguniadm']='0001';$row['ofiuniadm']='09';$row['uniuniadm']='00';$row['depuniadm']='51';
            $row['cargo']='AGENTE DE ATENCION INTEGRAL';
    }
    if ($ci=='12345678'){
            $row['minorguniadm']='0001';$row['ofiuniadm']='09';$row['uniuniadm']='00';$row['depuniadm']='51';
            $row['cargo']='ASISTENTE ADMINISTRATIVO III';
    }
    if ($ci=='15616471'){
            $row['minorguniadm']='0001';$row['ofiuniadm']='09';$row['uniuniadm']='00';$row['depuniadm']='51';
            $row['cargo']='JEFE TECNICO ADMINISTRATIVO IV';
    }
    if ($ci=='18954786'){
            $row['minorguniadm']='0001';$row['ofiuniadm']='09';$row['uniuniadm']='00';$row['depuniadm']='51';
            $row['cargo']='ARCHIVISTA';
    }
    if ($ci=='19721500'){
            $row['minorguniadm']='0001';$row['ofiuniadm']='09';$row['uniuniadm']='00';$row['depuniadm']='51';
            $row['cargo']='ARCHIVISTA';
    }
    if ($ci=='18461846'){
            $row['minorguniadm']='0001';$row['ofiuniadm']='09';$row['uniuniadm']='00';$row['depuniadm']='51';
            $row['cargo']='ARCHIVISTA';
    }
    if ($ci=='6108803'){
            $row['minorguniadm']='0001';$row['ofiuniadm']='09';$row['uniuniadm']='00';$row['depuniadm']='51';
            $row['cargo']='JEFE TECNICO ADMINISTRATIVO IV';
    }
    if ($ci=='18770231'){
            $row['minorguniadm']='0001';$row['ofiuniadm']='09';$row['uniuniadm']='00';$row['depuniadm']='51';
            $row['cargo']='AGENTE DE ATENCION INTEGRAL';
    }
    if ($ci=='16544243'){
            $row['minorguniadm']='0001';$row['ofiuniadm']='09';$row['uniuniadm']='00';$row['depuniadm']='51';
            $row['cargo']='AGENTE DE ATENCION INTEGRAL';
    }
    if ($ci=='6121667'){
            $row['minorguniadm']='0001';$row['ofiuniadm']='09';$row['uniuniadm']='00';$row['depuniadm']='51';
            $row['cargo']='DIRECTOR';
    }
    //var_dump($row);    
if (count($row)!=0){
    //echo "entro1";exit();
        if (($row['minorguniadm']=='0001')&&($row['ofiuniadm']=='09')&&($row['uniuniadm']=='00')){
            //echo "entro";
            if (($row['depuniadm']=='51')||($row['depuniadm']=='52')||$row['depuniadm']=='53'){

                //es de recursos humanos el usuario
                $sql1="select usuarios.cedula, ru.id_unidad,  ru.tipo_unidad
                        from usuarios 
                        left join recursos_usuarios as ru on ru.cedula=usuarios.cedula
                where usuarios.cedula='$ci';";
                //echo "$sql1"; exit();
                $row = $row + (array)$this->db->query($sql1)->row();
                
                /*echo '<pre>';
                print_r($row + (array)$this->db->query($sql1)->row());
                echo "</pre>";*/
                $row['rrhh']=TRUE;
                //la consulta con la que me traigo el cargo transformado para luego delimitar el acceso
               


            }

        }else{
        //encontro a la persona pero no es de recursos humanos

            $row['rrhh']=FALSE;
        }
        if ($row['rrhh']==TRUE){
           if ((! isset($row['tipo_unidad']))||($row['tipo_unidad']==''))
                $row['desactualizado']=TRUE;
            else
                $row['desactualizado']=FALSE;
        }
        //var_dump($row);exit();
        return $row;
    }
    return false;
        
    }
    
}

/* End of file modelUsuario.php */
/* Location: ./application/models/modelUsuario.php */