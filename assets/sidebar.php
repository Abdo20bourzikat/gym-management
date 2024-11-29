

    <!-- <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->

        <!-- Include Select2 CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

    <!-- Include jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <!-- Include Select2 JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->








            <!-- <a href="../dashboard.php" class="nav_link active">
                <i class='bx bxs-dashboard nav_logo-icon'></i>
                <span class="nav_name">Dashboard</span>
            </a> -->

           
           
           
            
            <?php //if ($_SESSION['role'] == 1): ?>

                <!-- <li class="accordion">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="collapsible nav_link" style="margin: 0 0 5px 3px;">
                        <i class="bi bi-gear-fill"></i> Configuration
                    </a>
                    <div id="collapseTwo" class="collapse">
                        <a href="../settings/users.php" class="nav_link" style="margin:0; padding:0 0 0 60px;"><i class="bi bi-people"></i> Utilisateurs</a>
                        <a href="../settings/setting.php" class="nav_link" style="margin:0; padding:10px 0 0 60px;"><i class="bi bi-gear-wide-connected"></i> Paramètres</a>
                    </div>
                </li> -->
            <?php //endif; ?>
       




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
   
    <title>
        <?php
            if (isset($tabTitle)) {
                echo $tabTitle;
            }
        ?>
    </title>


    <link href="../../public/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/sidebar.css">
    <link rel="stylesheet" href="../../public/css/main.css">
    <link rel="stylesheet" href="../../public/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="../../public/css/boxicons.min.css"> -->
    <link rel="stylesheet" href="../../public/bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../../public/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../public/fonts/icomoon/style.css">

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <!-- {{-- bootstrap icon --}} -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> -->

 


    <!-- summernote css link  -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    
    <!-- Favicon -->
    <!-- {{-- <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png"> --}} -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


          

    <!-- summernote css link  -->
    <!-- <link rel="stylesheet" href="/css/summernote.min.css"> -->


    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

</head>
<body>

  <div class="d-flex">
        <aside class="sidebar">
          <div class="toggle">
            <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
              <span></span>
            </a>
          </div>
          <div class="side-inner">
      
            <a href="../users/profile.php">
              <div class="profile">
                <img src="<?= $_SESSION['photo'] ?>" alt="Image" class="img-fluid">
                <h3 class="name">Craig David</h3>
                <!-- <span class="country">Web Designer</span> -->
              </div>
            </a>
      
            
            <div class="nav-menu">
              <ul>
                <li class="accordion">
                  <li><a href="../dashboard.php"><span class="icon-home mr-3"></span>Home</a></li>
                </li>
                <li class="accordion">
                  <a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="collapsible">
                    <span class="icon-users mr-3"></span>Membres
                  </a>
      
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingOne">
                    <div>
                      <ul>
                        <li class="sidebarLink">
                          <a href="../member/membersList.php"><i class="bi bi-people-fill nav_icon mx-1"></i>Liste membres</a>
                        </li>
                        
                          <li class="sidebarLink">
                              <a href="../member/membersHaveToPay.php">
                                  <i class="bi bi-person-fill-slash nav_icon mx-1"></i>Membres à payer
                              </a>
                          </li>
                          <li class="sidebarLink">
                              <a href="../member/disabledMembers.php">
                                  <i class="bi bi-person-x-fill nav_icon"></i>Membres désactivés
                              </a>
                          </li>
                      </ul>
                    </div>
                  </div>
                </li>
  
  
                <li><a href=""><span class="icon-notifications mr-3"></span>Notifications</a></li>
                <li><a href=""><span class="icon-message mr-3"></span>Messages</a></li>
                <li><a href="../calendar/calendar.php"><span class="icon-calendar mr-3"></span>Calendrier</a></li>
  
                <li><a href="../analysis/chart.php"><span class="icon-pie-chart mr-3"></span>Graphiques</a></li>
  
                <?php if ($_SESSION['role'] == 1): ?>
                <li class="accordion">
                  <a href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="collapsible">
                    <span class="icon-settings mr-3"></span>Configuration
                  </a>
      
                  <div id="collapseThree" class="collapse" aria-labelledby="headingOne">
                    <div>
                      <ul>                      
                          <li class="sidebarLink">
                              <a href="../settings/users.php">
                                <span class="icon-users mr-3"></span>Utilisateurs
                              </a>
                          </li>
                          <li class="sidebarLink">
                              <a href="../settings/setting.php">
                                <span class="icon-settings mr-3"></span>Paramètres
                              </a>
                          </li>
                      </ul>
                    </div>
                  </div>
                </li>
                <?php endif; ?>
  
                <li><a href="../resources/usefulResources.php"><span class="icon-location-arrow mr-3"></span>Ressources</a></li>

                <li>
                  <a id="logout" href="../logout.php"><span class="icon-sign-out mr-3"></span>Sign out</a>
                </li>
              </ul>
            </div>
          </div>
          
        </aside>

      <main>
        <div class="site-section">
            <div class="container">
                <div class="row justify-content-center">

                <header class="topHeader d-flex justify-space-between p-4" id="header">
                  <h5>
                      <?php
                          if (isset($pageTitle)) {
                              echo $pageTitle;
                          }
                      ?>
                  </h5>
                </header>




    <script src="../../public/js/sidebar.js"></script>
    <!-- <script src="../../public/js/bootstrap.js"></script> -->
    <script src="../../public/js/jquery.min.js"></script>
    <script src="../../public/js/main.js"></script>

    <script src="../../public/js/jquery-3.3.1.min.js"></script>
    <script src="../../public/js/popper.min.js"></script>
    <script src="../../public/js/bootstrap.min.js"></script>
    <script src="../../public/js/main2.js"></script>

