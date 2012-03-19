<?php
namespace Controllers;
use
    Resources,
    Models;

class Profile extends Resources\Controller {
    
    public function __construct(){
        
        parent::__construct();
        
        $this->session = new Resources\Session;
        $this->user = new Models\Users;
        $this->posts = new Models\Posts;
        $this->connections = new Models\Connections;
        $this->request  = new Resources\Request;
    }
    
    public function index($usrname){
        
        if( ! $data['user'] = $this->user->getOne( array('username' => $usrname) ) )
            throw new Resources\HttpException('User not exists.');
        
        $args = array('criteria' => array('userId' => $data['user']->userId) );
        
        $data['posts'] = $this->posts->getAll($args);
        
        $data['isFollower'] = false;
        $data['isOwner'] = false;
        
        if( $this->session->getValue('userId') ){
            
            if( $this->session->getValue('userId') == $data['user']->userId )
                $data['isOwner'] = true;
            else
                $data['isFollower'] = $this->connections->isFollower( $this->session->getValue('userId'), $data['user']->userId );
        }
        
        if( $this->request->post('follow') && ! $data['isFollower'] ){
            
            if( ! $this->session->getValue('userId') )
                $this->redirect('home?next='.$usrname);
            
            $this->connections->addFollowing( $this->session->getValue('userId'), $data['user']->userId );
            
            $this->redirect($usrname);
        }
        
        if( $this->request->post('unfollow') && $data['isFollower'] ){
            
            if( ! $this->session->getValue('userId') )
                $this->redirect('home?next='.$usrname);
            
            $this->connections->removeFollowing( $this->session->getValue('userId'), $data['user']->userId );
            
            $this->redirect($usrname);
        }
        
        $data['following']      = $this->connections->getFollowing($data['user']->userId);
        $data['totalFollowing'] = $this->connections->getTotalFollowing($data['user']->userId);
        $data['follower']       = $this->connections->getFollower($data['user']->userId);
        $data['totalFollower']  = $this->connections->getTotalFollower($data['user']->userId);
        $data['totalPosts']     = $this->posts->getTotal($data['user']->userId);
        
        if( ! $this->userId = $this->session->getValue('userId') )
            $data['signature']	= $this->libraries->requestSignature()->generate();
        
        $this->output('profile', $data);
    }
}