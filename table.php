<?php
// Database configuration
$host = 'localhost';
$dbname = 'apartment_price_prediction';
$username = 'root';
$password = '';

try {
    // Create connection
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if not exists
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $pdo->exec($sql);
    echo "Database created successfully<br>";

    // Select the database
    $pdo->exec("USE $dbname");

    // Create predictions table for manual predictions
    $sql = "CREATE TABLE IF NOT EXISTS predictions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        metro_minutes FLOAT NOT NULL,
        area FLOAT NOT NULL,
        living_area FLOAT NOT NULL,
        kitchen_area FLOAT NOT NULL,
        floor INT NOT NULL,
        num_floors INT NOT NULL,
        num_rooms INT NOT NULL,
        apartment_type VARCHAR(50) NOT NULL,
        renovation VARCHAR(10) NOT NULL,
        predicted_price FLOAT NOT NULL,
        model_used VARCHAR(50) NOT NULL,
        prediction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'predictions' created successfully<br>";

    // Create csv_predictions table for CSV file predictions
    $sql = "CREATE TABLE IF NOT EXISTS csv_predictions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        file_name VARCHAR(255) NOT NULL,
        num_predictions INT NOT NULL,
        model_used VARCHAR(50) NOT NULL,
        prediction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'csv_predictions' created successfully<br>";

    // Create csv_prediction_details table for individual predictions from CSV
    $sql = "CREATE TABLE IF NOT EXISTS csv_prediction_details (
        id INT AUTO_INCREMENT PRIMARY KEY,
        csv_prediction_id INT NOT NULL,
        metro_minutes FLOAT NOT NULL,
        area FLOAT NOT NULL,
        living_area FLOAT NOT NULL,
        kitchen_area FLOAT NOT NULL,
        floor INT NOT NULL,
        num_floors INT NOT NULL,
        apartment_type VARCHAR(50) NOT NULL,
        renovation VARCHAR(10) NOT NULL,
        predicted_price FLOAT NOT NULL,
        FOREIGN KEY (csv_prediction_id) REFERENCES csv_predictions(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);
    echo "Table 'csv_prediction_details' created successfully<br>";

    // Create model_metrics table for storing model performance metrics
    $sql = "CREATE TABLE IF NOT EXISTS model_metrics (
        id INT AUTO_INCREMENT PRIMARY KEY,
        model_name VARCHAR(50) NOT NULL,
        mse FLOAT NOT NULL,
        mae FLOAT NOT NULL,
        r2_score FLOAT NOT NULL,
        update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'model_metrics' created successfully<br>";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 