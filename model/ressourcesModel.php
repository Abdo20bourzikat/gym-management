<?php

    // Get all websites
    function GetWebsites() {
        global $cnx;
        $userId = $_SESSION['id'];
        $query = "SELECT w.*, g.groupname 
            FROM websites w
            JOIN sitegroup g ON w.groupid = g.id
            JOIN _users_ u ON w.user_id = u.id
            AND w.user_id = :userId
            ORDER BY g.groupname ASC";

        
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    $GetWebsites = GetWebsites();


    // Get groups
    function getGroups() {
        global $cnx;
        $query = "SELECT * FROM sitegroup";
        $stmt = $cnx->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Add site function
    function addSite($request, $siteImage = null) {
        global $cnx;
        $filtredData = filterData($request);

        $query = "INSERT INTO websites(sitetitle, groupid, description, siteimage, sitelink)
                VALUES (:sitetitle, :groupid, :description, :siteimage, :sitelink)";
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':sitetitle', $filtredData['siteTitle'], PDO::PARAM_STR);
        $stmt->bindParam(':groupid', $filtredData['siteGroup'], PDO::PARAM_INT);
        $stmt->bindParam(':description', $filtredData['siteDescription'], PDO::PARAM_STR);
        $stmt->bindParam(':siteimage', $siteImage, PDO::PARAM_STR);
        $stmt->bindParam(':sitelink', $filtredData['siteLink'], PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = "Le site a été ajouté avec succès !";
        }
    }

    // Add group function
    function addGroup() {
        global $cnx;
        $data = filterData($_POST);
        
        // Check if the group already exists
        $checkQuery = "SELECT COUNT(*) FROM sitegroup WHERE groupname = :groupname";
        $checkStmt = $cnx->prepare($checkQuery);
        $checkStmt->bindParam(':groupname', $data['groupname'], PDO::PARAM_STR);
        $checkStmt->execute();
        $groupExists = $checkStmt->fetchColumn();
        
        if ($groupExists > 0) {
            // Group already exists, show an error message
            $_SESSION['error'] = "Ce groupe existe déjà !";
        } else {
            $query = "INSERT INTO sitegroup(groupname) VALUES(:groupname)";
            $stmt = $cnx->prepare($query);
            $stmt->bindParam(':groupname', $data['groupname'], PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $_SESSION['success'] = "Le groupe a été ajouté avec succès !";
            }
        }
    }



    if (isset($_POST['updateSite'])) {
        $updatedData = filterData($_POST);
        // Get the form data
        $websiteId = $updatedData['websiteId'];
        $siteTitle = $updatedData['siteTitle'];
        $siteGroup = $updatedData['siteGroup'];
        $siteDescription = $updatedData['siteDescription'];
        $siteLink = $updatedData['siteLink'];
        $siteImage = null;

        // Handle file upload
        if (!empty($_FILES['siteImage']['name'])) {
            // Handle the image upload as before
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/resources/";
            $photoName = basename($_FILES['siteImage']['name']);
            $targetFilePath = $targetDir . $photoName;
            if (move_uploaded_file($_FILES['siteImage']['tmp_name'], $targetFilePath)) {
                $siteImage = "/uploads/resources/" . $photoName;
            } else {
                $_SESSION['error'] = "Échec du déplacement du fichier téléchargé !";
            }
        }

        // Update the website in the database
        $query = "UPDATE websites SET sitetitle = :sitetitle, groupid = :groupid, description = :description, 
        siteimage = :siteimage, sitelink = :sitelink WHERE id = :id";
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':sitetitle', $siteTitle);
        $stmt->bindParam(':groupid', $siteGroup);
        $stmt->bindParam(':description', $siteDescription);
        $stmt->bindParam(':siteimage', $siteImage);
        $stmt->bindParam(':sitelink', $siteLink);
        $stmt->bindParam(':id', $websiteId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = "Le site a été mis à jour avec succès !";
        } else {
            $_SESSION['error'] = "Aucune modification apportée.";
        }
        
    }

    // Add new site
    if (isset($_POST['saveSite'])) {
        // Handle site image
        $photoPath = null;
        if (!empty($_FILES['siteImage']['name'])) {
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/resources/";

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Create the target file path
            $photoName = basename($_FILES['siteImage']['name']);
            $targetFilePath = $targetDir . $photoName;

            if (move_uploaded_file($_FILES['siteImage']['tmp_name'], $targetFilePath)) {
                $photoPath = "/uploads/resources/" . $photoName;
            }
        }

        addSite($_POST, $photoPath);
    }

    // Delete some site
    if (isset($_POST['deleteSite'])) {
        $data = filterData($_POST);
        $websiteId = $data['websiteId'];
        $deleteQuery = "DELETE FROM websites WHERE id = :id";
        $stmt = $cnx->prepare($deleteQuery);
        $stmt->bindParam(':id', $websiteId,  PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = "Le site a été supprimé avec succès !";
        }
    }
    
    // Save new group
    if (isset($_POST['saveGroup'])) {
        addGroup();
    }
    
    if (isset($_POST['deleteSiteGroup'])) {
        $data = filterData($_POST);
        $groupId = $data['groupId'];
        $deleteQuery = "DELETE FROM sitegroup WHERE id = :id";
        $stmt = $cnx->prepare($deleteQuery);
        $stmt->bindParam(':id', $groupId,  PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = "Le groupe a été supprimé avec succès !";
        }
    }
    

?>