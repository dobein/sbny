<?

require_once 'authorize_dpm/anet_php_sdk/AuthorizeNet.php'; // The SDK

$redirect_url = "http://www.germaniumjapan.com/shopping/checkout_finish.php"; //Where the userwill end up.
$api_login_id = 'fxx6hcgv';
$md5_setting = "germanium"; // Your MD5 Setting


$response = new AuthorizeNetSIM($api_login_id, $md5_setting);
if ($response->isAuthorizeNet())
{
	if ($response->approved)
	{
		// Do your processing here.


		$redirect_url .= '?payment_method=CREDITCARD&response_code=1&transaction_id=' .
		$response->transaction_id;
	}
	else
	{
		$redirect_url .= '?payment_method=CREDITCARD&response_code='.$response->response_code .'&response_reason_text=' . $response->response_reason_text;
	}
	// Send the Javascript back to AuthorizeNet, which will redirect user back toyour site.
	echo AuthorizeNetDPM::getRelayResponseSnippet($redirect_url);
}
else
{
	echo "Error. Check your MD5 Setting.";
}

?>