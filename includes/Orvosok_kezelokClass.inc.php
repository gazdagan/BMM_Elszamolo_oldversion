<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class orvosok_kezelok {

    public function insert_admin_orvos() {
        $conn = DbConnect();
        // tábla fejrész
        $date = date("y-m-d");

        echo'<h1>Orvosok kezelők felvétele törlése</h1>';
        echo '<table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:50px;">Kezelő Id</th>
                        <th>Kezelő / Orvos Neve</th>
                        <th>Telephely</th>
                        <th>Szakterület</th>
                        <th>Kezelő Megjegyzés</th>
                        <th>Hozzáad</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                    <form action="' . $_SERVER['PHP_SELF'] . '?pid=page80" method="post">
                    <td><input type="tetx" class="form-control" name="kezelo_id" disabled></td>
                    <td><input type = "text" class = "form-control" name = "kezelo_neve" placeholder="DR Bubo Bubo" required></td>';
                    echo '<td>';
                    echo'<select class = "form-control" name = "kezelo_telephely">';
                  
                    $sql = "SELECT * FROM telephelyek";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row[telephely_neve] . '">' . $row[telephely_neve] . '</option>';
                        }
                    } else {
                        echo "0 results";
                    }
                    echo '</select>';
                    echo '</td>
                    <td><select name="kezelo_tipus" class="form-control">
                        <option value="Orvos">Orvos</option>
                        <option value="Gyógytornász">Gyógytornász</option>
                        <option value="Masszőr">Masszőr</option>
                        <option value="Kft">Kft</option>
                    </select>
                    </td>
                    <td> <input type = "text" class = "form-control" name = "kezelo_megj"></td>
                    <td><button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Tárol</button></td>
                    </form></tr>';
        // echo'</tbody></table>';    

        mysqli_close($conn);
    }

    public function admin_delete_kezelo() {
        $conn = DbConnect();

// táblázat visszaolvasása
        $sql = "SELECT * FROM kezelok_orvosok ORDER BY kezelo_neve ASC";
        $result = $conn->query($sql);
        echo '<form action="' . $_SERVER['PHP_SELF'] . '?pid=page80" method="post">';
        if ($result->num_rows > 0) {
// output echo "
            //echo'<table class="table table-striped"><tbody>';            
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>"
                . $row["kezelo_id"] . "</td><td> "
                . $row["kezelo_neve"] . "</td><td>"            
                . $row["kezelo_telephely"] . "</td><td>" 
                . $row["kezelo_tipus"] . "</td><td>" 
                . $row["kezelo_megj"] . "</td><td>"
                . '<input type="radio" name="delete_kezelo_id" value="' . $row["kezelo_id"] . '"></td></tr>'
                ;
            }
        } else {
            echo "0 results";
        }
        echo '<tr><td></td><td></td><td></td><td></td><td></td><td>'
        . '<button type = "submit" value = "Submit" type = "button" class = "btn btn-warning">Töröl</button></td></tr>';
        echo "</form></tbody></table>";

        mysqli_close($conn);
    }

    public function admin_post_delete_kezelo() {

        if (isset($_POST['delete_kezelo_id'])) {
            $deleteid = test_input($_POST['delete_kezelo_id']);
            //echo $deleteid;
            $conn = DbConnect();

            $sql = "DELETE FROM kezelok_orvosok WHERE kezelo_id='$deleteid'";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

    public function admin_post_insert_kezelo() {
        if (isset($_POST["kezelo_neve"]) ) {

            $conn = DbConnect();
            // adatbázisba írás
            // tárolandó adatok bemeneti ellenörzése
            $kezelo_neve = test_input($_POST["kezelo_neve"]);
            $kezelo_tipus = test_input($_POST["kezelo_tipus"]);
            $kezelo_megj = test_input($_POST["kezelo_megj"]);
            $kezelo_telephely = test_input($_POST["kezelo_telephely"]);

            $sql = "INSERT INTO kezelok_orvosok (kezelo_neve, kezelo_tipus,kezelo_megj,kezelo_telephely)
            VALUES ('$kezelo_neve','$kezelo_tipus','$kezelo_megj','$kezelo_telephely')";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

}
