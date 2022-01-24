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

  $filename = 'selectvalue.txt';
  $eachlines = file($filename, FILE_IGNORE_NEW_LINES);
  $firstname = $lastname = $birthdate = $email = $password = $studyprograms = "";
  $fnameErr = $lnameErr = $birthdateErr = $emailErr = $passwordErr = $studyprogramsErr = '';
  $valid = true;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = cleanupdata($_POST["firstname"]);
    $lastname = cleanupdata($_POST["lastname"]);
    $birthdate = strtotime($_POST["birthdate"]);
    $email = cleanupdata($_POST["email"]);
    $password = cleanupdata($_POST["password"]);
    $studyprograms = cleanupdata($_POST["studyprograms"]);



    #validation for first name
    if (empty($_POST["firstname"])) {
      $fnameErr = "Name is required";
    } else {
      if (preg_match("/^([a-zA-Z' ]+)$/", $firstname)) {
        $fnameErr = "Only letters are allowed!";
        $valid = false;
      }
    }

    #validation for lastname
    if (empty($_POST["lastname"])) {
      $lnameErr = "Name is required";
    } else {
      if (preg_match("/^([a-zA-Z' ]+)$/", $lastname)) {
        $lnameErr = "Only letters are allowed!";
        $valid = false;
      }
    }

    #validation for birthday and +18 years old.
    if (empty($_POST["birthdate"])) {
      $birthdateErr = "Pick a date";
    } else {
      if (time() < strtotime('+18 years', ($birthdate))) {
        $birthdateErr = "Under 18 years old!";
        $valid = false;
      }
    }
    $year = date("Y", $birthdate);



    #This is regex for the initial of the firstname and the base url to check.
    $expr = '/(?<=\s|^)[a-z]/i';
    preg_match_all($expr, $firstname, $matches);
    $firstNameInitial = implode('', $matches[0]);
    $baseEmail = $firstNameInitial . $lastname . $year . "@epoka.edu.al";

    #email validation to make sure initial + lastname  + year + @epoka.edu.al
    if (empty($_POST["email"])) {
      $emailErr = "Email is required";
    } else {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (!($email == $baseEmail))
          $emailErr = "Invallid email format.";
        $valid = false;
      }
    }

    //password validation with the requirements
    if (empty($_POST["password"])) {
      $passwordErr = "Password is required";
    } else {
      if (preg_match("^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$(?=\S*[\W])", $password)) {
        $passwordErr = "Not all the requirements are fullfilled.";
        $valid = false;
      }
    }

    if (empty($_POST['studyprograms'])) {
      if ($_POST['studyprograms'] == 'NULL') {
        $studyprogramsErr = "Select an option";
      } else {
        echo '<p>You selected :', $_POST['studyprograms'], '</p>';
        $valid = false;
      }
    }

    if ($valid) {
      $file = fopen("textfile.txt", "a+") or die("not able to open!");
      fwrite($file, "First name: " . $firstname . "\n");
      fwrite($file, "Last name: " . $lastname . "\n");
      fwrite($file, "Email: " . $baseEmail . "\n");
      fwrite($file, "Birthdate: " . $birthdate . "\n");
      fwrite($file, "Password: " . $password . "\n");
      fwrite($file, "StudyGroup:" . $studyprograms . "\n");
    }
  }




  function cleanupdata($data)
  {
    $data = htmlspecialchars(stripslashes((trim($data))));
    return $data;
  }

  ?>


  <h2>Epoka Registration Form</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    <label for="firstname">Name:</label><br>
    <input autocomplete="off" type="text" id="firstname" name="firstname" value="<?php echo isset($_POST["firstname"]) ? $_POST["firstname"] : ''; ?>" /><br>

    <label for="lastname">Last Name:</label><br>
    <input autocomplete="off" id="lastname" type="text" name=" lastname" id="lastname" value="<?php echo isset($_POST["lastname"]) ? $_POST["lastname"] : ''; ?>" /><br>

    <label for="birthdate">Birthday</label><br>
    <input type="date" id="birthdate" name="birthdate" value="<?php echo isset($_POST["birthdate"]) ? $_POST["birthdate"] : ''; ?>" /><br>

    <label for="email">Email</label><br>
    <input autocomplete="off" name="email" type="email" id="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>"><br>

    <label for="password">Password</label><br>
    <input type="password" id="password" name="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ''; ?>"><br>

    <label for="studyprograms">Study program</label><br>
    <select name="studyprograms" id="programs" value="<?php echo isset($_POST["studyprograms"]) ? $_POST["studyprograms"] : ''; ?>">
      <option selected value="studyprograms"> Please Select</option>
      <?php foreach ($eachlines as $lines) {
        echo "<option value='" . $lines . "'>$lines</option>";
      } ?>;
    </select><br><br>

    <input type="submit" name="submit" value="Submit">
  </form>

</body>

</html>