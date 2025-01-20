<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="<?= base_url("cdn/bootstrap/bootstrap.css")?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/chat.css")?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/tail-colors.css")?>">
    <link rel="stylesheet" href="<?= base_url("cdn/select2.css")?>">
    <link rel="stylesheet" href="<?= base_url("cdn/fontawesome.css")?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url("style.css")?>">
</head>
<body>
    <header>
        <div class="logo">
            <img src="data:image/jpeg;base64,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9Sx7Dn4/Q9q/0+r7izRF+fKSNzW2PeSV7pwSN/vWebcVtt92qwR0jWR8mwYW4SB27eKuK4a1x+HXpCtnJNr89kLkvNswytk5XFhvow2vcEa78VW6bhU4csZObfb8k3UcQ8XHNOXZs5XyAyd2MOwP2kC4PWN63azhtNRPNvtP7tem1t8Mcu28Iz4nn0w/J/UoHsOfj9Ev2r/R6nxQPph+T+pZ9iT8foe1f6fVKZQyMZII4Q+2DDptrs3DqvxVhqNDOXBXFFttkLDqvDyzkmN90X8UHemH5D7yrvYt/wDc9Ez2pHwPWZoG+mbRwZp8SsxwSd/vX9P/AKTxXp0om5MmN5AwM5oLSL69esnerW2kr9nnDXpG2yvjPbxfFt1lp5EyCad5eZMV2YbYbbQb6zuUbQ8OnTXm/Nv02b9VrfHrFdtuqRyrR8tE6PFhvbTa+og6uxTNVg8fFOPfbdHwZfCyRfbs0ch5FNOXEvxYgB0bWt2lRdDoPs0zPNvu36rV+PERttsrWUPJ26SSR/wkDG97rcle2JxNr49NrqyQl7hZhaG7gB3CyD4rKZkrHRyC7HNIcOBQUP5NnA3bV2sbtPJaRY6DcP18UF9pGvDGiRwc8ABzgMIcdptc2vuQQed2bhrRGBKI8BcdLcV7gDeLakH1mjm6aJsjTIJMbgbhuG1ha2soJ9BH5ayNDVR8nM2+1rhoc072n+wgp0vk0082qNvtR3PeHD1IPj5NHf5of/I++gtWaeQjRROiMnKYpC++HDa7Wtta583xQTSAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICD/9k=" alt="" srcset="">
        </div>
        <nav class="nav">
            <ul>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php 
                if(session()->get('logged_in')){
                  echo session()->get('user_name');
                }
                ?>
                <i class="fa-solid fa-user ms-1"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item d-inline min-width-1" href="#">Log Out</a></li>
                </ul>
              </li>
            </ul>
        </nav>
    </header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light ms-3 me-3 p-0">
        <div class="container-fluid">
          <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="http://localhost:8080/">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Live</a>
              </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Reports</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Logger Reports</a>
                <ul class="dropdown-submenu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="http://localhost:8080/report/1">SQl</a></li>
                  <li><a class="dropdown-item" href="http://localhost:8080/report/2">Mongo</a></li>
                  <li><a class="dropdown-item" href="http://localhost:8080/report/3">Elastic</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Hourly Reports</a>
                <ul class="dropdown-submenu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="http://localhost:8080/hreport/1">SQl</a></li>
                  <li><a class="dropdown-item" href="http://localhost:8080/hreport/2">Mongo</a></li>
                  <li><a class="dropdown-item" href="http://localhost:8080/hreport/3">Elastic</a></li>
                </ul>
              </li>
            </ul>
          </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Conversations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contacts</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Operations
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="http://localhost:8080/usertable">Users</a></li>
                  <li><a class="dropdown-item" href="#">Acess Level</a></li>
                  <li><a class="dropdown-item" href="<?= base_url("camptable");?>">Campaign</a></li>
                  <li><a class="dropdown-item" href="<?= base_url("chat");?>">Chat</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Advanced
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="#">IVR manage</a></li>
                  <li><a class="dropdown-item" href="#">Global Settings</a></li>
                  <li><a class="dropdown-item" href="#">Voice</a></li>
                  <li><a class="dropdown-item" href="#">SMS</a></li>
                  <li><a class="dropdown-item" href="#">API</a></li>
                  <li><a class="dropdown-item" href="#">Tab</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Custom Reports</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

    <main>

    <?= $this->renderSection('content'); ?>

    </main>

<!-- <footer>
    <p>&copy; 2024 SlashRTC. All rights reserved.</p>
</footer> -->

<script src="<?= base_url("cdn/popper.js")?>"></script>
<script src="<?= base_url("cdn/bootstrap/bootstrap.js")?>"></script>
<script src="<?= base_url("assets/javascript/chat.js")?>"></script>
<script src="<?= base_url("../../../public/cdn/socket.js")?>"></script>
<script src="<?= base_url("cdn/jquery.js")?>"></script>
<script src="<?= base_url("cdn/select2.js")?>"></script>


<script>
    function confirmdelete(){
      return confirm("Are you sure you want to delete");
    }
    $(document).ready(function() {
      $('.filter-select').select2({
      dropdownParent: $('#filterModal')
      });
    })
</script>
</body>
</html>