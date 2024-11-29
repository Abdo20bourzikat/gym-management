<?php

    include '../../model/loginModel.php';
    accessPermission();

    // Handle members status
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $memberId = $_POST['id'];
        $status = $_POST['status'];

        if (isset($memberId) && isset($status)) {
            try {
                $currentDate = date('Y-m-d');

                if ($status == 'active') {
                    $stmt = $cnx->prepare("UPDATE members SET status = :status, inactivated_date = NULL WHERE id = :id");
                    $stmt->execute(['status' => $status, 'id' => $memberId]);
                } else {
                    $stmt = $cnx->prepare("UPDATE members SET status = :status, inactivated_date = :currentDate WHERE id = :id");
                    $stmt->execute(['status' => $status, 'currentDate' => $currentDate, 'id' => $memberId]);
                }

                $_SESSION['success'] = "Le membre a été mis à jour avec succès !";
            } catch (PDOException $e) {
                error_log("Erreur lors de la mise à jour du statut: " . $e->getMessage());
                echo "Erreur lors de la mise à jour du statut.";
            }
        } else {
            $_SESSION['error'] = "Données invalides !";
        }
    }

?>