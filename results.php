
<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include 'databasecon.php';


// Fetch all survey responses
$result = $conn->query("SELECT * FROM tbsurvey");
$total_surveys = $result->num_rows;

// Initialize variables
$total_age = 0;
$ages = [];
$pizza_count = 0;
$pasta_count = 0;
$pap_count = 0;

$total_eat_out = 0;
$total_movies = 0;
$total_radio = 0;
$total_tv = 0;

if ($total_surveys > 0) {
    while ($row = $result->fetch_assoc()) {
        // Calculate age
        $dob = new DateTime($row['dob']);
        $today = new DateTime();
        $age = $today->diff($dob)->y;
        $total_age += $age;
        $ages[] = $age;

        
        // Food preferences
$foods = array_map('trim', explode(',', strtolower($row['food'])));
if (in_array('pizza', $foods)) $pizza_count++;
if (in_array('pasta', $foods)) $pasta_count++;
if (in_array('pap and wors', $foods)) $pap_count++;

        // Ratings
        $total_eat_out += $row['eat_out'];
        $total_movies += $row['watch_movies'];
        $total_radio += $row['listen_radio'];
        $total_tv += $row['watch_tv'];
    }

    // Calculate statistics
    $avg_age = round($total_age / $total_surveys, 1);
    $oldest = max($ages);
    $youngest = min($ages);

    $pizza_percent = round(($pizza_count / $total_surveys) * 100, 1);
    $pasta_percent = round(($pasta_count / $total_surveys) * 100, 1);
    $pap_percent = round(($pap_count / $total_surveys) * 100, 1);

    $avg_eat_out = round($total_eat_out / $total_surveys, 1);
    $avg_movies = round($total_movies / $total_surveys, 1);
    $avg_radio = round($total_radio / $total_surveys, 1);
    $avg_tv = round($total_tv / $total_surveys, 1);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Survey Results</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <header>
      <div class="menu">_Surveys</div>
      <nav>
        <a href="index.html">FILL OUT SURVEY</a>
        <a href="results.php" class="active">VIEW SURVEY RESULTS</a>
      </nav>
    </header>

    <main>
      <h2>Survey Results</h2>
      <!-- Display if no surveys -->
      <!-- <p class="no-data">No Surveys Available.</p> -->

      <!-- Display if data is available -->
       <?php if ($total_surveys > 0): ?>
        <!-- show table with results -->
      <div class="results">
        <p>Total number of surveys: <span>#surveys</span> <strong><?= $total_surveys ?></p>
        <p>Average Age: <span>#average age</span><strong><?= $avg_age ?></strong></p>
        <p>Oldest person who participated in survey: <span>#max age</span><strong><?= $oldest ?></strong></p>
        <p>Youngest person who participated in survey: <span>#min age</span><strong><?= $youngest ?></strong></p>

        <p>Percentage of people who like Pizza: <span># % Pizza</span><strong><?= $pizza_percent ?>%</strong></p>
        <p>Percentage of people who like Pasta: <span># % Pasta</span><strong><?= $pasta_percent ?>%</strong></p>
        <p>Percentage of people who like Pap and Wors: <span># % Pap and Wors</span><strong><?= $pap_percent ?>%</strong></p>

        <p>People who like to watch movies: <span>#average of rating</span><strong><?= $avg_movies ?></strong></p>
        <p>People who like to listen to radio: <span>#average of rating</span><strong><?= $avg_radio ?></strong></p>
        <p>People who like to eat out: <span>#average of rating</span><strong><?= $avg_eat_out ?></strong></p>
        <p>People who like to watch TV: <span>#average of rating</span><strong><?= $avg_tv ?></strong></p>
      </div>
      <?php else: ?>
        <p style="color: red;"><strong>No surveys available.</p></strong>
    <?php endif; ?>
    </main>
  </div>
</body>
</html>
<?php $conn->close(); ?>




