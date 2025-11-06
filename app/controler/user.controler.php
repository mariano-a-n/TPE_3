<?php
require_once './app/models/user.model.php';
require_once './app/veiws/user.view.php';


class userController {
    private $userModel;
    private $view;

    function __construct() {
        $this->userModel = new UserModel();
        $this->view = new userView();
    }

    public function showLogin($request) {
        // muestra el formulario de login
        $this->view->showLogin($request->user);
    }

    public function doLogin($request) {
        // 1. validar que se hayan enviado los campos
        if (empty($_POST['user']) || empty($_POST['password'])) {
            return $this->view->showLogin ($request->user);
        }

        // 2. obtener datos del formulario
        $email = $_POST['user'];
        $password = $_POST['password'];

        // 3. buscar el usuario en la base de datos
        $userFromDB = $this->userModel->getByUser($email);
        
        // 4. verificar que exista y que la contraseña coincida
        if ($userFromDB && password_verify($password, $userFromDB->contraseña)) {
            // 5. guardar datos del usuario en la sesión
            $_SESSION['USER_ID'] = $userFromDB->id;
            $_SESSION['USER_EMAIL'] = $userFromDB->email;

            // 6. redirigir a home
            header("Location: " . BASE_URL . "home"); 
            exit;
        } else {
            // si no coincide, mostrar error
            return $this->view->showLogin($request->user);
        }
    }

    public function logout($request) {
        session_destroy();
        header("Location: " . BASE_URL . "login");
        exit;
    }
}