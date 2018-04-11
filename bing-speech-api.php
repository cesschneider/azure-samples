<?php

$key = '<YOUR_SERVICE_KEY>';
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_VERBOSE, 1);
//curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_URL, "https://api.cognitive.microsoft.com/sts/v1.0/issueToken");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	"Ocp-Apim-Subscription-Key: {$key}",
	'Content-Length: 0',
	'User-Agent: Bing Speech Client'
));
$token = curl_exec($ch);
print(curl_getinfo($ch, CURLINFO_HTTP_CODE));

curl_setopt($ch, CURLOPT_URL, "https://speech.platform.bing.com/synthesize");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	"Authorization: Bearer {$token}",
	'Content-Type: application/ssml+xml',
	'X-Microsoft-OutputFormat: audio-16khz-32kbitrate-mono-mp3',
	'User-Agent: Bing Speech Client'
));
$body = "<speak version='1.0' xml:lang='en-US'><voice xml:lang='pt-BR' xml:gender='Female' name='Microsoft Server Speech Text to Speech Voice (pt-BR, HeloisaRUS)'>Muito bem! Agora estou usando a conta da Microsoft.</voice></speak>";
curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
$response = curl_exec($ch);
print(curl_getinfo($ch, CURLINFO_HTTP_CODE));
file_put_contents('output.mp3', $response);

?>