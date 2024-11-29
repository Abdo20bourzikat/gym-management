<?php


    include '../../model/loginModel.php';

    $userId = $_SESSION['id'];
    // Prepare the query to fetch events from the database
    $query = "SELECT id, event_name AS title, 
            event_description AS description,
            DATE_FORMAT(start_date, '%Y-%m-%dT%H:%i:%s') AS start, 
            DATE_FORMAT(end_date, '%Y-%m-%dT%H:%i:%s') AS end 
            FROM _events_ WHERE user_id = :userId ";

    $stmt = $cnx->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch events as an associative array
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the events in JSON format for FullCalendar
    header('Content-Type: application/json');
    echo json_encode($events);


?>



