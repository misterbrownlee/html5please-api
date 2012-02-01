<?php

$callback = isset($_GET['callback']) ? $_GET['callback'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : 'js';
$features = isset($_GET['features']) ? explode(' ', $_GET['features']) : array();

if ($type === 'json')
{
	header('Content-Type: text/json');
}

if ($type === 'js')
{
	header('Content-Type: text/javascript');
}

if (!$features)
{
	exit();
}

$jsonName = 'data.json';

$jsonText = file_get_contents($jsonName);

$jsonData = json_decode($jsonText, true);

$jsonDataData = $jsonData['data'];

$jsonDataDataCustom = array();

foreach ($features as $featureName)
{
	if (isset($jsonDataData[$featureName]))
	{
		$featureData = $jsonDataData[$featureName];
		$featureStats = $featureData['stats'];

		$jsonDataDataCustom[$featureName] = $featureData;
	}
}

if ($callback)
{
	exit($callback . '(' . json_encode($jsonDataDataCustom) . ');');
}
else
{
	exit(json_encode($jsonDataDataCustom));
}

?>