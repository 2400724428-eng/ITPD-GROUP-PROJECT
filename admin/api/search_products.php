<?php
require_once __DIR__ . '/../../includes/db_connect.php';

header('Content-Type: application/json');

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

try {
    $sql = "
        SELECT 
            p.id, 
            p.product_name AS name, 
            p.category AS cat, 
            p.product_price AS price, 
            p.offer_price AS offer, 
            p.discount_percentage AS discount, 
            p.unit_type AS unit, 
            p.image_primary AS img,
            COALESCE(ROUND(AVG(c.rating), 1), 0) AS real_rating,
            COUNT(c.id) AS real_reviews
        FROM products p
        LEFT JOIN comments c ON p.id = c.product_id
        WHERE 1=1
    ";

    $params = [];

    if ($query !== '') {
        // Use LIKE with % to match any product name containing or starting with the letters
        $sql .= " AND (p.product_name LIKE ? OR p.category LIKE ?)";
        $params[] = "%{$query}%";
        $params[] = "%{$query}%";
    }

    $sql .= " GROUP BY p.id ORDER BY p.id DESC LIMIT 20";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format products for frontend consumption
    $formatted = array_map(function($p) {
        $price = (float)$p['price'];
        $offer = (float)$p['offer'];
        $effectivePrice = ($offer > 0 && $offer < $price) ? $offer : $price;
        $discount = (float)$p['discount'];
        
        if ($discount <= 0 && $offer > 0 && $offer < $price) {
            $discount = round((($price - $offer) / $price) * 100);
        }

        return [
            'id'      => (int)$p['id'],
            'name'    => $p['name'],
            'cat'     => $p['cat'] ?: 'General',
            'price'   => $effectivePrice,
            'old'     => ($offer > 0 && $offer < $price) ? $price : null,
            'unit'    => $p['unit'] ? ('/' . $p['unit']) : '',
            'rating'  => (float)$p['real_rating'], 
            'reviews' => (int)$p['real_reviews'],  
            'off'     => round($discount),
            'img'     => !empty($p['img']) ? $p['img'] : 'https://images.unsplash.com/photo-1546483875-ad9014c88eba?auto=format&fit=crop&w=500&q=80'
        ];
    }, $products);

    echo json_encode(['success' => true, 'products' => $formatted]);
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}