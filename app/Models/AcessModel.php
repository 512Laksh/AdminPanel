<?php
namespace App\Models;
use CodeIgniter\Model;
 class AcessModel extends Model{
    protected $table='acess';
    protected $primaryKey='id';
    protected $allowedFields=[
        'role'
    ];

    public function getdata(){
        $data=$this->findAll();
        return $data;
    }
    

 }

?>