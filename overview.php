<?php include("connection.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Overzicht</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <?php require("menu.php");?>
        <div class="bodyDiv">
            <!-- form met sorteer opties  -->
            <form class="tools" method="POST">
                <label><input type="radio" value="actieve vliegtuigen" name="radioActive"/>alleen actieve vliegtuigen</label><br/>
                <label><input type="radio" value="alles tonen" name="radioActive"/>alles tonen</label><br/>
                <br/>
                <input type="submit" name="btnSubmit"/>
            </form>
        
        
            <table>
                <th>Type</th>
                <th>Vliegmaatschappij</th>
                <th>Status</th>


                <?php 
                    
                    // als op de knop gedrukt wordt en de radioknop op 'actieve vliegtuigen' staat worden alleen
                    //de gegevens van de actieve vliegtuigen getoond in een 'table data (td) cel
                    if(isset($_POST['btnSubmit']) && $_POST['radioActive'] == "actieve vliegtuigen" ) {
                        $query = "SELECT * FROM vliegtuigen WHERE status='ACTIVE'";
                        $stm = $conn->prepare($query);
                        if($stm->execute()) {
                            $data = $stm->fetchAll(PDO::FETCH_OBJ);
                            foreach($data as $rows) {
                                echo "<tr>". 
                                "<td>".$rows->type."</td>".
                                "<td>".$rows->vliegmaatschappij."</td>".
                                "<td>".$rows->status."</td>".
                                "<td>"."<a href='home.php?id=".$rows->vliegtuignummer."'>wijzig</a></td>".
                                "<td>"."<a href='planning.php?id=".$rows->vliegtuignummer."'>planning</a>".
                                "<td>"."<a href='deleted.php?vliegtuigId=".$rows->vliegtuignummer."'>verwijderen</a>".
                                "</tr>";
                            }
                        } else echo "ophalen van vliegtuigdata mislukt";
                    // als op de knop gedrukt wordt en de radioknop op 'alles tonen' staat worden alle
                    // gegevens getoond in een 'table data (td) cel
                    } else if(isset($_POST['btnSubmit']) && $_POST['radioActive'] == "alles tonen" ) {
                            $query = "SELECT * FROM vliegtuigen";
                            $stm = $conn->prepare($query);
                            if($stm->execute()) {
                                $data = $stm->fetchAll(PDO::FETCH_OBJ);
                                foreach($data as $rows) {
                                    echo "<tr>". 
                                    "<td>".$rows->type."</td>".
                                    "<td>".$rows->vliegmaatschappij."</td>".
                                    "<td>".$rows->status."</td>".
                                    "<td>"."<a href='home.php?id=".$rows->vliegtuignummer."'>wijzig</a></td>".
                                    "<td>"."<a href='planning.php?id=".$rows->vliegtuignummer."'>planning</a>".
                                    "<td>"."<a href='deleted.php?vliegtuigId=".$rows->vliegtuignummer."'>verwijderen</a>".
                                    "</tr>";
                                }
                            } else echo "ophalen van vliegtuigdata mislukt";
                    } else {
                        //als geen interactie is geweest met de pagina (er nog op geen knop of dergelijken gedrukt)
                        //dan worden alle gegevens in een tabel getoond
                        $query = "SELECT * FROM vliegtuigen";
                            $stm = $conn->prepare($query);
                            if($stm->execute()) {
                                $data = $stm->fetchAll(PDO::FETCH_OBJ);
                                foreach($data as $rows) {
                                    echo "<tr>". 
                                    "<td>".$rows->type."</td>".
                                    "<td>".$rows->vliegmaatschappij."</td>".
                                    "<td>".$rows->status."</td>".
                                    "<td>"."<a href='home.php?id=".$rows->vliegtuignummer."'>wijzig</a></td>".
                                    "<td>"."<a href='planning.php?id=".$rows->vliegtuignummer."'>planning</a>".
                                    "<td>"."<a href='deleted.php?vliegtuigId=".$rows->vliegtuignummer."'>verwijderen</a>".

                                    "</tr>";
                                }
                            } else echo "ophalen van vliegtuigdata mislukt";
                    }
                    

                ?>
            </table>
            <!-- een div voor de achtergrond-afbeelding -->
        </div>
        <div class="imageDiv">
        </div>
    
</body>
</html>