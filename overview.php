<?php include("connection.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="css.css"/>
</head>
<body>
    <a href="overview.php">overzicht vliegtuigen</a>
    <a href="home.php">home</a>
    
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
                    "<td>"."<a href='home.php?id=".$rows['vliegtuignummer']."'>wijzig</a>"."</td>";
                    "</tr>";
                }
            } else echo "ophalen van vliegtuigdata mislukt";

            

        ?>
    </table>
    
</body>
</html>