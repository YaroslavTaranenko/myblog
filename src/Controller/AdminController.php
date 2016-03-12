<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AdminController extends AppController{
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => 'Admin',
                'action' => 'login'
            ],
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' =>[
                'Form' => [
                    'fields' => ['username'=>'email', 'password'=>'password']
                ]
            ],
            'storage' => 'Session'
        ]);
    }
    public function beforeFilter(Event $event) {
        $this->Auth->allow(['login']);
        parent::beforeFilter($event);
        

        $current_user = $this->Auth->user();
        if(!$current_user)
                        return;
        $this->set(compact('current_user'));
        
        if($current_user['roles_id'] < 2){
            if($this->request->params['action'] == 'logout')
                return ;            
            $this->Flash->forbidden(__('You shouldn\'t go there'));
            $this->redirect('/');
            
        }
    }
    
    public function display(){
        
    }
    
    public function users($mode = 'view', $id = null){
        $this->loadModel('Users');
        $this->loadModel('Roles');
        switch ($mode){
            case 'view': $users = $this->Users->find('all');
                $this->set(compact('users'));
                $this->render('users');
                break;
            case 'add': 
                $user = $this->Users->newEntity();
                if($this->request->is('post')){
                    $user = $this->Users->patchEntity($user, $this->request->data);
                    if($user = $this->Users->save($user)){
                        
                        $user->foto = $this->uploadFile($this->request->data['foto'], $user);
                        $this->Flash->success(__('User successfully added'));
                        return $this->redirect(['action' => 'users', 'view']);
                    }  else {
                        $this->Flash->error(__('An Error occured'));
                    }
                }
                $roles = $this->Roles->find('list');
                $this->set(compact('user', 'roles'));
                $this->set('_serialize', ['user', 'roles']);
                $this->render('userAdd');
                break;
            case 'edit': 
                $user = $this->Users->get($id);
                //debug($user);
                if($this->request->is(['patch', 'post', 'put'])){
                    $foto = $user->foto;
                    $user = $this->Users->patchEntity($user, $this->request->data);
//                    debug($this->request->data['foto']);
//                    return;
                    if($this->request->data['foto']['size'] > 0){
                        if($user->foto != $this->request->data['foto']['name']){
                            $user->foto = $this->uploadFile($this->request->data['foto'], $user);

                        }
                    }else{
                        $user->foto = $foto;
                    }
                    if($this->request->data['change_password']){
                        if($this->request->data['change_password'] == $this->request->data['repeat_password']){
                            $user->password = $this->request->data['change_password'];
                        }  else {
                            $this->Flash->error(__('Passwords didn\'t match'));
                            return $this->redirect(['action' => 'users', 'edit', $id]);
                        }
                        
                    }
                        
                    if($this->Users->save($user)){                        
                        $this->Flash->success(__('User successfully added'));
                        return $this->redirect(['action' => 'users', 'view']);
                    }  else {
                        $this->Flash->error(__('An Error occured'));
                    }
                }
                $roles = $this->Roles->find('list');
                $this->set(compact('user', 'roles'));
                $this->set('_serialize', ['user', 'roles']);
                $this->render('userEdit');
                break;
            case 'delete':
                $user = $this->Users->get($id);
                if($this->Users->delete($user)){
                    $this->Flash->success(__('User successfully removed'));
                    $this->recurseRmdir(WWW_ROOT . DS . 'img' . DS . 'users' . DS . $id);
                }  else {
                    $this->Flash->error(__('User can not be removed'));
                }
                return $this->redirect(['action'=>'users']);
                break;
                
        }
        
        
    }
    public function login(){
        if($this->request->is('post')){
            $user = $this->Auth->identify();
            if($user){
                if($user['roles_id'] == '3'){
                    $this->Auth->setUser($user);
                    return $this->redirect(['controller'=>'Admin', 'action'=>'display']);
                }  else {
                    $this->Auth->setUser($user);
                    return $this->redirect(['controller'=>'Pages', 'action'=>'display']);
                }
            }  else {
                $this->Flash->errorLogin(__('Username or password incorrect'));
                return $this->redirect(['controller'=>'Admin', 'action'=>'login']);
            }
            
        }
    }
    public function logout(){
        $this->Auth->logout();
        return $this->redirect($this->request->referer());
    }
    
    private function uploadFile($img, $user){
        if(!empty($img['name'])){
            $ext = substr(strtolower(strrchr($img['name'], '.')), 1);// get extension
            $arr_ext = array('jpg', 'jpeg', 'png', 'bmp', 'ico', 'gif');
            
            if(in_array($ext, $arr_ext)){
                $dir = WWW_ROOT . 'img' . DS . 'users' . DS;
                $new_alias = $user->id;
                if(!is_dir($dir.$new_alias)){
                    mkdir($dir.$new_alias);
                }
                move_uploaded_file($img['tmp_name'], $dir.$new_alias.DS.$img['name']);
            }
        }
        return $img['name'];
    }
    function recurseRmdir($dir) {
            if(is_dir($dir)){
            $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) {
                (is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
            }
            return rmdir($dir);
        }
    }
}