<?php 
    include '../../model/loginModel.php';
    include '../../model/memberModel.php';
    include '../../model/userModel.php';
    accessPermission();
    
    $tabTitle = 'Paramètres';
    $pageTitle = 'Paramètres';

    if ($_SESSION['role'] == 0):
?>
                
        <div class="col-md-12 mt-5 card shadow">
            <h5 class="text-danger my-5 mx-auto">Vous n'avez pas l'autorisation pour ce processus !</h5>
        </div>
        
    <?php else: ?>

    <?php include '../../assets/sidebar.php'; ?>

    <div class="container">

        <!-- Edit settings modal -->
        <div class="modal fade" id="editSettigns" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-gear-wide-connected mx-1"></i> Modifier les paramètres</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post" class="mt-3 mx-5" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="gymname" class="form-label">Nom de GYM</label>
                                        <input type="text" name="gymname" class="form-control shadow-none" value="<?= $getGymData['gymname'] ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="gymlogo" class="form-label">Logo</label>
                                        <input type="file" name="gymlogo" class="form-control shadow-none">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" name="updateSettings" class="btn btn-primary btn-sm shadow-none">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-5">
            <?php include '../../assets/alert.php'; ?>
        </div>


        <div class="card shadow mt-3 cardHover">
            <?php if ($getGymData > 0): ?>
                <div class="card-header">
                    <h5>
                        <strong>
                            <i class="bi bi-gear-fill mx-1"></i>Paramètre général
                        </strong>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p>GYM:</p>
                            <p>
                                <strong>
                                    <?= $getGymData['gymname'] ?>
                                </strong>
                            </p>
                            <p>LOGO:</p>
                            <p>
                               <img src="<?= $getGymData['logo'] ?>" style="with: 70px; height: 70px;" class="rounded">
                            </p>
                        </div>
                        <div class="float-end">
                            <button type="button" class="btn btn-primary btn-sm shadow-none float-end" data-bs-toggle="modal" data-bs-target="#editSettigns">
                                <i class="bi bi-pencil-square"></i> Modifier
                            </button>
                        </div>
    
                    </div>
                </div>
            <?php else: ?>
                <h5 class="text-secondary m-5 p-5 text-center bg-light">Aucun paramètre encore</h5>
            <?php endif; ?>
        </div>

        <div class="col-md-12">
            
            <div class="card shadow mt-3 cardHover">
                <div class="card-header">
                    <h5>
                        <strong>
                            <i class="bi bi-layout-text-window-reverse"></i> Visibilité des colonnes pour la liste des membres
                        </strong>
                    </h5>
                </div>
                <div class="card-body">
                    <div style="max-height: 400px; overflow-y: auto; overflow-x: hidden; padding: 0 5px 0 5px;">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Column</th>
                                    <th>Visible</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr>
                                    <td>Nom</td>
                                    <td>
                                        <div class="form-check form-switch float-end">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                <?php echo isset($settingsMap['firstname']) && $settingsMap['firstname'] ? 'checked' : ''; ?>
                                                data-column="firstname">
                                        </div>
                                    </td>
                                </tr> -->
                                <!-- <tr>
                                    <td>Prénom</td>
                                    <td>
                                        <div class="form-check form-switch float-end">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                <?php echo isset($settingsMap['lastname']) && $settingsMap['lastname'] ? 'checked' : ''; ?>
                                                data-column="lastname">
                                        </div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>Email</td>
                                    <td>
                                        <div class="form-check form-switch float-end">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                <?php echo isset($settingsMap['email']) && $settingsMap['email'] ? 'checked' : ''; ?>
                                                data-column="email">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Téléphone</td>
                                    <td>
                                        <div class="form-check form-switch float-end">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                <?php echo isset($settingsMap['phone']) && $settingsMap['phone'] ? 'checked' : ''; ?>
                                                data-column="phone">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Adresse</td>
                                    <td>
                                        <div class="form-check form-switch float-end">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                <?php echo isset($settingsMap['address']) && $settingsMap['address'] ? 'checked' : ''; ?>
                                                data-column="address">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        <div class="form-check form-switch float-end">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                <?php echo isset($settingsMap['status']) && $settingsMap['status'] ? 'checked' : ''; ?>
                                                data-column="status">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Montant payé</td>
                                    <td>
                                        <div class="form-check form-switch float-end">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                <?php echo isset($settingsMap['amount']) && $settingsMap['amount'] ? 'checked' : ''; ?>
                                                data-column="amount">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Reste</td>
                                    <td>
                                        <div class="form-check form-switch float-end">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                <?php echo isset($settingsMap['remainder']) && $settingsMap['remainder'] ? 'checked' : ''; ?>
                                                data-column="remainder">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Photo</td>
                                    <td>
                                        <div class="form-check form-switch float-end">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                <?php echo isset($settingsMap['photo']) && $settingsMap['photo'] ? 'checked' : ''; ?>
                                                data-column="photo">
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Date de paiement</td>
                                    <td>
                                        <div class="form-check form-switch float-end">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                <?php echo isset($settingsMap['payment_date']) && $settingsMap['payment_date'] ? 'checked' : ''; ?>
                                                data-column="payment_date">
                                        </div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>Date de création</td>
                                    <td>
                                        <div class="form-check form-switch float-end">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                <?php echo isset($settingsMap['creation_date']) && $settingsMap['creation_date'] ? 'checked' : ''; ?>
                                                data-column="creation_date">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date de désactivation</td>
                                    <td>
                                        <div class="form-check form-switch float-end">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                <?php echo isset($settingsMap['inactivated_date']) && $settingsMap['inactivated_date'] ? 'checked' : ''; ?>
                                                data-column="inactivated_date">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <?php include('../../assets/footer.php'); ?>

    </div>



    <script>
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const column = this.getAttribute('data-column');
                const isVisible = this.checked ? '1' : '0';
                
                // Send AJAX request to update the display_settings table
                fetch('update_settings.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        column: column,
                        is_visible: isVisible
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Les paramètres de visibilité ont été mis à jour avec succès.');
                    } else {
                        alert('Erreur lors de la mise à jour des paramètres.');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Erreur lors de la mise à jour des paramètres.');
                });
            });
        });
    </script>


    <script src="../../public/js/sidebar.js"></script>
    <script src="../../public/js/bootstrap.js"></script>
    <script src="../../public/js/jquery.min.js"></script>
    <script src="../../public/js/main.js"></script>

    </body>
</html>
<?php endif; ?>
