<?php

// require HelloSign SDK
require_once '../hs_sdk/vendor/autoload.php';

// create signature request
$client = new HelloSign\Client('16da700985354f875a843cd83458ec93d615f4125c60dc63eda6b1c4c27f31e3');
$request = new HelloSign\SignatureRequest;
$request->enableTestMode();
$request->setSubject('My first embedded signature request');
$request->addSigner('editor@sitepoint.com', 'SitePoint Editor');
$request->addFile("document.pdf");

$client_id = '641be717bbc132e01a8068ddb86183ee';
$embedded_request = new HelloSign\EmbeddedSignatureRequest($request, $client_id);

// get the response
$response = $client->createEmbeddedSignatureRequest($embedded_request);

// get signature ID - just one signer in this example
$signatures   = $response->getSignatures();
$signature_id = $signatures[0]->getId();

// get embedded signature URL
$embeddedURL = $client->getEmbeddedSignUrl($signature_id);
$url = $embeddedURL->getSignUrl();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sample Document</title>
</head>
<body>


<script src="https://s3.amazonaws.com/cdn.hellosign.com/public/js/hellosign-embedded.LATEST.min.js"></script>
<script>
    HelloSign.init("641be717bbc132e01a8068ddb86183ee");
    HelloSign.open({
        url: "<?=$url?>",     
        allowCancel: true,
        skipDomainVerification: true
    });
</script>
</body>
</html>