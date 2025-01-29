<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$accessToken = 'EAAZAZAY1u0NSABOwqFwGUkZA8dP5DwxE31N4VtNAbSI3qJshBqHZAnI5gH1DaC16dZAs0NMPmjYvkGB2cBei0ZB4ZAMNB24crbq9qpBf0N35YrYU7G6vERr5ZArrJOkqdkO1LTJSl8FVGtB7l0yAVLDu7S7wAbhyrbjk5rznlnvxylfyxZAMbzlXZCM793AKxHM3P3ivUoxTlD';
$instagramAccountId = '17841404489776558';
$apiVersion = 'v18.0';

// Fetch Followers
// function getInstagramFollowers($accessToken, $instagramAccountId, $apiVersion) {
//     $url = "https://graph.facebook.com/{$apiVersion}/{$instagramAccountId}?fields=followers_count&access_token={$accessToken}";
//     $response = json_decode(file_get_contents($url), true);
//     return $response['followers_count'] ?? 0;
// }

// // Fetch Posts (Last 12 posts)
// function getInstagramPosts($accessToken, $instagramAccountId, $apiVersion) {
//     $url = "https://graph.facebook.com/{$apiVersion}/{$instagramAccountId}/media?fields=id,caption,media_url,permalink,like_count,comments_count,timestamp&access_token={$accessToken}&limit=12";
//     $response = json_decode(file_get_contents($url), true);
//     return $response['data'] ?? [];
// }

//fetch instagram Data 
function getInstagramData($accessToken, $instagramAccountId, $apiVersion) {
    $url = "https://graph.facebook.com/{$apiVersion}/{$instagramAccountId}?" . 
           "fields=followers_count,media{id,caption,media_url,permalink,like_count,comments_count,timestamp}&" . 
           "access_token={$accessToken}";
    $response = json_decode(file_get_contents($url), true);
    return [
        'followers' => $response['followers_count'] ?? 0,
        'posts' => $response['media']['data'] ?? []
    ];
}


try {
    // Fetch all data
    $instagram = getInstagramData($accessToken, $instagramAccountId, $apiVersion);
    // $posts = getFacebookPosts($pageId, $pageAccessToken, $apiVersion);

} catch (Exception $e) {
    die("<div class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</div>");
}
?>