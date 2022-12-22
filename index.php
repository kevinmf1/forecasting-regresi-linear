<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="css/signin.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <title>Login</title>
</head>
<body class="text-center">

  <div class="container">
    <form action="authenticate.php" method="POST" class="login-email">
        <p class="login-text" style="font-size: 2rem; font-weight: 800;">Admin Login</p>
        <div class="input-group">
          <input type="text" placeholder="Username" id="inputEmail" name="username" required>
        </div>
        <div class="input-group">
          <input type="password" placeholder="Password" id="inputPassword" name="password" required>
        </div>
        <?php if (isset($_GET['notify'])) {
            if($_GET['notify'] == 'error') {
              echo '<p>Username atau password salah</p>';
            }
        } ?>
        <div class="input-group">
          <button name="do-login" class="btn">Login</button>
        </div>
    </form>
  </div>
</body>
</html>
