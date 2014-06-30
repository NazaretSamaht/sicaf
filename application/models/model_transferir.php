

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_transferir extends CI_Model {
    
    public $sigesp;
    
    function __construct(){
        parent::__construct();
        //$this->db=$this->load->database('sicaf', TRUE);
        
    }
    
       function actualizar_asignar_proc($post,$usuario){
       /* echo '<pre>';
        print_r($post);
        echo '</pre>';*/
        
            foreach ($post['analista'] as $id=>$analista) {
                /*echo "id_doc:$id</br>";
                echo "analista:$analista</br>";*/
                $data=explode('_', $analista);
                $cedula_p=$data[0];
                $id_proc=$data[1];
                $cedula_a=$data[2];
                //echo "la observación:".$post['obs'][$id];
                //actualizo la asignacion
                $sql="update asignar_procedimiento set cedula='$cedula_p' where id_procedimiento=$id_proc;";
                $arr=$this->db->query($sql); 
                //inserto en la tabla de respaldo
                $sql="insert into respaldo_proc_trans(id_proc, cedula_previa, cedula_posterior) values ($id_proc, '$cedula_a', '$cedula_p');";
                $arr=$this->db->query($sql);
                //actualizo la observacion de cuando se asigno por primera vez el procedimiento
                $sql="update procedimiento_estatus set observacion='{$post['obs'][$id]}' where id_procedimiento=$id_proc and id_estatus=2;";
                $arr=$this->db->query($sql);
                //actualizo quien lo asigno, por quien lo transfirió
                $sql="update procedimiento_estatus set cedula='{$usuario['cedper']}' where id_procedimiento=$id_proc and id_estatus=2;";
                $arr=$this->db->query($sql);
                
            }
        
        
            
        return $arr;
    }


    function transferir_proc($data){
        $aColumns = array( 'id_procedimiento','nombre_doc', 'nombre', 'cedula','id_proc');
         
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id_procedimiento";
         
        /* DB table to use */
        $sTable = "  proc_trans";
         
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

        $sWhere = "";
        
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
                if ( $aColumns[$i] == "id_proc" )
                {
                    /* Special output formatting for 'version' column *//*<a target='_blank' href='recibo.php?id={$aRow[ $aColumns[$i] ]}'>Ver Recibo</a>*/
                    //$row[] = "<a href='".  site_url('consulta/documentos')."/{$aRow[ $aColumns[$i] ]}'>Documentos</a>";
                    //codigo de nazaret
                    //se debe mostrar la accion disponible del usuario para ese estatus, me valgo de id_proximo y el estatus_proximo
                    //$row[]="hola{$aRow[ $aColumns[$i]]}";
                    $ana='';
                    foreach ($data['analistas'] as $arr ) {
                        //debo verificar que no sea el mismo analista del que se le quiere transferir el procedimiento, se compara
                        if($arr['nomper']!=$aRow['nombre']){
                            @$ana .="{$arr['nomper']}<input type='radio' name='analista[{$aRow['id_proc']}]' value='{$arr['cedula']}_{$aRow['id_proc']}_{$aRow['cedula']}'/>"; 
                        }
                                              
                    }
                    //$ana.="</form>";
                    $row[]=$ana."</br><input type='text' name='obs[{$aRow['id_proc']}]' maxlength='150' class='reduc'/>";

                    //codigo de nazaret
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