<?php

/**
 *Arak_jutalekClass
 *
 * araj jutalék tábla feltöltése kezelése
 * @author Andras
 */
class arak_jutalek {

/**
 * admin jugú felhasználó árat jutalékot össszerendelő form tábla
 */
    public function admin_insert_arak_jutalek() {
        $conn = DbConnect();
// tábla fejrész
        $date = date("y-m-d");
        $sql1 = "SELECT * FROM szolgaltatasok";
        $result_szolgaltatasok = $conn->query($sql1);

        echo'<h1>Szolgáltatás árak jutalékok rögzítése törlése</h1>';
        echo '<table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:50px;">Id</th>
                        <th>Orvos neve</th>
                        <th>Szolgáltatás neve</th>
                        <th>Szolgáltatás ára Ft</th>
                        <th>Kezelő jutaléka Ft</th>        
                        <th>Hozzáad</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                    <form action="' . $_SERVER['PHP_SELF'] . '?pid=page86" method="post">
                    <td> <input type="tetx" class="form-control" name="ar_id" disabled></td>
                    <td>';
        
        // select options orvosok kezelok
        echo'<select class = "form-control" name = "kezelo_szolg_jutalek">';
        $sql = "SELECT DISTINCT kezelo_neve FROM kezelok_orvosok ORDER BY kezelo_neve ASC";
        $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row[kezelo_neve] . '">' . $row[kezelo_neve] . '</option>';
                }
            } else {
                echo "0 results";
            }
        echo '</select></td>';

        // szolgáltatás tiousok select

        echo'<td><select class = "form-control" name = "szolgaltatas_jutalek">';
        $sql = "SELECT * FROM `szolgaltatasok` ORDER BY szolg_neve ASC";
        $result2 = $conn->query($sql);

        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                echo '<option value="' . $row[szolg_neve] . '">' . $row[szolg_neve] . '</option>';
            }
        } else {
            echo "0 results";
        }
        echo'</select></td>';
                echo'    <td> <input type="number" class="form-control" name="szolgaltatas_ara" placeholder="szolgaltatás ára" required></td>
                    <td> <input type = "number" class = "form-control" name = "kezelo_jutalek" placeholder="kezelő juteleka" required></td>
                    <td><button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Tárol</button></td>
                    </form></tr>';
        // echo'</tbody></table>';    

        mysqli_close($conn);
    }

    public function admin_delete_kezeles_arak_jutalek() {
        $conn = DbConnect();

        // táblázat visszaolvasása
        $sql = "SELECT * FROM kezeles_arak_jutalek ORDER BY kezelo_neve ASC, kezeles_tipus ASC";
        $result = $conn->query($sql);
        echo '<form action="' . $_SERVER['PHP_SELF'] . '?pid=page86" method="post">';
        if ($result->num_rows > 0) {

        //echo'<table class="table table-striped"><tbody>';            
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>"
                . $row["ar_id"] . "</td><td> "
                . $row["kezelo_neve"] . "</td><td>"
                . $row["kezeles_tipus"] . "</td><td>"
                . $row["kezeles_ar"] . "</td><td>"
                . $row["kezelo_jutalek"] . "</td><td>"
                . '<input type="radio" name="delete_kezeles_arak_jutalek_id" value="' . $row["ar_id"] . '"></td></tr>'
                ;
            }
        } else {
            echo "0 results";
        }
        echo '<tr><td></td><td></td><td></td><td></td><td></td>'
        . '<td><button type = "submit" value = "Submit" type = "button" class = "btn btn-warning">Töröl</button></td>';
        echo "</tr></form></tbody></table>";

        mysqli_close($conn);
    }

    public function admin_post_delete_arak_jutalek() {

        if (isset($_POST['delete_kezeles_arak_jutalek_id'])) {
            $deleteid = test_input($_POST['delete_kezeles_arak_jutalek_id']);
            echo $deleteid;
            $conn = DbConnect();

            $sql = "DELETE FROM kezeles_arak_jutalek WHERE ar_id='$deleteid'";

            if (mysqli_query($conn, $sql)) {
            // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

    public function admin_post_insert_arak_jutalek() {

        if (isset($_POST["kezelo_szolg_jutalek"]) && $_POST["szolgaltatas_jutalek"] ) {
            $conn = DbConnect();
        // adatbázisba írás
        // tárolandó adatok bemeneti ellenörzése
            $kezelo_neve = test_input($_POST["kezelo_szolg_jutalek"]);
            $szolgaltatas_tipus = test_input($_POST["szolgaltatas_jutalek"]);
            $szolgaltatas_ara = $_POST["szolgaltatas_ara"];
            $kezelo_jutaleka = $_POST["kezelo_jutalek"];
            
            
            $sql = "INSERT INTO kezeles_arak_jutalek (kezelo_neve, kezeles_tipus, kezeles_ar, kezelo_jutalek )
            VALUES ('$kezelo_neve','$szolgaltatas_tipus','$szolgaltatas_ara','$kezelo_jutaleka')";

            if (mysqli_query($conn, $sql)) {
            // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

}
