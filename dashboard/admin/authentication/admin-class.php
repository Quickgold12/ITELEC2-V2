<?php 
require_once __DIR__.'/../../../database/dbconnection.php';
include_once __DIR__.'/../../../config/settings-configuration.php';

class ADMIN
{
    private $conn;
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->dbConnection();
    }

    public function addAdmin($username, $email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(array(":email" => $email));

        if($stmt->rowCount() > 0){
            echo "<script>alert('Email Already exists.'); window.location.href = '../../../';</scrip>";
            exit;
        }
        if(!isset($csrf_token) || !hash_equals($_SESSION['cstf_token'], $csrf_token)){
            echo "<script>alert('Invalid CSRF Token.'); window.location.href = '../../../';</scrip>";
            exit;
        }

        unset($_SESSION['csrf_token']);

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $STMT = $this->runQuery('INSERT INTO user (username, email, password) VALUES(:username, :email, :password)');
        $exec = $stmt->execute(array(

            ":username" => $username,
            ":email" => $email,
            ":password" => $hash_password,


        ));

        if($exec){
            echo "<script>alert('Admin Added Succesfully.'); window.location.href = '../../../';</scrip>";
            exit;
        }else{
            echo "<script>alert('Error Adding Admin.'); window.location.href = '../../../';</scrip>";
            exit;
        }
    }
    public function adminSignin($csrf_token, $email, $password)
    {
        try{
            if(!isset($csrf_token) || !hash_equals($_SESSION['cstf_token'], $csrf_token)){
                echo "<script>alert('Invalid CSRF Token.'); window.location.href = '../../../';</scrip>";
                exit;
            }
            unset($_SESSION['csrf_token']);

            $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->execute(array(":email" => $email));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if($stmt->rowCount() == 1 && $userRow['password'] == md5($password)){
              $activity = "Has Succesfully signed in";
              $user_id = $userRow['id'];
              $this_.logs($activity, $user_id);

            }


        }catch (PDOException $ex){
            echo $ex->getMessage();
        }
    }
    public function adminSignout()
    {

    }
    public function logs($activity, $user_id)
    {
        $stmt = $this->conn->prepare("INSERT INTO logs (user_id, activity)");
    }
    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
}


if(isset($_POST['btn-signup']))
{
    $csrf_token = trim($_POST['csrf_token']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $addAdmin = new ADMIN();
    $addAdmin->addAdmin($username, $email, $password);

}

if(isset($_POST['btn-signin'])){
    $csrf_token = trim($_POST['csrf_token']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $adminSignin = new ADMIN();
    $adminSignin -> adminSignin($csrf_token, $email, $password);
}

?>