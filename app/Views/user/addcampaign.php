<?= $this->extend('user/layout.php');?>
<?= $this->section('content');?>
<div class="card mx-auto my-auto mt-5" style="width: 30%;">
  <div class="card-body">
  <div class="cnt">
<form action="<?= base_url("store-camp")?>" method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Campaign Name</label>
    <input type="text" name="cname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?= set_value('cname'); ?>">
    <div class="alert text-danger mb-0"><?= isset($validation) ? $validation->getError('cname') : ''; ?></div>


  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Description</label>
    <input type="text" name="description" class="form-control" id="exampleInputPassword1" value="<?= set_value('description'); ?>">
    <div class="alert text-danger mb-0"><?= isset($validation) ? $validation->getError('description') : ''; ?></div>


  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Client</label>
    <input type="text" name="client" class="form-control" id="exampleInputPassword1" value="<?= set_value('client'); ?>">
    <div class="alert text-danger mb-0"><?= isset($validation) ? $validation->getError('client') : ''; ?></div>

  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Supervisor</label>
    <select name="supervisor" class="form-select" aria-label="Default select example">
    <option selected disabled>Select Supervisor</option>
    <?php foreach($acess as $opt):?>
    <option value="<?= $opt['uname']?>"><?= $opt['uname']?></option>
    <?php endforeach;?>
  </select>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
  </div>
</div>
<?= $this->endSection('content');?>