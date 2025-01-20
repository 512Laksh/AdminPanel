<?= $this->extend('user/layout.php');?>
<?= $this->section('content');?>
<div class="container bg-white">
        <h1><?= $pageName?></h1>
        <div class="filter float-end">
        <a href="<?= base_url("dwn/".$id)?>" class="btn btn-success btn-sm m-1"><i class="fa-solid fa-download fa-lg"></i></a>
        <button type="button" class="btn btn-primary btn-sm float-start m-1" data-bs-toggle="modal" data-bs-target="#filterModal"><i class="fa fa-filter"></i></button>  
          <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <form action="<?= base_url("filter1/".$id)?>" method="get">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Filters</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id='filterModal'>
                    <div class=" mb-0">
                      <label for="name">By Campaign: </label>
                      <input type="text" name="campaign" style="width: 97%" value="<?= set_value('campaign')?>">
                    </div>

                    <div class=" mb-0">
                      <label for="name">By Process: </label>
                      <input type="text" name="process" style="width: 97%" value="<?= set_value('process')?>">
                    </div>

                    <div class=" mb-0">
                      <label for="name">By Agent: </label>
                      <input type="text" name="agent" style="width: 97%" value="<?= set_value('agent')?>">
                    </div>

                    <div class=" mb-0">
                      <label for="name">By CallType: </label>
                      <select class="filter" name="calltype">
                      <option selected disabled value="<?= set_value('agent')?>">--Choose--</option>
                      <option value="disposed" <?php if (set_value('calltype') == 'disposed') echo 'selected="selected"'; ?> >Answered</option>   
                      <option value="missed" <?php if (set_value('calltype')  == 'missed') echo 'selected="selected"'; ?> >Missed</option>   
                      <option value="autoFail" <?php if (set_value('calltype')  == 'autoFail') echo 'selected="selected"'; ?> >Autofail</option>  
                      <option value="autoDrop" <?php if (set_value('calltype')  == 'autoDrop') echo 'selected="selected"'; ?> >Autodrop</option> 
                    </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                    <a href="<?= base_url("report/".$id)?>" class="btn btn-light btn-sm" >Cancel</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Dispose Type</th>
                    <th>Dispose Name</th>
                    <th>Duration</th>
                    <th>Agent</th>
                    <th>Campaign</th>
                    <th>Process</th>
                    <th>Leadset</th>
                    <th>Ref id</th>
                    <th>Cust id</th>
                    <th>Hold</th>
                    <th>Mute</th>
                    <th>Ringing</th>
                    <th>Transfer</th>
                    <th>Conference</th>
                    <th>Call</th>
                    <th>Dispose Time</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($pageData as $data):?>
                <tr>
                <td><?= $data['date_time']?></td>
                <td><?= $data['type']?></td>
                <td><?php  
                  if(!empty($data['dispose_type'])){
                    echo $data['dispose_type'];
                  }else if(!empty($data['_source']['dispose_type'])){
                    echo $data['_source']['dispose_type'];
                  }else{
                    echo "";
                  }
                ?></td>
                <td><?= $data['dispose_name']?></td>
                <td><?= $data['duration']?></td>
                <td><?= $data['agent_name']?></td>
                <td><?= $data['campaign_name']?></td>
                <td><?= $data['process_name']?></td>
                <td><?= $data['leadset']?></td>
                <td><?= $data['reference_uuid']?></td></td>
                <td><?= $data['customer_uuid']?></td>
                <td><?= $data['hold']?></td>
                <td><?= $data['mute']?></td>
                <td><?= $data['ringing']?></td>
                <td><?= $data['transfer']?></td>
                <td><?= $data['conference']?></td>
                <td><?= $data['call_time']?></td>
                <td><?= $data['dispose_time']?></td>
                </tr>        
            <?php endforeach;?>
            </tbody>
        </table>
        <div class="float-end">
           <?= $pager?> 
        </div>
        </div>
<style>
     .table td, .table th {
        font-size: 12px;
    }
</style>
<?= $this->endSection('content')?>
