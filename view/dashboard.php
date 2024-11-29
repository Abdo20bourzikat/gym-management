<?php

    include '../model/loginModel.php';
    include '../model/memberModel.php';
    include '../model/chartModel.php';
    include '../model/ressourcesModel.php';



    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        header('Location: login.php');
        exit();
    }

    $membersHaveToPay = membersHaveToPay();
    $countMembersHaveToPay = countMembers('active', 'AND payment_date <= CURDATE()');
    $countMembers = countMembers();

    $recentMembers = getData('members', 'active', ' LIMIT 20 ');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
   
    <title>Tableau de bord</title>

    <link href="../public/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/sidebar.css">
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="../public/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="../../public/css/boxicons.min.css"> -->
    <link rel="stylesheet" href="../public/bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../public/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../public/fonts/icomoon/style.css">

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <!-- {{-- bootstrap icon --}} -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> -->

 


    <!-- summernote css link  -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet"> -->

    <!-- Favicon -->
    <!-- {{-- <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png"> --}} -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">



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
    
        <a href="./users/profile.php">
            <div class="profile">
                <img src="<?= $_SESSION['photo'] ?>" alt="Image" class="img-fluid">
                <h3 class="name">Craig David</h3>
                <!-- <span class="country">Web Designer</span> -->
            </div>
        </a>
    
          
          <div class="nav-menu">
            <ul>
              <li class="accordion">
                <li><a href="dashboard.php"><span class="icon-home mr-3"></span>Home</a></li>
              </li>
              <li class="accordion">
                <a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="collapsible">
                  <span class="icon-users mr-3"></span>Membres
                </a>
    
                <div id="collapseTwo" class="collapse" aria-labelledby="headingOne">
                  <div>
                    <ul>
                      <li class="sidebarLink">
                        <a href="./member/membersList.php"><i class="bi bi-people-fill nav_icon mx-1"></i>Liste membres</a>
                      </li>
                      
                        <li class="sidebarLink">
                            <a href="./member/membersHaveToPay.php">
                                <i class="bi bi-person-fill-slash nav_icon mx-1"></i>Membres à payer
                            </a>
                        </li>
                        <li class="sidebarLink">
                            <a href="./member/disabledMembers.php">
                                <i class="bi bi-person-x-fill nav_icon"></i>Membres désactivés
                            </a>
                        </li>
                    </ul>
                  </div>
                </div>
              </li>

              <li><a href=""><span class="icon-notifications mr-3"></span>Notifications</a></li>
              <li><a href=""><span class="icon-message mr-3"></span>Messages</a></li>
              <li><a href="./calendar/calendar.php"><span class="icon-calendar mr-3"></span>Calendrier</a></li>
              <li><a href="./analysis/chart.php"><span class="icon-pie-chart mr-3"></span>Graphiques</a></li>

              <?php if ($_SESSION['role']): ?>
                <li class="accordion">
                    <a href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="collapsible">
                    <span class="icon-settings mr-3"></span>Configuration
                    </a>
        
                    <div id="collapseThree" class="collapse" aria-labelledby="headingOne">
                    <div>
                        <ul>                      
                            <li class="sidebarLink">
                                <a href="./settings/users.php">
                                <span class="icon-users mr-3"></span>Utilisateurs
                                </a>
                            </li>
                            <li class="sidebarLink">
                                <a href="./settings/setting.php">
                                <span class="icon-settings mr-3"></span>Paramètres
                                </a>
                            </li>
                        </ul>
                    </div>
                    </div>
                </li>
              <?php endif; ?>
              <li><a href="./resources/usefulResources.php"><span class="icon-location-arrow mr-3"></span>Ressources</a></li>

              <li>
                <a id="logout" href="./logout.php"><span class="icon-sign-out mr-3"></span>Sign out</a>
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
                  <h5>Tableau de bord</h5>
                </header>

                    <div class="container">

                        <div class="col-md-5">
                            <?php include '../assets/alert.php'; ?>
                        </div>

                        <!-- add new member modal -->
                        <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                        <i class="bi bi-person-fill-add fs-5"></i> Nouveau Membre
                                    </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="row mb-2">
                                                <div class="col-md-6 shadow-none">
                                                    <label for="firstname" class="col-md-6 col-form-label text-secondary">Prénom</label>
                                                    <input id="firstname" name="firstname" type="text" class="form-control shadow-none" placeholder="prénom..." required>
                                                </div>
                                                <div class="col-md-6 shadow-none">
                                                    <label for="lastname" class="col-md-6 col-form-label text-secondary">Nom</label>
                                                    <input  type="text" id="lastname" name="lastname" class="form-control shadow-none" placeholder="nom..." required>
                                                </div>
                                            </div>
                                
                                            <div class="row mb-2">
                                                <div class="col-md-6 shadow-none">
                                                    <label for="email" class="col-md-6 col-form-label text-secondary">Email</label>
                                                    <input id="email" name="email" type="email" class="form-control shadow-none" placeholder="email...">
                                                </div>
                                                <div class="col-md-6 shadow-none">
                                                    <label for="phone" class="col-md-6 col-form-label text-secondary">Téléphone</label>
                                                    <input type="text" id="phone" name="phone" class="form-control shadow-none" placeholder="téléphone...">
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-12 shadow-none">
                                                    <label for="address" class="col-md-6 col-form-label text-secondary">Adresse</label>
                                                    <textarea id="address" name="address" type="text" class="form-control shadow-none" row="3"></textarea>
                                                </div>
                                            </div>
                                        
                                            <div class="row mb-2">
                                                <div class="col-md-6 shadow-none">
                                                    <label for="amount" class="col-md-6 col-form-label text-secondary">Montant payé</label>
                                                    <input id="amount" name="amount" type="text" class="form-control shadow-none" placeholder="montant payé..." required>
                                                </div>
                                                <div class="col-md-6 shadow-none">
                                                    <label for="remainder" class="col-md-6 col-form-label text-secondary">Reste</label>
                                                    <input  type="text" id="remainder" name="remainder" class="form-control shadow-none" placeholder="reste...">
                                                </div>
                                            </div>
                                        
                                            <div class="row mb-2">
                                                <div class="col-md-6 shadow-none">
                                                    <label for="paymentDate" class="col-md-6 col-form-label text-secondary">Date paiement prochaine</label>
                                                    <input type="date" name="paymentDate" class="form-control shadow-none" required>
                                                </div>
                                                <div class="col-md-6 shadow-none">
                                                    <label class="col-md-6 col-form-label text-secondary">Photo du membre</label>
                                                    <input type="file" name="photo" class="form-control shadow-none" accept="image/*">
                                                </div>
                                            </div>
                                        
                                        </div>


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" name="saveMember" class="btn btn-primary btn-sm">
                                                Enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                            
                        <!-- payment modal -->
                        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-person-fill fs-5"></i></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="post">
                                        <input type="hidden" id="memberIdModal" name="memberIdModal">

                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6 shadow-none">
                                                    <label for="amount" class="col-md-6 col-form-label text-secondary">Montant payé</label>
                                                    <input id="amount" name="amount" type="text" class="form-control shadow-none" required>
                                                </div>
                                                <div class="col-md-6 shadow-none">
                                                    <label for="remainder" class="col-md-6 col-form-label text-secondary">Reste</label>
                                                    <input type="text" id="remainder" name="remainder" class="form-control shadow-none">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6 shadow-none">
                                                    <label for="paymentDate" class="col-md-6 col-form-label text-secondary">Date paiement prochaine</label>
                                                    <input type="date" id="paymentDate" name="paymentDate" class="form-control shadow-none" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" name="memberPaymentConfig" class="btn btn-success btn-sm">Valider</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="card shadow rounded-3">
                                    <div class="card-header">
                                        <h5>
                                            <strong>
                                                <i class="bi bi-calendar3"></i> <?= date('d-M-Y') ?>
                                            </strong>
                                        </h5>
                                    </div>
                                    <div class="card-body p-1">
                                        <div class="container-fluid py-5">
                                            <h1 class="display-5 fw-bold">GYM-ALPHA</h1>
                                            <hr>
                        
                                            <?php if ($countMembersHaveToPay > 0): ?>
                        
                                                <p class="col-md-12 fs-4 mb-5">
                                                    Il y a actuellement <strong>" <?= $countMembersHaveToPay ?> "</strong> membre(s) dont la date de paiement est arrivée.
                                                </p>
                                            <?php else: ?>
                                                <h5 class="text-secondary mb-3">
                                                    <strong>Aucun membre n’a de paiement dû aujourd’hui.</strong>
                                                </h5>
                                            <?php endif; ?>
                    
                                            <hr>
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-primary btn-sm shadow-none" style="white-space: nowrap;" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                                                    <i class="bi bi-person-fill-add"></i> Nouveau Membre
                                                </button>
                                                <a href="./member/membersHaveToPay.php" style="white-space: nowrap;"  class="btn btn-secondary btn-sm mx-1"><i class="bi bi-person-fill-slash">
                                                    </i> Membres à Payer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h5>
                                            <strong>
                                                <i class="bi bi-bar-chart-fill mx-1"></i> Graphique des paiements mensuels
                                            </strong>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="monthlyChart" style="max-height: 500px; width: 100%"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="row mt-4 mb-4">
                            <?php
                                if (count($allMembers) > 0):
                            ?>
                            <div class="card shadow">
                                <div class="card-header">
                                    <h5>
                                        <strong>
                                        <i class="bi bi-list mx-1 fs-5"></i>Liste des Membres
                                        </strong>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div style="max-height: 500px; overflow-y: auto; overflow-x: hidden; padding: 10px;">
                                        <div class="row">
                                            <?php 
                                                if (isset($_POST['searchMember'])) {
                                                    $allMembers = [];
                                                    $allMembers = searchMembers("AND status = 'active' ");
                                                }
                                                // foreach ($allMembers as $member):
                                            ?>

                                            <table class="table table-hover">

                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Membre
                                                            <i class="bi bi-caret-down-fill m-1" onclick="filterData('firstname')"></i>
                                                        </th>
                                                        <?php if ($settingsMap['photo'] == 1): ?>
                                                            <th>Photo</th>
                                                        <?php endif; ?>

                                                        <?php if ($settingsMap['email'] == 1): ?>
                                                        <th>
                                                            Email
                                                            <i class="bi bi-caret-down-fill m-1" onclick="filterData('email')"></i>
                                                        </th>
                                                        <?php endif; ?>
                                                        <?php if ($settingsMap['phone'] == 1): ?>
                                                        <th>
                                                            Contact
                                                            <i class="bi bi-caret-down-fill m-1" onclick="filterData('phone')"></i>
                                                        </th>
                                                        <?php endif; ?>

                                                        <?php if ($settingsMap['address'] == 1): ?>
                                                            <th>
                                                                Adresse
                                                                <i class="bi bi-caret-down-fill m-1" onclick="filterData('address')"></i>
                                                            </th>
                                                        <?php endif; ?>
                                                        <?php if ($settingsMap['status'] == 1): ?>
                                                            <th>
                                                                Status
                                                                <i class="bi bi-caret-down-fill m-1" onclick="filterData('status')"></i>
                                                            </th>
                                                        <?php endif; ?>

                                                        <?php if ($settingsMap['amount'] == 1): ?>
                                                            <th>
                                                                Montant payé
                                                                <i class="bi bi-caret-down-fill m-1" onclick="filterData('amount')"></i>
                                                            </th>
                                                        <?php endif; ?>

                                                        <?php if ($settingsMap['remainder'] == 1): ?>
                                                            <th>
                                                                Reste
                                                                <i class="bi bi-caret-down-fill" onclick="filterData('remainder')"></i>
                                                            </th>
                                                        <?php endif; ?>

                                                        <th>
                                                            <div class="d-flex">
                                                                Paiement actuelle
                                                                <i class="bi bi-caret-down-fill" onclick="filterData('payment_date_trace')"></i>
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="d-flex">
                                                                Paiement prochaine
                                                                <i class="bi bi-caret-down-fill" onclick="filterData('payment_date')"></i>
                                                            </div>
                                                        </th>

                                                        <?php if ($settingsMap['inactivated_date'] == 1): ?>
                                                        <th>
                                                            <div class="d-flex">
                                                                Date désactivation
                                                                <i class="bi bi-caret-down-fill" onclick="filterData('inactivated_date')"></i>
                                                            </div>
                                                        </th>
                                                        <?php endif; ?>

                                                        <th>Activer/Désactiver</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                        if (isset($_POST['searchMember'])) {
                                                            $allMembers = [];
                                                            $allMembers = searchMembers("AND status = 'active' ");
                                                        }
                                                        foreach ($allMembers as $member):
                                                    ?>

                                                    <tr>
                                                        <td>
                                                            <?php 
                                                                $currentDate = new DateTime();
                                                                $paymentDate = new DateTime($member['payment_date']);
                                                                // $dateDiff = $currentDate->diff($paymentDate);

                                                                if ($currentDate >= $paymentDate): 
                                                            ?>
                                                                <span style="height: 10px; width: 10px; background-color: red; border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                                                                <?php else: ?>
                                                                    <span style="height: 10px; width: 10px; background-color: #198754; border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                                                            <?php endif; ?>
                                                            <a href="./member/memberCard.php?memberId=<?= $member['id'] ?>" class="text-dark">
                                                                <?= $member['firstname'] . ' ' . $member['lastname'] ?>
                                                            </a>
                                                        </td>

                                                        <?php if ($settingsMap['photo'] == 1): ?>
                                                            <td>
                                                                <?php if ($member['photo']): ?>
                                                                <div class="">
                                                                    <img src="<?= $member['photo'] ?>" alt="Photo de <?= $member['firstname'] ?>" class="user-photo">
                                                                </div>
                                                                <?php else: ?>
                                                                    <div class="initials-circle-user" style="background-color: #<?php echo substr(md5($member['firstname'] . $member['lastname']), 0, 6); ?>">
                                                                        <?= strtoupper($member['firstname'][0]) . strtoupper($member['lastname'][0]) ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </td>
                                                        <?php endif; ?>

                                                        <?php if ($settingsMap['email'] == 1): ?>
                                                            <td><?= $member['email'] ?></td>
                                                        <?php endif; ?>

                                                        <?php if ($settingsMap['phone'] == 1): ?>
                                                            <td><?= $member['phone'] ?></td>
                                                        <?php endif; ?>
                                                        
                                                        <?php if ($settingsMap['address'] == 1): ?>
                                                            <td><?= $member['address'] ?></td>
                                                        <?php endif; ?>
                                                        <?php if ($settingsMap['status'] == 1): ?>
                                                            <td><?= $member['status'] ?></td>
                                                        <?php endif; ?>

                                                        <?php if ($settingsMap['amount'] == 1): ?>
                                                            <td class="text-center"><?= $member['amount'] ?></td>
                                                        <?php endif; ?>

                                                        <?php if ($settingsMap['remainder'] == 1): ?>
                                                            <td><?= $member['remainder'] ?></td>
                                                        <?php endif; ?>

                                                        <td class="text-center">
                                                            <?php
                                                                $dateTime = new DateTime($member['payment_date_trace']);
                                                                $formattedDate = $dateTime->format('Y-m-d');
                                                                echo $formattedDate;
                                                                ?>
                                                        </td>

                                                        <td class="text-center">
                                                            <?php
                                                                $dateTime = new DateTime($member['payment_date']);
                                                                $formattedDate = $dateTime->format('Y-m-d');
                                                                if ($currentDate >= $paymentDate):
                                                            ?>
                                                                <p class="text-danger"><?= $formattedDate; ?></p>
                                                            <?php else: echo $formattedDate; ?>
                                                            <?php endif; ?>
                                                                
                                                        </td>

                                                        <?php if ($settingsMap['inactivated_date'] == 1): ?>

                                                            <td class="text-center">
                                                                <?php if ($member['inactivated_date'] != null): ?>
                                                                    <?= $member['inactivated_date'] ?>
                                                                <?php else: ?>
                                                                    --
                                                                <?php endif; ?>
                                                            </td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <div class="d-flex">
                                                                <div class="form-check form-switch mt-1">
                                                                    <input 
                                                                        class="form-check-input" 
                                                                        type="checkbox" 
                                                                        id="memberStatus<?= $member['id'] ?>" 
                                                                        <?php if ($member['status'] == 'active'): ?>
                                                                            title="désactiver ce membre"
                                                                            <?php else: ?>
                                                                                title="activer ce membre"
                                                                            <?php endif; ?>
                                                                        <?= $member['status'] === 'active' ? 'checked' : '' ?> 
                                                                        onclick="toggleMemberStatus(<?= $member['id'] ?>, this)">
                                                                </div>
                                                                <a href="./member/mailToMember.php?memberId=<?= $member['id'] ?>" title="Contacter ce membre">
                                                                    <i class="bi bi-envelope-at-fill  fs-4"></i>
                                                                </a>

                                                            </div>
                                                        </td>

                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>

                                            </table>                            
                                        </div>
                                    </div>

                                    <!-- Pagination controls -->
                                    <?php $totalPages = ceil($countMembers / $limit); ?>
                                    <nav class="d-flex mt-4">
                                        <ul class="pagination">
                                            <?php if($page > 1): ?>
                                                <li class="page-item"><a class="page-link shadow-none" href="?page=<?= $page - 1 ?>">Précédent</a></li>
                                            <?php endif; ?>
                                            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>"><a class="page-link shadow-none" href="?page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php endfor; ?>
                                            <?php if($page < $totalPages): ?>
                                                <li class="page-item"><a class="page-link shadow-none" href="?page=<?= $page + 1 ?>">Suivant</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                            <?php else: ?>
                                <h5 class="text-secondary m-5 p-5 text-center bg-light">Aucun membre encore</h5>
                                <div style="min-height: 200px;"></div>
                            <?php endif; ?>

                        </div>


                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Membres à Payer (<?= $countMembersHaveToPay ?>)
                                </button>
                            </h2>

                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <form action="" method="post">
                                                <div class="mb-2 d-flex">
                                                    <input type="text" name="searchMemberValue" class="form-control form-control-sm shadow-none me-2" placeholder="Nom, prénom ou téléphone" required>
                                                    <button type="submit" name="searchMember" class="btn btn-primary btn-sm shadow-none"><i class="bi bi-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- <div class="p-5 mb-4 bg-light shadow rounded-3"> -->
                                            <?php if ($countMembersHaveToPay > 0): ?>
                                                <div class="card shadow mb-4">
            
                                                    <div class="card-body">
                                                        <div style="max-height: 640px; overflow-y: auto; overflow-x: hidden; padding: 10px;">
                                                            <div class="row">
            
                                                                <?php 
                                                                    if (isset($_POST['searchMember'])) {
                                                                        $membersHaveToPay = [];
                                                                        $membersHaveToPay = searchMembers("AND payment_date <= CURDATE() AND status = 'active'");
                                                                    }
                                                                    foreach ($membersHaveToPay as $member):
                                                                ?>
            
                                                                    <div class="col-md-4">
                                                                        <div class="card my-2 bg-light shadow">
                                                                            <div class="card-body">
                                                                                <a href="./member/memberCard.php?memberId=<?= $member['id'] ?>" class="text-decoration-none text-dark">
                                                                                    <?php if ($member['photo']): ?>
                                                                                        <div class="text-center">
                                                                                            <img src="<?= $member['photo'] ?>" alt="Photo de <?= $member['firstname'] ?>" class="member-photo">
                                                                                        </div>
                                                                                    <?php else: ?>
                                                                                        <div class="initials-circle mx-auto" style="background-color: #<?php echo substr(md5($member['firstname'] . $member['lastname']), 0, 6); ?>">
                                                                                            <?= strtoupper($member['firstname'][0]) . strtoupper($member['lastname'][0]) ?>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                </a>
            
                                                                                <div class="d-flex justify-content-between bg-light mt-3">
                                                                                    <h5 class="card-title"><?= $member['firstname'] . ' ' . $member['lastname'] ?></h5>
                                                                                    <div class="form-check form-switch">
                                                                                        <input 
                                                                                            class="form-check-input" 
                                                                                            type="checkbox" 
                                                                                            id="memberStatus<?= $member['id'] ?>" 
                                                                                            <?php if ($member['status'] == 'active'): ?>
                                                                                            title="désactiver ce membre"
                                                                                            <?php else: ?>
                                                                                                title="activer ce membre"
                                                                                            <?php endif; ?>
                                                                                            <?= $member['status'] === 'active' ? 'checked' : '' ?> 
                                                                                            onclick="toggleMemberStatus(<?= $member['id'] ?>, this)">
                                                                                    </div>
                                                                                </div>
                                                                                <hr class="mb-3">
            
                                                                                <p><strong>Date de paiement prochaine:</strong> <?= $member['payment_date'] ?></p>
                                                                                <p><strong>Montant payé:</strong> <?= $member['amount'] ?></p>
                                                                                <p><strong>Reste:</strong> <?= $member['remainder'] ?></p>
                                                                                <hr>
                                                                                <div class="d-flex">
                                                                                    <form action="" method="post">
                                                                                        <input type="hidden" name="memberId" value="<?= $member['id'] ?>">
                                                                                        <input type="hidden" name="memberAmount" value="<?= $member['amount'] ?>">
                                                                                        <input type="hidden" name="memberRemainder" value="<?= $member['remainder'] ?>">
                                                                                        <button type="submit" name="memberPayment" 
                                                                                            onClick="return confirm('Veuillez vérifier les informations avant de confirmer le paiement !')" 
                                                                                            class="btn btn-primary btn-sm shadow-none">Payer Maintenant</button>
                                                                                    </form>
                                                                                    <button type="button" class="btn btn-success btn-sm shadow-none mx-1" 
                                                                                            data-bs-toggle="modal" 
                                                                                            data-bs-target="#paymentModal"
                                                                                            data-member-id="<?= $member['id'] ?>"
                                                                                            data-firstname="<?= $member['firstname'] ?>"
                                                                                            data-lastname="<?= $member['lastname'] ?>"
                                                                                            data-amount="<?= $member['amount'] ?>"
                                                                                            data-remainder="<?= $member['remainder'] ?>"
                                                                                            data-payment-date="<?= $member['payment_date'] ?>">
                                                                                            Modifier Paiement
                                                                                    </button>
                                                                                </div>
            
                                                                            </div>
                                                                        </div>
            
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <h5 class="text-secondary m-5 p-5 text-center">Aucun membre à payer encore</h5>
                                                <div style="min-height: 100px;"></div>
                                            <?php endif; ?>
                                        </div> 
                                </div>
                            </div>
                        </div>



                        <div class="row mb-5">

                            <?php 
                                $currentGroup = null;
                                foreach ($GetWebsites as $website):

                                if ($currentGroup !== $website['groupname']): 
                                    $currentGroup = $website['groupname'];
                            ?>
                            <div class="line-with-title">
                                <h4 class="mt-4 mb-3">
                                    <strong><?= $currentGroup ?></strong>
                                </h4>
                            </div>
                            <?php endif; ?>

                                <div class="col-md-3">
                                    <div class="card shadow position-relative d-flex flex-column">
                                        <a href="<?= $website['sitelink'] ?>" target="_blank">
                                        <?php if (!empty($website['siteimage'])): ?>
                                            <img src="<?= $website['siteimage'] ?>" style="min-height: 250px;" class="card-img-top" alt="...">
                                        <?php else: ?>
                                            <div class="card-img-top" style="background-color: gray; height: 250px; display: flex; align-items: center; justify-content: center;">
                                                <span class="text-white">No Image</span>
                                            </div>
                                        <?php endif; ?>
                                        </a>

                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <h5 class="card-title text-dark"><?= $website['sitetitle'] ?></h5>
                                            <hr width="90px;">
                                            
                                            <!-- Set a minimum height for the description to ensure equal height -->
                                            <p class="card-text text-dark" style="min-height: 70px;"><?= $website['description'] ?></p>
                                            
                                        </div>
                                    </div>
                                </div>



                            <?php endforeach; ?>
                        </div>


                        <?php include('../assets/footer.php'); ?>
                    </div>

    <script src="../public/js/sidebar.js"></script>
    <script src="../public/js/bootstrap.js"></script>
    <script src="../public/js/jquery.min.js"></script>
    <script src="../public/js/chart.cdn.js"></script>
    <script src="../public/js/main.js"></script>

    <script src="../public/js/jquery-3.3.1.min.js"></script>
    <script src="../public/js/popper.min.js"></script>
    <script src="../public/js/bootstrap.min.js"></script>
    <script src="../public/js/main2.js"></script>



    <script>
        // Filter script
        function filterData(columnName) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './member/getMembers.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    // Replace the table body with the filtered data
                    document.querySelector('table tbody').innerHTML = this.responseText;
                }
            };
            xhr.send('column=' + columnName);
        }
    </script>

    <script>
        // For Monthly Chart
        var monthlyLabels = <?php echo json_encode(array_column($data['monthly'], 'payment_month')); ?>;
        var monthlyData = <?php echo json_encode(array_column($data['monthly'], 'total_amount')); ?>;

        // Monthly Payments Chart
        var monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        var monthlyChart = new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Monthly Payments',
                    data: monthlyData,
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            }
        });

        // Payment with configuration modal
        document.addEventListener('DOMContentLoaded', function() {
            var paymentModal = document.getElementById('paymentModal');
            paymentModal.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                var button = event.relatedTarget;

                // Extract info from data-* attributes
                var memberId = button.getAttribute('data-member-id');
                var firstname = button.getAttribute('data-firstname');
                var lastname = button.getAttribute('data-lastname');
                var amount = button.getAttribute('data-amount');
                var remainder = button.getAttribute('data-remainder');
                var paymentDate = button.getAttribute('data-payment-date');

                // Update the modal's content
                var modalTitle = paymentModal.querySelector('.modal-title');
                var modalAmount = paymentModal.querySelector('#amount');
                var modalRemainder = paymentModal.querySelector('#remainder');
                var modalPaymentDate = paymentModal.querySelector('#paymentDate');
                var memberIdModal = paymentModal.querySelector('#memberIdModal');

                modalTitle.textContent = firstname + ' ' + lastname;
                modalAmount.value = amount;
                modalRemainder.value = remainder;
                modalPaymentDate.value = paymentDate;
                memberIdModal.value = memberId;

            });
        });
    </script>

</body>
</html>
