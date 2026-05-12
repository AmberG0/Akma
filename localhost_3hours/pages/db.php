<?

session_start();

$servername = "localhost";
$dbname = "Net";
$user = "root";
$password = "";

$pdo = new PDO("mysql: host = $servername, dbname = $dbname", $user, $password);
$pdo -> setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);

?>