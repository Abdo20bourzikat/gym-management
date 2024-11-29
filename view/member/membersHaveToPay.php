<?php 
    include '../../model/loginModel.php';
    include '../../model/memberModel.php';
    accessPermission();
    $membersHaveToPay = membersHaveToPay(' Limit 50 ');

    if (isset($_POST['getLimitedData'])) {
        $filtredData = filterData($_POST);
        $limitSelect = $filtredData['limitSelect'];
        if ($limitSelect == 0) {
            $membersHaveToPay = membersHaveToPay();
        } else {
            $membersHaveToPay = membersHaveToPay(' LIMIT ' . $limitSelect);

        }

    }

    $countMembersHaveToPay = countMembers('active', 'AND payment_date <= CURDATE()');
    $tabTitle = "Membres à Payer"; 
    $pageTitle = 'Membres à Payer <span class="badge badge-count">' . $countMembersHaveToPay . '</span>';


?>

    <?php include '../../assets/sidebar.php'; ?>

    <div class="container mt-3">

        <!-- Payment with configuration -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">

                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" id="memberIdModal" name="memberIdModal">

                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6 shadow-none">
                                    <label for="amount" class="col-md-6 col-form-label text-secondary">Montant</label>
                                    <input id="amount" name="amount" type="text" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 shadow-none">
                                    <label for="remainder" class="col-md-6 col-form-label text-secondary">Reste</label>
                                    <input type="text" id="remainder" name="remainder" class="form-control shadow-none">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 shadow-none">
                                    <label for="paymentDate" class="col-md-6 col-form-label text-secondary">Date de paiement</label>
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


        <?php
            if (count($membersHaveToPay) > 0):
        ?>


        <div class="col-md-5">
            <?php include '../../assets/alert.php'; ?>
        </div>

        <div class="row mt-3">
            <div class="col-md-2">
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
            </div>
            <div class="col-md-7"></div>
            <div class="col-md-3">
                <form action="" method="post" class="d-flex">
                    <input type="text" name="searchMemberValue" class="form-control form-control-sm me-2" placeholder="Nom, prénom ou téléphone" required>
                    <button type="submit" name="searchMember" class="btn btn-primary btn-sm shadow-none p-2"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>
        <hr class="mb-4">

        <div style="max-height: 640px; overflow-y: auto; overflow-x: hidden; padding: 0 5px 0 5px;">
            <div class="row">
                <?php 
                    if (isset($_POST['searchMember'])) {
                        $membersHaveToPay = [];
                        $membersHaveToPay = searchMembers('AND payment_date <= CURDATE()');
                    }
                    foreach ($membersHaveToPay as $member):
                ?>
                    <div class="col-md-3 mb-4">
                        <div class="card my-2 shadow cardHover">

                            <div class="card-body">
                                <a href="./memberCard.php?memberId=<?= $member['id'] ?>" class="text-decoration-none text-dark">
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

                                <div class="d-flex justify-content-between mt-3">
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

                                <p><strong>Date de Paiement:</strong> <?= $member['payment_date'] ?></p>
                                <p><strong>Montant:</strong> <?= $member['amount'] ?></p>
                                <p><strong>Reste:</strong> <?= $member['remainder'] ?></p>
                                <hr>
                                <div class="d-flex">
                                    <form action="" method="post">
                                        <input type="hidden" name="memberId" value="<?= $member['id'] ?>">
                                        <input type="hidden" name="memberAmount" value="<?= $member['amount'] ?>">
                                        <input type="hidden" name="memberRemainder" value="<?= $member['remainder'] ?>">
                                        <button type="submit" name="memberPayment" 
                                            onClick="return confirm('Veuillez vérifier les informations avant de confirmer le paiement !')" 
                                            class="btn btn-primary btn-sm shadow-none"
                                            style="white-space: nowrap; max-width: 120px; margin-right: 1px;">Payer Maintenant</button>
                                    </form>

                                    <button type="button" class="btn btn-success btn-sm shadow-none" 
                                        style="white-space: nowrap; max-width: 122px;" 
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
                <?php endforeach; ?>
            </div>
        </div>
            <?php 
                if (count($membersHaveToPay) <= 4):
            ?>
                <div style="min-height: 200px;"></div>
            <?php endif; ?>
        <?php else: ?>
            <h5 class="text-secondary m-5 p-5 text-center bg-light">Aucun membre à payer encore</h5>
            <div style="min-height: 200px;"></div>
        <?php endif; ?>

        <?php include('../../assets/footer.php'); ?>
    </div>
</div>

    <script src="../../public/js/sidebar.js"></script>
    <script src="../../public/js/bootstrap.js"></script>
    <script src="../../public/js/jquery.min.js"></script>
    <script src="../../public/js/main.js"></script>

    <script>
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

                modalTitle.innerHTML = '<i class="bi bi-person-fill"></i> ' + firstname + ' ' + lastname;
                modalAmount.value = amount;
                modalRemainder.value = remainder;
                modalPaymentDate.value = paymentDate;
                memberIdModal.value = memberId;

            });
        });
    </script>

</body>
</html>