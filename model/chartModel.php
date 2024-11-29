<?php
    $data = [
        'daily' => [], 
        'weekly' => [], 
        'monthly' => []
    ];

    // Fetch daily data
    $dailyQuery = "SELECT DATE(payment_date_trace) as payment_date, SUM(trace_amount) as total_amount 
                FROM payments_trace 
                GROUP BY DATE(payment_date_trace)";
    $dailyResult = $cnx->prepare($dailyQuery);
    $dailyResult->execute();
    $data['daily'] = $dailyResult->fetchAll(PDO::FETCH_ASSOC);

    // Fetch weekly data for all weeks with at least one payment
    $weeklyQuery = "SELECT WEEK(payment_date_trace) as payment_week, SUM(trace_amount) as total_amount 
                    FROM payments_trace 
                    GROUP BY WEEK(payment_date_trace)";
    $weeklyResult = $cnx->prepare($weeklyQuery);
    $weeklyResult->execute();
    $data['weekly'] = $weeklyResult->fetchAll(PDO::FETCH_ASSOC);

    // Fetch monthly data for all months with at least one payment
    $monthlyQuery = "SELECT MONTH(payment_date_trace) as payment_month, SUM(trace_amount) as total_amount 
                    FROM payments_trace 
                    GROUP BY MONTH(payment_date_trace)";
    $monthlyResult = $cnx->prepare($monthlyQuery);
    $monthlyResult->execute();
    $data['monthly'] = $monthlyResult->fetchAll(PDO::FETCH_ASSOC);


?>