<?= $this->extend('user/layout.php');?>
<?= $this->section('content');?>
<!-- <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">User Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Acess Level</th>
                  <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
               
            
            </tbody>
        </table>
</div> -->


<div class="container">
  <div class="row">
    <div class="col-md-12 mt-4">
      
      <div class="card">
        <div class="card-header d-flex">
        <a href="<?= base_url('addcamp');?>" class="btn btn-success btn-sm m-1"><i class="fa-solid fa-plus fa-lg"></i></a>
        <button type="button" class="btn btn-primary btn-sm float-start m-1" data-bs-toggle="modal"
            data-bs-target="#filterModal"><i class="fa fa-filter"></i></button>  
          <div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <form action="<?= base_url("cfilter")?>" method="post">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Filters</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id='filterModal'>
                    <div class=" mb-0">
                      <label for="name">By Campaign name: </label>
                      <input type="text" name="cname" value="<?= set_value("cname")?>">
                    </div>

                    <div class=" mb-0">
                      <label for="name">By client: </label>
                      <input type="text" name="client" value="<?= set_value("client")?>">
                    </div>

                    <div class=" mb-0">
                      <label for="name">By Supervisor: </label>
                      <select class="filter-select " name="role">
                      <option selected disabled><?= set_value("client")!==null ? set_value("role") : ""; ?></option>
                        <?php 
                        foreach($acess as $row):?>
                        <option value="<?= $row['uname'] ?>"><?= $row['uname'] ?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                    <a href="<?= base_url("camptable")?>" class="btn btn-light btn-sm" >Cancel</a>
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
                <th>Campaign Name</th>
                <th>Description</th>
                <th>Client</th>
                <th>Supervisor</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($campaign as $row): ?>
                <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['cname']; ?></td>
                <td><?= $row['description']; ?></td>
                <td><?= $row['client']; ?></td>
                <td><?= $row['supervisor']; ?></td>
                <td class="d-flex">
                <a href="<?= base_url("campdel/{$row['id']}");?>" class="btn btn-danger btn-sm m-1" 
                onclick="return confirmdelete()"><i class="fa-solid fa-trash fa-lg"></i></a>
                <form action="<? //= base_url('emp/update/'.$row['id']);?>" method="POST" id='editcamp'>
                  <button type="button" class="btn btn-primary btn-sm m-1" data-bs-toggle="modal" data-bs-target="#edit"
                    onclick="editValuec('<?= $row['id']; ?>','<?= $row['cname']; ?>','<?= $row['description']; ?>','<?= $row['client']; ?>','<?= $row['supervisor']; ?>')"><i
                      class="fa-solid fa-pen fa-lg"></i></button>   
                      <div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit campaign Details</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                          <div class="modal-body">
                            <div class="row">
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Campaign Name</label>
                              <input type="text" name="cname" id="cname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                            </div>
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Description</label>
                              <input type="text" name="description" id="description" class="form-control" id="exampleInputPassword1">

                            </div>
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Client</label>
                              <input type="text" name="client" id="client" class="form-control" id="exampleInputPassword1">
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Supervisor</label>
                              <select name="supervisor" id="supervisor" class="form-select" aria-label="Default select example">
                              <?php foreach($acess as $opt):?>
                              <option value="<?= $opt['uname']?>"><?= $opt['uname']?></option>
                              <?php endforeach;?>
                              
                            </select>
                           
                            </div>
                          </div>
                      <div class="modal-footer"><button type="submit" class="btn btn-primary">Update</button></div>
                    </div>
                  </div>
                  </form>
                </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination float-end"> 
    <?= $pager->links() ?>
    </div>
    </div>
  </div>
</div>
<script>
    function editValuec(id,cname, description, client,supervisor) {
    document.getElementById('cname').value = cname;
    document.getElementById('description').value = description;
    document.getElementById('client').value = client;
    document.getElementById('supervisor').selected = supervisor;
    document.getElementById('editcamp').action = `<?= base_url('cupdate/');?>${id}`; 
  }
</script>
<?= $this->endSection('content');?>