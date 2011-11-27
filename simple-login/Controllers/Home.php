<?php
namespace Controllers;
use Resources;

class Home extends Resources\Controller {
    
    private
        $myUsername = 'admin',
        $myPassword = 'admin';
    
    public function __construct(){
        
        parent::__construct();
        
        $this->session = new Resources\Session;
        $this->request = new Resources\Request;
    }
    
    public function index(){
        
        if( $this->session->getValue('isLogin') )
            $this->redirect('dashboard');
        
        $data['errorMessage'] = false;
        
        if( $this->request->post('submit') ){
            
            if( $this->request->post('username') == $this->myUsername && $this->request->post('password') == $this->myPassword ){
                
                $this->session->setValue(
                    array(
                        'isLogin' => true,
                        'username' => $this->myUsername
                    )
                );
                
                $this->redirect('dashboard');
            }
            
            $data['errorMessage'] = 'Wrong username/password.';
        }
        
        $this->output('home', $data);
    }
}