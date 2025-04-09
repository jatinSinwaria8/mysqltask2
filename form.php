<?php

/**
 * DbInsert class to handle database operations for employee data.
 */
class DbInsert
{
  /**
   * @var mysqli $conn The MySQLi connection object. 
   */
  private $conn;

  /**
   * @var string $database The name of the database.
   */
  private $database = "employee";

  /**
   * @var string $emp_id Employee ID.
   */
  private $emp_id = "";

  /**
   * @var string $emp_firstname Employee First Name.
   */
  private $emp_firstname = "";

  /**
   * @var string $emp_lastname Employee Last Name.
   */
  private $emp_lastname = "";

  /**
   * @var string $emp_code Employee Code.
   */
  private $emp_code = "";

  /**
   * @var string $emp_code_name Employee Code Name.
   */
  private $emp_code_name = "";

  /**
   * @var string $emp_domain Employee Domain.
   */
  private $emp_domain = "";

  /**
   * @var int $emp_salary Employee Salary.
   */
  private $emp_salary = "";

  /**
   * @var int $emp_percent Employee Graduation Percentile.
   */
  private $emp_percent = "";

  /**
   * Constructor to establish a connection to the MySQL database.
   *
   * @return void
   */
  public function __construct()
  {
    // Create connection to employee database
    $this->conn = new mysqli("localhost", "jatinSinwaria", "Jatin123!@#");

    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $this->database";
    $this->conn->query($sql);

    // Select the database
    $this->conn->select_db($this->database);
  }

  /**
   * Function to initialize variables with POST data.
   *
   * @return void
   */
  public function initiliseVariable()
  {
    // Initialize variables with POST data
    $this->emp_id = $_POST['emp_id'];
    $this->emp_firstname = $_POST['emp_firstname'];
    $this->emp_lastname = $_POST['emp_lastname'];
    $this->emp_code = $_POST['emp_code'];
    $this->emp_code_name = $_POST['emp_code_name'];
    $this->emp_domain = $_POST['emp_domain'];
    $this->emp_salary = (int) $_POST['emp_salary'];
    $this->emp_percent = (int) $_POST['emp_percent'];
  }

  /**
   * Function to insert data into employee_code_table.
   *
   * @return void
   */
  public function insertEmployeeCodeTable()
  {
    // Create employee_code_table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS employee_code_table (
      employee_code VARCHAR(50) NOT NULL,
      employee_code_name VARCHAR(50) NOT NULL,
      employee_domain VARCHAR(50) NOT NULL,
      primary key (employee_code)      
    )";
    $this->conn->query($sql);

    // Check if employee_code already exists
    $sql = "SELECT employee_code FROM employee_code_table WHERE employee_code = '$this->emp_code'";

    // Execute the query
    $result = $this->conn->query($sql);

    // Check if the employee_code already exists
    if ($result->num_rows > 0) {
      echo "Employee Code already exists in employee_code_table <br>";
      return;
    }

    // Insert new record into employee_code_table
    $sql = "INSERT INTO employee_code_table (employee_code, employee_code_name, employee_domain) VALUES ('$this->emp_code', '$this->emp_code_name', '$this->emp_domain')";

    // Execute the query
    if ($this->conn->query($sql) === TRUE) {
      // New record created successfully
      echo "New record created successfully in employee_code_table <br>";
    } else {
      // Error occurred while inserting the record
      echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
    }

  }

  /**
   * Function to insert data into employee_salary_table.
   *
   * @return void
   */
  public function insertEmployeeSalaryTable()
  {
    // Create employee_salary_table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS employee_salary_table (
      employee_id VARCHAR(50),
      employee_salary INT,
      employee_code VARCHAR(50),
      primary key (employee_id),
      foreign key (employee_code) references employee_code_table(employee_code)
    )";

    // Execute the query
    $this->conn->query($sql);

    // Check if employee_id already exists
    $sql = "SELECT employee_id FROM employee_salary_table WHERE employee_id = '$this->emp_id'";

    // Execute the query
    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      // Employee ID already exists
      echo "Employee ID already exists in employee_salary_table <br>";
      return;
    }

    // Insert new record into employee_salary_table
    $sql = "INSERT INTO employee_salary_table (employee_id, employee_salary, employee_code) VALUES ('$this->emp_id', '$this->emp_salary', '$this->emp_code')";

    // Execute the query
    if ($this->conn->query($sql) === TRUE) {
      // New record created successfully
      echo "New record created successfully in employee_salary_table <br>";
    } else {
      // Error occurred while inserting the record
      echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
    }
  }

  /**
   * Function to insert data into employee_details_table.
   *
   * @return void
   */
  public function insertEmployeeDetailsTable()
  {
    // Create employee_details_table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS employee_details_table (
      employee_id VARCHAR(50),
      employee_firstname VARCHAR(50),
      employee_lastname VARCHAR(50),
      Graduation_percentile INT,
      primary key (employee_id)
    )";

    // Execute the query
    $this->conn->query($sql);

    // Check if employee_id already exists
    $sql = "SELECT employee_id FROM employee_details_table WHERE employee_id = '$this->emp_id'";

    // Execute the query
    $result = $this->conn->query($sql);

    // Check if the employee_id already exists
    if ($result->num_rows > 0) {
      echo "Employee ID already exists in employee_details_table <br>";
      return;
    }

    // Insert new record into employee_details_table
    $sql = "INSERT INTO employee_details_table (employee_id, employee_firstname, employee_lastname, Graduation_percentile) VALUES ('$this->emp_id', '$this->emp_firstname', '$this->emp_lastname', '$this->emp_percent')";

    // Execute the query
    if ($this->conn->query($sql) === TRUE) {
      // New record created successfully
      echo "New record created successfully in employee_details_table <br>";
    } else {
      // Error occurred while inserting the record
      echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
    }
  }

  /**
   * Function to display all records from the tables.
   *
   * @return void
   */
  public function show_all_tables()
  {
    echo "<h2>employee_code_table</h2>";

    // SQL query to select all records from employee_code_table
    $sql = "SELECT * FROM employee_code_table";
    $result = $this->conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {

      // Display results in a table
      while ($row = $result->fetch_assoc()) {
        echo "employee_code: " . $row["employee_code"] . " - employee_code_name: " . $row["employee_code_name"] . " - employee_domain: " . $row["employee_domain"] . "<br>";
      }

    } else {
      // If no results found, display message
      echo "0 results";
    }

    echo "<br>";
    echo "<h2>employee_salary_table</h2>";

    // SQL query to select all records from employee_salary_table
    $sql = "SELECT * FROM employee_salary_table";
    $result = $this->conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {

      // Display results in a table
      while ($row = $result->fetch_assoc()) {
        echo "employee_id: " . $row["employee_id"] . " - employee_salary: " . $row["employee_salary"] . "k - employee_code: " . $row["employee_code"] . "<br>";
      }
    } else {
      // If no results found, display message
      echo "0 results";
    }

    echo "<br>";
    echo "<h2>employee_details_table</h2>";

    // SQL query to select all records from employee_details_table
    $sql = "SELECT * FROM employee_details_table";
    $result = $this->conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {

      // Display results in a table
      while ($row = $result->fetch_assoc()) {
        echo "employee_id: " . $row["employee_id"] . " - employee_firstname: " . $row["employee_firstname"] . " - employee_lastname: " . $row["employee_lastname"] . " - Graduation_percentile: " . $row["Graduation_percentile"] . "%<br>";
      }
    } else {
      // If no results found, display message
      echo "0 results";
    }
    echo "<br>";
  }

  /**
   * Destructor to close the MySQL connection.
   *
   * @return void
   */
  public function __destruct()
  {
    // Close the MySQL connection
    $this->conn->close();
  }
}

/**
 * @var DbInsert $insert Instance of DbInsert class.
 */
$insert = new DbInsert();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Initialize variables with POST data
  $insert->initiliseVariable();

  // Insert data into employee_code_table
  $insert->insertEmployeeCodeTable();

  // Insert data into employee_salary_table
  $insert->insertEmployeeSalaryTable();

  // Insert data into employee_details_table
  $insert->insertEmployeeDetailsTable();

  // Display all records from the tables
  $insert->show_all_tables();

  // Redirect to index.php after 25 seconds
  echo "<br> Redirecting in 25 seconds........... <br>";
  header("Refresh:25; url=index.php");
}
