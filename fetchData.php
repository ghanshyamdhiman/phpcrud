<?php 
// Include config file 
include_once 'config.php'; 
 
// Database connection info 
$dbDetails = array( 
    'host' => DB_HOST, 
    'user' => DB_USER, 
    'pass' => DB_PASS, 
    'db'   => DB_NAME 
); 
 
// DB table to use 
$table = 'tblfsr'; 
 
// Table's primary key 
$primaryKey = 'fsr_id'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 'db' => 'fsr_id', 'dt' => 0),
    array( 'db' => 'fsr_date', 'dt' => 1,'formatter' => function( $d, $row ) {return date( 'jS M Y', strtotime($d));}),
    array( 'db' => 'fsr_slot', 'dt' => 2),
    array( 'db' => 'fsr_sch_fm', 'dt' => 3,'formatter' => function( $d, $row ) {return date( 'h:i:s', strtotime($d));}),
    array( 'db' => 'fsr_sch_till', 'dt' => 4,'formatter' => function( $d, $row ) {return date( 'h:i:s', strtotime($d));}),
    array( 'db' => 'faculty', 'dt' => 5),
    array( 'db' => 'lec_type', 'dt' => 6),
    array( 'db' => 'act_code', 'dt' => 7),
    array( 'db' => 'batch', 'dt' => 8),
    array( 'db' => 'room', 'dt' => 9),
    array( 'db' => 'chap_code', 'dt' => 10),
    array( 'db' => 'fac_time_in', 'dt' => 11,'formatter' => function( $d, $row ) {return date( 'h:i:s', strtotime($d));}),
    array( 'db' => 'fac_time_out', 'dt' => 12,'formatter' => function( $d, $row ) {return date( 'h:i:s', strtotime($d));}),
    array( 'db' => 'attn_by', 'dt' => 13),
    array( 'db' => 'attn_by_in', 'dt' => 14,'formatter' => function( $d, $row ) {return date( 'h:i:s', strtotime($d));}),
    array( 'db' => 'attn_by_out', 'dt' => 15,'formatter' => function( $d, $row ) {return date( 'h:i:s', strtotime($d));}),
    array( 'db' => 'remarks', 'dt' => 16),
    array( 
        'db'        => 'fsr_id', 
        'dt'        => 17, 
        'formatter' => function( $d, $row ) { 
            return ' 
                <a href="javascript:void(0);" class="btn btn-warning" onclick="editData('.htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8').')">Edit</a>&nbsp; 
                <a href="javascript:void(0);" class="btn btn-danger" onclick="deleteData('.$d.')">Delete</a> 
            '; 
        } 
    ) 
); 
 
// Include SQL query processing class 
require 'ssp.class.php'; 
 
// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns ) 
);

?>
