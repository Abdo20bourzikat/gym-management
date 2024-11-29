<?php

    // Get user events
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
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count events for the logged user
    $countQuery = "SELECT COUNT(*) AS event_count FROM _events_ WHERE user_id = :userId";
    $countStmt = $cnx->prepare($countQuery);
    $countStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $countStmt->execute();
    $countResult = $countStmt->fetch(PDO::FETCH_ASSOC);

    // Get the count of events
    $eventCount = $countResult['event_count'];


    // Save or update events 
    if (isset($_POST['saveNewEvent'])) {
        // Check if updating an existing event
        if (isset($_POST['eventId'])) {
            // Prepare the SQL statement for updating an existing event
            $stmt = $cnx->prepare("UPDATE _events_ SET event_name = :event_name, event_description = :event_description, 
            start_date = :start_date, end_date = :end_date WHERE id = :id");
            $stmt->bindParam(':id', $_POST['eventId']);
        } else {
            // Prepare the SQL statement for inserting a new event
            $stmt = $cnx->prepare("INSERT INTO _events_ (event_name, user_id, event_description, start_date, end_date) 
                VALUES (:event_name, :user_id, :event_description, :start_date, :end_date)");
            $userid = $_SESSION['id'];
            $stmt->bindParam(':user_id', $userid);
        }

        // Bind the parameters
        $stmt->bindParam(':event_name', $_POST['eventName']);
        $stmt->bindParam(':event_description', $_POST['eventDescription']);
        $stmt->bindParam(':start_date', $_POST['startDate']);
        $stmt->bindParam(':end_date', $_POST['endDate']);

        // Execute the statement
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $_SESSION['success'] = isset($_POST['eventId']) ? "L'événement a été modifié avec succès !" : "L'événement a été ajouté avec succès !";
            } else {
                $_SESSION['error'] = "Une erreur est survenue lors de l'ajout/modification de l'événement.";
            }
        } else {
            $_SESSION['error'] = "Erreur lors de l'exécution de la requête SQL.";
        }
    }

    // Delete event
    if (isset($_POST['deleteEvent'])) {
        $data = filterData($_POST);
        $eventId = $data['eventId'];
        $deleteQuery = "DELETE FROM _events_ WHERE id = :id";
        $stmt = $cnx->prepare($deleteQuery);
        $stmt->bindParam(':id', $eventId,  PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = "L'événement a été supprimé avec succès !";
        }
    }


?>

