<?php

class Queries
{

  private $conn;
  private $database = "employee";



  public function __construct()
  {
    $this->conn = new mysqli("localhost", "jatinSinwaria", "Jatin123!@#", "employee");
    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }

  }

  public function query1()
  {
    $sql = "select a.employee_firstname from employee_details_table as a inner join  employee_salary_table as b where a.employee_id = b.employee_id and  b.employee_salary > 50";
    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {

      echo "<table border='1'>";
      echo "<tr><th>Employee Firstname</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_firstname"] . "</td></tr>";
      }
      echo "</table>";

    }
  }

  public function query2()
  {
    $sql = "SELECT employee_lastname from employee_details_table where Graduation_percentile > 70";
    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {

      echo "<table border='1'>";
      echo "<tr><th>Employee Lastname</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_lastname"] . "</td></tr>";
      }
      echo "</table>";

    }
  }

  public function query3()
  {
    $sql = "SELECT a.employee_code_name from employee_code_table as a INNER JOIN employee_salary_table as b on a.employee_code = b.employee_code INNER JOIN employee_details_table as c on c.employee_id = b.employee_id where Graduation_percentile < 70";
    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {
      echo "<table border='1'>";
      echo "<tr><th>Employee Code Name</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_code_name"] . "</td></tr>";
      }
      echo "</table>";
    }
  }

  public function query4()
  {
    $sql = "SELECT concat(a.employee_firstname,' ',a.employee_lastname) as 'Full Name' from employee_details_table as a INNER JOIN employee_salary_table as b on a.employee_id = b.employee_id INNER     JOIN employee_code_table as c on c.employee_code = b.employee_code where NOT c.employee_domain = 'Java'";

    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {
      echo "<table border='1'>";
      echo "<tr><th>Full Name</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Full Name"] . "</td></tr>";
      }
      echo "</table>";
    }
  }

  public function query5()
  {
    $sql = "SELECT b.employee_domain, SUM(a.employee_salary) as 'Domain Salary' from employee_salary_table as a INNER JOIN employee_code_table as b on a.employee_code = b.employee_code GROUP BY b.employee_domain";

    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {
      echo "<table border='1'>";
      echo "<tr><th>Domain</th><th>Domain Salary</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_domain"] . "</td><td>" . $row["Domain Salary"] . "</td></tr>";
      }
      echo "</table>";
    }

  }

  public function query6()
  {
    $sql = " SELECT b.employee_domain, SUM(a.employee_salary) as 'Domain Salary' from employee_salary_table as a INNER JOIN employee_code_table as b on a.employee_code = b.employee_code WHERE a.employee_salary > 30  GROUP BY b.employee_domain";
    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {
      echo "<table border='1'>";
      echo "<tr><th>Domain</th><th>Domain Salary</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_domain"] . "</td><td>" . $row["Domain Salary"] . "</td></tr>";
      }
      echo "</table>";
    }
  }
  public function query7()
  {
    $sql = "SELECT employee_id from employee_salary_table where employee_code IS NULL";
    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {
      echo "<table border='1'>";
      echo "<tr><th>Employee ID</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_id"] . "</td></tr>";
      }
      echo "</table>";
    } else {
      echo "No results found.";
    }
  }


  public function __destruct()
  {
    $this->conn->close();
  }
}

$queries = new Queries();

echo "<h3>Query to list all employee first name with salary greater than 50k.</h3>";
$queries->query1();

echo "<h3>Query to list all employee last name with graduation percentile greater than 70%.</h3>";
$queries->query2();

echo "<h3>Query to list all employee code name with graduation percentile less than 70%.</h3>";
$queries->query3();

echo "<h3>Query to list all employee full name with domain not equal to Java.</h3>";
$queries->query4();

echo "<h3>Query to list all employee domain and their total salary.</h3>";
$queries->query5();

echo "<h3>Query to list all employee domain and their total salary with salary greater than 30k.</h3>";
$queries->query6();

echo "<h3>Query to list all employee id with employee code not assigned.</h3>";
$queries->query7();
?>