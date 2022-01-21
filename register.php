<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <style>
    .error {color: #FF0000;}
    </style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<div class="container">
<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1"><h2>Register Page</h2></span>
  </div>
</nav>

<p><span class="error">* required field</span></p>
<?php 
include 'dbconfig.php';
$firstnameErr = $lastnameErr = $usernameErr = $passwordErr = "";
$firstname = $lastname = $username = $password = $confirm_password = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli($servername, $username_db, $password_db,$dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $create_new_user = true;
  $sql = "INSERT INTO user_data (firstname, lastname, username, password)
  VALUES ('".$firstname."', '".$lastname."', '".$username."', '".password_hash($password,PASSWORD_DEFAULT)."')";
  if($password != $confirm_password){
    $passwordErr = 'password and confirm password does not match';
    $create_new_user = false;
  }
  $sql_check_user = "SELECT * FROM user_data WHERE username='".$username."'";
  if($conn->query($sql_check_user)->num_rows>0){
    $usernameErr = 'the username used';
    $create_new_user = false;
  }
  if($create_new_user){
    if ($conn->query($sql) === TRUE) {
      header("Location: login.php");
      die();
    }
  }
  $conn->close();
}



?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Firstname: <input type="text" name="firstname" required>
  <span class="error">* 
    <?php echo $firstnameErr;?>
  </span>
  <br><br>
  Lastname: <input type="text" name="lastname" required>
  <span class="error">* 
    <?php echo $lastnameErr;?>
  </span>
  <br><br>
  Username: <input type="text" name="username" required>
  <span class="error">* 
    <?php echo $usernameErr;?>
  </span>
  <br><br>
  Password: <input name="password" type="password" required>
  <span class="error">* </span>
  <br><br>
  Confirm Password: <input name="confirm_password" type="password" required> 
  <span class="error">* </span>
  <br>
  <span class="error">
    <?php echo $passwordErr;?>
  </span>
  <br>
  <br>
  <input type="submit" name="submit" value="Submit">  
</form>

</div>
</body>
</html>