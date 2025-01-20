<?php
namespace App\Controllers;
// use App\Models\Employee;
use App\Models\Users;
class LoginController extends BaseController{

    public function index(){
        return view('user/login');
    }

    public function login(){

        helper('form');
        $validation = \Config\Services::validation();
        $validation->setRules([
            'uname' => 'required',
            'pass' => 'required|alpha_numeric_punct|min_length[5]|max_length[16]',
        ]);
        if (!$this->validate($validation->getRules())) {
            return view('user/login', ['validation' => $this->validator]);
        }
        $user = new Users();
        $uname = $this->request->getPost('uname');
        $password = $this->request->getPost('pass');
        $data = $user->where('uname', $uname)->find();
        // print_r($data);
        if($data){
            $pass=$data[0]['pass'];
            $check=password_verify($password,$pass);
            if ($check) {
                session()->set([
                    'user_id' => $data[0]['id'],
                    'user_name' => $data[0]['uname'],
                    'user_email' => $data[0]['email'],
                    'acesslevel' => $data[0]['acesslevel'],
                    'logged_in' => true
                ]);
                session()->setFlashdata('success', 'Logged in successfully');
                return redirect()->to('dashboard');
            }else{
                session()->setFlashdata('msg', 'Wrong Password try again');
                return redirect()->to('log');
            }
        } 
        else {
            session()->setFlashdata('msg', 'Username not found');
            return redirect()->to('log');
        }
    }

    public function logout(){
        $session=session();
        $session->destroy();
        return redirect()->to('log')->with('logout',"You have been succesfully Logged Out !");
    }  
}

?>