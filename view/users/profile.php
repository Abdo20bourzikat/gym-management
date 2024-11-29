<?php 
    $tabTitle = "Mon Profil";
    $pageTitle = "Mon Profil";
    include '../../model/loginModel.php';
    include '../../model/memberModel.php';
    include '../../model/userModel.php';
    include '../../model/calendarModel.php';
    accessPermission();
?>

<?php include '../../assets/sidebar.php'; ?>

<div class="container mt-3">
    <div class="col-md-4">
        <?php include '../../assets/alert.php'; ?>
    </div>


    <!-- Update data modal -->
    <div class="modal fade" id="updateProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-pencil-square mx-1"></i> Modifier les informations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="mt-3 mx-5" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname" class="form-label">Nom</label>
                                    <input type="text" name="lastname" class="form-control shadow-none" value="<?= $_SESSION['lastname'] ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Prénom</label>
                                    <input type="text" name="name" class="form-control shadow-none" value="<?= $_SESSION['name'] ?>" required>
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
                                    <input type="text" name="login" class="form-control shadow-none" value="<?= $_SESSION['log'] ?>" required>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="currentPassword" class="form-label">Mot de passe actuel</label>
                                <input type="password" name="currentPassword" class="form-control shadow-none" placeholder="Mot de passe actuel..." required>
                            </div>
                            <div class="col-md-4">
                                <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                                <input type="password" name="newPassword" class="form-control shadow-none" placeholder="Nouveau mot de passe..." required>
                            </div>
                            <div class="col-md-4">
                                <label for="passwordConfirmation" class="form-label col-md-12">Confirmer le</label>
                                <input type="password" name="passwordConfirmation" class="form-control shadow-none" placeholder="Confirmation..." required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="changePassword" class="btn btn-primary btn-sm shadow-none">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <!-- Modal for adding a new event -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addEventModalLabel">
                        <i class="bi bi-calendar-plus fs-5"></i> Nouvel Événement
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="eventForm" action="" method="post">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-md-6 shadow-none">
                                <label for="eventName" class="col-form-label text-secondary">Nom de l'événement</label>
                                <input type="text" id="eventName" name="eventName" class="form-control shadow-none" placeholder="Nom de l'événement..." required>
                            </div>
                            <div class="col-md-6 shadow-none">
                                <label for="eventDescription" class="col-form-label text-secondary">Description de l'événement</label>
                                <textarea id="eventDescription" name="eventDescription" class="form-control shadow-none" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6 shadow-none">
                                <label for="startDate" class="col-form-label text-secondary">Date de début</label>
                                <input type="datetime-local" id="startDate" name="startDate" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 shadow-none">
                                <label for="endDate" class="col-form-label text-secondary">Date de fin</label>
                                <input type="datetime-local" id="endDate" name="endDate" class="form-control shadow-none" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="saveNewEvent" class="btn btn-primary btn-sm">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- Profile Card -->
    <div class="card shadow mb-4">
        <div class="card-body px-5 py-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <!-- Profile Photo or Initials -->
                    <?php if ($_SESSION['photo']): ?>
                        <img src="<?= $_SESSION['photo'] ?>" alt="Photo de <?= $_SESSION['name'] ?>" class="user-photo" data-bs-toggle="modal" data-bs-target="#photoModal<?= $_SESSION['id'] ?>">
                    <?php else: ?>
                        <div class="initials-circle-user" style="background-color: #<?php echo substr(md5($_SESSION['name'] . $_SESSION['lastname']), 0, 6); ?>" data-bs-toggle="modal" data-bs-target="#photoModal<?= $_SESSION['id'] ?>">
                            <?= strtoupper($_SESSION['name'][0]) . strtoupper($_SESSION['lastname'][0]) ?>
                        </div>
                    <?php endif; ?>
                    <!-- User Name -->
                    <h5 class="mt-2 mx-3"><?= $_SESSION['name'] . ' ' . $_SESSION['lastname'] ?></h5>
                </div>
                <!-- Edit Profile Button -->
                <button type="button" class="btn btn-primary btn-sm shadow-none" data-bs-toggle="modal" data-bs-target="#updateProfile">
                    <i class="bi bi-pencil-square"></i> Modifier
                </button>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="card shadow mb-4">
        <div class="card-body d-flex justify-content-between py-3 px-5">
            <div>
                <p>Utilisateur</p>
                <strong><?= $_SESSION['name'] . ' ' . $_SESSION['lastname'] ?></strong>
            </div>
            <div>
                <p>Rôle</p>
                <strong><?= $_SESSION['role'] == 1 ? 'Admin' : 'Utilisateur' ?></strong>
            </div>
            <div>
                <p>Login</p>
                <strong><?= $_SESSION['log'] ?></strong>
            </div>
        </div>
    </div>


    <div class="card shadow">
        <div class="card-header">
            <h5>
                <i class="bi bi-calendar4-week mx-1 fs-4"></i> Calendrier
            </h5>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <?php include('../../assets/footer.php'); ?>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            // Fetch events dynamically from fetch_events.php
            events: '../calendar/fetch_events.php',

            editable: true,

            // Handle event click for modifying existing events
            eventClick: function(info) {
                // Populate the modal with event data for editing
                document.getElementById('eventName').value = info.event.title;
                document.getElementById('eventDescription').value = info.event.extendedProps.description;
                document.getElementById('startDate').value = info.event.start.toISOString().slice(0, 16);
                document.getElementById('endDate').value = info.event.end ? info.event.end.toISOString().slice(0, 16) : '';

                // Change modal title to indicate editing
                document.getElementById('addEventModalLabel').innerHTML = '<i class="bi bi-pencil-square fs-5"></i> Modifier Événement';

                // Show the modal
                $('#addEventModal').modal('show');

                // Add a hidden input to identify if it is an edit
                const eventIdInput = document.createElement('input');
                eventIdInput.type = 'hidden';
                eventIdInput.name = 'eventId';
                eventIdInput.value = info.event.id;
                document.getElementById('eventForm').appendChild(eventIdInput);
            },

            // Handle day click for creating new events
            dateClick: function(info) {
                // Clear the modal fields for new event
                document.getElementById('eventName').value = '';
                document.getElementById('eventDescription').value = '';
                document.getElementById('startDate').value = info.dateStr;
                document.getElementById('endDate').value = new Date(info.dateStr);
                
                // Set end date to the next day
                const nextDay = new Date(info.dateStr);
                const currentDay = new Date(info.dateStr);
                nextDay.setDate(nextDay.getDate() + 1);
                document.getElementById('startDate').value = currentDay.toISOString().slice(0, 16); 
                document.getElementById('endDate').value = nextDay.toISOString().slice(0, 16); // Format to YYYY-MM-DDTHH:MM

                // Change modal title to indicate adding a new event
                document.getElementById('addEventModalLabel').innerHTML = '<i class="bi bi-calendar-plus fs-5"></i> Nouvel Événement';

                // Show the modal
                $('#addEventModal').modal('show');

                // Remove any existing eventId input if present
                const existingEventIdInput = document.querySelector('input[name="eventId"]');
                if (existingEventIdInput) {
                    existingEventIdInput.remove();
                }
            }
        });

        calendar.render();
    });
</script>
