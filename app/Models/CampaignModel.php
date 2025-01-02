<?php
namespace App\Models;
use CodeIgniter\Model;
 class CampaignModel extends Model{
    protected $table='campaign';
    protected $primaryKey='id';
    protected $allowedFields=[
        'cname',
        'description',
        'client',
        'supervisor'
    ];

    public function getdata(){
        $data=$this->findAll();
        return $data;
    }
    public function filter($role, $cname, $client){
        if($role){
            $query= $this->where("supervisor",$role);
        }
        if($cname){
            $query= $this->like("cname",$cname);
        }
        if($client){
            $query=$this->like("client",$client);
        }
        $data=[
            'campaign'=>$query->paginate(5),
            'pager' => $this->pager,
        ];
        return $data;
    }
 }

?>