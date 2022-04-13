<?php include("connection.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <?php require("menu.php");?>
    <div id="bodyDiv">
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
                

                if(isset($_POST['btnSubmit']) && $_POST['radioActive'] == "actieve vliegtuigen" ) {
                    $query = "SELECT * FROM vliegtuigen WHERE status='ACTIVE'";
                    $stm = $conn->prepare($query);
                    if($stm->execute()) {
                        while ($rows=$stm->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>". 
                            "<td>".$rows['type']."</td>".
                            "<td>".$rows['vliegmaatschappij']."</td>".
                            "<td>".$rows['status']."</td>".
                            "<td>"."<a href='home.php?id=".$rows['vliegtuignummer']."'>wijzig</a></td>".
                            "<td>"."<a href='planepage.php?id=".$rows['vliegtuignummer']."'>details</a></td>".
                            "<td>"."<a href='planning.php?id=".$rows['vliegtuignummer']."'>planning</a>".
                            "</tr>";
                        }
                    } else echo "ophalen van vliegtuigdata mislukt";
                } else if(isset($_POST['btnSubmit']) && $_POST['radioActive'] == "alles tonen" ) {
                        $query = "SELECT * FROM vliegtuigen";
                        $stm = $conn->prepare($query);
                        if($stm->execute()) {
                            while ($rows=$stm->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>". 
                                "<td>".$rows['type']."</td>".
                                "<td>".$rows['vliegmaatschappij']."</td>".
                                "<td>".$rows['status']."</td>".
                                "<td>"."<a href='home.php?id=".$rows['vliegtuignummer']."'>wijzig</a></td>".
                                "<td>"."<a href='planepage.php?id=".$rows['vliegtuignummer']."'>details</a></td>".
                                "<td>"."<a href='planning.php?id=".$rows['vliegtuignummer']."'>planning</a>".
                                "</tr>";
                            }
                        } else echo "ophalen van vliegtuigdata mislukt";
                } else {
                    $query = "SELECT * FROM vliegtuigen";
                        $stm = $conn->prepare($query);
                        if($stm->execute()) {
                            while ($rows=$stm->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>". 
                                "<td>".$rows['type']."</td>".
                                "<td>".$rows['vliegmaatschappij']."</td>".
                                "<td>".$rows['status']."</td>".
                                "<td>"."<a href='home.php?id=".$rows['vliegtuignummer']."'>wijzig</a></td>".
                                "<td>"."<a href='planepage.php?id=".$rows['vliegtuignummer']."'>details</a></td>".
                                "<td>"."<a href='planning.php?id=".$rows['vliegtuignummer']."'>planning</a>".
                                "</tr>";
                            }
                        } else echo "ophalen van vliegtuigdata mislukt";
                }
                

            ?>
        </table>
    </div>
    
</body>
</html>