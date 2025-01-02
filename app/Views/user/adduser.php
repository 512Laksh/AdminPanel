<?= $this->extend('user/layout.php');?>
<?= $this->section('content');?>
<div class="card mx-auto my-auto mt-5" style="width: 30%;">
  <div class="card-body">
  <div class="cnt">
<form action="<?= base_url("store")?>" method="POST">
  <div class="mb-0">
    <label for="exampleInputEmail1" class="form-label">Username</label>
    <input type="text" name="uname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?= set_value('uname'); ?>">
    <div class="alert text-danger mb-0"><?= isset($validation) ? $validation->getError('uname') : ''; ?></div>
  </div>
  <div class="mb-0">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="pass" class="form-control" id="exampleInputPassword1" value="<?= set_value('pass'); ?>">
    <div class="alert text-danger mb-0"><?= isset($validation) ? $validation->getError('pass') : ''; ?></div>
  </div>
  <div class="mb-0">
    <label for="exampleInputPassword1" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" id="exampleInputPassword1" value="<?= set_value('email'); ?>">
    <div class="alert text-danger mb-0"><?= isset($validation) ? $validation->getError('email') : ''; ?></div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Role</label>
    <select name="acesslevel" class="form-select" aria-label="Default select example" value="<?= set_value('acesslevel'); ?>">
    <div class="alert text-danger mb-0"><?= isset($validation) ? $validation->getError('acesslevel') : ''; ?></div>
    <option selected disabled>Select Role</option>
    <?php foreach($acess as $opt){?>
    <option value="<?= $opt['id']?>"><?= $opt['Role']?></option>
    <?php }?>
</select>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
  </div>
</div>
 
<?= $this->endSection('content');?>