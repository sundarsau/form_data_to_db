<?php
$succ_msg = $err_msg = "";
$nameErr = $emailErr = $ageErr = "";
$errFlag = false;
$name = $email = $age = "";
$conn = new mysqli("localhost","root","","test");
if($conn->connect_error){
    die("DB Connection failed ".$conn->connect_error);
}
if (isset($_POST['submit'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $age = $_POST['age'];

    if (empty($name)){
        $nameErr = "Name must be entered";
        $errFlag = true;
    }
    if (empty($email)){
        $emailErr = "Email must be entered";
        $errFlag = true;
    }
    else{
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $emailErr = "Not a valid format Email";
            $errFlag = true;
        }
    }
    if (empty($age)){
        $ageErr = "Age must be entered";
        $errFlag = true;
    }
// if (!$errFlag){
    $sql = "insert into users (name, email, age) values (?,?,?)";
    try{
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi",$name, $email, $age);
        $stmt->execute();
        $succ_msg = "Data inserted successfully";
        $name = $email = $age = "";
        }
        catch(Exception $e){
            $err_msg = $e->getMessage();
        }
    // }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert form data into database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Insert form data into database</h1>
        <?php
        if (!empty($succ_msg)){ ?>
            <div class="alert alert-success"><?= $succ_msg?></div>
            <?php }
            
         if (!empty($err_msg)){ ?>
            <div class="alert alert-danger"><?= $err_msg?></div>
            <?php }
            ?>
        <form action="" method="post">
            Name: <input class="form-control mb-3" type="text" name="name" placeholder ="Enter Name" value="<?= $name ?>">
            <div class="text-danger"><?= $nameErr?></div>

            Email: <input class="form-control mb-3" type="text" name="email" placeholder ="Enter Email" value="<?= $email ?>">
            <div class="text-danger"><?= $emailErr?></div>

            Age: <input class="form-control mb-3" type="number" name="age" placeholder ="Enter Age" value="<?= $age ?>">
            <div class="text-danger"><?= $ageErr?></div>

            <button class="btn btn-primary" type="submit" name="submit">Submit</button>

        </form>
    </div>
    
</body>
</html>