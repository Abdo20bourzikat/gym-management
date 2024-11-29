<?php 
    include '../../model/loginModel.php';
    include '../../model/memberModel.php';
    include '../../model/calendarModel.php';
    accessPermission();
    $tabTitle = "Calendrier";
    $pageTitle = "Calendrier";

?>


<?php include '../../assets/sidebar.php'; ?>

<div class="container mt-2">

    <div class="row mb-2">
        <div class="col-md-5">
            <?php include '../../assets/alert.php'; ?>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-3" id="chartTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="calendar-tab" data-bs-toggle="tab" href="#calendar" role="tab" aria-controls="calendar" aria-selected="true">Calendrier</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="eventsList-tab" data-bs-toggle="tab" href="#eventsList" role="tab" aria-controls="eventsList" aria-selected="false">Liste des événement (<?= $eventCount ?>)</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-4">
        <div class="tab-pane fade show active" id="calendar" role="tabpanel" aria-labelledby="calendar-tab">
            <div class="col-md-12">
                <div id="calendar"></div>
            </div>
        </div>
        <div class="tab-pane fade" id="eventsList" role="tabpanel" aria-labelledby="eventsList-tab">

            <?php if (count($events) > 0): ?>

                <div style="max-height: 500px; overflow-y: auto; overflow-x: hidden; padding: 10px;">
                    <div class="row mb-4">
                        
                        <?php foreach ($events as $event): ?>
                            <div class="col-md-4 mb-2">
                                <div class="card shadow-sm p-3">
                                    <div class="card-header bg-white">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title"><?= htmlspecialchars($event['title']) ?></h5>
                                            <form action="" method="post">
                                                <input type="hidden" name="eventId" value="<?= $event['id'] ?>">
                                                <button type="submit" name="deleteEvent" class="float-end pb-2" style="background: none; border-style: none;" 
                                                    onClick="return confirm('Voulez-vous vraiment supprimer cet événement ?');">
                                                    <i class="bi bi-x-circle text-danger fs-4"></i>
                                                </button>
                                            </form>
                                        </div>

                                        </div>
                                    <div class="card-body">
                                        <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
                                        <p><strong>Date de début :</strong> <?= (new DateTime($event['start']))->format('d F Y') ?></p>
                                        <p><strong>Date de fin :</strong> <?= (new DateTime($event['end']))->format('d F Y') ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php else: ?>
                <h5 class="text-secondary m-5 p-5 text-center bg-light">Aucun événement encore</h5>
                <div style="min-height: 200px;"></div>

            <?php endif; ?>

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


</div>

<?php include('../../assets/footer.php'); ?>

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
            events: 'fetch_events.php',

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
