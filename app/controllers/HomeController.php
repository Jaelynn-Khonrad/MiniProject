<?php
class HomeController {
    private $db;
    private $savingModel;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();

        require_once 'app/models/Saving.php';
        require_once 'app/models/user.php';

        $this->savingModel = new Saving($this->db);
        $this->userModel = new User($this->db);
    }

    public function index() {
        require_once 'app/helpers/AuthMiddleware.php';
        AuthMiddleware::isAuthenticated(); 
    
        $userId = AuthMiddleware::getUserId();
        $isAdmin = $_SESSION['user_role'] === 'admin';
        $savings = $this->savingModel->getByUserId($userId); 
        require_once 'app/views/home.php';
    }
    
    

    public function admin()
    {
        require_once 'app/helpers/AuthMiddleware.php';
        AuthMiddleware::isAdmin();
        
        $users = $this->userModel->getAllUsers();
        $savings = $this->savingModel->getAll();
        require_once 'app/views/admin.php';
    }
}