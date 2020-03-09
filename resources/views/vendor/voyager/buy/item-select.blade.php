@extends('voyager::master')

@section('content')
    <?php
        $servername   = "localhost";
        $username     = "root";
        $password     = "root";
        $dbname           = 'bs_db';
        $inventory_db = "inventories";

        // if ($conn->connect_error) {
        //     die( "Connection failed: " . $conn->connect_error );
        // } else {
        //     echo "Connected successfully";
        // }

        // $inventory_query = "SELECT * FROM $inventory_db";
        // $res = $conn->query($inventory_query);

        // echo $res;

        // if ( $res->num_rows > 0 ) :
        //     while($row = $res->fetch_assoc()) {
        //         echo "id: " . $row["id"]. " - Name: " . $row["name"] . "<br>";
        //     }
        // else:
        //     echo "0 results";
        // endif;

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) :
            die("Connection failed: " . mysqli_connect_error() . "</br>");
        else:
            echo "Connected! </br>";
        endif;

        $sql = "SELECT * FROM $inventory_db";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) :
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo "id: " . $row["id"]. " - Name: " . $row["name"] . "<br>";
            }
        else :
            echo "0 results";
        endif;
    ?>
    <div class="form_container">
        <h2>Search Student/Staff</h2>
        <form class="client_search" method="post">
            <div class="input_div">
                <label for="Category">Category</label>
                <select name="category">
                    <option value="">Select</option>
                    <option value="staff">Staff</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <div class="input_div">
                <label for="student_id">Student ID</label>
                <input type="number" name="student_id" value="">
            </div>
            <div class="input_div">
                <input class="btn btn-success btn-add-new" type="submit" name="search" value="Search" />
            </div>
        </form>
    </div>
    <?php
        mysqli_close($conn);
    ?>
@stop
