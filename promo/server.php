<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
    $friend1_name = isset($_POST["friend1_name"]) ? $_POST["friend1_name"] : "";
    $friend2_name = isset($_POST["friend2_name"]) ? $_POST["friend2_name"] : "";
    $friend3_name = isset($_POST["friend3_name"]) ? $_POST["friend3_name"] : "";



    $data = "Name: $name, Email: $email, Phone: $phone, Friend_1: $friend1_name, Friend_2: $friend2_name, Friend_3: $friend3_name\n";

    file_put_contents("submission.txt", $data, FILE_APPEND);

    header("Content-Type: application/json");
    echo json_encode(["status" => "success", "message" => "Form submitted successfully!"]);
    exit();
} else {
    header("Content-Type: application/json");
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

?>
