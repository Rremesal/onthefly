<?php include("connection.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <?php require("menu.php");?>
    
    <table>
        <th>Type</th>
        <th>Vliegmaatschappij</th>
        <th>Status</th>


        <?php 
            $query = "SELECT * FROM vliegtuigen";
            $stm = $conn->prepare($query);
            if($stm->execute()) {
                while ($rows=$stm->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>". 
                    "<td>".$rows['type']."</td>".
                    "<td>".$rows['vliegmaatschappij']."</td>".
                    "<td>".$rows['status']."</td>".
                    "<td>"."<a href='home.php?id=".$rows['vliegtuignummer']."'>wijzig</a> <a href='planepage.php?id=".$rows['vliegtuignummer']."'>details</a></td>";
                    "</tr>";
                }
            } else echo "ophalen van vliegtuigdata mislukt";

            

        ?>
    </table>
    
</body>
</html>