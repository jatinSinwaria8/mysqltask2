<?php

/**
 * Queries class to perform various SQL queries on the employee database.
 */
class Queries
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
   * Constructor to establish a connection to the MySQL database.
   *
   * @return void
   */
  public function __construct()
  {
    // Create connection to employee database
    $this->conn = new mysqli("localhost", "jatinSinwaria", "Jatin123!@#", "employee");

    if ($this->conn->connect_error) {
      // If connection fails, display error message
      die("Connection failed: " . $this->conn->connect_error);
    }
  }

  /**
   * Function to execute the Query to list all employee first name with salary greater than 50k.
   *
   * @return void
   */
  public function query1()
  {
    // SQL query
    $sql = "select a.employee_firstname from employee_details_table as a inner join  employee_salary_table as b where a.employee_id = b.employee_id and  b.employee_salary > 50";
    $result = $this->conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {

      // Display results in a table
      echo "<table border='1'>";
      echo "<tr><th>Employee Firstname</th></tr>";

      // Fetch and display each row
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_firstname"] . "</td></tr>";
      }

      echo "</table>";

    } else {
      // If no results found, display message
      echo "No results found.";
    }
  }

  /** 
   * Function to execute the Query to list all employee last name with      graduation percentile greater than 70%.
   * 
   * @return void
   */
  public function query2()
  {
    // SQL query
    $sql = "SELECT employee_lastname from employee_details_table where Graduation_percentile > 70";
    $result = $this->conn->query($sql);

    // Check if there are results 
    if ($result->num_rows > 0) {

      // Display results in a table
      echo "<table border='1'>";
      echo "<tr><th>Employee Lastname</th></tr>";

      // Fetch and display each row
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_lastname"] . "</td></tr>";
      }

      echo "</table>";

    } else {
      // If no results found, display message
      echo "No results found.";
    }
  }

  /** 
   * Function to execute the Query to list all employee code name with graduation percentile less than 70%.
   *
   * @return void
   */
  public function query3()
  {
    // SQL query
    $sql = "SELECT a.employee_code_name from employee_code_table as a INNER JOIN employee_salary_table as b on a.employee_code = b.employee_code INNER JOIN employee_details_table as c on c.employee_id = b.employee_id where Graduation_percentile < 70";
    $result = $this->conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {

      // Display results in a table
      echo "<table border='1'>";
      echo "<tr><th>Employee Code Name</th></tr>";

      // Fetch and display each row
      while ($row = $result->fetch_assoc()) {
        // Display employee code name
        echo "<tr><td>" . $row["employee_code_name"] . "</td></tr>";
      }

      echo "</table>";

    } else {
      // If no results found, display message
      echo "No results found.";
    }
  }

  /** 
   * Function to execute the Query to list all employee full name with domain not equal to Java.
   *
   * @return void
   */
  public function query4()
  {
    // SQL query
    $sql = "SELECT concat(a.employee_firstname,' ',a.employee_lastname) as 'Full Name' from employee_details_table as a INNER JOIN employee_salary_table as b on a.employee_id = b.employee_id INNER     JOIN employee_code_table as c on c.employee_code = b.employee_code where NOT c.employee_domain = 'Java'";

    // Execute the query
    $result = $this->conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {

      // Display results in a table
      echo "<table border='1'>";
      echo "<tr><th>Full Name</th></tr>";

      // Fetch and display each row
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Full Name"] . "</td></tr>";
      }

      echo "</table>";

    } else {
      // If no results found, display message
      echo "No results found.";
    }
  }

  /**
   * Function to execute the Query to list all employee domain and their total salary.
   *
   * @return void
   */
  public function query5()
  {
    // SQL query
    $sql = "SELECT b.employee_domain, SUM(a.employee_salary) as 'Domain Salary' from employee_salary_table as a INNER JOIN employee_code_table as b on a.employee_code = b.employee_code GROUP BY b.employee_domain";

    // Execute the query
    $result = $this->conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {

      // Display results in a table
      echo "<table border='1'>";
      echo "<tr><th>Domain</th><th>Domain Salary</th></tr>";

      // Fetch and display each row
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_domain"] . "</td><td>" . $row["Domain Salary"] . "</td></tr>";
      }

      echo "</table>";

    } else {
      // If no results found, display message
      echo "No results found.";
    }
  }

  /**
   * Function to execute the Query to list all employee domain and their total salary with salary greater than 30k.
   *
   * @return void
   */
  public function query6()
  {
    // SQL query
    $sql = " SELECT b.employee_domain, SUM(a.employee_salary) as 'Domain Salary' from employee_salary_table as a INNER JOIN employee_code_table as b on a.employee_code = b.employee_code WHERE a.employee_salary > 30  GROUP BY b.employee_domain";

    // Execute the query
    $result = $this->conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {

      echo "<table border='1'>";
      echo "<tr><th>Domain</th><th>Domain Salary</th></tr>";

      // Fetch and display each row
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_domain"] . "</td><td>" . $row["Domain Salary"] . "</td></tr>";
      }

      echo "</table>";

    } else {
      // If no results found, display message
      echo "No results found.";
    }
  }

  /** 
   * Function to execute the Query to list all employee id with employee code not assigned.
   *
   * @return void
   */
  public function query7()
  {
    // SQL query
    $sql = "SELECT employee_id from employee_salary_table where employee_code IS NULL";

    // Execute the query
    $result = $this->conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {

      echo "<table border='1'>";
      echo "<tr><th>Employee ID</th></tr>";

      // Fetch and display each row
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["employee_id"] . "</td></tr>";
      }

      echo "</table>";

    } else {
      // If no results found, display message
      echo "No results found.";
    }
  }

  /*
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
 * @var Queries $queries An instance of the Queries class.
 */
$queries = new Queries();

// Displaying All the queries.

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
