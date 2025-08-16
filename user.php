<?php
header("Content-Type:application/json");
include 'db.php';


//GET ALL DATA
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode([
        "status" => "success",
        "data" => $users
    ]);
}

// POST DATA
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $name = $data["name"];
    $email = $data["email"];

    $sql = "INSERT INTO users (name,email) VALUES ('$name','$email')";

    if ($conn->query($sql)) {
        echo json_encode(["status" => "success", "message" => "user addedd"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}

// UPDATE DATA
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $data = json_decode(file_get_contents("php://input"), true);

        $name = $data["name"];
        $email = $data["email"];

        $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id";

        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "user updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing id parameter"]);
    }
}

//DELETE DATA
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $sql = "DELETE FROM users WHERE id=$id";

        if ($conn->query($sql)) {
            echo json_encode(["status" => "succes", "message" => "user deleted"]);
        }else{
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
    }else{
        echo json_encode(["status" => "error", "message" => "Missing parameters"]);
    }
}
