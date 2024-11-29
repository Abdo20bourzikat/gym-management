<?php

require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['exportData'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Define the SQL query for the 'members' table
    $query = "SELECT * FROM members";
    if ($startDate && $endDate) {
        $query .= " WHERE payment_date BETWEEN '$startDate' AND '$endDate'";
    }

    // Fetch data from the database
    $result = $cnx->query($query);
    $membersData = $result->fetchAll(PDO::FETCH_ASSOC);

    // Create a new spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add column names
    if (!empty($membersData)) {
        $columnNames = array_keys($membersData[0]);
        $columnNames[] = 'Historique des Paiements'; // Add column for payment history
        $columnIndex = 'A';
        foreach ($columnNames as $columnName) {
            $sheet->setCellValue($columnIndex . '1', $columnName);
            $columnIndex++;
        }

        // Add data rows
        $rowIndex = 2;
        foreach ($membersData as $member) {
            $columnIndex = 'A';
            foreach ($member as $key => $value) {
                // Format date columns to display only the date
                if (strpos($key, 'date') !== false) {
                    $value = date('Y-m-d', strtotime($value));
                }
                $sheet->setCellValue($columnIndex . $rowIndex, $value);
                $columnIndex++;
            }

            // Fetch payment traces for the current member
            $memberId = $member['id']; // Adjust 'id' to your primary key field
            $traceQuery = "SELECT payment_date_trace FROM payments_trace WHERE member_id = ?";
            $traceStmt = $cnx->prepare($traceQuery);
            $traceStmt->execute([$memberId]);
            $traces = $traceStmt->fetchAll(PDO::FETCH_COLUMN);

            // Concatenate payment dates into a single string
            $paymentHistory = implode(', ', $traces);
            $sheet->setCellValue($columnIndex . $rowIndex, $paymentHistory);

            $rowIndex++;
        }
    }

    // Define the filename with optional dates
    $filename = "export_members";
    if ($startDate && $endDate) {
        $filename .= "_{$startDate}_to_{$endDate}";
    }
    $filename .= ".xlsx";

    // Set the headers to force download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    // Write the file
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}
?>
