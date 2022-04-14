<?php include("connection.php"); ?>

<?php 
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <?php require("menu.php"); ?>
    <div class="bodyDiv">
    <?php 
    // alleen als er geen id wordt meegegeven aan de url wordt deze 'form' getoond (dus als de pagina direct wordt)
    //benaderd
        if(!isset($_GET['id'])) {
    ?>
        <form class="tools" method="POST">
            planning zien van: <input type="date" name="dateInput" min="<?php echo date("Y-m-d")?>" max="2023-01-01"/>
            <br/>
            <br/>
            <input type="submit" name="btnSubmit"/>
        </form>
    <?php } ?>

    <?php 
        //als er op de knop in het 'form' gedrukt wordt worden alleen de planningen op de ingevoerde dag getoond
        if(isset($_POST['btnSubmit'])) {
            $dateInputted = $_POST['dateInput'];
            $query = "SELECT * FROM planning WHERE vertrekdatum='$dateInputted'";
            $stm = $conn->prepare($query);
            if($stm->execute()) {
                $data = $stm->fetchAll(PDO::FETCH_OBJ);
                foreach($data as $plane) {
                    echo "<tr>". 
                    "<td>".$plane->vliegtuignummer."</td>". 
                    "<td>".$plane->vertrekdatum."</td>". 
                    "<td>".$plane->retourdatum."</td>". 
                    "<td>".$plane->bestemming."</td>". 
                    "<td>".$plane->status."</td>".
                    "</tr>";
                }
            }
        }

    ?>
        <table>
            <th>Vliegtuignummer</th>
            <th>Vertrekdatum</th>
            <th>Retourdatum</th>
            <th>Bestemming</th>
            <th>Status</th>
            
            <?php
            //als er een 'id' is meegegeven aan de url worden alleen de planningen van het vliegtuig met dat 'id'
            //getoond
                if(isset($_GET['id'])) {
                    $planeId = $_GET['id'];
                    $queryVliegtuig = "SELECT * FROM vliegtuigen WHERE vliegtuignummer=$planeId";
                    $stm = $conn->prepare($queryVliegtuig);
                    $stm->execute();
                    $dataVliegtuig = $stm->fetch(PDO::FETCH_OBJ);  
                    echo "<div style='color: yellowgreen; margin-left: 200px; margin-top: 40px'>"."Type: ".$dataVliegtuig->type."</div>"."<br/>";
                    echo "<div style='color: yellowgreen; margin-left: 200px';>"."Vliegtuigmaatschappij: ".$dataVliegtuig->vliegmaatschappij."</div>"."<br/>";
                    echo "<div style='color: yellowgreen; margin-left: 200px; margin-bottom: 20px'>"."Status: ".$dataVliegtuig->status."</div>";   
                    
                    $query = "SELECT * FROM planning WHERE vliegtuignummer=$planeId";
                    $stm = $conn->prepare($query);
                    if($stm->execute()) {
                        $data = $stm->fetchAll(PDO::FETCH_OBJ);
                            foreach($data as $rows) {
                                echo "<tr>". 
                                "<td>".$rows->vliegtuignummer."</td>". 
                                "<td>".$rows->vertrekdatum."</td>". 
                                "<td>".$rows->retourdatum."</td>". 
                                "<td>".$rows->bestemming."</td>". 
                                "<td>".$rows->status."</td>".
                                "<td>"."<a href='home.php?id=$planeId&pid=$rows->vluchtnummer'>Wijzigen</a>"."</td>";
                                "</tr>";
                            }
                       
                    } else echo "kon data niet ophalen";
                } else {
                    //als er geen id is meegegeven aan de url worden alle planningen getoond
                    $query = "SELECT * FROM planning";
                    $stm = $conn->prepare($query);
                    if($stm->execute()) {
                        $data =$stm->fetchAll(PDO::FETCH_OBJ);
                        foreach($data as $rows) {
                            echo "<tr>". 
                            "<td>".$rows->vliegtuignummer."</td>".
                            "<td>".$rows->vertrekdatum."</td>". 
                            "<td>".$rows->retourdatum."</td>". 
                            "<td>".$rows->bestemming."</td>". 
                            "<td>".$rows->status."</td>". 
                            "<td>"."<a href='deleted.php?planningId=".$rows->vluchtnummer."'>Verwijderen</a>"."</td>";  
                            "</tr>";
                        }
                    }
                }
            ?>
        </table>
        <?php 
            

        ?>
    <!-- een div voor de achtergrond-afbeelding -->
    </div>
    <div class="imageDiv">
    </div>
    
</body>
</html>