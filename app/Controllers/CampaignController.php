<?php

namespace App\Controllers;
use App\Models\Users;
use App\Models\AcessModel;
use App\Models\CampaignModel;
class CampaignController extends BaseController
{
    public $user;
    public $acess;
    public $campaign;
    public function __construct(){   
        $this->user= new Users();
        $this->acess= new AcessModel();
        $this->campaign=new CampaignModel();
    }
    
    public function index(){  
        return view('user/dashboard');
    }
    public function showUser(){
        $data['users']=$this->user->getdata();
        $data['acess']=$this->user->findsuper();
        $data['campaign']=$this->campaign->paginate(5);
        $data['pager'] = $this->campaign->pager;
        return view('user/camptable',$data);
    }
    public function addCamp(){
        $data['acess']=$this->user->findsuper();
        return view('user/addcampaign',$data);
    }
    public function deleteCamp($id){
        $this->campaign->delete($id);
        return redirect()->back()->with('status',"Campaign Deleted succesfully !");
    }
    public function updateUser($id){
        $data=[
            'cname'=> $this->request->getpost('cname'),
            'description'=> $this->request->getpost('description'),
            'client'=> $this->request->getpost('client'),
            'supervisor'=> $this->request->getpost('supervisor'),
        ];
        $this->campaign->update($id,$data); 
        
        return redirect()->to('camptable')->with('status',"Campaign updated succesfully !",); 
    }
    public function store(){
        helper('form');
        $validation = \Config\Services::validation();
        $validation->setRules([
            'cname' => 'required|alpha_numeric_punct|min_length[1]|is_unique[campaign.cname]',
            'description' => 'required|alpha_numeric_punct',
            'client'=> 'required|alpha_numeric_punct',
        ]);

        if ($this->validate($validation->getRules())) {
            $data=[
                'cname'=> $this->request->getpost('cname'),
                'description'=> $this->request->getpost('description'),
                'client'=> $this->request->getpost('client'),
                'supervisor'=> $this->request->getpost('supervisor')
            ];
            $this->campaign->save($data);
            return redirect()->to('camptable')->with('campAdd',"Campaign Added succesfully !");
        }  
        else{
            $acess=$this->user->findsuper();
            return view('user/addcampaign',['validation' => $this->validator, 'acess' => $acess]);
        } 
    }
    public function filter(){
        $cname=$this->request->getpost('cname');
        $client=$this->request->getpost('client');
        $role=$this->request->getpost('role');
        $data=$this->campaign->filter($role,$cname,$client);
        $data['users']=$this->user->getdata();
        $data['acess']=$this->user->findsuper();
        return view('user/camptable',$data);
    }
}
