<?php
require __DIR__ . "/config.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

if (!defined("GEMINI_API_KEY") || GEMINI_API_KEY === "") {
    http_response_code(500);
    echo json_encode(["error" => "Missing API key"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
$message = trim((string) ($input["message"] ?? ""));

if ($message === "") {
    http_response_code(400);
    echo json_encode(["error" => "Message required"]);
    exit;
}

$systemInstruction = "You are HopeCare's helpful, compassionate assistant. You focus on orphan support, education, health, safety, and ways people can help. Avoid medical, legal, or financial advice. Encourage contacting local authorities for emergencies.";

$payload = [
    "systemInstruction" => ["parts" => [["text" => $systemInstruction]]],
    "contents" => [
        ["role" => "user", "parts" => [["text" => $message]]]
    ],
    "generationConfig" => [
        "temperature" => 0.6,
        "maxOutputTokens" => 350
    ]
];

$endpoint = "https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key=" . GEMINI_API_KEY;

$ch = curl_init($endpoint);
if ($ch === false) {
    http_response_code(500);
    echo json_encode(["error" => "cURL not available"]);
    exit;
}
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($response === false || $httpCode >= 400) {
    http_response_code(502);
    echo json_encode([
        "error" => "Chat service unavailable",
        "detail" => $curlError,
        "status" => $httpCode,
        "raw" => $response
    ]);
    exit;
}

$data = json_decode($response, true);
$jsonError = json_last_error();

if ($jsonError !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo json_encode(["error" => "Invalid JSON response"]);
    exit;
}
$text = $data["candidates"][0]["content"]["parts"][0]["text"] ?? "";

if ($text === "") {
    http_response_code(500);
    echo json_encode(["error" => "Empty response"]);
    exit;
}

header("Content-Type: application/json");
echo json_encode(["reply" => $text]);
