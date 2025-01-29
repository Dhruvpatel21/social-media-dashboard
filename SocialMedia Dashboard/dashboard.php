<?php 
include "instagram_data.php";
include "social_data.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Social Media Dashboard</title>
    <style>
        /* Base Styles */
        :root {
            --instagram: #e4405f;
            --facebook: #1877f2;
            --background: #f5f6f7;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--background);
            padding: 2rem;
        }

        .dashboard {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .tab-button {
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            background: white;
            font-weight: bold;
        }

        .tab-button.active {
            color: white;
        }

        #instagram-tab.active { background: var(--instagram); }
        #facebook-tab.active { background: var(--facebook); }

        /* Stats Header */
        .stats-header {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .follower-count {
            font-size: 2.5rem;
            margin: 0.5rem 0;
        }

        /* Posts Grid (Shared Styles) */
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
            height: 250px;
            object-fit: cover;
        }

        /* Facebook-Specific Styles */
        .facebook-post .post-stats {
            color: var(--facebook);
        }

        /* Instagram-Specific Styles */
        .instagram-post .post-stats {
            color: var(--instagram);
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Tabs -->
        <div class="tabs">
            <button class="tab-button active" id="instagram-tab" onclick="showTab('instagram')">Instagram</button>
            <button class="tab-button" id="facebook-tab" onclick="showTab('facebook')">Facebook</button>
        </div>

        <!-- Instagram Content -->
        <div id="instagram-content" class="tab-content">
            <div class="stats-header">
                <h1>Instagram Analytics</h1>
                <div class="follower-count" style="color: var(--instagram);">
                    Followers: <?php echo number_format($instagram['followers']); ?>
                </div>
            </div>

            <div class="posts-grid">
                <?php foreach ($instagram['posts'] as $post): ?>
                    <div class="post-card instagram-post">
                        <img src="<?php echo $post['media_url']; ?>" class="post-image" alt="Instagram post">
                        <div class="post-details">
                            <p class="post-caption"><?php echo substr($post['caption'] ?? 'No caption', 0, 100); ?>...</p>
                            <div class="post-stats">
                                <span>❤️ <?php echo number_format($post['like_count']); ?></span>
                                <span>💬 <?php echo number_format($post['comments_count']); ?></span>
                                <a href="<?php echo $post['permalink']; ?>" target="_blank">View Post →</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Facebook Content -->
        <div id="facebook-content" class="tab-content" style="display: none;">
            <div class="stats-header">
                <h1>Facebook Page Post</h1>
                <div class="follower-count" style="color: var(--facebook);">
                Followers: <?php echo number_format($followersCount); ?>
                </div>
            </div>

            <<div class="posts-grid">
            <?php foreach ($posts as $post): ?>
                    <div class="post-card instagram-post">
                            
                        <?php if (isset($post['attachments']['data'][0]['media']['image']['src'])): ?>
                        <img src="<?php echo $post['attachments']['data'][0]['media']['image']['src']; ?>" class="post-image" alt="Post image">
                    <?php endif; ?>

                        <div class="post-details">
                            <p class="post-caption"><?php echo substr($post['message'] ?? 'No message available', 0, 150); ?>...</p>
                            <div class="post-stats">
                                <span>❤️ <?php echo $post['reactions']['summary']['total_count'] ?? 0; ?></span>
                                <span>💬 <?php echo date('M d, Y', strtotime($post['created_time'])); ?></span>
                                <a href="<?php echo $post['permalink_url']; ?>" target="_blank">View Post →</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        // Tab Switching
        function showTab(platform) {
            document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.tab-button').forEach(el => el.classList.remove('active'));
            document.getElementById(`${platform}-content`).style.display = 'block';
            document.getElementById(`${platform}-tab`).classList.add('active');
        }
    </script>
</body>
</html>