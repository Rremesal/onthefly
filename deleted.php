<?php include("connection.php"); ?>
<?php
    //als er een 'planningId' is meegegeven aan de url wordt de planning met dit 'planningId' verwijderd
    //en wordt er genavigeerd naar 'deleted.php'
    if(isset($_GET['planningId'])) {
        $planningId = $_GET['planningId'];
        $query = "DELETE FROM planning WHERE vluchtnummer=$planningId";
        $stm = $conn->prepare($query);
        if($stm->execute()) {
            header("Location: deleted.php");
        }
    //anders als er een 'vliegtuigId' is meegegeven aan de url wordt de planning met dit 'planningId' verwijderd
    //en wordt er genavigeerd naar 'deleted.php'
    } else if(isset($_GET['vliegtuigId'])) {
        $vliegtuigId = $_GET['vliegtuigId'];
        $query = "DELETE FROM vliegtuigen WHERE vliegtuignummer=$vliegtuigId";
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
<!-- een div met een bericht dat de gegevens succesvol zijn verwijderd. Na 5 seconden op deze pagina word
je teruggestuurd naar de homepagina -->
<body id="deletedPage">
    <div id="messageDiv">
        <h3>Record verwijderd</h3>
        <p>U wordt in 1 seconden teruggestuurd naar de homepagina.</p>
        <?php header("Refresh: 1; URL=home.php"); ?>
    </div>

    
</body>
</html>