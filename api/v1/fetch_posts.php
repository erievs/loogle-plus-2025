<?php

header('Content-Type: application/json');

require_once '../../important/config.php';

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

class PostAPI
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchPosts(array $params): array
    {
        $community = isset($params['community']) ? $params['community'] : null;
        $page = isset($params['page']) && is_numeric($params['page']) && (int)$params['page'] > 0 
        ? (int)$params['page'] 
        : 1;  
        $pageSize = isset($params['page_size']) && is_numeric($params['page_size']) && (int)$params['page_size'] > 0 
        ? (int)$params['page_size'] 
        : 15;  
        $showAll = isset($params['show_all']) && $params['show_all'] === 'true';
        $searchQuery = isset($params['search']) ? $params['search'] : '';

        if ($showAll) {
            $page = 1;
            $pageSize = PHP_INT_MAX;
        }

        $offset = ($page - 1) * $pageSize;

        try {

            $sql = "SELECT * FROM posts";
            $queryParams = [];
            
            if ($searchQuery) {
                $sql .= " WHERE content LIKE :search_query"; 
                $queryParams['search_query'] = '%' . $searchQuery . '%'; 
            }
            
            if ($community) {
                $sql .= $searchQuery ? " AND community = :community" : " WHERE community = :community";
                $queryParams['community'] = $community;
            }
            
            $sql .= " ORDER BY created_at ASC LIMIT " . (int)$pageSize . " OFFSET " . (int)$offset;
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($queryParams);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($posts) && $searchQuery) {

                $posts = [
                    [
                        'id' => 0,
                        'content' => 'No Results found, 1984',
                        'createdssssat' => date('1984'),
                        'community' => 'internal',
                        'user_id' => 0, 
                        'username' => 'Big Brother', 
                        'comments' => []
                    ]
                ];
            } else {

                foreach ($posts as &$post) {
                    $postId = $post['id'];
                    $commentStmt = $this->pdo->prepare("SELECT * FROM comments WHERE post_id = :post_id ORDER BY created_at DESC");
                    $commentStmt->execute(['post_id' => $postId]);
                    $comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);

                    $post['comments'] = $comments;
                }
            }

            return $this->response('success', 'Posts fetched successfully', [
                'posts' => $posts,
                'pagination' => $this->getPagination($page, $pageSize, $searchQuery, $community)
            ]);
        } catch (PDOException $e) {
            return $this->response('error', 'Database error: ' . $e->getMessage());
        }
    }

    private function getPagination(int $page, int $pageSize, ?string $searchQuery, ?string $community): array
    {
        $sql = "SELECT COUNT(*) FROM posts";
        $queryParams = [];

        if ($searchQuery) {
            $sql .= " WHERE content LIKE :search_query";
            $queryParams['search_query'] = '%' . $searchQuery . '%';
        }

        if ($community) {
            $sql .= $searchQuery ? " AND community = :community" : " WHERE community = :community";
            $queryParams['community'] = $community;
        }

        $countStmt = $this->pdo->prepare($sql);
        $countStmt->execute($queryParams);
        $totalPosts = $countStmt->fetchColumn();

        $totalPages = ceil($totalPosts / $pageSize);

        $pagination = [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_posts' => $totalPosts,
            'page_size' => $pageSize
        ];

        if ($page < $totalPages) {
            $pagination['next_url'] = $this->generatePageUrl($page + 1, $pageSize, $community, $searchQuery);
        } else {
            $pagination['next_url'] = null;
        }

        return $pagination;
    }

    private function generatePageUrl(int $page, int $pageSize, ?string $community, ?string $searchQuery): string
    {
        $url = SITE_URL . "/api/v1/fetch_posts.php?page=" . $page . "&page_size=" . $pageSize;
        if ($community) {
            $url .= "&community=" . urlencode($community);
        }
        if ($searchQuery) {
            $url .= "&search=" . urlencode($searchQuery);
        }
        return $url;
    }

    private function response(string $status, string $message, array $data = []): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }
}

$requestData = $_GET; 

$api = new PostAPI($pdo);
$response = $api->fetchPosts($requestData);

echo json_encode($response);

?>