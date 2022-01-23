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

  <h2>Epoka Registration Form</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    <label for="firstname">Name:</label><br>
    <input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" /><br>

    <label for="lastname">Last Name:</label><br>
    <input id="lastname" type="text" name=" lastname" id="lastname" value="<?php echo $lastname; ?>" /><br>

    <label for="birthdate">Birthday</label><br>
    <input type="date" id="birthdate" name="birthdate" value="<?php echo $birthdate; ?>" /><br>

    <label for="email">Email</label><br>
    <input type="email" id="email" value="<?php echo $email; ?>" name="email"><br>

    <label for="password">Password</label><br>
    <input type="password" id="password" name="password" value="<?php echo $password; ?>"><br>

    <label for="studyprograms">Study program</label><br>
    <select name="studyprograms" id="programs">
      <option selected value="CEN">CEN</option>
      <option value="BINF">BINF</option>
      <option value="SW">SW</option>
    </select><br><br>

    <input type="submit" name="submit" value="Submit">
  </form>

  <?php

  $firstname = $lastname = $birthdate = $email = $password = $studyprograms = "";
  $fnameErr = $lnameErr = $birthdateErr = $emailErr = $passwordErr = $studyprogramsErr = '';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstname"])) {
      $fnameErr = "Name is required";
    } else {
      $firstname = cleanupdata($_POST["firstname"]);
      if (preg_match("/^([a-zA-Z' ]+)$/", $firstname)) {
        $fnameErr = "Only letters are allowed!";
      }
    }
  }

  function cleanupdata($data)
  {
    $data = htmlspecialchars(stripslashes((trim($data))));
    return $data;
  }

  ?>
</body>

</html>