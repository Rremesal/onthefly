<?php include("connection.php"); ?>
<!-- kijkt of er een 'id' is meegegeven aan de url als dit zo is worden twee queries uitgevoerd 
om de data uit beide tabellen kunt halen. Als er geen 'id' is meegegeven wordt er een variabele 'datePlanning'
aangemaakt die leeg is -->
<?php
    if(isset($_GET['id'])) {
        $planeId = $_GET['id'];

        $queryPlane = "SELECT * FROM vliegtuigen WHERE vliegtuignummer = $planeId";
        $stm = $conn->prepare($queryPlane);
        if ($stm->execute()) {
            $data = $stm->fetch(PDO::FETCH_OBJ);
        } else echo "ophalen van data vliegtuig mislukt";

        $queryPlanning = "SELECT * FROM planning WHERE vliegtuignummer = $planeId";
        $stm = $conn->prepare($queryPlanning);
        if($stm->execute()) {
            $dataPlanning = $stm->fetch(PDO::FETCH_OBJ);
        } else echo "ophalen van data planning mislukt"; 
    //als zowel een 'id' als een 'pid' (id van planning tabel) zijn meegegeven aan de url, dan wordt een query 
    //uitgevoerd die records oplevert die zowel dit 'id' als 'pid' hebben
    } else if (isset($_GET['id']) && isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $planeId = $_GET['id'];
            $queryPlanning = "SELECT * FROM planning WHERE vliegtuignummer=$planeId AND vluchtnummer=$pid";
            $stm = $conn->prepare($queryPlanning);
            if($stm->execute()) {
                $dataPlanning = $stm->fetch(PDO::FETCH_OBJ);
            } else echo "ophalen van data planning mislukt"; 
    
    } else $dataPlanning = "";

?> 
    
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <?php require("menu.php");?>

    <div id="banner">
        <img src="background.png"/>
        <h1>Welkom</h1>
    </div>

    <div class="flexcontainer">
        

    
        <div id="toevoegDiv">
            <h2>Vliegtuigen</h2>
        <!-- als de 'data' variabele bestaat en waardes bevat wordt deze data automatisch ingevoerd in de input-velden, anders blijven deze leeg -->
            <form method="POST" class="form">
                <label>Type <input type="text" name="txtType" id="inputType" value="<?php if(isset($data)) echo $data->type; ?>"/></label><br/>
                <label>Vliegtuigmaatschappij <input type="text" name="txtVliegtuigMa" id="inputVliegtuigMa" value="<?php if(isset($data)) echo $data->vliegmaatschappij; ?>"/></label><br/>
                <label>Status </label>
                <select id="statusDropDown" name="selStatus" value="<?php if(isset($data)) echo $data->status; ?>">
                    <option <?php if(isset($data)) if($data->status == "") echo "selected ";?> value="-"></option>
                    <option <?php if(isset($data)) if($data->status == "NOT IN OPERATION") echo "selected ";?>value="NOT IN OPERATION">IN PRODUCTION</option>
                    <option <?php if(isset($data)) if($data->status == "READY FOR USE") echo "selected ";?>value="READY FOR USE">READY FOR USE</option>
                    <option <?php if(isset($data)) if($data->status == "ACTIVE") echo "selected ";?>value="ACTIVE">ACTIVE</option>
                </select>
                <br/>
                <br/>
                <input type="submit" value=<?php if(isset($_GET['id'])) echo "Wijzigen"; else echo "Toevoegen";?>  name="btnSubmit" id="btnSubmit"/>
            </form>
        <?php 
        // als er een 'id' in de url-balk staat en op de knop gedrukt wordt, wordt er een update query uitgevoerd
        if(isset($_GET['id']) && isset($_POST['btnSubmit'])) {
            $type = $_POST['txtType'];
            $vliegtuigmaatschappij = $_POST['txtVliegtuigMa'];
            $status = $_POST['selStatus'];

            $query = "UPDATE vliegtuigen SET type='$type',vliegmaatschappij='$vliegtuigmaatschappij',status='$status' WHERE vliegtuignummer=$planeId";
            $stm = $conn->prepare($query);
            if($stm->execute()) {
                echo "info geupdatet";
                echo "</div>";
            }  
        //als er geen 'id' in de url-balk staat wordt er een insert query uitgevoerd
        } else if((!isset($_GET['id']) && (isset($_POST['btnSubmit'])))) {
            $type = $_POST['txtType'];
            $vliegtuigmaatschappij = $_POST['txtVliegtuigMa'];
            $status = $_POST['selStatus'];

            $query = "INSERT INTO vliegtuigen (type,vliegmaatschappij,status) VALUES ('$type','$vliegtuigmaatschappij','$status')";
            $stm = $conn->prepare($query);
            if($stm->execute()) {
                echo "<br/>"."<br/>";
                echo "vliegtuig opgeslagen";
                echo "</div>";
            } else {
                echo "fout met het uploaden van de data";
                echo "</div>";
            } 
        } else {
            echo "</div>";
        }
    ?>
            
        
        <div id="toevoegDivPlanning">
            <h2>Planning</h2>
        <!-- als de 'data' variabele bestaat en waardes bevat wordt deze data automatisch ingevoerd in de input-velden, anders blijven deze leeg -->
            <form method="POST" class="form">
                <label>Vliegtuignummer 
                    <select name="ddVliegtuigNummer" id="dropdownVliegtuigNummer"> 
                        <?php 
                            $query = "SELECT vliegtuignummer,type FROM vliegtuigen";
                            $stm = $conn->prepare($query);
                            if($stm->execute()) {
                                $data = $stm->fetchAll(PDO::FETCH_OBJ);
                                foreach($data as $plane) {
                                    echo "<option value='".$plane->vliegtuignummer."'>".$plane->vliegtuignummer." - ".$plane->type."</option>";
                                }
                            }
                        ?>
                    </select>
                    <br/>
                    <label>Bestemming <input type="text" name="txtDestination" id="inputDestination" value="<?php if($dataPlanning == "") echo ""; else echo $dataPlanning->bestemming; ?>"/></label><br/>
                    <label>Vertrekdatum <input type="date" name="dateDepartureDate" id="inputDepartureDate" value="<?php if($dataPlanning == "") echo ""; else echo $dataPlanning->vertrekdatum; ?>"/></label><br/>
                    <label>Retourdatum <input type="date" name="dateRetourDate" id="inputRetourDate" value="<?php if($dataPlanning == "") echo ""; else echo $dataPlanning->retourdatum;?>"/></label><br/>
                    <label>Status </label>
                    <select id="statusDropDownPlanning" name="selStatus" value="<?php if(isset($dataPlanning) && $dataPlanning == "") echo "";?>">
                        <option <?php if(isset($dataPlanning) && isset($_GET['id'])) if($dataPlanning->status == "") echo "selected ";?> value="-"></option>
                        <option <?php if(isset($dataPlanning) && isset($_GET['id'])) if($dataPlanning->status == "READY FOR TAKEOFF") echo "selected ";?>value="READY FOR TAKEOFF">READY FOR TAKEOFF</option>
                        <option <?php if(isset($dataPlanning) && isset($_GET['id'])) if($dataPlanning->status == "DEPARTED") echo "selected ";?>value="DEPARTED">DEPARTED</option>
                        <option <?php if(isset($dataPlanning) && isset($_GET['id'])) if($dataPlanning->status == "CANCELLED") echo "selected ";?>value="CANCELLED">CANCELLED</option>
                        <option <?php if(isset($dataPlanning) && isset($_GET['id'])) if($dataPlanning->status == "DELAYED") echo "selected ";?>value="DELAYED">DELAYED</option>
                    </select>
                    <br/>
                    <br/>
                    <input type="submit" value=<?php if(isset($_GET['id'])) echo "Wijzigen"; else echo "Toevoegen";?> name="btnSubmitPlanning" id="btnSubmitPlanning"/>
                    <br/>
            </form>
        
    

    

<?php 
// als er een 'id' in de url-balk staat en op de knop gedrukt wordt, wordt er een update query uitgevoerd
    if(isset($_GET['id']) && isset($_POST['btnSubmitPlanning'])) {
        $bestemming = $_POST['txtDestination'];
        $vertrekdatum = $_POST['dateDepartureDate'];
        $aankomstdatum = $_POST['dateRetourDate'];
        $statusPlanning = $_POST['selStatus'];

        $query = "UPDATE planning SET bestemming='$bestemming',vertrekdatum='$vertrekdatum',status='$statusPlanning' WHERE vliegtuignummer=$dataPlanning->vliegtuignummer AND vluchtnummer=$dataPlanning->vluchtnummer";
        $stm = $conn->prepare($query);
        if($stm->execute()) {
            echo "info geupdatet";
            echo "</div>";
        }  
//als er geen 'id' in de url-balk staat wordt er een insert query uitgevoerd
    } else if((!isset($_GET['id']) && (isset($_POST['btnSubmitPlanning'])))) {
        $bestemming = $_POST['txtDestination'];
        $vliegtuigNummer = $_POST['ddVliegtuigNummer'];
        $vertrekdatum = $_POST['dateDepartureDate'];
        $aankomstdatum = $_POST['dateRetourDate'];
        $statusPlanning = $_POST['selStatus'];

        $query = "INSERT INTO planning (vliegtuignummer,vertrekdatum,retourdatum,bestemming,status) VALUES ($vliegtuigNummer,'$vertrekdatum','$aankomstdatum','$bestemming','$statusPlanning')";
        $stm = $conn->prepare($query);
        if($stm->execute()) {
            echo "planning opgeslagen";
        } else  {
            echo "fout met het uploaden van de data";
            echo "</div>";
        }
    }

?>
</div>

    
</body>
</html>