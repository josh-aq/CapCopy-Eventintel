<?php
require_once __DIR__ . '/../config/db.php';
header('Content-Type: application/json');
$in = json_decode(file_get_contents('php://input'), true) ?: [];
$event = $in['event'] ?? 'Event';
$budget = $in['budget'] ?? '0';
$pax = $in['pax'] ?? '0';
$services = $in['services'] ?? [];

$prompt = "Create an event program flow and supplier/service recommendations for: Event=$event, Budget=$budget PHP, Guests=$pax, Needed services=".implode(', ', $services).". Keep it concise.";

if (OPENAI_API_KEY) {
    $payload = ["model"=>"gpt-4o-mini","messages"=>[["role"=>"user","content"=>$prompt]]];
    $ch = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER=>true,
        CURLOPT_POST=>true,
        CURLOPT_HTTPHEADER=>["Content-Type: application/json","Authorization: Bearer ".OPENAI_API_KEY],
        CURLOPT_POSTFIELDS=>json_encode($payload)
    ]);
    $raw = curl_exec($ch);
    $json = json_decode($raw,true);
    $txt = $json['choices'][0]['message']['content'] ?? '';
    if ($txt) {
        echo json_encode(["html"=>nl2br(esc($txt))]);
        exit;
    }
}
$list = $services ? implode('<br>• ', array_map('esc',$services)) : 'Venue<br>• Catering<br>• Host<br>• Photographer';
$html = "<b>Event:</b> ".esc($event)."<br><b>Budget:</b> ₱".esc($budget)."<br><b>Pax:</b> ".esc($pax).
"<br><br><b>Recommended Services:</b><br>• ".$list.
"<br><br><b>AI Program Flow:</b><br>• Guest Arrival and Registration<br>• Opening Remarks<br>• Main Event Activity<br>• Food Service<br>• Entertainment / Photo Session<br>• Closing Remarks";
echo json_encode(["html"=>$html]);
?>