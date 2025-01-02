<?php
namespace App\Models;
use CodeIgniter\Model;
 class Users extends Model{
    protected $table='users';
    protected $primaryKey='id';
    protected $allowedFields=[
        'uname',
        'pass',
        'email',
        'acesslevel'
    ];

    public function getdata(){
        $data=$this->findAll();
        return $data;
    }
    public function findsuper(){
        $query= $this->select('*');
        $query->where('acesslevel',2);
        $data=$query->findAll();
        return $data;
    }

    public function filter($role, $uname, $email){
        if($role){
            $query= $this->where("acesslevel",$role);
        }
        if($uname){
            $query= $this->like("uname",$uname);
        }
        if($email){
            $query=$this->like("email",$email);
        }
        $data=[
            'users'=>$query->paginate(5),
            'pager' => $this->pager,
            'user'=>$this->getdata(),
        ];
        return $data;
    }

    
 }
?>