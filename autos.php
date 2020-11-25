<?php
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}
require_once "pdo.php";
$failure = false;
if ( isset($_POST['make']) && isset($_POST['year']) 
     && isset($_POST['mileage'])) {
	 $make=$_POST['make'];
	 $year=$_POST['year'];
	 $mileage=$_POST['mileage'];
	 if((!is_numeric($year) || !is_numeric($mileage)))
	 {
	 $failure="Mileage and year must be numeric";
	 }
	 elseif(strlen($make)<1)
	 {
	 $failure="Make is required";
	 }
	 elseif(is_numeric($year) && is_numeric($mileage) && strlen($make)>1){
    $sql = "INSERT INTO autos (make, year, mileage) 
              VALUES (:make, :year, :mileage)";
    //echo("<pre>\n".$sql."\n</pre>\n");
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage']));
		}
}

$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<script type="text/javascript">
    function msg()
    {
    location.replace("index.php")
    }
</script>
<!DOCTYPE html>
<html>
<head>
<title>Syed Tanveer Islam's Automobile Tracker</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo $_REQUEST['name']?></h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="button" name="logout" value="Logout" onclick="msg()">
</form>

<h2>Automobiles</h2>
<head></head><body><table border="1">
<?php
foreach ( $rows as $row ) {
    echo "<tr><td>";
    echo($row['make']);
    echo("</td><td>");
    echo($row['year']);
    echo("</td><td>");
    echo($row['mileage']);
    echo("</td></tr>\n");
}
?>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>