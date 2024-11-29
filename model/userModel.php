<?php

    // Add new user
    if (isset($_POST['addUser'])) {
        if ($_SESSION['role'] == 1) {
            $stmt = $cnx->prepare("SELECT login FROM _users_");
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $filtredUserData = filterData($_POST);
            
            $userExists = false;
            foreach ($records as $record) {
                if ($filtredUserData['login'] == $record['login']) {
                    $userExists = true;
                    break;
                }
            }
        
            if (!$userExists) {
                // Handle photos
                $photoPath = null;
                if (!empty($_FILES['userPhoto']['name'])) {
                    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/users-photos/";

                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0777, true);
                    }

                    // Create the target file path
                    $photoName = basename($_FILES['userPhoto']['name']);
                    $targetFilePath = $targetDir . $photoName;

                    if (move_uploaded_file($_FILES['userPhoto']['tmp_name'], $targetFilePath)) {
                        $photoPath = "/uploads/users-photos/" . $photoName;
                    } else {
                        $_SESSION['error'] =  "Échec du déplacement du fichier téléchargé !";
                    }
                }

                if ($filtredUserData['password'] === $filtredUserData['passwordConfirmation']) {
                    $hashPassword = password_hash($filtredUserData['password'], PASSWORD_DEFAULT);
                    $insertUser = $cnx->prepare("INSERT INTO _users_(nom, prenom, login, password, `role`, photo)
                                VALUES(:lastname, :name, :login, :password, :role, :photo)");
                    $insertUser->bindParam(':name', $filtredUserData['name'], PDO::PARAM_STR);
                    $insertUser->bindParam(':lastname', $filtredUserData['lastname'], PDO::PARAM_STR);
                    $insertUser->bindParam(':login', $filtredUserData['login'], PDO::PARAM_STR);
                    $insertUser->bindParam(':password', $hashPassword, PDO::PARAM_STR);
                    $insertUser->bindParam(':role', $filtredUserData['role'], PDO::PARAM_INT);
                    $insertUser->bindParam(':photo', $photoPath, PDO::PARAM_STR);
                    $insertUser->execute();

                    $_SESSION['success'] = "L'utilisateur a été ajouté avec succès !";
                } else {
                    $_SESSION['error'] = "Le mot de passe et la confirmation du mot de passe ne correspondent pas !";
                }
            } else {
                $_SESSION['error'] = "Identifiant invalide, veuillez le mettre à jour !";
            }
        } else {
            $_SESSION['error'] = "Vous n'avez pas l'autorisation pour ce processus !";
        }
    }


    // Update profile
    if (isset($_POST['changePassword'])) {
        $filtredData = filterData($_POST);

        if (
            !empty($filtredData["currentPassword"]) || 
            !empty($filtredData["newPassword"]) || 
            !empty($filtredData["passwordConfirmation"])
        ) {
            $query = "SELECT * FROM `_users_` ";
            $request = $cnx->prepare($query);
            $request->execute();
            $data = $request->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item) {
                if (password_verify($filtredData["currentPassword"], $item['password'])) {
                    if ($filtredData["newPassword"] === $filtredData["passwordConfirmation"]) {
                        $newHashPass = password_hash($filtredData["newPassword"], PASSWORD_DEFAULT);
                        $sql = "UPDATE `_users_` SET nom = :lastname, prenom = :name, login = :login, 
                        password = :password WHERE id = :id ";
                        $req = $cnx->prepare($sql);
                        $req->bindParam(':password', $newHashPass);
                        $req->bindParam(':lastname', $filtredData['lastname'], PDO::PARAM_STR);
                        $req->bindParam(':name', $filtredData['name'], PDO::PARAM_STR);
                        $req->bindParam(':login', $filtredData['login'], PDO::PARAM_STR);
                        $req->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                        $req->execute();
                        $_SESSION['success'] = "Vos informations personnelles ont été modifiées avec succès !";
                        
                    } else {
                        $_SESSION['error'] = "Le mot de passe et la confirmation du mot de passe ne correspondent pas !";
                    }
                } else {
                    $_SESSION['error'] = "Le mot de passe actuel est incorrect !";
                }

            }


        } else {
            $_SESSION['error'] = "Veuillez remplir toutes les informations !";
        }
    }

    // Search user
    function searchUsers($condition = null) {
        if (isset($_POST['searchUser'])) {
            global $cnx;
            $filteredData = filterData($_POST);

            if (!isset($filteredData['searchUserValue']) || empty($filteredData['searchUserValue'])) {
                return [];
            }

            $inputValueLike = '%' . $filteredData['searchUserValue'] . '%';

            $query = "SELECT * 
                    FROM _users_
                    WHERE (nom LIKE :inputValueLike OR 
                            prenom LIKE :inputValueLike OR 
                            CONCAT(prenom, ' ', nom) LIKE :inputValueLike)";
            if ($condition) {
                $query .= " " . $condition;
            }

            $query .= " ORDER BY id DESC";

            $request = $cnx->prepare($query);
            $request->bindParam(':inputValueLike', $inputValueLike, PDO::PARAM_STR);

            $request->execute();

            $records = $request->fetchAll(PDO::FETCH_ASSOC);
            return $records;
        }
        return [];
    }

    
    // Delete user
    if (isset($_POST['deleteUser'])) {
        $userData = filterData($_POST);
        $userId = $userData['userId'];
        deleteData(
            '_users_',
            $userId, 
            "L'utilisateur a été supprimé avec succès!", 
            "Aucun utilisateur trouvé avec l'ID donné!"
        );
    }

    function countUsers() {
        global $cnx;
        $query = "SELECT COUNT(*) FROM _users_ ";
        $request = $cnx->prepare($query);
        $request->execute();
        $data = $request->fetch(PDO::FETCH_NUM);
        return $data[0];
    }

    // Upload user photo
    if (isset($_POST['uploadUserPhoto'])) {
        $uploadedData = filterData($_POST);
        $userId = $_SESSION['id'];

        $photoPath = null;
        if (!empty($_FILES['photo']['name'])) {
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/users-photos/";

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Create the target file path
            $photoName = basename($_FILES['photo']['name']);
            $targetFilePath = $targetDir . $photoName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
                $photoPath = "/uploads/users-photos/" . $photoName;
            } else {
                $_SESSION['error'] =  "Échec du déplacement du fichier téléchargé !";
            }
        }

        $uploadQuery = "UPDATE `_users_` SET photo = :photo WHERE id = :id ";
        $stmt = $cnx->prepare($uploadQuery);
        $stmt->bindParam(':photo', $photoPath, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        $_SESSION['success'] = "La photo d'utilisateur a été téléchargé avec succès !";

    }

?>