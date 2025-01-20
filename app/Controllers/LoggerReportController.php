<?php
namespace App\Controllers;
use App\Models\Users;
use App\Models\AcessModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as exel;
class LoggerReportController extends BaseController{

    public function download($id){
        ob_start();
        ob_end_clean();
        $filename = 'calls_data' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
        
        $curl = curl_init();
        if($id==1){
            $url = 'http://localhost:5000/mysql/get';
        }else if($id==2){
            $url = 'http://localhost:5001/mongo/get';
        }else {
            $url = 'http://localhost:5002/elastic/get';
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);

        $file = fopen('php://output', 'w');

        for ($i = 0; $i < 1; $i++) {
            $headers = array_keys($response[$i]);
        }
        fputcsv($file, $headers);

        foreach ($response as $key => $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }


    public function filter($id){
        $calltype = $this->request->getVar('calltype');
        $campaign = $this->request->getVar('campaign');
        $process = $this->request->getVar('process');
        $agent = $this->request->getVar('agent');
        // var_dump($calltype, $campaign, $process, $agent);

        isset($calltype)?$condition['type']=$calltype : null;
        !empty($campaign)?$condition['campaign_name']=$campaign : null;
        !empty($process)?$condition['process_name']=$process : null;
        !empty($agent)?$condition['agent_name']=$agent : null;

        $ch = curl_init();
        if($id==1){
            $url = 'http://localhost:5000/a';
        }else if($id==2){
            $url = 'http://localhost:5001/filter';
        }else{
            $url = 'http://localhost:5002/filter';
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($condition));
    
        $response = json_decode(curl_exec($ch),true);
        curl_close($ch);
        $pager = \Config\Services::pager();
        $page = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
        $perPage = 10;
        $total = count($response);
        $pagedData = array_slice($response, ($page - 1) * $perPage, $perPage);
        $data['id']=$id;
        $data['pageName'] = 'Logger Report';
        $data['pageData'] = $pagedData;
        $data['pager'] = $pager->makeLinks($page, $perPage, $total);
        // print_r($data['pageData']);
        return view('user/logger_report', $data);
    }

    public function downloadHourly($id){
        ob_start();
        ob_end_clean();
        $filename = 'calls_data' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
        
        $curl = curl_init();
        if($id==1){
            $url = 'http://localhost:5000/mysql/report';
        }else if($id==2){
            $url = 'http://localhost:5001/mongo/report';
        }else {
            $url = 'http://localhost:5002/elastic/report';
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);
    
        $file = fopen('php://output', 'w');
    
        for ($i = 0; $i < 1; $i++) {
            $headers = array_keys($response[$i]);
        }
    
        fputcsv($file, $headers);
    
        foreach ($response as $key => $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }

    public function logger($id){
        $ch = curl_init();
        if($id==1){
            $url = 'http://localhost:5000/mysql/get';
        }else if($id==2){
            $url = 'http://localhost:5001/mongo/get';
        }else{
            $url = 'http://localhost:5002/elastic/get';
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        // print_r($response);die;

        $pager = \Config\Services::pager();
        $page = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
        $perPage = 10;
        $total = count($response);
  
        $pagedData = array_slice($response, ($page - 1) * $perPage, $perPage);
        $data['id']=$id;
        $data['pageName'] = 'Logger Report';
        $data['pageData'] = $pagedData;
        $data['pager'] = $pager->makeLinks($page, $perPage, $total);
        // print_r($data['pageData']);
        return view('user/logger_report', $data);
    }

    public function hourly($id){
        $ch = curl_init();
        if($id==1){
            $url = 'http://localhost:5000/mysql/report';
        }else if($id==2){
            $url = 'http://localhost:5001/mongo/report';
        }else{
            $url = 'http://localhost:5002/elastic/report';
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);
        $data['id']=$id;
        $data['pageName'] = 'Hourly Report';
        $data['pageData'] = $response;
        // print_r($data);
        return view('user/hourly_report',$data);
    }

}
?>