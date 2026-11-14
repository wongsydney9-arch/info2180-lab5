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
$lookup = isset($_GET['lookup']) ? trim($_GET['lookup']): '';
$csearch = false;
$country = filter_var($country, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$found = false;
echo '<table>';

if ($lookup === ''){
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
      $found = true;
    }
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
  } 
} else {
  echo '<thead><tr>
  <th>Name</th>
  <th>District</th>
  <th>Population</th>
  <tr></thead>';

  if($country === ''){
    ob_end_clean();
    echo '<h4>Please enter country to find cities</h4>';
    $found = true;
  } else {
    $cstmt = $conn -> query("SELECT cities.*, countries.name AS country_name FROM cities
    INNER JOIN countries ON cities.country_code = countries.code WHERE countries.name LIKE '%$country%'");
    $cresults = $cstmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($cresults as $row){
      echo '<tr>
      <td>' . $row['name'] . '</td>
      <td>' . $row['district'] .'</td>
      <td>' . $row['population'] .'</td>
      </tr>';
      $found = true;
    }
  }
}
echo '</table>';

  if(!$found){
    ob_end_clean();
    echo '<h4>Country not found</h4>';
  }
?>