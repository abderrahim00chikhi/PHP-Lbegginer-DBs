<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style2.css"> -->
    <title>Document</title>
</head>
<body>
    
<style>
    
*{
    font-family: 'Courier New', Courier, monospace;
}
table{
    margin: 0 auto;
} 
.form-group{
    display: flex;
    width: 100%;
}
.form-group label{
    justify-content: flex-start;
    width: 50%;
}
.form-group input{
    justify-content: flex-end;
}

.marked{
    background: yellow;
    color: #000;
    text-align: center;
}
.colsed{
    color: red;
    font-size:2vw;
    position:absolute;
    top:50%;left:50%;
    transform: translate(-50%,-50%);
}
th, td{
    border: 1px solid #000;
    box-sizing: border-box;
    padding: 10px;
    margin: 0;
    width: 10%;
}

</style>

<?php

class Stagiaire{

    function  __construct($CIN,$Nom,$Prenom,$DN,$LN,$SPC,$Sexe){
        $this->CIN = $CIN;
        $this->Nom = $Nom;
        $this->Prenom = $Prenom;
        $this->DN = $DN;
        $this->LN = $LN;
        $this->SPC = $SPC;
        $this->Sexe = $Sexe;
        $this->DB = new mysqli("localhost", "root", "","stagiaires");
    }
    function checkConn(){
        if ($this->DB->connect_error) {
            die("Connection failed: " . $this->DB->connect_error);
        }
        echo "connection succesfull";
    }
    function ajouter(){
        $sql_req = "INSERT INTO info(CIN,Nom,Prenom,DateNaissance,LieuNaissance,Specialite,Sexe) VALUES('$this->CIN','$this->Nom','$this->Prenom','$this->DN','$this->LN','$this->SPC','$this->Sexe')";
        $this->DB->query($sql_req);
        header("Location: index.php");

    }
    function modifier(){
        // $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql_req = "UPDATE info SET Nom='$this->Nom', Prenom='$this->Prenom', DateNaissance='$this->DN', LieuNaissance='$this->LN', Specialite='$this->SPC', Sexe='$this->Sexe' WHERE CIN = '$this->CIN'";
        $this->DB->query($sql_req);
        header("Location: index.php");
    }

    function supprimer(){
        $sql_req = "DELETE FROM info WHERE CIN = '$this->CIN' ";
        $this->DB->query($sql_req);
        header("Location: index.php");
    }

    function rechercher(){
        echo "<u><b>Results:</b></u></br>";
        function notNull($x){
            if($x == (null || '')){
                return false;
            }else{
                return true;
            }
        }
        
        
        // if(notNull($this->CIN)){
        //     $sql_req= "SELECT * FROM info WHERE CIN=$this->CIN";
        // }if(notNull($this->CIN)&&notNull($this->Nom)){
        //     $sql_req= "SELECT * FROM info WHERE CIN='$this->CIN' AND Nom='$this->Nom'";
        // }if(notNull($this->CIN)&&notNull($this->Nom)&&notNull($this->Prenom)){
        //     $sql_req= "SELECT * FROM info WHERE CIN='$this->CIN' AND Nom='$this->Nom' AND Prenom='$this->Prenom'";
        // }if(notNull($this->CIN)&&notNull($this->Nom)&&notNull($this->Prenom)&&notNull($this->DN)){
        //     $sql_req= "SELECT * FROM info WHERE CIN='$this->CIN' AND Nom='$this->Nom' AND Prenom='$this->Prenom' AND DateNaissance='$this->DN";
        // }if(notNull($this->CIN)&&notNull($this->Nom)&&notNull($this->Prenom)&&notNull($this->DN)&&notNull($this->LN)){
        //     $sql_req= "SELECT * FROM info WHERE CIN='$this->CIN' AND Nom='$this->Nom' AND Prenom='$this->Prenom' AND DateNaissance='$this->DN' AND LieuNaissance='$this->LN'";
        // }
        $toValid = [
            [$this->CIN,"CIN"],
            [$this->Nom,"Nom"],
            [$this->Prenom,"Prenom"],
            [$this->DN,"DateNaissance"],
            [$this->LN,"LieuNaissance"],
            [$this->SPC,"Specialite"],
            [$this->Sexe,"Sexe"]
        ];
        $valid = [];
        for($i=0;$i<count($toValid);$i++){
            if(notNull($toValid[$i][0])){
                array_push($valid,$toValid[$i]);
            }
        }      
        if(count($valid)>0){
            
            $sql_req = "SELECT * FROM info WHERE ";
            for($i=0;$i<count($valid);$i++){
                if($i==0){
                    $sql_req.= $valid[$i][1]." = '{$valid[$i][0]}'";
                }else{
                    $sql_req.=" AND ". $valid[$i][1]." = '{$valid[$i][0]}'";
                }
            } 



            
        }else{
            echo "<p class='marked'>Please enter somthing to look for..</p>";
            $sql_req = "SELECT * FROM info ";
        }

        $this->DB->query($sql_req);
            
        return $sql_req; 
        
        
    }

    function fermer(){
        $this->DB->close();
        echo "<b class='colsed'>server closed</b>";
    }

}



function catchGender(){
    if(isset($_POST["gender"])){
        return $_POST["gender"];
    }else{
        return null;
    }
}

$st = new Stagiaire($_POST["CIN"],$_POST["nom"],$_POST["prenom"],$_POST["DN"],$_POST["LN"],$_POST["SPC"],catchGender());

if(isset($_POST["ajouter"])){
    $st->ajouter();
}
if(isset($_POST["modifier"])){
    $st->modifier();
}
if(isset($_POST["supprimer"])){
    $st->supprimer();
}
if(isset($_POST["rechercher"])){
    $result = mysqli_query(mysqli_connect("localhost","root","","stagiaires"),$st->rechercher());
    if($result->num_rows > 0){
        echo "<table><thead><tr><th>CIN</th><th>Nom</th><th>Prénom</th><th>Date Naiss</th><th>lieu Naiss</th><th>Specialité</th><th>Sexe</th></tr>";
        
            while($row=mysqli_fetch_array($result)){
            echo "<tr>";
            echo "<td>".$row['CIN'] ."</td><td>". $row['Nom'] ."</td><td>". $row['Prenom'] ."</td><td>". $row['DateNaissance'] ."</td><td>". $row['LieuNaissance'] ."</td><td>". $row['Specialite'] ."</td><td>". $row['Sexe'] ."</td>";
            echo "</tr>";
            }           
    
        echo "</thead></table>";
    }else{
        echo "<p class='marked'>Nothing found!</p>";
    }
    
}
if(isset($_POST["fermer"])){
    $st->fermer();
}






?>



</body>
</html>