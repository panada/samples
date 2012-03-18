<?php
namespace Models;
use Resources;

class Connections {
    
    public function __construct(){
        
        $this->db = new Resources\Database;
    }
    
    public function isFollower($userId, $connectTo){
        
        return $this->db->getOne('connections', array('userId' => $userId, 'connectTo' => $connectTo) );
    }
    
    public function addFollowing($userId, $connectTo){
        
        return $this->db->insert('connections', array('userId' => $userId, 'connectTo' => $connectTo) );
    }
    
    public function removeFollowing($userId, $connectTo){
        
        return $this->db->delete('connections', array('userId' => $userId, 'connectTo' => $connectTo) );
    }
    
    public function getFollowing($userId){
        
        $this->db
            ->select('users.*')
            ->from('connections', 'users')
            ->where('connections.userId', '=', $userId, 'and')
            ->where('connections.connectTo', '=', 'users.userId', 'and')
            ->where('connections.connectTo', '!=', $userId)
            ->orderBy('connectionId', 'desc')->limit(10);
        
        return $this->db->getAll();
        
    }
    
    public function getTotalFollowing( $userId ){
        
        return $this->db->select('count(*)')->from('connections')->where('userId', '=', $userId, 'and')->where('connectTo', '!=', $userId)->getVar();
    }
    
    public function getFollower($userId){
        
        $this->db
            ->select('users.*')
            ->from('connections', 'users')
            ->where('connections.connectTo', '=', $userId, 'and')
            ->where('connections.userId', '=', 'users.userId', 'and')
            ->where('connections.userId', '!=', $userId)
            ->orderBy('connectionId', 'desc')->limit(10);
        
        return $this->db->getAll();
    }
    
    public function getTotalFollower( $userId ){
        
        return $this->db->select('count(*)')->from('connections')->where('connectTo', '=', $userId, 'and')->where('userId', '!=', $userId)->getVar();
    }
}