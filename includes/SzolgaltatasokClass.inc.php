<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class szolgaltatasok {

    public function admin_insert_szolgaltatasok() {
        $conn = DbConnect();
        // tábla fejrész
        $date = date("y-m-d");

        echo'<h1>Szolgáltatások áruk felvétele törlése</h1>';
        echo '<table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:50px;">Szolg Id</th>
                        <th>Szolgáltatások neve</th>
                        <th>Típusa</th>
                        <th>Hozzáad</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                    <form action="' . $_SERVER['PHP_SELF'] . '?pid=page81" method="post">
                    <td> <input type="tetx" class="form-control" name="szolg_id" disabled></td>
                    <td> <input type = "text" class = "form-control" name = "szolgaltatas_neve" placeholder="alapvizsgálat" required></td>
                    <td><select name="szolgaltatas_tipus" class="form-control">
                        <option value="Orvos">Orvosi</option>
                        <option value="Orvosi / kiegészítő">Orvosi / kiegészítő</option>
                        <option value="Gyógytorna">Gyógytornász</option>
                        <option value="Masszőr">Masszőr</option>
                        <option value="Bérlet">Bérlet</option>
                        <option value="Segédeszköz">Gyógyászati segédeszköz</option>
                        </select>
                    </td>
                    <td><button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Tárol</button></td>
                    </form></tr>';
        // echo'</tbody></table>';    

        mysqli_close($conn);
    }

    public function admin_delete_szolgaltatas() {
        $conn = DbConnect();

// táblázat visszaolvasása
        $sql = "SELECT * FROM szolgaltatasok ORDER BY  szolg_neve ASC";
        $result = $conn->query($sql);
        echo '<form action="' . $_SERVER['PHP_SELF'] . '?pid=page81" method="post">';
        if ($result->num_rows > 0) {
// output decho "
            //echo'<table class="table table-striped"><tbody>';            
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>"
                . $row["szolg_id"] . "</td><td> "
                . $row["szolg_neve"] . "</td><td>"
                . $row["szolg_tipus"] . "</td><td>"       
                . '<input type="radio" name="delete_szolgaltatas_id" value="' . $row["szolg_id"] .'?pid=page81"></td></tr>'
                ;
            }
        } else {
            echo "0 results";
        }
        echo '<tr><td></td><td></td><td></td><td>'
        . '<button type = "submit" value = "Submit" type = "button" class = "btn btn-warning">Töröl</button></td>';
        echo "</form></tbody></table>";

        mysqli_close($conn);
    }

    public function admin_post_delete_szolgaltatas() {
        
        if (isset($_POST['delete_szolgaltatas_id'])) {
            $deleteid = test_input($_POST['delete_szolgaltatas_id']);
            //echo $deleteid;
            $conn = DbConnect();

            $sql = "DELETE FROM szolgaltatasok WHERE szolg_id='$deleteid'";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

    public function admin_post_insert_szolgaltatas() {
        if (isset($_POST["szolgaltatas_neve"])) {

            $conn = DbConnect();
            // adatbázisba írás
            // tárolandó adatok bemeneti ellenörzése
            $szolgaltatas_neve = test_input($_POST["szolgaltatas_neve"]);
            $szolgaltatas_tipus = test_input($_POST["szolgaltatas_tipus"]);
            $sql = "INSERT INTO szolgaltatasok (szolg_neve,szolg_tipus)
            VALUES ('$szolgaltatas_neve','$szolgaltatas_tipus')";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

}
