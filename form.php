<?php

class DbInsert
{

  private $conn;
  private $database = "employee";

  private $emp_id = "";
  private $emp_firstname = "";
  private $emp_lastname = "";
  private $emp_code = "";
  private $emp_code_name = "";
  private $emp_domain = "";
  private $emp_salary = "";
  private $emp_percent = "";

  public function __construct()
  {
    $this->conn = new mysqli("localhost", "jatinSinwaria", "Jatin123!@#");

    $sql = "CREATE DATABASE IF NOT EXISTS $this->database";
    $this->conn->query($sql);
    $this->conn->select_db($this->database);
  }

  public function initiliseVariable()
  {
    $this->emp_id = $_POST['emp_id'];
    $this->emp_firstname = $_POST['emp_firstname'];
    $this->emp_lastname = $_POST['emp_lastname'];
    $this->emp_code = $_POST['emp_code'];
    $this->emp_code_name = $_POST['emp_code_name'];
    $this->emp_domain = $_POST['emp_domain'];
    $this->emp_salary = (int) $_POST['emp_salary'];
    $this->emp_percent = (int) $_POST['emp_percent'];
  }

  public function insertEmployeeCodeTable()
  {
    $sql = "CREATE TABLE IF NOT EXISTS employee_code_table (
      employee_code VARCHAR(50) NOT NULL,
      employee_code_name VARCHAR(50) NOT NULL,
      employee_domain VARCHAR(50) NOT NULL,
      primary key (employee_code)      
    )";
    $this->conn->query($sql);

    $sql = "SELECT employee_code FROM employee_code_table WHERE employee_code = '$this->emp_code'";
    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {
      echo "Employee Code already exists in employee_code_table <br>";
      return;
    }

    $sql = "INSERT INTO employee_code_table (employee_code, employee_code_name, employee_domain) VALUES ('$this->emp_code', '$this->emp_code_name', '$this->emp_domain')";

    if ($this->conn->query($sql) === TRUE) {
      echo "New record created successfully in employee_code_table <br>";
    } else {
      echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
    }

  }

  public function insertEmployeeSalaryTable()
  {
    $sql = "CREATE TABLE IF NOT EXISTS employee_salary_table (
      employee_id VARCHAR(50),
      employee_salary INT,
      employee_code VARCHAR(50),
      primary key (employee_id),
      foreign key (employee_code) references employee_code_table(employee_code)
    )";
    $this->conn->query($sql);

    $sql = "SELECT employee_id FROM employee_salary_table WHERE employee_id = '$this->emp_id'";
    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {
      echo "Employee ID already exists in employee_salary_table <br>";
      return;
    }

    $sql = "INSERT INTO employee_salary_table (employee_id, employee_salary, employee_code) VALUES ('$this->emp_id', '$this->emp_salary', '$this->emp_code')";
    if ($this->conn->query($sql) === TRUE) {
      echo "New record created successfully in employee_salary_table <br>";
    } else {
      echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
    }
  }

  public function insertEmployeeDetailsTable()
  {
    $sql = "CREATE TABLE IF NOT EXISTS employee_details_table (
      employee_id VARCHAR(50),
      employee_firstname VARCHAR(50),
      employee_lastname VARCHAR(50),
      Graduation_percentile INT,
      primary key (employee_id)
    )";
    $this->conn->query($sql);

    $sql = "SELECT employee_id FROM employee_details_table WHERE employee_id = '$this->emp_id'";
    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {
      echo "Employee ID already exists in employee_details_table <br>";
      return;
    }

    $sql = "INSERT INTO employee_details_table (employee_id, employee_firstname, employee_lastname, Graduation_percentile) VALUES ('$this->emp_id', '$this->emp_firstname', '$this->emp_lastname', '$this->emp_percent')";
    if ($this->conn->query($sql) === TRUE) {
      echo "New record created successfully in employee_details_table <br>";
    } else {
      echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
    }

  }

  public function show_all_tables()
  {
    echo "<h2>employee_code_table</h2>";
    $sql = "SELECT * FROM employee_code_table";
    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "employee_code: " . $row["employee_code"] . " - employee_code_name: " . $row["employee_code_name"] . " - employee_domain: " . $row["employee_domain"] . "<br>";
      }
    } else {
      echo "0 results";
    }
    echo "<br>";

    echo "<h2>employee_salary_table</h2>";
    $sql = "SELECT * FROM employee_salary_table";
    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "employee_id: " . $row["employee_id"] . " - employee_salary: " . $row["employee_salary"] . "k - employee_code: " . $row["employee_code"] . "<br>";
      }
    } else {
      echo "0 results";
    }
    echo "<br>";

    echo "<h2>employee_details_table</h2>";
    $sql = "SELECT * FROM employee_details_table";
    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "employee_id: " . $row["employee_id"] . " - employee_firstname: " . $row["employee_firstname"] . " - employee_lastname: " . $row["employee_lastname"] . " - Graduation_percentile: " . $row["Graduation_percentile"] . "%<br>";
      }
    } else {
      echo "0 results";
    }
    echo "<br>";
  }

  public function __destruct()
  {
    $this->conn->close();
  }
}

$insert = new DbInsert();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $insert->initiliseVariable();
  $insert->insertEmployeeCodeTable();
  $insert->insertEmployeeSalaryTable();
  $insert->insertEmployeeDetailsTable();
  $insert->show_all_tables();


  echo "<br> Redirecting in 25 seconds........... <br>";
  header("Refresh:10; url=index.php");
}

?>