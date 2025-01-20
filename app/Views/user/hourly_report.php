<?= $this->extend('user/layout.php');?>
<?= $this->section('content');?>

<div class="container bg-white mt-5 fs-6 fw-normal">
        <h1><?= $pageName?></h1>
        <a href="<?= base_url("dwnh/".$id."h")?>" class="btn btn-success btn-sm m-1 float-end"><i class="fa-solid fa-download fa-lg"></i></a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Hour</th>
                    <th>Call count</th>
                    <th>Total duration</th>
                    <th>Total hold</th>
                    <th>Total mute</th>
                    <th>Total ringing</th>
                    <th>Total transfer</th>
                    <th>Total conference</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($pageData as $data):?>
                <tr>
                <td><?php echo $data['hour'].":00-".(int)$data['hour']+1 .":00";?></td>
                <td><?php echo $data['unique_calls'];?></td>
                <td><?php echo gmdate("H:i:s",$data['total_duration']);?></td>
                <td><?php echo gmdate("H:i:s",$data['total_hold']);?></td>
                <td><?php echo gmdate("H:i:s",$data['total_mute']);?></td>
                <td><?php echo gmdate("H:i:s",$data['total_ringing']);?></td>
                <td><?php echo gmdate("H:i:s",$data['total_transfer']);?></td>
                <td><?php echo gmdate("H:i:s",$data['total_conference']);?></td>  
                </tr>        
            <?php endforeach;?>
            </tbody>
        </table>
        </div>
<style>
    .table td, .table th {
        font-size: 12px;
    }
</style>













<?= $this->endSection('content')?>