<?php include("connection.php"); ?>
<?php
    if(isset($_GET['planningId'])) {
        $planningId = $_GET['planningId'];
        $query = "DELETE FROM planning WHERE vluchtnummer=$planningId";
        $stm = $conn->prepare($query);
        if($stm->execute()) {
            header("Location: deleted.php");
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verwijderd</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body id="deletedPage">
    <div id="messageDiv">
        <h3>Record verwijderd</h3>
        <p>U wordt in 5 seconden teruggestuurd naar de homepagina</p>
        <?php header("Refresh: 5; URL=home.php"); ?>
    </div>

    
</body>
</html>