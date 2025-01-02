<?php
namespace App\Controllers;
use App\Models\AcessModel;
use App\Models\Users;
class SignupController extends BaseController{
    public $acess;
    public $user;
    public function __construct(){
        $this->acess= new AcessModel();
        $this->user= new Users();
    }
    public function index(){
        return view('user/signup');
    }

    public function signup(){
        helper('form');
        $validation = \Config\Services::validation();
        $validation->setRules([
            'uname' => 'required|alpha_numeric_punct|min_length[1]|is_unique[users.uname]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'pass' => 'required|alpha_numeric_punct|min_length[5]|max_length[16]',
            'acesslevel'=> 'required|alpha|min_length[1]'
        ]);
        if ($this->validate($validation->getRules())) {
                $data=[
                    'uname'=> $this->request->getpost('uname'),
                    'email'=> $this->request->getpost('email'),
                    'pass'=> password_hash($this->request->getpost('pass'),PASSWORD_BCRYPT),
                    'acesslevel'=> $this->request->getpost('acesslevel')
                ];
                $this->user->save($data);
                return redirect()->to('log')->with('userAdd',"User Added succesfully !");
            }  
            else{
                return view('user/signup',['validation' => $this->validator,]);
            }            
    }
    
    public function store(){
        helper('form');
        $validation = \Config\Services::validation();
        $validation->setRules([
            'uname' => 'required|alpha_numeric_punct|min_length[1]|is_unique[users.uname]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'pass' => 'required|alpha_numeric_punct|min_length[5]|max_length[16]',
            'acesslevel'=> 'required|alpha_numeric_punct|min_length[1]'
        ]);
        if ($this->validate($validation->getRules())) {
                $data=[
                    'uname'=> $this->request->getpost('uname'),
                    'email'=> $this->request->getpost('email'),
                    'pass'=> password_hash($this->request->getpost('pass'),PASSWORD_BCRYPT),
                    'acesslevel'=> $this->request->getpost('acesslevel')
                ];
                // print_r($data['acesslevel']);
                $this->user->save($data);
                return redirect()->to('usertable')->with('userAdd',"User Added succesfully !");
            }  
            else{
                $acess=$this->acess->getdata();
                // echo "dagsf";
                return view('user/adduser',['validation' => $this->validator, 'acess' => $acess]);
            }            
    }  
}
?>