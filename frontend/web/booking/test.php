<?php
var_dump(file_get_contents('http://google.com/'));
var_dump(file_get_contents('http://localhost/'));
$data = file_get_contents('http://es.servio.com.ua:8077/ReservationService_1_9');
die($data);