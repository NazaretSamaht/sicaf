

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pendiente extends CI_Model {
    
    public $sigesp;
    
    function __construct(){
        parent::__construct();
        //$this->db=$this->load->database('sicaf', TRUE);
        
    }
    
    function analistas_documentacion(){
        $sql="Select distinct(usuarios.cedula), ru.tipo_unidad, ru.id_unidad, usuarios.cargo, 
    case when db.staper isnull then '1' else db.staper end as staper, 
    case when db.nomper isnull then 'PASANTE' else db.nomper end as nomper
            from usuarios
            inner join recursos_usuarios as ru on ru.cedula=usuarios.cedula 
            left JOIN dblink('dbname=database_a port=5432 host=localhost user=postgres password=postgres'::text, 
            'select cedper, descasicar, staper, nomper  from sno_personal inner join sno_personalnomina on sno_personal.codper=sno_personalnomina.codper'::text) 
            db (cedper character varying, descasicar character varying, staper character varying, nomper character varying) ON usuarios.cedula::text = db.cedper::text
            where tipo_unidad='c' and id_unidad=2 and status=1 and (staper='1' or staper isnull) and cargo in ('ANALISTA DE PERSONAL III','ASISTENTE DE ANALISTA IV', 'ASISTENTE ADMINISTRATIVO III', 'ANALISTA DE PERSONAL II');";
            $arr=$this->db->query($sql)->result_array();
            return $arr;
        
    }

    function asignar_proc($post,$usuario){
       /* echo '<pre>';
        print_r($post);
        echo '</pre>';*/
        
            foreach ($post['analista'] as $id=>$analista) {
                /*echo "id_doc:$id</br>";
                echo "analista:$analista</br>";*/
                $data=explode('_', $analista);
                $cedula_a=$data[0];
                $idx=$data[1];
                $pasox=$data[2];
                $tipo_flujo=$data[3];
                //echo "la observación:".$post['obs'][$id];
                //ASIGNO COMO TAL
                $sql="insert into asignar_procedimiento (id_procedimiento, cedula, terminado) values ($id,'$cedula_a',0);";
                $arr=$this->db->query($sql); 
                //guardo el registro de como va el flujo
                //la cedula de la persona que genero ese registro, en tal caso el usuario de rrhh
                $sql="insert into procedimiento_estatus (id_estatus, id_procedimiento, paso, cedula, tipo_flujo, observacion) values ($idx,$id,$pasox,'{$usuario['cedper']}',$tipo_flujo,'{$post['obs'][$id]}');";
                $arr=$this->db->query($sql);
                //actualizar ultimo estatus en la tabla sd
                //para eso primero debo consultar el id del flujo
                $sql="select flujos.id
                    from solicitud_documento as sd
                    inner join flujos on flujos.id_documento=sd.id_documento
                    where sd.id=$id and flujos.id_estatus=$idx and flujos.paso=$pasox";
                $id_flujo=$this->db->query($sql)->row('id');
               
                $sql="update solicitud_documento set id_flujos=$id_flujo where id=$id";
                $arr=$this->db->query($sql);
            }
        
        
            
        return $arr;
    }

    function ere_proc($post,$usuario,$cad){
        /*echo '<pre>';
        print_r($post);
        echo '</pre>';*/

            foreach ($post[$cad] as $id=>$combo) {
                /*echo "id_doc:$id</br>";
                echo "analista:$analista</br>";*/
                $data=explode('_', $combo);
                $idx=$data[0];
                $pasox=$data[1]; 
                $tipo_flujo=$data[2];
                //echo "cad:$cad";
                
                    
                    
                    //guardo el registro de como va el flujo
                    //la cedula de la persona que genero ese registro, en tal caso el usuario de rrhh
                    $sql="insert into procedimiento_estatus (id_estatus, id_procedimiento, paso, cedula, tipo_flujo, observacion) values ($idx,$id,$pasox,'{$usuario['cedper']}', $tipo_flujo, '{$post['obs'][$id]}');";
                    $arr=$this->db->query($sql);
                    //actualizar ultimo estatus en la tabla sd
                    //para eso primero debo consultar el id del flujo
                    $sql="select flujos.id, flujos.descar, flujos.id_estatus
                        from solicitud_documento as sd
                        inner join flujos on flujos.id_documento=sd.id_documento
                        where sd.id=$id and flujos.id_estatus=$idx and flujos.paso=$pasox and flujos.tipo_flujo=$tipo_flujo;";
                    //echo $sql;
                    $id_flujo=$this->db->query($sql)->row('id');
                    $descar=$this->db->query($sql)->row('descar');
                    $id_estatus=$this->db->query($sql)->row('id_estatus');
                    $sql="update solicitud_documento set id_flujos=$id_flujo where id=$id";
                    $arr=$this->db->query($sql);
                    if (($descar=='ANALISTA')&&($id_estatus==4)){
                        //ya el analista terminó el proedimiento
                        //actualizo tabla de asignar_procedimiento
                        $sql="update asignar_procedimiento set terminado=1 where id_procedimiento=$id";
                        $arr=$this->db->query($sql);
                        $fecha=date("Y-m-d");
                        $sql="update asignar_procedimiento set fecha='$fecha' where id_procedimiento=$id";
                        $arr=$this->db->query($sql);
                    }
                    
                
                
            }
        
        
            
        //return $arr;
    }

    function documento_pendientes($data){
        $aColumns = array( 'id_sd', 'id', 'procedimiento', 'cant_proc','cedula', 'nombre_apellido', 'nominas', 'fecha_solicitud','descar','descar_proximo','id_proximo');
         
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id_sd";
         
        /* DB table to use */
        $sTable = "  documentos_pendientes";
         
        /* Database connection information */
        $gaSql['user']       = "postgres";
        $gaSql['password']   = "postgres";
        $gaSql['db']         = "sicaf";
        $gaSql['server']     = "localhost";
         
         
         
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP server-side, there is
         * no need to edit below this line
         */
         
        /*
         * DB connection
         */
        $gaSql['link'] = pg_connect(
            " host=".$gaSql['server'].
            " dbname=".$gaSql['db'].
            " user=".$gaSql['user'].
            " password=".$gaSql['password']
        ) or die('Could not connect: ' . pg_last_error());
         
         
        /*
         * Paging
         */
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {
            $sLimit = "LIMIT ".pg_escape_string( $_GET['iDisplayLength'] )." OFFSET ".
                pg_escape_string( $_GET['iDisplayStart'] );
        }
         
         
        /*
         * Ordering
         */
        if ( isset( $_GET['iSortCol_0'] ) )
        {
            $sOrder = "ORDER BY ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
            {
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
                {
                    $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                        ".pg_escape_string( $_GET['sSortDir_'.$i] ) .", ";
                }
            }
             
            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" )
            {
                $sOrder = "";
            }
        }
         
         
        /*
         * Filtering
         * NOTE This assumes that the field that is being searched on is a string typed field (ie. one
         * on which ILIKE can be used). Boolean fields etc will need a modification here.
         */

        //codigo de nazaret
            $tipo_unidad=$data['usuario']['tipo_unidad'];
            $id_unidad=$data['usuario']['id_unidad'];
            $descar=trim($data['usuario']['cargo']);
            $cedper=trim($data['usuario']['cedper']);
            // var_dump(($descar=='JEFE DE DIVISION' && $tipo_unidad=='d' && $id_unidad==1)||($descar=='JEFE TECNICO ADMINISTRATIVO VI' && $tipo_unidad=='c' && $id_unidad==2));
            if (($descar=='ANALISTA DE PERSONAL III')||($descar=='ASISTENTE DE ANALISTA IV')||($descar=='ASISTENTE ADMINISTRATIVO III')||($descar=='ANALISTA DE PERSONAL II')){
                $descar="'ANALISTA' and cedula_rrhh='$cedper'";
            }else if (($descar=='ARCHIVISTA III')||($descar=='ARCHIVISTA II')||($descar=='ARCHIVISTA I')||($descar=='ARCHIVISTA')){
                $descar="'ARCHIVISTA'";

            }else if(($descar=='JEFE DE DIVISION' && $tipo_unidad=='d' && $id_unidad==1)||($descar=='JEFE TECNICO ADMINISTRATIVO VI' && $tipo_unidad=='c' && $id_unidad==2)){
                $descar="'JEFE DE DIVISION /JEFE TECNICO ADMINISTRATIVO VI'";
            }
            else if(($descar=='JEFE TECNICO ADMINISTRATIVO VI' && $tipo_unidad=='c' && $id_unidad==16)||($descar=='JEFE TECNICO ADMINISTRATIVO IV' && $tipo_unidad=='c' && $id_unidad==16)){
                $descar="'AGENTE DE ATENCION INTEGRAL'";
            }
            else if(($descar=='JEFE TECNICO ADMINISTRATIVO III' && $tipo_unidad=='c' && $id_unidad==3)||($descar=='JEFE TECNICO ADMINISTRATIVO IV' && $tipo_unidad=='c' && $id_unidad==3)){
                $descar="'ARCHIVISTA'";
            }else{
                $descar="'" . trim($descar) . "'";
            }
            
           
            /*if ($descar=='SECRETARIA'){
                $sWhere = "WHERE terminado=0 and descar_actual='DIRECTOR' ";
            }else{
               
            }*/
 $sWhere = "WHERE terminado=0 and descar_actual=$descar ";
        //codigo de nazaret
        /*if ($descar=='ARCHIVISTA'){
            $sWhere = "WHERE id_documento=4 and terminado=0 and descar_actual='$descar' ";
        }else{*/
            
        //}
        //$sWhere = "WHERE id_documento=4 and terminado=0 and descar_actual=$descar ";
        if ( $_GET['sSearch'] != "" )
        {
            
            $sWhere = " WHERE (descar_actual=$descar and ( ";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                if ( $_GET['bSearchable_'.$i] == "true" )
                {
                    $sWhere .= $aColumns[$i]."::character varying ILIKE '%".pg_escape_string( $_GET['sSearch'] )."%' OR ";
                }
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= " )";
        }
         
        /* Individual column filtering */
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
            {
                if ( $sWhere == "" )
                {
                    $sWhere = "WHERE ";
                }
                else
                {
                    $sWhere .= " AND ";
                }
                $sWhere .= $aColumns[$i]."::character varying ILIKE '%".pg_escape_string($_GET['sSearch_'.$i])."%' ";
            }
        }
         
         
        $sQuery = "
            SELECT ".str_replace(" , ", " ", implode(", ", $aColumns))."
            FROM   $sTable
            $sWhere
            $sOrder
            $sLimit
        ";
        //echo $sQuery;
        $rResult = pg_query( $gaSql['link'], $sQuery ) or die(pg_last_error());
         
        $sQuery = "
            SELECT $sIndexColumn
            FROM   $sTable
        ";

        $rResultTotal = pg_query( $gaSql['link'], $sQuery ) or die(pg_last_error());
        $iTotal = pg_num_rows($rResultTotal);
        pg_free_result( $rResultTotal );
         
        if ( $sWhere != "" )
        {
            $sQuery = "
                SELECT $sIndexColumn
                FROM   $sTable
                $sWhere
            ";
            $rResultFilterTotal = pg_query( $gaSql['link'], $sQuery ) or die(pg_last_error());
            $iFilteredTotal = pg_num_rows($rResultFilterTotal);
            pg_free_result( $rResultFilterTotal );
        }
        else
        {
            $iFilteredTotal = $iTotal;
        }
         
         
         
        /*
         * Output
         */
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );
         
        while ( $aRow = pg_fetch_array($rResult, null, PGSQL_ASSOC) )
        {
            $row = array();
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                if ( $aColumns[$i] == "id_proximo" )
                {
                    /* Special output formatting for 'version' column *//*<a target='_blank' href='recibo.php?id={$aRow[ $aColumns[$i] ]}'>Ver Recibo</a>*/
                    //$row[] = "<a href='".  site_url('consulta/documentos')."/{$aRow[ $aColumns[$i] ]}'>Documentos</a>";
                    //codigo de nazaret
                    //se debe mostrar la accion disponible del usuario para ese estatus, me valgo de id_proximo y el estatus_proximo
                    //$row[]="hola{$aRow[ $aColumns[$i]]}";
                    $data1=explode('_', $aRow[ $aColumns[$i]]);
                    $idx=$data1[0];
                    $pasox=$data1[1];
                    $tipo_flujo=$data1[2];
                    if ($idx=='2'){
                        //el estatus indica que es asignar analistas
                        //var_dump($analistas);
                        /*echo '<pre>';
                        print_r($aRow['id_sd']);
                        echo '</pre>';*/
                        $ana='';
                        foreach ($data['analistas'] as $arr ) {
                           @$ana .="{$arr['nomper']}<input type='radio' name='analista[{$aRow['id_sd']}]' value='{$arr['cedula']}_{$aRow['id_proximo']}'/>";                        
                        }
                        //$ana.="</form>";
                        $row[]=$ana."</br><input type='text' name='obs[{$aRow['id_sd']}]' maxlength='150' class='reduc'/>";

                    }
                    if ($idx=='4'){
                        //se va enviar al documento, aunq yo no se q ente lo esta haciendo, al enviar la cedper, ya se sabe
                        $row[]="Enviar Documento a Destino <input type='checkbox' name='enviar[{$aRow['id_sd']}]' value='{$aRow['id_proximo']}' /></br><input type='text' name='obs[{$aRow['id_sd']}]' maxlength='150' class='reduc'/>";

                    }
                    if ($idx=='5'){
                        //se va enviar al documento, aunq yo no se q ente lo esta haciendo, al enviar la cedper, ya se sabe
                        $row[]="Recibir Documento de Origen <input type='checkbox' name='recibir[{$aRow['id_sd']}]' value='{$aRow['id_proximo']}' /></br><input type='text' name='obs[{$aRow['id_sd']}]' maxlength='150' class='reduc'/>";

                    }  
                    if ($idx=='6'){
                        //se va enviar al documento, aunq yo no se q ente lo esta haciendo, al enviar la cedper, ya se sabe
                        $row[]="Entregar Documento al Funcionario <input type='checkbox' name='entregar[{$aRow['id_sd']}]' value='{$aRow['id_proximo']}' /></br><input type='text' name='obs[{$aRow['id_sd']}]' maxlength='150' class='reduc'/>";

                    }
                    if ($idx=='7'){
                        //se pregunta si se desea solicitar el expediente o no
                        $data1=explode('_', $aRow[ $aColumns[$i]]);
                        $idx=$data1[0];
                        $pasox=$data1[1];
                        
                        $row[]="Solicitar Expediente a Destino</br><input type='checkbox' name='exp[{$aRow['id_sd']}]' value='{$idx}_{$pasox}_0' /></br><input type='text' name='obs[{$aRow['id_sd']}]' maxlength='150' class='reduc'/>";

                    }
                    if ($idx=='8'){
                        //se pregunta si se desea solicitar el expediente o no
                        
                        $row[]="Enviar Expediente a Destino <input type='checkbox' name='enviar[{$aRow['id_sd']}]' value='{$aRow['id_proximo']}' /></br><input type='text' name='obs[{$aRow['id_sd']}]' maxlength='150' class='reduc'/>";

                    }
                    if ($idx=='9'){
                        //se pregunta si se desea solicitar el expediente o no
                        
                        $row[]="Recibir Expediente de Origen <input type='checkbox' name='recibir[{$aRow['id_sd']}]' value='{$aRow['id_proximo']}' /></br><input type='text' name='obs[{$aRow['id_sd']}]' maxlength='150' class='reduc'/>";

                    }
                    if ($idx=='10'){
                        //se pregunta si se desea solicitar el expediente o no
                        
                        $row[]="Aprobar y Enviar a Destino <input type='checkbox' name='aprobar[{$aRow['id_sd']}]' value='{$aRow['id_proximo']}' /></br><input type='text' name='obs[{$aRow['id_sd']}]' maxlength='150' class='reduc'/>";

                    }


                    //codigo de nazaret
                }
                else if($aColumns[$i]=="id"){
                    $row[]="<a href='".  site_url('pdf/acuse_recibo')."/{$aRow[ $aColumns[$i]]}' target='_blank'><b>{$aRow[ $aColumns[$i]]}</b></a>";
                }
                else if ( $aColumns[$i] != ' ' )
                {
                    /* General output */
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }
            $output['aaData'][] = $row;
        }
         
        
         
        // Free resultset
        pg_free_result( $rResult );
         
        // Closing connection
        pg_close( $gaSql['link'] );
        
        return json_encode( $output );

    }
    
    
    
}


/* End of file modelUsuario.php */
/* Location: ./application/models/model_consulta.php */

/* End of file modelUsuario.php */
/* Location: ./application/models/model_consulta.php */