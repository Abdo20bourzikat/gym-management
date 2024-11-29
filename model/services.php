<?php
    include 'config.php';

    function accessPermission() {
        if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
            header('Location: ../login.php');
            exit();
        }
    }


    function filterData($data) {
        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
            $data[$key] = stripcslashes($value);
            $data[$key] = htmlspecialchars($value);
            $data[$key] = strip_tags($value);
        }
        return $data;
    }


    function getData($table, $status, $condition = null) 
    {
        global $cnx;
        $query = "SELECT * FROM $table WHERE status = '$status' ORDER BY id DESC ";
        if ($condition) {
            $query .= $condition;
        }
        $request = $cnx->prepare($query);
        $request->execute();
        return $request->fetchAll();
    }

    // Get users data
    function getUsersData($table) 
    {
        global $cnx;
        $query = "SELECT * FROM $table ";
       
        $request = $cnx->prepare($query);
        $request->execute();
        return $request->fetchAll();
    }

    // Update data
    function editData($table, $data, $condition, $successMsg, $errorMsg) {
        global $cnx;
    
        try {
            $setParts = [];
            $values = [];
            
            foreach ($data as $column => $value) {
                $setParts[] = "`$column` = ?";
                $values[] = $value;
            }
            
            $values[] = $condition['value'];
            $setQuery = implode(", ", $setParts);
    
            $query = "UPDATE `$table` SET $setQuery WHERE `{$condition['column']}` = ?";
            
            $req = $cnx->prepare($query);
            $req->execute($values);
    
            if ($req->rowCount() != 0) {
                $_SESSION['success'] = $successMsg;
            } else {
                $_SESSION['error'] = $errorMsg;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur s'est produite: " . $e->getMessage();
        }
    }

    // Delete data
    function deleteData($table, $clientId, $successMsg, $errorMsg) 
    {
        global $cnx;
    
        try {
            $query = "DELETE FROM $table WHERE id = ?";
            $req = $cnx->prepare($query);
    
            $req->execute([$clientId]);
    
            if ($req->rowCount() > 0) {
                $_SESSION['success'] = $successMsg;
            } else {
                $_SESSION['error'] = $errorMsg;
            }
        } catch(Exception $e) {
            $_SESSION['error'] = "Une erreur s'est produite: " . $e->getMessage();
            return $_SESSION['error'];
        }
    }
    
    // Get by id
    function getDataById($table, $id) {
        global $cnx;
    
        $stmt = $cnx->prepare("SELECT * FROM $table WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $data;
    }


    // Gym informations
    function getGymData() {
        global $cnx;
        $query = "SELECT * FROM settings WHERE id = 1 ";
        $stmt = $cnx->prepare($query);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    $getGymData = getGymData();

    function updateSettings($gymname, $logo) {
        global $cnx;
        $settingId = 1;
        $query = "UPDATE settings SET gymname = :gymname, logo = :logo WHERE id = :id";
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':gymname', $gymname, PDO::PARAM_STR);
        $stmt->bindParam(':logo', $logo, PDO::PARAM_STR);
        $stmt->bindParam(':id', $settingId, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['success'] = "Les paramètres ont été modifiés avec succès !";
    }

    if (isset($_POST['updateSettings'])) {
        $filtredData = filterData($_POST);

        // Handle logo
        $photoPath = $getGymData['logo'];
        if (!empty($_FILES['gymlogo']['name'])) {
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/logo/";

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Create the target file path
            $photoName = basename($_FILES['gymlogo']['name']);
            $targetFilePath = $targetDir . $photoName;

            if (move_uploaded_file($_FILES['gymlogo']['tmp_name'], $targetFilePath)) {
                $photoPath = "/uploads/logo/" . $photoName;
            } else {
                $_SESSION['error'] =  "Échec du déplacement du fichier téléchargé !";
            }
        }

        updateSettings($filtredData['gymname'], $photoPath);
    }


    // Get display columns data
    $sql = "SELECT * FROM display_settings";
    $stmt = $cnx->query($sql);
    $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Create an associative array for easier lookup
    $settingsMap = [];
    foreach ($settings as $setting) {
        $settingsMap[$setting['column_name']] = $setting['is_visible'] === '1';
    }
    
?>