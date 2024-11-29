<?php
    include '../../model/loginModel.php';

    header('Content-Type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);
    $column = $data['column'];
    $is_visible = $data['is_visible'];

    $sql = "UPDATE display_settings SET is_visible = :is_visible WHERE column_name = :column";
    $stmt = $cnx->prepare($sql);
    $stmt->execute([':is_visible' => $is_visible, ':column' => $column]);

    echo json_encode(['success' => true]);
