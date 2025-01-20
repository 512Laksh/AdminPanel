<?php

namespace App\Controllers;
use App\Models\Users;
use App\Models\AcessModel;
class Home extends BaseController
{
    public $user;
    public $acess;
    public function __construct(){   
        $this->user= new Users();
        $this->acess= new AcessModel();
    }
    
    public function index(){  
        return view('user/dashboard');
    }

    public function showUser(){

        $data['users']=$this->user->paginate(5); 
        $data['pager'] = $this->user->pager;
        $data['acess']=$this->acess->getdata();
        $data['user']=$this->user->getdata(); 
        return view('user/usertable',$data);
    }

    public function getAddUser(){
        $data['acess']=$this->acess->getdata();
        return view('user/adduser',$data);
    }

    public function deleteUser($id){
        $this->user->delete($id);
        return redirect()->to(base_url('usertable'))->with('status',"Employee Deleted succesfully !");
    }
    
    public function update($id){
        $data=[
            'uname'=> $this->request->getpost('uname'),
            'email'=> $this->request->getpost('email'),
            'acesslevel'=> $this->request->getpost('acesslevel'),];
        $this->user->update($id,$data); 
        return redirect()->back()->with('status',"Employee updated succesfully $id!",); 
    }

    public function Filter(){
        $role=$this->request->getpost('role');
        $uname=$this->request->getpost('uname');
        $email=$this->request->getpost('email');
        
        $data=$this->user->filter($role,$uname,$email);
        $data['acess']=$this->acess->findAll();
        return view('user/usertable',$data);
    }

    public function chat(){
        $data['users']=$this->user->getdata();
        return view('user/chat/chat.php',$data);
    }
}
