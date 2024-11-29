<?php 
    include '../../model/loginModel.php';
    include '../../model/memberModel.php';
    include '../../model/mailModel.php';
    $countMembersHaveToPay = countMembers('active', 'AND payment_date <= CURDATE()');
    $tabTitle = "Envoyer du courrier";
    $pageTitle = "Envoyer du courrier";

    accessPermission();

    if ($_GET['memberId']) {
        $memberId = $_GET['memberId'];
        $member = getDataById('members', $memberId);
    }
?>

    <?php include '../../assets/sidebar.php'; ?>

    <div class="container">
        
        <div class="row mb-2">
            <div class="col-md-5">
                <?php include '../../assets/alert.php'; ?>
            </div>
        </div>
        
        <div class="card shadow">
            <div class="card-body">
                <form action="" method="post">
                    <div class="row mb-2">
                        <div class="form-group">
                            <label class="col-form-label text-secondary" for="objet">Objet</label>
                            <input type="text" class="form-control shadow-none" name="object" placeholder="Objet..." required>
                        </div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="form-group">
                            <label class="col-form-label text-secondary" for="email">À</label>
                            <input type="text" class="form-control shadow-none" name="email" value="<?= $member['email'] ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label class="col-form-label text-secondary" for="subject">Subject</label>
                            <textarea class="form-control shadow-none" name="subject" id="mySummernote" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="d-flex">
                        <button type="submit" name="sendMail" class="btn btn-primary mr-1 shadow-none btn-sm">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <?php include('../../assets/footer.php'); ?>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#mySummernote").summernote({
                height: 200,
            });
            $('.dropdown-toggle').dropdown();
        });
    </script>

</body>
</html>