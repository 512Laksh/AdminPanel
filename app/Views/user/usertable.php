<?= $this->extend('user/layout.php');?>
<?= $this->section('content');?>
<div class="container">
  <div class="row">
    <div class="col-md-12 mt-4">
      <?php
        if(session()->getFlashdata('status')){  
           echo '<div class="alert alert-success  alert-dismissible fade show" role="alert">'.
                    session()->getFlashdata('status')
            .'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
        ?>
      <div class="card">
        <div class="card-header d-flex">
        <a href="<?= base_url("addUser")?>" class="btn btn-success btn-sm m-1"><i class="fa-solid fa-plus fa-lg"></i></a>
         


        <button type="button" class="btn btn-primary btn-sm float-start m-1" data-bs-toggle="modal"
            data-bs-target="#filterModal"><i class="fa fa-filter"></i></button>  
          <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <form action="<?= base_url("filter")?>" method="post">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Filters</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id='filterModal'>
                    <div class=" mb-0">
                      <label for="name">By Username: </label>
                      <input type="text" name="uname" style="width: 97%" value="<?= set_value("uname")?>">
                    </div>

                    <div class=" mb-0">
                      <label for="name">By Email: </label>
                      <input type="text" name="email" style="width: 97%" value="<?= set_value("email")?>">
                    </div>

                    <div class=" mb-0">
                      <label for="name">By Acesss level: </label>
                      <select class="filter-select " name="role">
                      <option selected disabled>--Choose--</option>
                        <?php 
                        foreach($acess as $row):?>
                        <option value="<?= $row['id'] ?>"><?= $row['Role'] ?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                    <a href="<?= base_url("usertable")?>" class="btn btn-light btn-sm" >Cancel</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
                       



        </div>
        <div class="card-body">
          <table class="table" id="myTable">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Acess Level</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($users as $row) :?>
              <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['uname']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $acess[$row['acesslevel']-1]['Role']; ?></td>
                <td class="d-flex">   
                <a href="<?= base_url("delete/{$row['id']}");?>" class="btn btn-danger btn-sm m-1" 
                onclick="return confirmdelete()"><i class="fa-solid fa-trash fa-lg"></i></a>
          
                <form action="" method="POST"  id='editform'>
                <button type="button" class="btn btn-primary btn-sm m-1" data-bs-toggle="modal" data-bs-target="#edit"
                    onclick="editValue('<?= $row['id']; ?>','<?= $row['uname']; ?>','<?= $row['email']; ?>','<?= $row['acesslevel']; ?>')"><i
                      class="fa-solid fa-pen fa-lg"></i></button>
                      <div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Employee Details</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                          <div class="modal-body">
                            
                              <div class="col-md-12">
                                  <label for="">Name</label>
                                  <input type="text" name="uname" id="uname" class="form-control"placeholder="Enter your Name" >
                              </div>
                              <div class="col-md-12">
                                  <label for="">Email</label>
                                  <input type="email" name="email" id="email" class="form-control"placeholder="Enter your Email" > 
                              </div>
                              <div class="col-md-12">
                                  <label for="">Role</label>
                                    <select name="acesslevel" id="acesslevel" class="form-select" aria-label="Default select example">
                                    <option selected disabled>Select Role</option>
                                    <?php foreach($acess as $opt):?>
                                    <option value="<?= $opt['Role']?>"><?= $opt['Role']?></option>
                                    <?php endforeach;?>
                                    </select>
                              </div>
                          </div>
                      <div class="modal-footer"><button class="btn btn-primary">Update</button></div>
                    </div>
                  </div>
                  </form>
                </td>
              </tr>
              <?php endforeach;?>

        </tbody>
    </table>
    <div class="pagination float-end"> 
    <?= $pager->links() ?>
    </div>

  

    </div>
  </div>
</div>
<script>
    function editValue(id,name, email, acesslevel) {
    document.getElementById('uname').value = name;
    document.getElementById('email').value = email;
    document.getElementById('acesslevel').selected = acesslevel;
    document.getElementById('editform').action = `<?= base_url("update/");?>${id}`;
  }
</script>
<?= $this->endSection('content');?>

