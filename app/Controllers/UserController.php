<?php

namespace App\Controllers;
use App\Models\Users;
use App\Models\AcessModel;
class UserController extends BaseController
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
    public function getShowuser(){
        $data['users']=$this->user->paginate(5); 
        $data['pager'] = $this->user->pager;
        $data['acess']=$this->acess->getdata();
        $data['state']=false;
        return view('user/usertable',$data);
    }
    public function getAddUser(){
        $data['acess']=$this->acess->getdata();
        // print_r($data);
        return view('user/adduser',$data);
    }
    public function deleteUser($id){
        $this->user->delete($id);
        return redirect()->to(base_url('usertable'))->with('status',"Employee Deleted succesfully !");
    }
    public function updateUser($id){
        $data=[
            'uname'=> $this->request->getpost('uname'),
            'email'=> $this->request->getpost('email'),
            'acesslevel'=> $this->request->getpost('acesslevel'),];
        $this->user->update($id,$data); 
        return redirect()->back()->with('status',"Employee updated succesfully $id!",); 
    }
    public function postFilter(){
        $role=$this->request->getpost('role');
        $query= $this->user->select('*');
        if($role){
            $query->like('acesslevel',$role);
        }
        $data=[
            'users'=>$query->paginate(5),
            'pager' => $this->user->pager,
            'acess'=>$this->acess->findAll(),
            'state'=>true,
        ];
        return view('user/usertable',$data);
    }
}
