<?php 
    include '../../model/loginModel.php';
    include '../../model/memberModel.php';
    $countMembersHaveToPay = countMembers('active', 'AND payment_date <= CURDATE()');
    $tabTitle = "Membres désactivés";
    $pageTitle = 'Membres désactivés <span class="badge badge-count">' . $countDisabledMembers . '</span>';

    accessPermission();

    $disabledMembers = getData('members', 'inactive', ' LIMIT 50 ');

    if (isset($_POST['getLimitedData'])) {
        $filtredData = filterData($_POST);
        $limitSelect = $filtredData['limitSelect'];
        if ($limitSelect == 0) {
            $disabledMembers = getData('members', 'inactive');
        } else {
            $disabledMembers = getData('members', 'inactive', ' LIMIT ' . $limitSelect);
        }
    }
    
?>

    <?php include '../../assets/sidebar.php'; ?>

<div class="container mt-3">
    <?php
        if (count($disabledMembers) > 0):
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

    <div style="max-height: 640px; overflow-y: auto; overflow-x: hidden; padding: 10px;">
        <div class="row">
            <?php 
                if (isset($_POST['searchMember'])) {
                    $disabledMembers = [];
                    $disabledMembers = searchMembers("AND status = 'inactive' ");
                }
                foreach ($disabledMembers as $member): 
            ?>
                <div class="col-md-3 mb-4">
                    <a href="./memberCard.php?memberId=<?= $member['id'] ?>" class="text-decoration-none text-dark">
                        <?php
                            $currentDate = new DateTime();
                            $paymentDate = new DateTime($member['payment_date']);

                            if ($currentDate >= $paymentDate): 
                        ?>
                        <div class="card shadow cardHover" style="border-bottom-right-radius: 1.3rem; border: 1px solid red;">
                            <?php else: ?>
                                <div class="card shadow cardHover" style="border-bottom-right-radius: 1.3rem;">
                            <?php endif; ?>
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
                                    <div style="width: 100%">
                                        <p class="label">Date de paiement:</p>
                                        <p><?= $member['payment_date'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
        <?php 
            if (count($disabledMembers) <= 4):
        ?>
            <div style="min-height: 200px;"></div>
        <?php endif; ?>
    <?php else: ?>
        <h5 class="text-secondary m-5 p-5 text-center bg-light">Aucun membre désactivé encore</h5>
        <div style="min-height: 200px;"></div>

    <?php endif; ?>



    <?php include('../../assets/footer.php'); ?>
</div>


</body>
</html>