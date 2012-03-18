<?php
namespace Controllers;
use Resources, Models;

class Signup extends Resources\Controller {
    
    public function __construct(){
        
        parent::__construct();
        
        $this->session  = new Resources\Session;
        $this->request  = new Resources\Request;
        $this->user     = new Models\Users;
        $this->connections = new Models\Connections;
    }
    
    public function index(){
        
        if( $this->session->getValue('isLogin') )
            $this->redirect('dashboard');
        
        $data['errorMessage'] = false;
        $usrname = $this->request->post('username');
        $password = $this->request->post('password');
        
        if( $usrname && $password ){
            
            if( ! $user = $this->user->getOne( array('username' => $usrname) ) ){
                
                $userId = $this->user->insert( array('username' => $usrname, 'password' => md5($password) ) );
                
                $this->connections->addFollowing($userId, $userId);
                
                $this->session->setValue(
                    array(
                        'userId' => $userId,
                        'username' => $usrname
                    )
                );
                
                $this->redirect('dashboard');
            }
            
            $data['errorMessage'] = 'Username already exists';
        }
        
        $this->output('signup', $data);
    }
}