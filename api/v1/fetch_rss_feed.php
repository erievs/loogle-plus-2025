<?php

header('Content-Type: application/rss+xml; charset=UTF-8');  

header('Content-Disposition: attachment; filename="feed.xml"'); 

require_once '../../important/config.php';

class PostAPI
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchPosts(): array
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM posts ORDER BY created_at DESC");
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = [];
            foreach ($posts as &$post) {
                $postId = $post['id'];
                $commentStmt = $this->pdo->prepare("SELECT * FROM comments WHERE post_id = :post_id ORDER BY created_at DESC");
                $commentStmt->execute(['post_id' => $postId]);
                $comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);

                $post['comments'] = $comments;
            }

            return $posts; 
        } catch (PDOException $e) {
            return []; 
        }
    }
}

$api = new PostAPI($pdo);
$posts = $api->fetchPosts();

$rssFeed = '<?xml version="1.0" encoding="UTF-8"?>';
$rssFeed .= '<rss version="2.0">';
$rssFeed .= '<channel>';
$rssFeed .= '<title>Loogle Plus Homepage</title>';
$rssFeed .= '<link>' . SITE_URL . '</link>';
$rssFeed .= '<description>Latest posts and their comments</description>';
$rssFeed .= '<language>en-us</language>';

foreach ($posts as $post) {

    $rssFeed .= '<item>';
    $rssFeed .= '<title>' . htmlspecialchars($post['content']) . '</title>';
    $rssFeed .= '<link>' . SITE_URL . '/post.php?id=' . $post['id'] . '</link>';
    $rssFeed .= '<description>' . htmlspecialchars($post['content']) . '</description>';
    $rssFeed .= '<pubDate>' . date(DATE_RSS, strtotime($post['created_at'])) . '</pubDate>';
    $rssFeed .= '<guid>' . SITE_URL . '/post.php?id=' . $post['id'] . '</guid>';

    if (!empty($post['comments'])) {
        $rssFeed .= '<comments>';
        foreach ($post['comments'] as $comment) {
            $rssFeed .= '<comment>';
            $rssFeed .= '<author>' . htmlspecialchars($comment['username']) . '</author>';
            $rssFeed .= '<content>' . htmlspecialchars($comment['content']) . '</content>';
            $rssFeed .= '<pubDate>' . date(DATE_RSS, strtotime($comment['created_at'])) . '</pubDate>';
            $rssFeed .= '</comment>';
        }
        $rssFeed .= '</comments>';
    }

    $rssFeed .= '</item>';
}

$rssFeed .= '</channel>';
$rssFeed .= '</rss>';

echo $rssFeed;

?>