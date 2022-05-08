<?php
const USERNAME = "system";
const PASSWORD = "Tien123";
const DATABASE = "localhost/orcl";

function connection()
{
    $connect = oci_connect(USERNAME, PASSWORD, DATABASE, 'AL32UTF8');
    if (oci_error($connect)) {
        die("Connection failed");
    }
    return $connect;
}

function Query($sql)
{
    $connect = connection();
    $query = oci_parse($connect, $sql);
    $execute = oci_execute($query);
    if (!$execute) {
        return 0;
    }
    oci_close($connect);
    return $query;
}

function GetObjectArray($sql)
{
    $arr = array();
    $connect = connection();
    $query = oci_parse($connect, $sql);
    oci_execute($query, OCI_DEFAULT);
    while ($Row = oci_fetch_array($query, OCI_ASSOC + OCI_RETURN_NULLS)) {
        $arr[] = $Row;
    }
    oci_close($connect);
    return $arr;
}

function GetRows($sql)
{
    $connect = connection();
    $query = oci_parse($connect, $sql);
    oci_define_by_name($query, 'NUMBER_OF_ROWS', $number_of_rows);
    oci_execute($query);
    oci_fetch($query);
    oci_close($connect);
    return $number_of_rows;
}