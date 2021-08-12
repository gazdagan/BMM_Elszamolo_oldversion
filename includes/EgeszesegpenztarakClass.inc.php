<?php

/*
 * Egészségpéztár tipusokat kezelő osztály
 */

class egeszsegpenztar {

    public function admin_insert_egeszsegpenztar() {
        $conn = DbConnect();
        // tábla fejrész
        $date = date("y-m-d");

        echo'<h1>Egészségpénztárak felvétele törlése</h1>';
        echo '<table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:100px;">Bevétel Id</th>
                        <th>Egészségpénztár neve</th>
                        <th>Hozzáad</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                    <form action="' . $_SERVER['PHP_SELF'] . '?pid=page83" method="post">
                    <td> <input type="tetx" class="form-control" name="ep_id" disabled></td>
                    <td> <input type = "text" class = "form-control" name = "ep_neve" placeholder="Egeszsegpenztár"></td>
                    <td><button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Tárol</button></td>
                    </form></tr>';
        // echo'</tbody></table>';    

        mysqli_close($conn);
    }

    public function admin_delete_egeszsegpenztar() {
        $conn = DbConnect();

// táblázat visszaolvasása
        $sql = "SELECT * FROM ep_lista";
        $result = $conn->query($sql);
        echo '<form action="' . $_SERVER['PHP_SELF'] . '?pid=page83" method="post">';
        if ($result->num_rows > 0) {
// output decho "
            //echo'<table class="table table-striped"><tbody>';            
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>"
                . $row["ep_id"] . "</td><td> "
                . $row["ep_neve"] . "</td><td>"
                . '<input type="radio" name="delete_ep_id" value="' . $row["ep_id"] . '"></td></tr>'
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

    public function admin_post_delete_egeszsegpenztar() {
        
        if (isset($_POST['delete_ep_id'])) {
            $deleteid = test_input($_POST['delete_ep_id']);
            echo $deleteid;
            $conn = DbConnect();

            $sql = "DELETE FROM ep_lista WHERE ep_id='$deleteid'";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

    public function admin_post_insert_egeszsegpenztar() {
        
        if (isset($_POST["ep_neve"])) {

            $conn = DbConnect();
            // adatbázisba írás
            // tárolandó adatok bemeneti ellenörzése
            $ep_neve = test_input($_POST["ep_neve"]);
           
            $sql = "INSERT INTO ep_lista (ep_neve)
            VALUES ('$ep_neve')";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

}
?>
