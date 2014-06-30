
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_correspondencia extends CI_Model {
    
    public $sigesp;
    
    function __construct(){
        parent::__construct();
        $this->sigesp=$this->load->database('sigesp', TRUE);
    }
    
    function division(){
        
        $query = $this->db->query('SELECT * FROM division;');
        $row=$query->result_array();
        return $row;
    }
    
   function coord(){
        
        $query = $this->db->query('SELECT * FROM coordinacion;');
        $row=$query->result_array();
        return $row;
    }

    function direccion(){
        
        $query = $this->db->query('SELECT * FROM direccion;');
        $row=$query->result_array();
        return $row;
    }

    function correspondencia(){
        
        $query = $this->db->query('SELECT * FROM correspondencia;');
        $row=$query->result_array();
        return $row;
    }
    
}

/* End of file modelCorrespondencia.php */
/* Location: ./application/models/model_correspondencia.php */