<?php
    include '../../model/loginModel.php';

    // Check if a column is set, otherwise set a default sorting order
    $column = isset($_POST['column']) ? $_POST['column'] : 'id';
    $validColumns = ['firstname', 'phone', 'amount', 'remainder', 'payment_date_trace', 'payment_date', 'inactivated_date'];

    if (in_array($column, $validColumns)) {
        $orderBy = $column;
    } else {
        $orderBy = 'id';  // Default sorting column
    }

    // Query to get all members sorted by the selected column
    $getMembersQuery = "
        SELECT members.*, payments_trace.payment_date_trace, payments_trace.trace_amount, 
        payments_trace.trace_remainder 
        FROM members
        LEFT JOIN payments_trace ON members.id = payments_trace.member_id
        GROUP BY members.id
        ORDER BY $orderBy DESC LIMIT :limit OFFSET :offset";

    $limit = 30;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $request = $cnx->prepare($getMembersQuery);
    $request->bindParam(':limit', $limit, PDO::PARAM_INT);
    $request->bindParam(':offset', $offset, PDO::PARAM_INT);

    $request->execute();
    $allMembers = $request->fetchAll();

    // Return only the rows (not the headers)
    foreach ($allMembers as $member) {
        echo "<tr>";
        echo "<td>{$member['firstname']} {$member['lastname']}</td>";

        if ($settingsMap['photo'] == 1):
            echo "<td>";
            if ($member['photo']) {
                echo "<img src='{$member['photo']}' alt='Photo of {$member['firstname']}' class='user-photo'>";
            } else {
                $initials = strtoupper($member['firstname'][0]) . strtoupper($member['lastname'][0]);
                echo "<div class='initials-circle-user' style='background-color: #" . substr(md5($member['firstname'] . $member['lastname']), 0, 6) . "'>{$initials}</div>";
            }
            echo "</td>";
        endif;

        if ($settingsMap['phone'] == 1):
            echo "<td>{$member['phone']}</td>";
        endif;
        if ($settingsMap['address'] == 1):
            echo "<td>{$member['address']}</td>";
        endif;
        if ($settingsMap['status'] == 1):
            echo "<td>{$member['status']}</td>";
        endif;

        if ($settingsMap['amount'] == 1):
            echo "<td>{$member['amount']}</td>";
        endif;
        if ($settingsMap['remainder'] == 1):
            echo "<td>{$member['remainder']}</td>";
        endif;
        echo "<td>{$member['payment_date_trace']}</td>";
        echo "<td>{$member['payment_date']}</td>";
        if ($settingsMap['inactivated_date'] == 1):
            echo "<td>{$member['inactivated_date']}</td>";
        endif;
        echo "<td>";
        echo "<div class='form-check form-switch mx-5'>";
        echo "<input class='form-check-input' type='checkbox' id='memberStatus{$member['id']}' " . ($member['status'] === 'active' ? 'checked' : '') . ">";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
    }
?>
