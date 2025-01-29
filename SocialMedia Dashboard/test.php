<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration
$pageId = '530766456792360'; // Replace with your Facebook Page ID
$pageAccessToken = 'EAAZAZAY1u0NSABOZCjKnXjxyxiWlfn0qZAZBM12sUb9T05xa0NDqIwZB4BeCWfY3ZCmc2x6mtZCrq5h5N3C0S3ywnTJHwpOyPKGZCZBNGV3VQ4lXGnZAXUFsq5BIZAyqUmYZBxQyT5yS0yPVqXSxqjZCcRR42kIpZBWThFfZAEvMHx4ImxFgThR7m1LgrKzZAhJZBTfAZAmYKRGX2UJM4cOaRPxZBdLUJZAQjrfq8kv178DmD3VUork1n'; // Replace with your Page Access Token
$apiVersion = 'v19.0'; // Use the latest API version

// Fetch Facebook Page Posts
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
    // Fetch posts
    $posts = getFacebookPosts($pageId, $pageAccessToken, $apiVersion);

} catch (Exception $e) {
    die("<div class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</div>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Facebook Page Posts</title>
    <style>
        :root {
            --facebook: #1877f2;
            --background: #f5f6f7;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--background);
            padding: 2rem;
        }

        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
        }

        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .post-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .post-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .post-details {
            padding: 1rem;
        }

        .post-message {
            color: #333;
            margin: 0.5rem 0;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .post-stats {
            display: flex;
            gap: 1rem;
            color: #666;
            font-size: 0.9rem;
        }

        .post-stats span {
            color: var(--facebook);
        }

        .error {
            color: red;
            padding: 2rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Facebook Page Posts</h1>
        <div class="posts-grid">
           
                <d <?php foreach ($posts as $post): ?>iv class="post-card">
                    <!-- Display Media (if available) -->
                    <?php if (isset($post['attachments']['data'][0]['media']['image']['src'])): ?>
                        <img src="<?php echo $post['attachments']['data'][0]['media']['image']['src']; ?>" class="post-image" alt="Post image">
                    <?php endif; ?>

                    <div class="post-details">
                        <!-- Post Message -->
                        <p class="post-message">
                            <?php echo substr($post['message'] ?? 'No message available', 0, 150); ?>...
                        </p>

                        <!-- Post Stats -->
                        <div class="post-stats">
                            <span>👍 <?php echo $post['reactions']['summary']['total_count'] ?? 0; ?></span>
                            <span>📅 <?php echo date('M d, Y', strtotime($post['created_time'])); ?></span>
                        </div>

                        <!-- Link to Post -->
                        <a href="<?php echo $post['permalink_url']; ?>" target="_blank" style="display: block; margin-top: 0.5rem; color: var(--facebook); text-decoration: none;">
                            View Post →
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>