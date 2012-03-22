<?php
namespace Controllers;
use
    Resources,
    Models,
    Libraries;

class Home extends Resources\Controller {
    
    private $userId;
    
    public function __construct(){
        
        parent::__construct();
        
        $this->session          = new Resources\Session;
        $this->request          = new Resources\Request;
        $this->user             = new Models\Users;
        $this->connections      = new Models\Connections;
        $this->posts            = new Models\Posts;
        $this->requestSignature = new Libraries\RequestSignature;
    }
    
    public function index(){
        
        // Have signed in? bring to dashboard method
        if( $this->userId = $this->session->getValue('userId') ){
            $this->dashboard();
            return;
        }
        
        // Validate the POST request
        if( $_SERVER['REQUEST_METHOD'] == 'POST' && ! $this->requestSignature->validate( $this->request->post('signature') ) ){
            Resources\Tools::setStatusHeader(400);
            $this->output('errors/400');
            return;
        }
        
        $data = array(
            'errorMessage' => false,
            'loginStyle' => null,
            'errorMessageRegister' => false,
            'loginStyleRegister' => null,
        );
        
        // Generate signature string to embeded in each HTTP POST request
        if( $_SERVER['REQUEST_METHOD'] == 'GET' )
            $data['signature'] = $this->requestSignature->generate();
        
        // Login process
        if( $this->request->post('submit') ){
            
            $usrname = $this->request->post('username', FILTER_SANITIZE_STRING);
            
            $user = $this->user->getOne( array('username' => $usrname) );
            
            if( $user && md5($this->request->post('password')) == $user->password ){
                
                $this->session->setValue(
                    array(
                        'userId' => $user->userId,
                        'username' => $user->username
                    )
                );
                
                if( ! $next = $this->request->get('next') )
                    $next = 'home';
                
                $this->redirect($next);
            }
            
            $data['errorMessage']   = 'Wrong username/password.';
            $data['loginStyle']     = 'error';
            $data['signature']      = $this->requestSignature->generate();
        }
        
        // Register process
        if( $this->request->post('register') ){
            if( ! $this->register() ){
                $data['errorMessageRegister'] = 'Username already exists';
                $data['loginStyleRegister'] = 'error';
            }
        }
        
        $this->output('home', $data);
    }
    
    private function register(){
        
        $usrname = $this->request->post('rUsername', FILTER_SANITIZE_STRING);
        $password = $this->request->post('rPassword');
        
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
                
                $this->redirect('home');
            }
            
            return false;
        }
        
        $this->output('signup', $data);
    }
    
    private function dashboard(){
        
        if( $post = $this->request->post('post', FILTER_SANITIZE_STRING) ){
            if( $this->posts->insert($this->userId, $post) )
                $this->redirect('home?');
        }
        
        $data['timeline']   = $this->posts->getTimeline($this->userId);
        $data['following']  = $this->connections->getTotalFollowing($this->userId);
        $data['follower']   = $this->connections->getTotalFollower($this->userId);
        $data['posts']      = $this->posts->getTotal($this->userId);
        
        $this->output('dashboard', $data );
    }
}