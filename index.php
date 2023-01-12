<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
 
<style>
    *{
    font-family: 'Courier New', Courier, monospace;
}
body{
    display: flex;
    flex-direction: row;
}

#FORM{
    flex-grow: 0.4;
}#TBL{
    flex-grow: 0.6;
}
.form-group{
    display: flex;
    padding: 3% 0;
}
.form-group label{
    justify-content: flex-start;
    width: 50%;
}
.form-group input{
    justify-content: flex-end;
    padding:2%;
    border:none;border-bottom : 1px solid #000;
}
.controle{
    padding: 10% 0;
}.controle input{
    background-color: blueviolet;
    color: aliceblue;
    border: transparent;
    padding: 2%;
    
}.controle input:hover{
    border-bottom:2px solid #000;
}

th, td{
    border: 1px solid #000;
    box-sizing: border-box;
    padding: 10px;
    margin: 0;
    width: 10%;
}

</style>


        <fieldset id="FORM">
                <legend>Fiche Stagiaires</legend>
                <form action="DB.php" method="post">
                    <div class="form-group">
                        <label for="CIN">CIN</label>
                        <input type="text" placeholder="ex: KJ465487" name="CIN">
                    </div>
                    
                    <div class="form-group">
                    <label for="nom">Nom</label>
                        <input type="text" placeholder="votre nom" name="nom"> 
                    </div>
                    
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" placeholder="votre prénom" name="prenom">   
                    </div>
                    
                    <div class="form-group">
                        <label for="DN">Date de naissance</label>
                        <input type="date" name="DN">
                    </div>
                    
                    <div class="form-group">
                        <label for="LN">Lieu de naissance</label>
                        <input type="text" placeholder="Ville" name="LN">
                    </div>
                    
                    <div class="form-group">
                        <label for="SPC">Specialité</label>
                        <input list="SPC" id="SPC" name="SPC">
                    
                        <datalist id="SPC">
                            <option value="Gestion informatique">
                            <option value="Developpement digital ">
                            <option value="Infographie">
                            <option value="Infrastructure digital">

                        </datalist>
                    </div>


                    <div class="form-group">
                        <label for="gender">Sexe</label>
                        <input type="radio"name="gender" value="M" >Masculin
                        <input type="radio"name="gender" value="F" >Féminin
                    </div>

                    <div class="controle">
                        <input type="submit" value="Ajouter" name="ajouter">
                        <input type="submit" value="Modifier"  name="modifier">
                        <input type="submit" value="Supprimer"  name="supprimer">
                        <input type="submit" value="Rechercher" name="rechercher">
                        <input type="submit" value="Fermer" name="fermer">
                    </div>
                    
                </form>

        </fieldset>


            


        <fieldset id="TBL">
            <legend>Liste de Stagiaire</legend>
            <table id="tableDB">
            <thead>
                <tr>
                    <th>CIN</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date Naiss</th>
                    <th>lieu Naiss</th>
                    <th>Specialité</th>
                    <th>Sexe</th>
                </tr>
                <?php

                    $con = mysqli_connect("localhost","root","","stagiaires");
                    // Check connection
                    if (mysqli_connect_errno()){
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    
                    }

                    $result = mysqli_query($con,"SELECT * FROM info");

                    while($row=mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>".$row['CIN'] ."</td><td>". $row['Nom'] ."</td><td>". $row['Prenom'] ."</td><td>". $row['DateNaissance'] ."</td><td>". $row['LieuNaissance'] ."</td><td>". $row['Specialite'] ."</td><td>". $row['Sexe'] ."</td>";
                    echo "</tr>";
                }
                    mysqli_close($con);
            ?>
            </thead>
        </table>


        </fieldset>




</body>
</html>