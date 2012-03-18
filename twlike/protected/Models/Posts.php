<?php
namespace Models;
use Resources;

class Posts {
    
    public function __construct(){
        
        $this->db = new Resources\Database;
    }
    
    public function getAll( $args = array() ){
        
        $default = array(
            'limit' => 10,
            'page' => 1,
            'orderBy' => 'timestamp',
            'sort' => 'DESC',
            'criteria' => array(),
            'fields' => array()
        );
        
        $args = array_merge($default, $args);
        
        $offset = ($args['limit'] * $args['page']) - $args['limit'];
        
        return $this->db
                ->orderBy($args['orderBy'], $args['sort'])
                ->limit($args['limit'], $offset)
                ->getAll('posts', $args['criteria'], $args['fields']);
    }
    
    public function getTotal( $userId = 0 ){
        
        $this->db->select('count(*)')->from('posts');
        
        if($userId > 0)
            $this->db->where('userId', '=', $userId);
        
        return $this->db->getVar();
    }
    
    public function getTimeline($userId){
        
        $this->db
            ->select('posts.*', 'users.username')
            ->from('connections', 'posts', 'users')
            ->where('connections.userId', '=', $userId, 'and')
            ->where('posts.userId', '=', 'connections.connectTo', 'and')
            ->where('posts.userId', '=', 'users.userId')
            ->orderBy('timestamp', 'desc')->limit(10);
        
        return $this->db->getAll();
    }
    
    public function insert($userId, $post){
        
        $this->db->insert( 'posts', array('userId' => $userId, 'post' => $post, 'timestamp' => time() ));
        return $this->db->insertId();
    }
}