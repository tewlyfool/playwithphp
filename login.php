<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <style>
    </style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<div class="container">

<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1"><h1>Login Page</h1></span>
  </div>
</nav>

<?php
include 'dbconfig.php';
// define variables and set to empty values
$usernameErr = $passwordErr = "";
$username = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $conn = new mysqli($servername, $username_db, $password_db, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT * FROM user_data WHERE username='".$username."'";
  $result = $conn->query($sql);
  // echo $result;
  $arr_result = [];

  if ($result->num_rows > 0) {
    // output data of each row
    $passwords = [];
    while($row = $result->fetch_assoc()) {
      array_push($arr_result,array(
        'username' => $row["username"],
        'firstname' => $row["firstname"],
        'lastname' => $row['lastname']

      ));
      $password = array_push($passwords,$row['password']); 
      // echo "Username: " . $row["username"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "password ". $row['password'] ."<br>";
    }
    // echo var_dump($password[0]);

    
    // echo var_dump($_POST['password'],password_hash($_POST['password'],PASSWORD_DEFAULT),password_verify($_POST['password'],$passwords[0]));
    if(password_verify($_POST['password'],$passwords[0])){
      session_start();
      $_SESSION['user_data'] = $arr_result[0];
      header("Location: index.php");
      die();
    }else{
      $passwordErr = 'wrong password';
    }
    unset($_POST['password']);
    
  }else{
    $usernameErr = 'no username :  '.$_POST['username'];
  }
  
  $conn->close();
}
// else{
//   echo 'no post';
// }
?>
<br>
<form id='loginForm' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">Username :</span>
  <input type="text" name="username" required class="form-control <?php if($usernameErr!=''){
    echo 'is-invalid';
  } ?>" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" >
  <div id="usernameFeedback" class="invalid-feedback">
  <?php echo $usernameErr;?>
  </div>
  
</div>  
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"> Password : </span>
  <input name="password" type="password" required class="form-control <?php if($passwordErr!=''){
    echo 'is-invalid';
  } ?>" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" type="text" name="username" required>
    <div id="passwordFeedback" class="invalid-feedback">
      <?php echo $passwordErr;?>
    </div>
</div>  

</form>
<input class='btn btn-outline-dark' type="submit" form='loginForm' name="submit" value="login">
<button class='btn btn-outline-dark' onclick="document.location='register.php'">register </button>
<br><br>




  <!-- Content here -->
</div>
</body>
</html>