<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<div class="container pt-5">

  <?php 
  include 'dbconfig.php';
  session_start();
  $user_data=[];
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    unset($_SESSION['user_data']);
    header("Location: login.php");
    die();
  }

  ?>

  <div class='col offset-8 '>
      
    <form   action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post' >
      <?php 
        if (isset($_SESSION['user_data'])){
          echo '<div class="d-flex justify-content-around">';
          echo "<span class='align-bottom fs-5'>HI, ".$_SESSION['user_data']['firstname']." ".$_SESSION['user_data']['lastname']."</span>";
          
          echo "<button class='btn btn-outline-dark ' type='submit'>logout</button>";
          echo '</div>';
        }else{
          echo "<h1>please login</h1>";
          echo "<script>
          window.onload = GoPage()
          function GoPage(){
          setTimeout(function(){ 
            window.location.replace('login.php');
              }, 2000);
          }
          </script>";
        }
      ?>

    </form>

  </div>
</div>
</body>
</html>