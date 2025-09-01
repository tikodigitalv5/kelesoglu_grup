<?php

use CodeIgniter\I18n\Time;

function convert_datetime_for_sql($date){
    list($day, $month, $year) = explode("/", $date);
    $formatted_date = $year."/".$month."/".$day;
    return date("Y-m-d H:i:s", strtotime($formatted_date));
}

function convert_datetime_for_sql_time($date, $time){
    list($day, $month, $year) = explode("/", $date);
    $formatted_date = $year."/".$month."/".$day;
    return date("Y-m-d H:i:s", strtotime($formatted_date . " " . $time));
}

function convert_date_for_sql($date){
    return date("Y-m-d", strtotime($date));
}

function convert_datetime_for_form($date){
    return date("Y/m/d H:i:s", strtotime($date));
}

function convert_date_for_form($date){
    return date("Y/m/d", strtotime($date));
}

function convert_time_for_form($date){
    return date("H:i:s", strtotime($date));
}

function current_time(){
    return new Time('now', 'Europe/Istanbul', 'tr_TR');
}

function humanize($date){
    return Time::parse($date, 'Europe/Istanbul', 'tr_TR')->humanize();
}

function create_str_to_time($date){
    return Time::parse($date, 'Europe/Istanbul');
}

function convert_datetime_for_view($date){
    return date("d/m/Y H:m:i", strtotime($date));
}

function convert_date_for_view($date){
    return date("d/m/Y", strtotime($date));
}

