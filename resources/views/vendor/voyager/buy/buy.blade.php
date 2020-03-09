@extends('voyager::master')

@section('content')
    <?php
        $servername   = "localhost";
        $username     = "root";
        $password     = "root";
        $dbname       = 'bs_db';
        $inventory_db = "inventories";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) :
            die("Connection failed: " . mysqli_connect_error() . "</br>");
        endif;

        $sql = "SELECT * FROM $inventory_db";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) :
    ?>
    <div class="form_container">
        <h2>Search Student/Staff</h2>

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <p>Oops! There were errors. See the errors below.</p>
                @foreach($errors->all() as $error)
                    <p>- {{$error}}</p>
                @endforeach
            </div>
        @endif

        {!! Form::open(['action' => 'BuyController@store', 'method' => 'post']) !!}
            <div class="form-group">
                {!! Form::label('category', 'Category') !!}
                {!! Form::select('category', [ '' => 'Select', 'staff' => 'Staff', 'student' => 'Student' ], null,  [ 'class' => 'form-control' ]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('client_id', 'Staff/Student ID') !!}
                {!! Form::number('client_id', '', [ 'class' => 'form-control' ] ) !!}
            </div>
            <div class="form-group">
                {!! Form::label('inventory', 'Item') !!}
                <input class="form-control" list="inventory" name="inventory">
                <datalist id="inventory"><?php
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['name'] . '">' ;
                    } ?>
                </datalist>
            </div>
            <div class="form-group">
                {!! Form::label('payment_type', 'Payment Type') !!}
                {!! Form::select('payment_type', [ '' => 'Select', 'cash' => 'Cash', 'card' => 'Card', 'cheque' => 'Cheque' ], null, [ 'class' => 'form-control' ] ) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Buy', ['class' => 'btn btn-success btn-add-new']) !!}
            </div>
        {!! Form::close() !!}
    </div><?php

    else :
        echo "0 results";
    endif;

    mysqli_close($conn); ?>
@stop
