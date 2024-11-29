<?php 

    include '../../model/loginModel.php';
    include '../../model/memberModel.php';
    include '../../model/exportModel.php';
    $countMembers = countMembers();
    $tabTitle = "Liste des membres"; 
    $pageTitle = 'Liste des membres <span class="badge badge-count">' . $countMembers . '</span>';

    accessPermission();

?>

    <?php include '../../assets/sidebar.php'; ?>

    <div class="container">

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
                                    <label for="paymentDate" class="col-md-6 col-form-label text-secondary">Date de paiement</label>
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

        <!-- Export modal -->
        <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-file-earmark-spreadsheet"></i> Exporter en excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="startDate" class="col-form-label text-secondary">Date 1</label>
                                        <input type="date" name="startDate" class="form-control shadow-none">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="endDate" class="col-form-label text-secondary">Date 2</label>
                                        <input type="date" name="endDate" class="form-control shadow-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" name="exportData" class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-spreadsheet"></i>Exporter en Excel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <?php
            if (count($allMembers) > 0):
        ?>
            <div class="col-md-12">
                <div class="col-md-5">
                    <?php include '../../assets/alert.php'; ?>
                </div>
            </div>

            <div class="row mt-4">
                <div class="">
                    <div class="d-flex">
                        <!-- <div class="col-md-2">
                            <form action="" method="post">
                                <div class="d-flex">
                                    <select name="limitSelect" class="form-select shadow-none">
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="500">500</option>
                                        <option value="0">Tous</option>
                                    </select>
                                    <button type="submit" name="getLimitedData" class="btn btn-info btn-sm shadow-none mx-1">Valider</button>
                                </div>
                            </form>
                        </div> -->
                        <div class="col-md-8">
                            <button type="button" class="btn btn-primary btn-mm shadow-none mx-1" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                                <i class="bi bi-person-fill-add"></i> Nouveau Membre
                            </button>
                            <?php if ($_SESSION['role'] == 1): ?>

                            <button type="button" class="btn btn-success btn-mm shadow-none" data-bs-toggle="modal" data-bs-target="#exportModal">
                                <i class="bi bi-file-earmark-spreadsheet"></i> Exporter en Excel
                            </button>
                            <?php endif; ?>

                        </div>
                        <div class="col-md-4">
                            <form action="" method="post" class="d-flex">
                                <input type="text" name="searchMemberValue" class="form-control form-control-sm me-2" placeholder="Nom, prénom ou téléphone" required>
                                <button type="submit" name="searchMember" class="btn btn-primary btn-sm shadow-none p-2"><span class="icon-search mx-2"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mb-4">


            <div style="max-height: 640px; overflow-y: auto; overflow-x: hidden; padding: 10px;">
                <div class="row">

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
                                        <a href="./memberCard.php?memberId=<?= $member['id'] ?>" class="text-dark">
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
                                        <div class="form-check form-switch mx-5">
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

        <?php else: ?>
            <h5 class="text-secondary m-5 p-5 text-center bg-light">Aucun membre encore</h5>
            <div style="min-height: 200px;"></div>
        <?php endif; ?>

    <?php include('../../assets/footer.php'); ?>
</div>

    <script>
        function filterData(columnName) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'getMembers.php', true);
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


</body>
</html>