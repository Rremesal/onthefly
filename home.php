<?php include("connection.php"); ?>

<?php
    if(isset($_GET['id'])) {
        $planeId = $_GET['id'];

        $query = "SELECT * FROM vliegtuigen WHERE vliegtuignummer = $planeId";
        $stm = $conn->prepare($query);
        if ($stm->execute()) {
            $data = $stm->fetch(PDO::FETCH_OBJ);
            echo var_dump($data);
        } else echo "ophalen van data mislukt";
    }

?> 
    
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="css.css"/>
</head>
<body>
    <a href="overview.php">overzicht vliegtuigen</a>
    <a href="home.php">home</a>

    <div id="banner">
        <img src="background.png"/>
        <h1>Welkom</h1>
    </div>
        

    
    <div id="toevoegDiv">
        <h2>Vliegtuigen</h2>
    
        <form method="POST">
            <label>Type <input type="text" name="txtType" id="inputType" value="<?php if(isset($data)) echo $data->type; ?>"/></label><br/>
            <label>Vliegtuigmaatschappij <input type="text" name="txtVliegtuigMa" id="inputVliegtuigMa" value="<?php if(isset($data)) echo $data->vliegmaatschappij; ?>"/></label><br/>
            <label>Status </label>
            <select id="statusDropDown" name="selStatus" value="<?php if(isset($data)) echo $data->status; ?>">
                <option <?php if(isset($data)) if($data->status == "") echo "selected"; ?> value="-"></option>
                <option value="NOT IN OPERATION">NOT IN OPERATION</option>
                <option value="DEPARTED">DEPARTED</option>
                <option value="ARRIVED">ARRIVED</option>
                <option value="DELAYED">DELAYED</option>
                <option value="CANCELLED">CANCELLED</option>
            </select>
            <br/>
            <br/>
            <input type="submit" name="btnSubmit" id="btnSubmit"/>
        </form>
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