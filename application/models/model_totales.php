
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_totales extends CI_Model {
    
    public $sigesp;
    
    function __construct(){
        parent::__construct();
        //$this->db=$this->load->database('sicaf', TRUE);
        
    }
    
    


    function totales($fecha_total){
        $var=explode("-",$fecha_total);
            $ano=$var[0];
            $mes=$var[0].'-'.$var[1];
           
        $aColumns = array( 'nombre_apellido','dia','mes','ano','proc_pend' );
         
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "nombre_apellido";
         
        /* DB table to use */
        $sTable = "  totales_analistas('$fecha_total','$mes','$ano')";
         
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
            $sWhere = " WHERE (";
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
                
                if ( $aColumns[$i] != ' ' )
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