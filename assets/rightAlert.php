<style>
    .alert {
    opacity: 0;
    transition: opacity 1s ease-in-out;
    }

    .alert.fade.show {
        opacity: 1;
    }
</style>

<?php if (isset($_SESSION['rightSuccess'])) { ?>
<div class="alert alert-success border-left-success col-md-12 alert-dismissible fade mt-2" role="alert" id="right-success-alert">
    <?= $_SESSION['rightSuccess'] ?>
    <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php unset($_SESSION['rightSuccess']); }  ?>

<?php if (isset($_SESSION['rightError'])) { ?>
<div class="alert alert-danger border-left-danger col-md-12 alert-dismissible fade mt-2" role="alert" id="right-error-alert">
    <?= $_SESSION['rightError'] ?>
    <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php unset($_SESSION['rightError']); }  ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var rightSuccessAlert = document.getElementById('right-success-alert');
        var rightErrorAlert = document.getElementById('right-error-alert');
        
        if (rightSuccessAlert) {
            setTimeout(function() {
                rightSuccessAlert.classList.add('show');
            }, 100);
        }

        if (rightErrorAlert) {
            setTimeout(function() {
                rightErrorAlert.classList.add('show');
            }, 100);
        }
    });
</script>
