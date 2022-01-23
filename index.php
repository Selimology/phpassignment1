<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forms</title>

  <style>
    body {
      text-align: center;
      font-size: 1.1rem;
    }

    .error {
      color: red;
      font-size: 1.2rem;
      font-style: italic;
    }
  </style>
</head>

<body>



  <?php
  $firstname = $lastname = $birthdate = $email = $password = $studyprograms = "";
  $fnameErr = $lnameErr = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // if (!isset($_POST["firstname"])) {
    //   $fnameErr = "Please enter your first name";
    // } else {
    //   $firstname =  cleanupdata($_POST["firstname"]);
    //   if (!preg_match("/^[a-zA-Z-' ]*$/", $firstname)) {
    //     $fnameErr  = "Only letters";
    //   }
    // }
    if (empty($_POST["name"])) {
      $fnameErr = "Name is required";
    } else {
      $firstname = cleanupdata($_POST["name"]);
      if (!preg_match("/^[a-zA-Z-' ]*$/", $firstname)) {
        $fnameErr = "Only letters and white space allowed";
      }
    }

    if (!isset($_POST["lastname"])) {
      $lnameErr = "Please enter your first name";
    } else {
      $lastname = cleanupdata($_POST["lastname"]);
      if (!preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
        $lnameErr = "Only letters";
      }
    }
  }

  function cleanupdata($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>

  <h2>Epoka Registration Form</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    <label>Name:</label>
    <input type="text" name="firstname" value="<?php echo $firstname; ?>" />
    <span class="error">* <?php echo $fnameErr; ?></span>
    <br>

    Last Name:<input type="text" name="lastname" id="ln" value="<?php echo $lastname; ?>" /><br>

    Birth day<input type="date" id="bdate" name="birthdate" value="<?php echo $birthdate; ?>" /><br>

    Email<input type="email" id="email" name="email"><br>

    Password<input type="password" id="password" name="password"><br>

    Study program<select name="studyprograms" id="programs">
      <option selected value="CEN">CEN</option>
      <option value="BINF">BINF</option>
      <option value="SW">SW</option>
    </select><br>

    <button id="submit" name="submit" value="submit" type="submit">Register</button>
  </form>

  <?php

  echo $firstname;
  ?>

</body>

</html>