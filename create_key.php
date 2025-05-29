<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if(empty($data['key'])) {
    echo json_encode(['success' => false, 'message' => 'Key không được trống']);
    exit;
}

$key = $data['key'];
$keys = json_decode(file_get_contents('../keys.json'), true);

// Kiểm tra trùng lặp
foreach($keys as $k) {
    if($k['value'] === $key) {
        echo json_encode(['success' => false, 'message' => 'Key đã tồn tại']);
        exit;
    }
}

// Thêm key mới
$keys[] = ['value' => $key, 'created' => date('Y-m-d H:i:s')];
file_put_contents('../keys.json', json_encode($keys, JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'message' => 'Key đã được tạo']);
