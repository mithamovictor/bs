@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->getTranslatedAttribute('display_name_singular'))



@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }}'s Reciept &nbsp;
        <button class="btn btn-success btn-add-new" onclick="window.print();" target="_blank">Print</button>
    </h1>
    <?php echo $dataTypeContent->getKey(); ?>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <?php
        $servername       = "localhost";
        $username         = "root";
        $password         = "root";
        $dbname           = 'bs_db';
        $sales_db         = 'sales';
        $inventory_db     = "inventories";
        $student_staff_db = "staff_student_lists";
        $id               = $dataTypeContent->getKey();


        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) :
            die("Connection failed: " . mysqli_connect_error() . "</br>");
        endif;

        $sql = "SELECT * FROM $sales_db WHERE id LIKE $id";
        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($result);

        $ss_id = $row['user_id'];

        $ss_query = "SELECT * FROM $student_staff_db WHERE uon_id = $ss_id";
        $ss_result = mysqli_query($conn, $ss_query);

        $ss_row = mysqli_fetch_assoc($ss_result);

        $inv_name = $row['item_name'];

        $inv_query = "SELECT * FROM $inventory_db";
        $inv_result = mysqli_query($conn, $inv_query);

    ?>
    <div class="reciept_container">
        <div class="reciept">
            <div class="logo_container">
                <img src="/storage/logos/LOGO-HD-UON-LOGO-973x1024.jpg" alt="uon logo" width="100px" height="auto">
            </div>
            <div class="info">
                <div class="header"><?php
                    if( $ss_row['category'] == 'staff' ) : ?>
                        <p class="bold">Staff ID:</p><?php
                    elseif ( $ss_row['category'] == 'student' ) : ?>
                        <p class="bold">Student ID:</p><?php
                    endif; ?>
                </div>
                <div class="content">
                    <p><?php echo $row['user_id']; ?></p>
                </div>
            </div>
            <div class="info">
                <div class="header">
                    <p class="bold">Name:</p>
                </div>
                <div class="content">
                    <p><?php echo $ss_row['first_name'] . ' ' . $ss_row['last_name']; ?></p>
                </div>
            </div>
            <div class="info">
                <div class="header">
                    <p class="bold">Category:</p>
                </div>
                <div class="content"><?php
                    if( $ss_row['category'] == 'staff' ) : ?>
                        <p class="bold">Staff</p><?php
                    elseif ( $ss_row['category'] == 'student' ) : ?>
                        <p class="bold">Student</p><?php
                    endif; ?>
                </div>
            </div>
            <div class="info">
                <div class="header">
                    <p class="bold">Email:</p>
                </div>
                <div class="content">
                    <p><?php echo $ss_row['email']; ?></p>
                </div>
            </div>
            <div class="info">
                <div class="header">
                    <p class="bold">Phone:</p>
                </div>
                <div class="content">
                    <p><?php echo $ss_row['phone']; ?></p>
                </div>
            </div>
            <div class="info">
                <div class="header">
                    <p class="bold">Item:</p>
                </div>
                <div class="content">
                    <p><?php echo $row['item_name']; ?></p>
                </div>
            </div>
            <div class="info">
                <div class="header">
                    <p class="bold">Price</p>
                </div>
                <div class="content"><?php
                    while( $inv_row = mysqli_fetch_assoc($inv_result)) {
                        if( $inv_row['name'] == $row['item_name'] ) : ?>
                            <p>Ksh. <?php echo $inv_row['selling_price']; ?>.00</p><?php
                        endif;
                    } ?>
                </div>
            </div>
            <div class="info">
                <div class="header">
                    <p class="bold">Payment Type:</p>
                </div>
                <div class="content">
                    <p><?php echo $row['payment_type']; ?></p>
                </div>
            </div>
        </div>
    </div><?php

    mysqli_close($conn); ?>
@stop

