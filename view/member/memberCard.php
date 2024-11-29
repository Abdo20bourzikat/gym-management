<?php 
    $pageTitle = "Détails de membre";
    include '../../model/loginModel.php';
    include '../../model/memberModel.php';
    accessPermission();
    $countDisabledMembers = countMembers('inactive');
    $tabTitle = "Détails de membre";

    if ($_GET['memberId']) {
        $memberId = $_GET['memberId'];
        $member = getDataById('members', $memberId);
        
        $traceQuery = "SELECT * FROM payments_trace WHERE member_id = :memberId";
        $stmt = $cnx->prepare($traceQuery);
        $stmt->bindParam(":memberId", $memberId, PDO::PARAM_INT);
        $stmt->execute();
        $paymentTrace = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

?>

    <?php include '../../assets/sidebar.php'; ?>


    <div class="container">

        <!-- Payment with configuration modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <label for="paymentDate" class="col-md-12 col-form-label text-secondary">Date de paiement prochaine</label>
                                    <input type="date" id="paymentDate" name="paymentDate" class="form-control shadow-none" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" name="memberPaymentConfig" class="btn btn-primary btn-sm">Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Payment trace modal -->
        <div class="modal fade" id="paymentTraceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <i class="bi bi-clock-history fs-5"></i> Historique des Paiements
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <form action="" method="post">
                        <div class="modal-body">
                            <div class="my-2 bg-light" id="paymentInputs" style="display: none;">
                                <div class="d-flex">
                                    <div class="form-group">
                                        <input type="hidden" id="historyIdUpdated" name="historyIdUpdated">
                                        <label for="historyAmount" class="form-label">Montant payé</label>
                                        <input type="text" id="historyAmount" name="historyAmount" class="form-control shadow-none">
                                    </div>
                                    <div class="form-group mx-2">
                                        <label for="historyRemainder" class="form-label">Reste</label>
                                        <input type="text" id="historyRemainder" name="historyRemainder" class="form-control shadow-none">
                                    </div>
                                    <div class="form-group">
                                        <label for="historyPaymentDate" class="form-label">Date Paiement</label>
                                        <input type="datetime-local" id="historyPaymentDate" name="historyPaymentDate" class="form-control shadow-none">
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <button type="button" id="closeHistoryForm" onClick="handleHistoryForm();" class="btn btn-secondary btn-sm mx-1 shadow-none">Annuler</button>
                                    <button type="submit" name="updateHistories" class="btn btn-primary btn-sm mx-1 shadow-none" >Modifier</button>
                                </div>
                                <hr>
                            </div>

                            <?php if (count($paymentTrace) > 0): ?>

                                <div style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Montant payé</th>
                                            <th>Reste</th>
                                            <th>Date-Paiement</th>
                                            <?php if ($_SESSION['role'] == 1): ?>
                                                <th>Action</th>
                                            <?php endif; ?>
                                        </tr>
                                        <?php foreach ($paymentTrace as $trace): ?>
                                            <tr>
                                                <td><?= $trace['trace_amount'] ?></td>
                                                <td><?= $trace['trace_remainder'] ?></td>
                                                <td>
                                                    <?php 
                                                        $dateTime = new DateTime($trace['payment_date_trace']);
                                                        $formattedDate = $dateTime->format('Y-m-d H:i');
                                                        echo $formattedDate;
                                                    ?>
                                                </td>
                                                <?php if ($_SESSION['role'] == 1): ?>

                                                    <td>
                                                        <form action="" method="post">
                                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm" 
                                                                onclick="openPaymentModal(<?= $trace['id'] ?>)">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>


                                                            <input type="hidden" name="historyId" value="<?= $trace['id'] ?>">
                                                            <button type="submit" class="btn btn-danger btn-sm" name="deleteTrace"
                                                                onClick="return confirm('Êtes-vous sûr de vouloir supprimer cette historie ?');"
                                                                >
                                                                <i class="bi bi-trash3-fill"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>

                                            <?php endforeach; ?>
                                        
                                    </table>
                                </div>
                            <?php else: ?>
                                <h5 class="text-secondary m-5 p-5 text-center bg-light">Aucun historie encore</h5>
                            <?php endif; ?>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Upload photo modal -->
        <div class="modal fade" id="photoModal<?= $member['id'] ?>" tabindex="-1" aria-labelledby="photoModalLabel<?= $member['id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="photoModalLabel<?= $member['id'] ?>">
                        <i class="bi bi-image fs-5 mx-1"></i>Options pour la photo
                    </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <?php if ($member['photo']): ?>
                            <li class="list-group-item">
                                <a href="<?= $member['photo'] ?>" target="_blank">Afficher la photo</a>
                            </li>
                            <?php endif; ?>
                            <li class="list-group-item mt-2">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="memberId" value="<?= $member['id'] ?>">
                                    <label for="uploadPhoto">Télécharger une photo :</label>
                                    <input type="file" name="photo" id="uploadPhoto" class="form-control" required>
                                    <button type="submit" name="uploadMemberPhoto" class="btn btn-primary btn-sm mt-3">Télécharger</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-5">
            <?php include '../../assets/alert.php'; ?>

                <?php
                    $currentDate = new DateTime();
                    $paymentDate = new DateTime($member['payment_date']);

                    if ($currentDate >= $paymentDate): 
                ?>
                <div class="card shadow mb-2 bg-light" style="border-bottom-right-radius: 1.5rem; border: 1px solid red;">
                    <?php else: ?>
                        <div class="card shadow bg-light" style="border-bottom-right-radius: 1.5rem;">
                    <?php endif; ?>

                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <?php if ($member['photo']): ?>
                                <img src="<?= $member['photo'] ?>" alt="Photo de <?= $member['firstname'] ?>" class="member-photo-card" data-bs-toggle="modal" data-bs-target="#photoModal<?= $member['id'] ?>">
                            <?php else: ?>
                                <div class="initials-circle-card" style="background-color: #<?php echo substr(md5($member['firstname'] . $member['lastname']), 0, 6); ?>" data-bs-toggle="modal" data-bs-target="#photoModal<?= $member['id'] ?>">
                                    <?= strtoupper($member['firstname'][0]) . strtoupper($member['lastname'][0]) ?>
                                </div>
                            <?php endif; ?>

                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Plus d’options
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#paymentTraceModal">
                                            Historique des Paiements
                                        </button>
                                    </li>
                                    <li>
                                    <hr>
                                    <form action="" method="post" onsubmit="return confirmDelete();">
                                        <input type="hidden" name="memberId" value="<?= $member['id'] ?>">
                                        <button type="submit" name="deleteMember" class="dropdown-item"
                                            onClick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?');">
                                            Supprimer ce membre
                                        </button>
                                    </form>
                                    </li>
                                </ul>
                            </div>

                        </div>


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
                        <hr>
                        <div class="info">
                            <div>
                                <p class="label">Status:</p>
                                <p><?= $member['status'] ?></p>
                            </div>
                            <div>
                                <p class="label">Contact:</p>
                                <p><?= $member['phone'] ?></p>
                            </div>
                        </div>
                        <div class="info">
                            <div>
                                <p class="label">Montant payé:</p>
                                <p><?= $member['amount'] ?></p>
                            </div>
                            <div>
                                <p class="label">Reste:</p>
                                <p><?= $member['remainder'] ?></p>
                            </div>
                        </div>
                        <div class="info">
                            <div>
                                <p class="label">Date de création:</p>
                                <p>
                                    <?php
                                        $dateTime = new DateTime($member['creation_date']);
                                        $formattedDate = $dateTime->format('Y-m-d');
                                        echo $formattedDate;
                                    ?>
                                </p>
                            </div>
                            <div>
                                <p class="label">Date de paiement prochaine:</p>
                                <p><?= $member['payment_date'] ?></p>
                            </div>
                        </div>
                        <hr>
                        
                        <div class="d-flex">
                            <form action="" method="post">
                                <input type="hidden" name="memberId" value="<?= $member['id'] ?>">
                                <input type="hidden" name="memberAmount" value="<?= $member['amount'] ?>">
                                <input type="hidden" name="memberRemainder" value="<?= $member['remainder'] ?>">
                                <button type="submit" name="memberPayment" 
                                    onClick="return confirm('Veuillez vérifier les informations avant de confirmer le paiement !')" 
                                    class="btn btn-primary btn-sm shadow-none w-100" 
                                    style="white-space: nowrap;">Payer Maintenant</button>
                            </form>
                            <button type="button" class="btn btn-success btn-sm mx-1 shadow-none" 
                                style="white-space: nowrap;" 
                                data-bs-toggle="modal" 
                                data-bs-target="#paymentModal"
                                data-member-id="<?= $member['id'] ?>"
                                data-firstname="<?= $member['firstname'] ?>"
                                data-lastname="<?= $member['lastname'] ?>"
                                data-amount="<?= $member['amount'] ?>"
                                data-remainder="<?= $member['remainder'] ?>"
                                data-payment-date="<?= $member['payment_date'] ?>">Modifier Paiement
                            </button>
                        </div>

                    </div>
                </div>                

            </div>


            <div class="col-md-7">

                <?php
                    $currentDate = new DateTime();
                    $paymentDate = new DateTime($member['payment_date']);

                    if ($currentDate >= $paymentDate): 
                ?>
                <div class="card shadow bg-light p-3" style="border-bottom-right-radius: 1.3rem; border: 1px solid red;">
                    <?php else: ?>
                        <div class="card shadow bg-light p-3" style="border-bottom-right-radius: 1.3rem;">
                    <?php endif; ?>

                    <form action="" method="post">
                        <div class="row ">
                            <div class="col-md-8">
                                <?php if ($member['inactivated_date'] != null): ?>
                                    <h5>
                                        <strong>
                                            Désactivé le <?= $member['inactivated_date'] ?>
                                            <hr>
                                        </strong>
                                    </h5>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6 shadow-none">
                                <input type="hidden" name="memberId" value="<?= $member['id'] ?>">
                                <label for="firstname" class="col-md-6 col-form-label text-secondary">Prénom</label>
                                <input id="firstname" name="firstname" type="text" class="form-control shadow-none" value="<?= $member['firstname'] ?>" required>
                            </div>
                            <div class="col-md-6 shadow-none">
                                <label for="lastname" class="col-md-6 col-form-label text-secondary">Nom</label>
                                <input  type="text" id="lastname" name="lastname" class="form-control shadow-none" value="<?= $member['lastname'] ?>" required>
                            </div>
                        </div>
            
                        <div class="row mb-2">
                            <div class="col-md-6 shadow-none">
                                <label for="email" class="col-md-6 col-form-label text-secondary">Email</label>
                                <input id="email" name="email" type="email" class="form-control shadow-none" value="<?= $member['email'] ?>">
                            </div>
                            <div class="col-md-6 shadow-none">
                                <label for="phone" class="col-md-6 col-form-label text-secondary">Téléphone</label>
                                <input type="text" id="phone" name="phone" class="form-control shadow-none" value="<?= $member['phone'] ?>">
                            </div>
                        </div>
        
                        <div class="row mb-2">
                            <div class="col-md-12 shadow-none">
                                <label for="address" class="col-md-6 col-form-label text-secondary">Adresse</label>
                                <textarea id="address" name="address" type="text" class="form-control shadow-none" row="3"><?= $member['address'] ?></textarea>
                            </div>
                        </div>
                    
                        <div class="row mb-2">
                            <div class="col-md-6 shadow-none">
                                <label for="amount" class="col-md-6 col-form-label text-secondary">Montant payé</label>
                                <input id="amount" name="amount" type="text" class="form-control shadow-none" value="<?= $member['amount'] ?>" required>
                            </div>
                            <div class="col-md-6 shadow-none">
                                <label for="remainder" class="col-md-6 col-form-label text-secondary">Reste</label>
                                <input  type="text" id="remainder" name="remainder" class="form-control shadow-none" value="<?= $member['remainder'] ?>">
                            </div>
                        </div>
                    
                        <div class="row mb-3">
                            <div class="col-md-6 shadow-none">
                                <label for="creationDate" class="col-md-6 col-form-label text-secondary">Date de création</label>
                                <input type="datetime-local" name="creationDate" type="text" class="form-control shadow-none" value="<?= $member['creation_date'] ?>">
                            </div>
                            <div class="col-md-6 shadow-none">
                                <label for="paymentDate" class="col-md-12 col-form-label text-secondary">Date paiement prochaine</label>
                                <input type="date" name="paymentDate" type="text" class="form-control shadow-none" value="<?= $member['payment_date'] ?>">
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex my-2">
                                <a href="./membersList.php" class="btn btn-secondary btn-sm shadow-none">Annuler</a>
                                <button type="submit" name="updateMember" class="btn btn-primary btn-sm mx-1 shadow-none">Modifier</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include('../../assets/footer.php'); ?>
    </div>

    <script>

        function openPaymentModal(paymentHistoryId) {
            // Fetch data without reloading the page
            fetch('getPaymentHistory.php?paymentHistoryId=' + paymentHistoryId)
                .then(response => response.json())
                .then(data => {
                    // Convert the fetched date to the correct format for datetime-local (YYYY-MM-DDTHH:MM)
                    let paymentDate = new Date(data.payment_date_trace);
                    let formattedDate = paymentDate.toISOString().slice(0, 16);

                    // Populate modal fields with fetched data
                    document.getElementById('historyIdUpdated').value = data.id;
                    document.getElementById('historyAmount').value = data.trace_amount;
                    document.getElementById('historyRemainder').value = data.trace_remainder;
                    document.getElementById('historyPaymentDate').value = formattedDate;

                    document.getElementById('paymentInputs').style.display = 'block';

                    // Open the modal
                    var modal = new bootstrap.Modal(document.getElementById('paymentTraceModal'));
                    modal.show();
                })
                .catch(error => console.error('Error fetching payment history:', error));
        }

        // Hide the update history form
        function handleHistoryForm() {
            document.getElementById('paymentInputs').style.display = 'none';
        }

        // JS function to show confirmation alert
        function confirmDelete() {
            return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?');
        }


        // Get payment data for config modal
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

                modalTitle.innerHTML = '<i class="bi bi-person-fill fs-5"></i> ' + firstname + ' ' + lastname;

                modalAmount.value = amount;
                modalRemainder.value = remainder;
                modalPaymentDate.value = paymentDate;
                memberIdModal.value = memberId;

            });
        });
    </script>

</body>
</html> 