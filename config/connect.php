<?php
const HOSTNAME= "localhost";
const USERNAME = "root";
const PASSWORD = "";
const DATABASE = "neongrid";

const CONN = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);

if (CONN->connect_errno)
{
    die('Database connection failed '. CONN->connect_error);
}