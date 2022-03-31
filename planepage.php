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
            ?> <?php echo "Type: "; echo $data->type; ?><br/>
            <?php
            } 
            ?>
            <?php echo "vliegtuigmaatschappij: "; echo $data->vliegmaatschappij;  ?><br/>
            <?php echo "status: "; echo $data->status; ?>
    </div>
      
    
</body>
</html>