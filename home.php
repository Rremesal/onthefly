<?php include("connection.php"); ?>

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
    }

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
        
            <form method="POST">
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
            <!-- </form> -->
        

        <?php 
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
            
        } else if((!isset($_GET['id']) && (isset($_POST['btnSubmit'])))) {
            $type = $_POST['txtType'];
            $vliegtuigmaatschappij = $_POST['txtVliegtuigMa'];
            $status = $_POST['selStatus'];

            $query = "INSERT INTO vliegtuigen (type,vliegmaatschappij,status) VALUES ('$type','$vliegtuigmaatschappij','$status')";
            $stm = $conn->prepare($query);
            if($stm->execute()) {
                echo "vliegtuig opgeslagen";
                echo "</form>";
                echo "</div>";
            } else {
                echo "fout met het uploaden van de data";
                echo "</form>";
                echo "</div>";
            } 
        } else {
            echo "</div>";
        }
    ?>

        <div id="toevoegDivPlanning">
            <h2>Planning</h2>
        
            <form method="POST">
            <label>Vliegtuignummer 
                <select name="ddVliegtuigNummer"> 
                    <?php 
                        $query = "SELECT vliegtuignummer,type FROM vliegtuigen";
                        $stm = $conn->prepare($query);
                        if($stm->execute()) {
                            //$data = $stm->fetchAll(PDO::FETCH_OBJ);
                            while($rows=$stm->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='".$rows['vliegtuignummer']."'>".$rows['vliegtuignummer']." - ".$rows['type']."</option>";
                            }
                        }
                    ?>
                </select>
                <br/>
                <label>Bestemming <input type="text" name="txtDestination" id="inputDestination" value="<?php if(isset($dataPlanning)) echo $dataPlanning->bestemming; ?>"/></label><br/>
                <label>Vertrekdatum <input type="date" name="dateDepartureDate" id="inputDepartureDate" value="<?php if(isset($dataPlanning)) echo $dataPlanning->vertrekdatum; ?>"/></label><br/>
                <label>Retourdatum <input type="date" name="dateRetourDate" id="inputRetourDate" value="<?php if(isset($dataPlanning)) echo $dataPlanning->retourdatum;?>"/></label><br/>
                <label>Status </label>
                <select id="statusDropDownPlanning" name="selStatus" value="<?php if(isset($data)) echo $dataPlanning->status; ?>">
                    <option <?php if(isset($dataPlanning)) if($dataPlanning->status == "") echo "selected ";?> value="-"></option>
                    <option <?php if(isset($dataPlanning)) if($dataPlanning->status == "READY FOR TAKEOFF") echo "selected ";?>value="READY FOR TAKEOFF">READY FOR TAKEOFF</option>
                    <option <?php if(isset($dataPlanning)) if($dataPlanning->status == "DEPARTED") echo "selected ";?>value="DEPARTED">DEPARTED</option>
                    <option <?php if(isset($dataPlanning)) if($dataPlanning->status == "CANCELLED") echo "selected ";?>value="CANCELLED">CANCELLED</option>
                    <option <?php if(isset($dataPlanning)) if($dataPlanning->status == "DELAYED") echo "selected ";?>value="DELAYED">DELAYED</option>
                </select>
                <br/>
                <br/>
                <input type="submit" name="btnSubmitPlanning" id="btnSubmitPlanning"/>
                <br/>
            </form>
        
    

    

<?php 
    if(isset($_GET['id']) && isset($_POST['btnSubmitPlanning'])) {
        $bestemming = $_POST['txtDestination'];
        $vertrekdatum = $_POST['dateDepartureDate'];
        $aankomstdatum = $_POST['dateRetourDate'];
        $statusPlanning = $_POST['selStatus'];

        $query = "UPDATE planning SET bestemming='$bestemming',vertrekdatum='$vertrekdatum',status='$statusPlanning' WHERE vliegtuignummer=$planeId";
        $stm = $conn->prepare($query);
        if($stm->execute()) {
            echo "info geupdatet";
            echo "</div>";
        }  
        
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