<?php
 
 header("Content-Type: application/json");
 
 // Get raw POST data
 $data = file_get_contents("php://input");
 print_r($data);
 
 // Decode JSON data into PHP array
 $formData = json_decode($data, true);
 
 if ($formData) {
    $file = 'guestlist.json';
    $fileBackup = 'backup.json';
    // Check if file exists and read current data
    if (file_exists($file)) {
        $currentData = json_decode(file_get_contents($file), true);
        if (!is_array($currentData)) {
           $currentData = [];
        }
    } else {
        $currentData = [];
    }
 
    // Append new data
    $currentData[] = $formData;
 
    // Save updated data to guestlist.json
    file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT));
 
    // Save updated data to backup.json
    file_put_contents($fileBackup, json_encode($currentData, JSON_PRETTY_PRINT));
 
    echo json_encode(["status" => "success", "message" => "Data saved successfully"]);
 } else {
     echo json_encode(["status" => "error", "message" => "Invalid data received"]);
 }
 ?>