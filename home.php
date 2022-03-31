<?php include("connection.php"); ?>

<?php
    if(isset($_GET['id'])) {
        $planeId = $_GET['id'];

        $queryPlane = "SELECT * FROM vliegtuigen WHERE vliegtuignummer = $planeId";
        $stm = $conn->prepare($queryPlane);
        if ($stm->execute()) {
            $data = $stm->fetch(PDO::FETCH_OBJ);
            echo var_dump($data);
        } else echo "ophalen van data vliegtuig mislukt";

        $queryPlanning = "SELECT * FROM planning WHERE vliegtuignummer = $planeId";
        $stm = $conn->prepare($queryPlanning);
        if($stm->execute()) {
            $dataPlanning = $stm->fetch(PDO::FETCH_OBJ);
            echo var_dump($data);
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
                </select>
                <br/>
                <br/>
                <input type="submit" name="btnSubmit" id="btnSubmit"/>
            </form>
        </div>

        <div id="toevoegDivPlanning">
            <h2>Planning</h2>
        
            <form method="POST">
                <label>Bestemming <input type="text" name="txtDestination" id="inputDestination" value="<?php if(isset($data)) echo $dataPlanning->bestemming; ?>"/></label><br/>
                <label>Vertrekdatum <input type="date" name="dateDepartureDate" id="inputDepartureDate" value="<?php if(isset($data)) echo $data->vertrekdatum; ?>"/></label><br/>
                <label>Retourdatum <input type="date" name="dateRetourDate" id="inputRetourDate" value="<?php if(isset($data)) echo $data->retourdatum; ?>"/></label><br/>
                <label>Status </label>
                <select id="statusDropDownPlanning" name="selStatus" value="<?php if(isset($data)) echo $dataPlanning->status; ?>">
                    <option <?php if(isset($data)) if($data->status == "") echo "selected ";?> value="-"></option>
                    <option <?php if(isset($data)) if($data->status == "READY FOR TAKEOFF") echo "selected ";?>value="READY FOR TAKEOFF">READY FOR TAKEOFF</option>
                    <option <?php if(isset($data)) if($data->status == "DEPARTED") echo "selected ";?>value="DEPARTED">DEPARTED</option>
                    <option <?php if(isset($data)) if($data->status == "CANCELLED") echo "selected ";?>value="CANCELLED">CANCELLED</option>
                    <option <?php if(isset($data)) if($data->status == "DELAYED") echo "selected ";?>value="DELAYED">DELAYED</option>
                </select>
                <br/>
                <br/>
                <input type="submit" name="btnSubmit" id="btnSubmitPlanning"/>
            </form>
        </div>
    </div>

    <?php 
        if(isset($_POST['btnSubmit'])) {
            $type = $_POST['txtType'];
            $vliegtuigmaatschappij = $_POST['txtVliegtuigMa'];
            $status = $_POST['selStatus'];
            
            $query = "INSERT INTO vliegtuigen (type,vliegmaatschappij,status) VALUES ('$type','$vliegtuigmaatschappij','$status')";
            $stm = $conn->prepare($query);
            if($stm->execute()) {
                echo "vliegtuig opgeslagen";
            } else echo "fout met het uploaden van de data";

        }


    ?>

    
</body>
</html>