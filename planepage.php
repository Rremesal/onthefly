<?php include("connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vliegtuigdetails</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require("menu.php");?>
    <div id="detailDiv">
        <?php
            $planeId = $_GET['id'];
            $query = "SELECT * FROM vliegtuigen WHERE vliegtuignummer=$planeId";
            $stm = $conn->prepare($query);
            if($stm->execute()) {
                $data = $stm->fetch(PDO::FETCH_OBJ);
            ?>  <h2><?php echo $data->type; ?></h2>
            <?php
            } 
            ?>
    </div>
      
    
</body>
</html>