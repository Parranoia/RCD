<?php
    error_reporting(E_ERROR | E_COMPILE_ERROR | E_CORE_ERROR);

    $require_verify_email = false; // Set to false if you don't need the user to activate their accounts

    $email_config = array();
    $email_config['host'] = 'www.example.com';
    $email_config['port'] = 465;
    $email_config['username'] = 'username@example.com';
    $email_config['password'] = 'password';
    
    $username = "root";
    $password = "justwhatever1";
    $host = "localhost";
    $dbname = "RCD";

    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

    try
    {
        $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);
    } 
    catch (PDOException $e)
    {
        die("Failed to connect to the database: " . $e->getMEssage());
    }

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    header('Content-Type: text/html; charset=utf-8');

    session_start();