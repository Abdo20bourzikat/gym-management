<?php

    // Get all members
    $getMembersQuery = "
        SELECT members.*, payments_trace.payment_date_trace, payments_trace.trace_amount, payments_trace.trace_remainder 
        FROM members
        LEFT JOIN payments_trace ON members.id = payments_trace.member_id
        GROUP BY members.id
        ORDER BY members.id DESC LIMIT :limit OFFSET :offset";

    $limit = 30;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $request = $cnx->prepare($getMembersQuery);
    $request->bindParam(':limit', $limit, PDO::PARAM_INT);
    $request->bindParam(':offset', $offset, PDO::PARAM_INT);
    $request->execute();
    $allMembers = $request->fetchAll();


    // Add new member
    if (isset($_POST['saveMember'])) {
        $filtredData = filterData($_POST);

       // Handle file upload
        $photoPath = null;
        if (!empty($_FILES['photo']['name'])) {
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/members-photos/";

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Create the target file path
            $photoName = basename($_FILES['photo']['name']);
            $targetFilePath = $targetDir . $photoName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
                $photoPath = "/uploads/members-photos/" . $photoName;
            } else {
                $_SESSION['error'] =  "Échec du déplacement du fichier téléchargé !";
            }
        }

    
        $checkQuery = "SELECT COUNT(*) FROM members 
                    WHERE firstname = :firstname AND lastname = :lastname";
        
        $stmt = $cnx->prepare($checkQuery);
        $stmt->bindParam(':firstname', $filtredData['firstname']);
        $stmt->bindParam(':lastname', $filtredData['lastname']);
        $stmt->execute();
    
        $count = $stmt->fetchColumn();
    
        if ($count > 0) {
            $_SESSION['error'] = "Ce membre existe déjà !";
        } else {
            $insertQuery = "INSERT INTO members(`firstname`, `lastname`, `email`, `phone`, `address`, `status`, `amount`, `remainder`, `payment_date`, `photo`)
                VALUES(
                    :firstname, :lastname, :email, :phone, :address, 'active',
                    :amount, :remainder, :paymentDate, :photo
                )";

            $stmt = $cnx->prepare($insertQuery);
            $stmt->bindParam(':firstname', $filtredData['firstname']);
            $stmt->bindParam(':lastname', $filtredData['lastname']);
            $stmt->bindParam(':email', $filtredData['email']);
            $stmt->bindParam(':phone', $filtredData['phone']);
            $stmt->bindParam(':address', $filtredData['address']);
            $stmt->bindParam(':amount', $filtredData['amount']);
            $stmt->bindParam(':remainder', $filtredData['remainder']);
            $stmt->bindParam(':paymentDate', $filtredData['paymentDate']);
            $stmt->bindParam(':photo', $photoPath, PDO::PARAM_STR);

            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                $lastMember = getData('members', 'active', ' LIMIT 1 ');
    
                $traceQuery = "INSERT INTO `payments_trace`(`member_id`, `trace_amount`, `trace_remainder`) 
                        VALUES (:memberId, :traceAmount, :traceRemainder)";
                $traceReq = $cnx->prepare($traceQuery);
                $traceReq->bindParam(':memberId', $lastMember[0]['id'], PDO::PARAM_INT);
                $traceReq->bindParam(':traceAmount', $filtredData['amount'], PDO::PARAM_STR);
                $traceReq->bindParam(':traceRemainder', $filtredData['remainder'], PDO::PARAM_STR);
                $traceReq->execute();
    
                $_SESSION['success'] = "Le membre a été ajouté avec succès !";
            }
        }
    }

    
    // Upload member photo
    if (isset($_POST['uploadMemberPhoto'])) {
        $uploadedData = filterData($_POST);
        $memberId = $uploadedData['memberId'];

        $photoPath = null;
        if (!empty($_FILES['photo']['name'])) {
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/members-photos/";

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Create the target file path
            $photoName = basename($_FILES['photo']['name']);
            $targetFilePath = $targetDir . $photoName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
                $photoPath = "/uploads/members-photos/" . $photoName;
            } else {
                $_SESSION['error'] =  "Échec du déplacement du fichier téléchargé !";
            }
        }

        $uploadQuery = "UPDATE `members` SET photo = :photo WHERE id = :id ";
        $stmt = $cnx->prepare($uploadQuery);
        $stmt->bindParam(':photo', $photoPath, PDO::PARAM_STR);
        $stmt->bindParam(':id', $memberId, PDO::PARAM_INT);
        $stmt->execute();
    
        $_SESSION['success'] = "La photo du membre a été téléchargé avec succès !";

    }

    // Update member data
    if (isset($_POST['updateMember'])) {
        $memberId = $_POST['memberId'];
        $request = filterData($_POST);

        $data = [
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'amount' => $request['amount'],
            'remainder' => $request['remainder'],
            'payment_date' => $request['paymentDate'],
            'creation_date' => $request['creationDate']
        ];

        $condition = [
            'column' => 'id',
            'value' => $memberId
        ];

        editData('members', $data, $condition, 
            "Le membre a été Modifié avec succès !", 
            "Une erreur s'est produite lors de la modification du membre"
        );
    }

    // Update history record
    if (isset($_POST['updateHistories'])) {
        $historyRequest = filterData($_POST);

        // Format the date properly
        $rawPaymentDate = $historyRequest['historyPaymentDate'];
        $formattedPaymentDate = str_replace('T', ' ', $rawPaymentDate) . ':00';

        // Data to update
        $data = [
            'trace_amount' => $historyRequest['historyAmount'],
            'trace_remainder' => $historyRequest['historyRemainder'],
            'payment_date_trace' => $formattedPaymentDate
        ];

        $condition = [
            'column' => 'id',
            'value' => $historyRequest['historyIdUpdated']
        ];

        // Call your function to update the data
        editData('payments_trace', $data, $condition, "L'historie a été modifiée avec succès !", "Une erreur s'est produite lors de la modification d'historie.");
    }



    // Delete member
    if (isset($_POST['deleteMember'])) {
        $memberId = intval($_POST['memberId']);
        deleteData(
            'members',
            $memberId, 
            "Le member a été supprimé avec succès!", 
            "Aucun member trouvé avec l'ID donné!"
        );
        header('location: membersList.php');
    }    

    // Delete some history
    if (isset($_POST['deleteTrace'])) {
        $historyId = intval($_POST['historyId']);
        deleteData(
            'payments_trace',
            $historyId, 
            "L'historie a été supprimé avec succès!",
            "Aucun historie trouvé avec l'ID donné!"
        );
    }


    // Search members
    function searchMembers($condition = null) {
        if (isset($_POST['searchMember'])) {
            global $cnx;
            $filteredData = filterData($_POST);

            if (!isset($filteredData['searchMemberValue']) || empty($filteredData['searchMemberValue'])) {
                return [];
            }

            $inputValueLike = '%' . $filteredData['searchMemberValue'] . '%';

            $query = "SELECT members.*, payments_trace.payment_date_trace, payments_trace.trace_amount, payments_trace.trace_remainder 
                    FROM members
                    LEFT JOIN payments_trace ON members.id = payments_trace.member_id
                    WHERE (firstname LIKE :inputValueLike OR 
                            lastname LIKE :inputValueLike OR 
                            CONCAT(firstname, ' ', lastname) LIKE :inputValueLike OR
                            phone LIKE :inputValueLike)";
            if ($condition) {
                $query .= " " . $condition;
            }

            $query .= " GROUP BY members.id ORDER BY members.id DESC";

            $request = $cnx->prepare($query);
            $request->bindParam(':inputValueLike', $inputValueLike, PDO::PARAM_STR);

            $request->execute();

            $records = $request->fetchAll(PDO::FETCH_ASSOC);
            return $records;
        }
        return [];
    }


    function membersHaveToPay($condition = null) {
        global $cnx;
        $query = "SELECT *
                FROM `members`
                WHERE `payment_date` <= CURDATE() AND status = 'active' ";
        if ($condition) {
            $query .= " " . $condition;
        }
        $stmt = $cnx->prepare($query);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $records;
        
    }

    // fast payment
    if (isset($_POST['memberPayment'])) {
        $filtredData = filterData($_POST);

        $memberId = $filtredData['memberId'];

        $req = "SELECT payment_date FROM members WHERE id = :id";
        $request = $cnx->prepare($req);
        $request->bindParam(':id', $memberId, PDO::PARAM_INT);
        $request->execute();

        $data = $request->fetch(PDO::FETCH_NUM);
        $currentPaymentDate = $data[0];

        $newPaymentDate = date('Y-m-d', strtotime($currentPaymentDate . ' +1 month'));

        $updateQuery = "UPDATE members SET payment_date = :paymentDate WHERE id = :idMember ";
        $stmt = $cnx->prepare($updateQuery);
        $stmt->bindParam(":paymentDate", $newPaymentDate, PDO::PARAM_STR);
        $stmt->bindParam(":idMember", $memberId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $traceQuery = "INSERT INTO `payments_trace`(`member_id`, `trace_amount`, `trace_remainder`) 
                        VALUES (:memberId, :traceAmount, :traceRemainder)";
            $traceReq = $cnx->prepare($traceQuery);
            $traceReq->bindParam(':memberId', $memberId, PDO::PARAM_INT);
            $traceReq->bindParam(':traceAmount', $filtredData['memberAmount'], PDO::PARAM_STR);
            $traceReq->bindParam(':traceRemainder', $filtredData['memberRemainder'], PDO::PARAM_STR);
            $traceReq->execute();

            $_SESSION['success'] = "Le paiement du membre a été enregistré avec succès !";
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de l'enregistrement du paiement. Veuillez réessayer.";
        }

    }


    // Payment with config
    if (isset($_POST['memberPaymentConfig'])) {

        $paymentData = filterData($_POST);

        $updateQuery = "UPDATE members SET amount = :amount, remainder = :remainder,
                    payment_date = :paymentDate WHERE id = :idMember ";
        $stmt = $cnx->prepare($updateQuery);
        $stmt->bindParam(":amount", $paymentData['amount'], PDO::PARAM_STR);
        $stmt->bindParam(":remainder", $paymentData['remainder'], PDO::PARAM_STR);
        $stmt->bindParam(":paymentDate", $paymentData['paymentDate'], PDO::PARAM_STR);
        $stmt->bindParam(":idMember", $paymentData['memberIdModal'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $traceQuery = "INSERT INTO `payments_trace`(`member_id`, `trace_amount`, `trace_remainder`) 
                        VALUES (:memberId, :traceAmount, :traceRemainder)";
            $traceReq = $cnx->prepare($traceQuery);
            $traceReq->bindParam(':memberId', $paymentData['memberIdModal'], PDO::PARAM_INT);
            $traceReq->bindParam(':traceAmount', $paymentData['amount'], PDO::PARAM_STR);
            $traceReq->bindParam(':traceRemainder', $paymentData['remainder'], PDO::PARAM_STR);
            $traceReq->execute();

            $_SESSION['success'] = "Le paiement du membre a été enregistré avec succès !";
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de l'enregistrement du paiement. Veuillez réessayer.";
        }

    }


    function countMembers($status=null, $condition=null) {
        global $cnx;
        $query = "SELECT COUNT(*) FROM members ";
        if ($status != null) {
            $query .= " WHERE status='$status'";
        }
        if ($condition != null) {
            $query .= " AND `payment_date` <= CURDATE()";
        }
        $request = $cnx->prepare($query);
        $request->execute();
        $data = $request->fetch(PDO::FETCH_NUM);
        return $data[0];
    }

    // Count disabled members
    $countDisabledMembers = countMembers('inactive');


?>