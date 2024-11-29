<?php

    include '../../model/loginModel.php';
    accessPermission();

    if (isset($_GET['paymentHistoryId'])) {
        $paymentHistoryId = $_GET['paymentHistoryId'];
        
        // Fetch the payment history data from the database
        $historyQuery = "SELECT * FROM payments_trace WHERE id = :id";
        $request = $cnx->prepare($historyQuery);
        $request->bindParam(":id", $paymentHistoryId, PDO::PARAM_INT);
        $request->execute();
        
        // Fetch data as associative array
        $historyData = $request->fetch(PDO::FETCH_ASSOC);

        echo json_encode($historyData);
    }

?>
