<?php

/* 
 * Budapest Mozgásszervi Begánrendelő Napi Elszámolás Projek
 * Gazdag András  * 
 * Mérnök Informatikus * 
 * Programozó Informatikus * 
 */


class telephely {

    public function admin_insert_telephely() {
        $conn = DbConnect();
        // tábla fejrész
        $date = date("y-m-d");

        echo'<h1>Rendelők felvétele törlése</h1>';
        echo '<table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:100px;">Bevétel Id</th>
                        <th>Rendelők neve</th>
                        <th>Hozzáad</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                    <form action="' . $_SERVER['PHP_SELF'] . 'pid=page84" method="post">
                    <td> <input type="tetx" class="form-control" name="telephely_id" disabled></td>
                    <td> <input type = "text" class = "form-control" name = "telephely_neve" placeholder="BMM rendelő"></td>
                    <td><button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Tárol</button></td>
                    </form></tr>';
        // echo'</tbody></table>';    

        mysqli_close($conn);
    }

    public function admin_delete_telephely() {
        $conn = DbConnect();

// táblázat visszaolvasása
        $sql = "SELECT * FROM telephelyek";
        $result = $conn->query($sql);
        echo '<form action="' . $_SERVER['PHP_SELF'] . 'pid=page84" method="post">';
        if ($result->num_rows > 0) {
// output decho "
            //echo'<table class="table table-striped"><tbody>';            
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>"
                . $row["telephely_id"] . "</td><td> "
                . $row["telephely_neve"] . "</td><td>"
                . '<input type="radio" name="delete_telephely_id" value="' . $row["telephely_id"] . '"></td></tr>'
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

    public function admin_post_delete_telephely() {
        
        if (isset($_POST['delete_telephely_id'])) {
            $deleteid = test_input($_POST['delete_telephely_id']);
            echo $deleteid;
            $conn = DbConnect();

            $sql = "DELETE FROM telephelyek WHERE telephely_id='$deleteid'";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

    public function admin_post_insert_telephely() {
        
        if (isset($_POST["telephely_neve"])) {

            $conn = DbConnect();
            // adatbázisba írás
            // tárolandó adatok bemeneti ellenörzése
            $telephely_neve = test_input($_POST["telephely_neve"]);
           
            $sql = "INSERT INTO telephelyek (telephely_neve)
            VALUES ('$telephely_neve')";

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
