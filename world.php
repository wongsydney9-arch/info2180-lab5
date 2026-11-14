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
echo '<table>';
echo '<thead><tr>
  <th>Name</th>
  <th>Continent</th>
  <th>Independence</th>
  <th>Head of State</th>
  <tr></thead>';
if($country === ''){
  foreach($results as $row){
    echo '<tr>
    <td>' . $row['name'] . '</td>
    <td>' . $row['continent'] .'</td>
    <td>' . $row['independence_year'] .'</td>
    <td>' . $row['head_of_state'] .'</td>
    </tr>';
  }
  echo '</table>';
} else {
  $qstmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
  $qresults = $qstmt->fetchAll(PDO::FETCH_ASSOC);
  foreach($qresults as $row){
    echo '<tr>
    <td>' . $row['name'] . '</td>
    <td>' . $row['continent'] .'</td>
    <td>' . $row['independence_year'] .'</td>
    <td>' . $row['head_of_state'] .'</td>
    </tr>';
    $found = true;
  }
  echo '</table>';

  if(!$found){
  ob_end_clean();
  echo '<p>Country not found</p>';
  }
}
?>