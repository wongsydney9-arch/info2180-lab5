<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php /*
<ul>
<?php foreach ($results as $row): ?>
<li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
<?php endforeach; ?>
<ul>
*/?>

<?php $country = isset($_GET['country']) ? trim($_GET['country']): '';
$country = filter_var($country, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$found = false;

if($country === ''){
  echo '<ul>';
  foreach($results as $row){
    echo '<li>' . $row['name'] . ' is ruled by ' . $row['head_of_state'] . '</li>';
  }
  echo '</ul>';
} else {
  $qstmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
  $qresults = $qstmt->fetchAll(PDO::FETCH_ASSOC);
  echo '<ul>';
  foreach($qresults as $row){
    echo '<li>' . htmlspecialchars($row['name']) . '</li>';
    $found = true;
  }
  echo '</ul>';

  if(!$found){
  echo '<p>Country not found</p>';
  }
}
?>