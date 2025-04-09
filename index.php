<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Sql Task 2</title>
</head>

<body>

  <h1>My Sql Task 2</h1>
  <h2>Insert Employee Data into MySQL Database</h2>
  <br><br>
  <div class="form-division">
    <!-- Employee form to get data from user -->
    <form method="post" action="form.php">

      <!-- Employee Id -->
      <label>Employee ID : </label>
      <input type="text" name="emp_id" placeholder="Enter your Employee ID" required>
      <br><br>

      <!-- Employee First Name -->
      <label>Firstname : </label>
      <input type="text" name="emp_firstname" placeholder="Enter your Firstname" required>
      <br><br>

      <!-- Employee Last Name -->
      <label>Lastname : </label>
      <input type="text" name="emp_lastname" placeholder="Enter your Lastname" required>
      <br><br>

      <!-- Employee Code -->
      <label>Employee Code : </label>
      <input type="text" name="emp_code" placeholder="Enter your Employee Code" required>
      <br><br>

      <!-- Employee Code Name -->
      <label>Employee Code Name : </label>
      <input type="text" name="emp_code_name" placeholder="Enter your Employee Code Name" required>
      <br><br>

      <!-- Employee Domain -->
      <label>Domain : </label>
      <input type="text" name="emp_domain" placeholder="Enter your Domain" required>
      <br><br>

      <!-- Employee Salary -->
      <label>Salary : </label>
      <input type="text" name="emp_salary" placeholder="Enter your Salary" required>
      <br><br>

      <!-- Employee Graduation Percentile -->
      <label>Graduation Percentile : </label>
      <input type="text" name="emp_percent" placeholder="Enter your Graduation Percentile" required>
      <br><br>

      <!-- Submit button -->
      <input type="submit" value="Submit">

    </form>

    <br><br>
    <h2>View all Queries from MySQL Database</h2>

    <!-- Form to view all queries from MySQL database -->
    <form method="post" action="<?php
    echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?q=view";
    ?>">
      <input type="submit" value="view">
    </form>
    <br><br>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['q'] == 'view') {
      include 'query.php';
    }
    ?>

  </div>
</body>

</html>
