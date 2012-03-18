<?php
namespace Models;
use Resources;

class Users {
    
    public function __construct(){
        
        $this->db = new Resources\Database;
    }
    
    public function getOne( $criteria = array() ){
        
        return $this->db->getOne('users', $criteria);
    }
    
    public function getAll( $args = array() ){
        
        $default = array(
            'limit' => 10,
            'page' => 1,
            'orderBy' => 'userId',
            'sort' => 'DESC',
            'criteria' => array(),
            'fields' => array()
        );
        
        $args = array_merge($default, $args);
        
        $offset = ($args['limit'] * $args['page']) - $args['limit'];
        
        return $this->db
                ->orderBy($args['orderBy'], $args['sort'])
                ->limit($args['limit'], $offset)
                ->getAll('users', $args['criteria'], $args['fields']);
    }
    
    public function getTotal( $criteria = array() ){
        
        $this->db->select('COUNT(*)');
        
        if ( ! empty( $criteria ) )
	    foreach($criteria as $key => $val)
		$this->where($key, '=', $val, 'AND');
        
        return $this->db->from('users')->getVar();
    }
    
    public function insert( $data = array() ){
        
        if( $this->db->insert('users', $data) )
            return $this->db->insertId();
        
        return false;
    }
}