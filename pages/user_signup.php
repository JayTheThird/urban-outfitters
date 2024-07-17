<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Registration or Sign Up form in HTML CSS | CodingLab </title>
  <link rel="stylesheet" href="../styles/login_signup_style.css">

</head>

<body>
  <div class="wrapper">
    <h2>Registration</h2>
    <form action="#">
      <div class="input-box">
        <input type="text" placeholder="First Name" required>
      </div>
      <div class="input-box">
        <input type="text" placeholder="Last Name" required>
      </div>
      <div class="input-box">
        <input type="text" placeholder="Email" required>
      </div>
      <div class="input-box">
        <input type="number" placeholder="Contact Number" required>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Password" required>
      </div>
      <div class="policy">
        <input type="checkbox">
        <h3>I accept all terms & condition</h3>
      </div>
      <div class="input-box button">
        <input type="Submit" value="Register Now">
      </div>
      <div class="text">
        <h3>Already have an account? <a href="user_login.php">Login now</a></h3>
      </div>
    </form>
  </div>

</body>

</html>