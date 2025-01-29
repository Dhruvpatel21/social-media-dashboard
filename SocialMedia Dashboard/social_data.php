<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Config
$accessToken = 'EAAZAZAY1u0NSABOwqFwGUkZA8dP5DwxE31N4VtNAbSI3qJshBqHZAnI5gH1DaC16dZAs0NMPmjYvkGB2cBei0ZB4ZAMNB24crbq9qpBf0N35YrYU7G6vERr5ZArrJOkqdkO1LTJSl8FVGtB7l0yAVLDu7S7wAbhyrbjk5rznlnvxylfyxZAMbzlXZCM793AKxHM3P3ivUoxTlD'; // Same token works for FB & IG
$instagramAccountId = '17841404489776558';
$facebookPageId = '530766456792360';
$pageId = '530766456792360'; // Replace with your Facebook Page ID
// facebook page access token
$pageAccessToken = 'EAAZAZAY1u0NSABO1TIpOesRUKd9hu6ViSp1zU7EhlI8Qg14zVHoPPpirVSOQqZA49hIFphmZBedaBH9pZBkAPBk0nGGTOUW9QPF2YLj1DFxSNkdkfWkCoW6Gcx0ZALGPr2a3nuiRc0G8X6z11ovRr5IXyvapkYkIZCHJpbADpA2ktLZAyJRVTdCUpXYQMuXEza3s8ZBVcZBhvuhaiDapc3neAqAWc7zZCLzVRhTaVh10rM2'; // Replace with your Page Access Token

$apiVersion = 'v19.0';

// Fetch Instagram Data
// function getInstagramData($accessToken, $instagramAccountId, $apiVersion) {
//     $url = "https://graph.facebook.com/{$apiVersion}/{$instagramAccountId}?" . 
//            "fields=followers_count,media{id,caption,media_url,permalink,like_count,comments_count,timestamp}&" . 
//            "access_token={$accessToken}";
//     $response = json_decode(file_get_contents($url), true);
//     return [
//         'followers' => $response['followers_count'] ?? 0,
//         'posts' => $response['media']['data'] ?? []
//     ];
// }

// Fetch Facebook Page Data
function getFacebookPosts($pageId, $pageAccessToken, $apiVersion) {
    $url = "https://graph.facebook.com/{$apiVersion}/{$pageId}/posts?" . 
           "fields=id,message,created_time,permalink_url,attachments{media},reactions.summary(true)&" . 
           "access_token={$pageAccessToken}&limit=10"; // Fetch last 10 posts

    $response = file_get_contents($url);
    if ($response === false) {
        throw new Exception("Failed to fetch data from Facebook API.");
    }

    $data = json_decode($response, true);
    if (isset($data['error'])) {
        throw new Exception("Facebook API Error: " . $data['error']['message']);
    }

    return $data['data'] ?? [];
}

// facebook page followers

// API URL to get followers count
$url = "https://graph.facebook.com/v19.0/{$pageId}?fields=followers_count&access_token={$pageAccessToken}";

// Fetch the response
$response = json_decode(file_get_contents($url), true);

// Handle any errors
if (isset($response['error'])) {
    die("Error: " . htmlspecialchars($response['error']['message']));
}
$followersCount = $response['followers_count'] ?? 0;


try {
    // Fetch all data
    // $instagram = getInstagramData($accessToken, $instagramAccountId, $apiVersion);
    $posts = getFacebookPosts($pageId, $pageAccessToken, $apiVersion);

} catch (Exception $e) {
    die("<div class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</div>");
}
?>