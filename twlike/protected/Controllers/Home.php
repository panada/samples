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
        $this->formValidation   = new Models\FormValidation;
    }
    
    public function index(){
        
        // Have signed in? bring to dashboard method
        if( $this->userId = $this->session->getValue('userId') ){
            $this->dashboard();
            return;
        }
        
        $this->requestSignature = new Libraries\RequestSignature;
        
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
        
        
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            
            // by default login process
            $ruleType = 'signin';
            $style = 'loginStyle';
            
            
            // Register process
            if( $this->request->post('register') ) {
                
                $ruleType = 'signup';
                $style = 'loginStyleRegister';
            }
            
            if( ! $next = $this->formValidation->validateValues($ruleType) ) {
                
                $data[$style] = 'error';
                $data['signature']  = $this->requestSignature->generate();
            }
            else {
                $this->redirect($next);
            }
        }
        
        $this->output('home', $data);
    }
    
    private function dashboard(){
        
        $this->connections  = new Models\Connections;
        $this->posts        = new Models\Posts;
        
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            
            if( $this->formValidation->validateValues('post') ) {
                
                if( $this->posts->insert($this->userId, $post) )
                    $this->redirect('home?');
            }
        }
        
        $data['timeline']   = $this->posts->getTimeline($this->userId);
        $data['following']  = $this->connections->getTotalFollowing($this->userId);
        $data['follower']   = $this->connections->getTotalFollower($this->userId);
        $data['posts']      = $this->posts->getTotal($this->userId);
        
        $this->output('dashboard', $data );
    }
}