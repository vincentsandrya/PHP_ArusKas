<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css?family=Assistant:400,700" rel="stylesheet"><link rel="stylesheet" href="./style.css">

  <?php
  include "../include/config.php";
  ob_start();
  session_start();

  if(isset($_POST["submitLogin"]))
  {
    $passuser = $_POST["pass"];
    $sql_login = mysqli_query($connection, "SELECT * FROM refuser where password = '$passuser'");

    if(mysqli_num_rows($sql_login)>0)
    {
      $row_admin = mysqli_fetch_array($sql_login);
      $_SESSION['username'] = $row_admin['username'];
      header("location:../index.php");
    }
  }
  ?>

</head>
<body>
  <!-- partial:index.partial.html -->
  <section class='login' id='login'>
    <div class='head'>
      <h1 class='company'>Welcome Back!</h1>
    </div>
    <p class='msg'>input your code...</p>
    <div class='form'>
      <form method="POST" >
        <!-- <input type="text" placeholder='Username' class='text' id='username' required><br> -->
        <input type="password" placeholder='••••••••••••••' class='password' name="pass"><br>
        <center>
          <button type="submit" class="btn-login" id="submitLogin" name="submitLogin">Login</button>
        </center>
        <!-- <a href="#" class='forgot'>Forgot?</a> -->

      </form>
    </div>
  </section>
  <footer>
    <p>Made with <span class='heart'>&hearts;</span> by Bridges(<a href='https://github.com/pxntxs'>@pxntxs</a>)</p>
    <p>Gradient: <a href='https://uigradients.com/#Turquoiseflow'>https://uigradients.com/#Turquoiseflow</a></p>
  </footer>
  <!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>
