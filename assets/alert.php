<style>
    .alert {
    opacity: 0;
    transition: opacity 1s ease-in-out;
    }

    .alert.fade.show {
        opacity: 1;
    }

</style>

<?php if (isset($_SESSION['success'])) { ?>
<div class="alert alert-success border-left-success col-md-12 alert-dismissible fade mt-2" role="alert" id="success-alert">
    <?= $_SESSION['success'] ?>
    <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php unset($_SESSION['success']); }  ?>

<?php if (isset($_SESSION['error'])) { ?>
<div class="alert alert-danger border-left-danger col-md-12 alert-dismissible fade mt-2" role="alert" id="error-alert">
    <?= $_SESSION['error'] ?>
    <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php unset($_SESSION['error']); }  ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var successAlert = document.getElementById('success-alert');
        var errorAlert = document.getElementById('error-alert');
        
        if (successAlert) {
            setTimeout(function() {
                successAlert.classList.add('show');
            }, 100);
        }

        if (errorAlert) {
            setTimeout(function() {
                errorAlert.classList.add('show');
            }, 100);
        }
    });
</script>
