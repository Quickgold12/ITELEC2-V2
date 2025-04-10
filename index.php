<?php 
    include_once 'config/settings-configuration.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>SiGN IN</h1>
    <form action="" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
        <input type="email" name="email" placeholder="Enter Email" required> <br>
        <input type="password" name="password" placeholder="Enter Email" required> <br>
        <button type="submit" name="btn-signin">SIGN IN</button>
    </form>


    <h1>REGISTRATION</h1>
    <form action="" method="POST">
    
    </form>
</body>
</html>