<?php

/*
 * Bevéte tipusokat kezelő adattábla 
 */

class bevetel_tipusok {

    public function admin_insert_beveteltipus() {
        $conn = DbConnect();
        // tábla fejrész
        $date = date("y-m-d");
            
        echo'<h1>Bevetel fajták felvétele törlése</h1>';
        echo '<table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:50px;">Bevétel Id</th>
                        <th>Bevétel neve</th>
                        <th>Hozzáad</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                    <form action="' . $_SERVER['PHP_SELF'] . '?pid=page82" method="post">
                    <td> <input type="tetx" class="form-control" name="bevetel_id" disabled></td>
                    <td> <input type = "text" class = "form-control" name = "bevetel_neve" placeholder="készpénz" required></td>
                    <td><button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Tárol</button></td>
                    </form></tr>';
        // echo'</tbody></table>';    

        mysqli_close($conn);
    }

    public function admin_delete_beveteltipus() {
        $conn = DbConnect();

// táblázat visszaolvasása
        $sql = "SELECT * FROM bevetel_tipusok";
        $result = $conn->query($sql);
        echo '<form action="' . $_SERVER['PHP_SELF'] . '?pid=page82" method="post">';
        if ($result->num_rows > 0) {
// output decho "
            //echo'<table class="table table-striped"><tbody>';            
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>"
                . $row["bevetel_id"] . "</td><td> "
                . $row["bevetel_neve"] . "</td><td>"
                . '<input type="radio" name="delete_bevetel_id" value="' . $row["bevetel_id"] . '"></td></tr>'
                ;
            }
        } else {
            echo "0 results";
        }
        echo '<tr><td></td><td></td><td>'
        . '<button type = "submit" value = "Submit" type = "button" class = "btn btn-warning">Töröl</button></td>';
        echo "</form></tbody></table>";

        mysqli_close($conn);
    }

    public function admin_post_delete_beveteltipus() {
        
        if (isset($_POST['delete_bevetel_id'])) {
            $deleteid = test_input($_POST['delete_bevetel_id']);
            //echo $deleteid;
            $conn = DbConnect();

            $sql = "DELETE FROM bevetel_tipusok WHERE bevetel_id='$deleteid'";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

    public function admin_post_insert_beveteltipus() {
        
        if (isset($_POST["bevetel_neve"])) {

            $conn = DbConnect();
            // adatbázisba írás
            // tárolandó adatok bemeneti ellenörzése
            $bevetel_neve = test_input($_POST["bevetel_neve"]);
           
            $sql = "INSERT INTO bevetel_tipusok (bevetel_neve)
            VALUES ('$bevetel_neve')";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

}
