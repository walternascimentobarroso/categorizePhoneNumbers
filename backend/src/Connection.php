<?php

namespace App;

/**
 * SQLite connnection
 */
class Connection
{
  /**
   * PDO instance
   * @var type
   */
  private $pdo;

  /**
   * return in instance of the PDO object that connects to the SQLite database
   * @return \PDO
   */
  public function __construct()
  {
    try {
      if ($this->pdo == null) {
        $this->pdo = new \PDO("sqlite:" . Config::DB_HOST);
      }
      return $this->pdo;
    } catch (PDOException $e) {
      print "Error in openhrsedb " . $e->getMessage();
    }
  }

  public function getAll()
  {
    $stmt = $this->pdo->query("SELECT * FROM customer");
    $data = [];
    $i = 0;
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      $data[$i]["id"] = $row["id"];
      $data[$i]["phone"] = $row["phone"];
      $data[$i]["valid"] = $this->phoneValidate($row["phone"]);
      $i++;
    }

    return $data;
  }

  function phoneValidate($phone)
  {
    $pattern = "/9[1236][0-9]{7}|2[1-9][0-9]{7}/";
    if (preg_match($pattern, $phone) == false) {
      return false;
    }
    return true;
  }
}
