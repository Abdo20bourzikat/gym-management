<?php
    session_start();
    include 'services.php';

    $accessErrors = [
        'loginError' => '',
        'passError' => '',
        'lastError' => '',
    ];

    if (isset($_POST['_loginRequest_'])) {
        $filteredAccess = filterData($_POST);

        if (!empty($filteredAccess['_login_'])) {
            if (!empty($filteredAccess['_password_'])) {
                $query = "SELECT * FROM _users_";
                $request = $cnx->prepare($query);
                $request->execute();
                $data = $request->fetchAll(PDO::FETCH_ASSOC);

                for ($i = 0; $i < count($data); $i++) {
                    if (password_verify($filteredAccess['_password_'], $data[$i]['password']) && $data[$i]['login'] == $filteredAccess['_login_']) {
                        $_SESSION['login'] = true;
                        $_SESSION['id'] = $data[$i]['id'];
                        $_SESSION['role'] = $data[$i]['role'];
                        $_SESSION['name'] = $data[$i]['prenom'];
                        $_SESSION['lastname'] = $data[$i]['nom'];
                        $_SESSION['log'] = $data[$i]['login'];
                        $_SESSION['photo'] = $data[$i]['photo'];
                        header('Location: dashboard.php');
                    } else {
                        $accessErrors['lastError'] = 'The login or password is incorrect!';
                    }
                }

            } else {
                $accessErrors['passError'] = 'Please enter your password!';
            }
        } else {
            $accessErrors['loginError'] = 'Please enter your login!';
        }
    }

?>