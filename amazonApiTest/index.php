<?php
/*
 * AmazonAPIを叩いて書籍情報を取得するスクリプト
 */
$access_key_id     = 'AKIAIII42AH4WILWRGPA';
$secret_access_key = 'zM55JZTkwcor0OfMOSTLPDd7P7BK4aVfhSVxkXau';

function urlencode_rfc3986($str)
{
    return str_replace('%7E', '~', rawurlencode($str));
}

$baseurl                  = 'http://ecs.amazonaws.jp/onca/xml';
$params                   = array();
$params['Service']        = 'AWSECommerceService';
$params['AWSAccessKeyId'] = $access_key_id;
$params['Version']        = '2009-07-01';
$params['Operation']      = 'ItemLookup';
$params['ResponseGroup']  = 'Large';
$params['IdType']         = 'ISBN';
$params['SearchIndex']    = 'Books';
$params['ItemId']         = '4873038618';
$params['AssociateTag']   = 'hironorioka28-22';

$params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');

ksort($params);

$canonical_string = '';
foreach ($params as $k => $v) {
    $canonical_string .= '&' . urlencode_rfc3986($k) . '=' . urlencode_rfc3986($v);
}
$canonical_string = substr($canonical_string, 1);

$parsed_url = parse_url($baseurl);
$string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
$signature = base64_encode(hash_hmac('sha256', $string_to_sign, $secret_access_key, true));

$url = $baseurl . '?' . $canonical_string . '&Signature=' . urlencode_rfc3986($signature);

echo $url;
