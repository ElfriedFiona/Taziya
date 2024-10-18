<?php

$conn = mysqli_connect("localhost", "root", "", "taziya");

if (!$conn) {
    echo "Connection Failed";
}