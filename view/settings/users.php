<?php 
    include '../../model/loginModel.php';
    include '../../model/memberModel.php';
    include '../../model/userModel.php';
    $countUsers = countUsers();
    $usersData = getUsersData('_users_');
    accessPermission();
    $tabTitle = "Utilisateurs";
    $pageTitle = 'Utilisateurs <span class="badge badge-count">' . $countUsers . '</span>';

    if ($_SESSION['role'] == 0):
?>
                
        <div class="col-md-12 mt-5 card shadow">
            <h5 class="text-danger my-5 mx-auto">Vous n'avez pas l'autorisation pour ce processus !</h5>
        </div>
        
    <?php else: ?>

    <?php include '../../assets/sidebar.php'; ?>


    <div class="container">

        <!-- Add user modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-person-fill-lock mx-1"></i> Nouveau Utilisateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post" class="mt-3 mx-5" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname" class="form-label">Nom</label>
                                        <input type="text" name="lastname" class="form-control shadow-none" placeholder="nom..." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Prénom</label>
                                        <input type="text" name="name" class="form-control shadow-none" placeholder="prénom..." required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="userPhoto" class="form-label">Photo</label>
                                        <input type="file" name="userPhoto" class="form-control shadow-none">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role" class="form-label">Rôle</label>
                                        <select name="role" class="form-select shadow-none" required>
                                            <option value="">Veuillez Sélectionnez un rôle</option>
                                            <option value="1">Admine</option>
                                            <option value="0">Utilisateur</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="login" class="form-label">Login</label>
                                        <input type="text" name="login" class="form-control shadow-none" placeholder="login..." required>
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label for="" class="form-label">Mot de passe</label>
                                        <input type="password" name="password" class="form-control shadow-none" placeholder="mot de passe..." required>
                                    </div>
                                </div>
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label for="" class="form-label">Confirmation du mot de passe</label>
                                        <input type="password" name="passwordConfirmation" class="form-control shadow-none" placeholder="confirmation du mot de passe..." required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" name="addUser" class="btn btn-primary btn-sm shadow-none">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <?php include '../../assets/alert.php'; ?>
        </div>


        <div class="row mb-2">
            <div class="col-md-3">
                <button type="button" class="btn btn-primary btn-mm shadow-none" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-person-fill-lock"></i> Nouveau Utilisateur
                </button>

            </div>
            <div class="col-md-6"></div>
            <div class="col-md-3">
                <form action="" method="post" class="d-flex">
                        <input type="text" name="searchUserValue" class="form-control form-control-sm me-2" placeholder="rechercher..." required>
                        <button type="submit" name="searchUser" class="btn btn-primary btn-sm shadow-none p-2"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <hr class="mb-4">



        <?php if (count($usersData)> 0): ?>
            <div class="mt-3">
                    
                <div class="d-flex justify-content-between mx-4">
                    <p class="mb-0"><i class="bi bi-people-fill mx-1"></i> Liste des Utilisateurs</p>
                </div>
                <hr class="mx-5" width="90px">
                <div style="max-height: 400px; overflow-y: auto; overflow-x: hidden; padding: 10px;">
                    <div class="row">
                        <?php 
                            if (isset($_POST['searchUser'])) {
                                $usersData = [];
                                $usersData = searchUsers();
                            }
                            foreach ($usersData as $user): 
                            
                        ?>
    
                        <div class="col-md-3 mb-4">
                            <div class="card my-2 shadow h-100" style="display: flex; flex-direction: column; justify-content: flex-start;">
                                <!-- Placeholder space for delete button -->
                                <div style="height: 40px; position: relative;">
                                    <?php if ($user['role'] == '0'): ?>
                                        <form action="" method="post" style="position: absolute; right: 0;">
                                            <input type="hidden" name="eventId" value="<?= $user['id'] ?>">
                                            <button type="submit" name="deleteUser" style="background: none; border-style: none;" 
                                                onClick="return confirm('Êtes-vous sûr de vouloir supprimer ce utilisateur ?');">
                                                <i class="bi bi-x-circle text-danger fs-4"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body" style="text-align: center;">
                                    <?php if ($user['photo']): ?>
                                        <div class="photo-wrapper mb-3" style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; margin: 0 auto;">
                                            <img src="<?= $user['photo'] ?>" alt="Photo de <?= $user['prenom'] ?>" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    <?php else: ?>
                                        <div class="initials-circle" style="background-color: #<?php echo substr(md5($user['prenom'] . $user['nom']), 0, 6); ?>; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; color: white; margin: 0 auto;">
                                            <?= strtoupper($user['prenom'][0]) . strtoupper($user['nom'][0]) ?>
                                        </div>
                                    <?php endif; ?>

                                    <h5 class="card-title mt-3"><?= $user['prenom'] . ' ' . $user['nom'] ?></h5>
                                    <hr>
                                    <p><strong>Rôle:</strong> <?= ($user['role'] == 1 ? 'Admine' : 'Utilisateur') ?></p>
                                    <p>
                                        <strong>Date de création:</strong> 
                                        <?php
                                            $dateTime = new DateTime($user['creation_date']);
                                            $formattedDate = $dateTime->format('Y-m-d');
                                            echo $formattedDate;
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>


    
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        <?php else: ?>
            <h5 class="text-secondary m-5 p-5 text-center bg-light">Aucun utilisateur encore</h5>
            <div style="min-height: 200px;"></div>
        <?php endif; ?>


        <?php include('../../assets/footer.php'); ?>
    </div>

    <script src="../../public/js/sidebar.js"></script>
    <script src="../../public/js/bootstrap.js"></script>
    <script src="../../public/js/jquery.min.js"></script>
    <script src="../../public/js/main.js"></script>

    </body>
</html>
<?php endif; ?>
