<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if(empty($data['key'])) {
    echo json_encode(['success' => false, 'message' => 'Key không được trống']);
    exit;
}

$key = $data['key'];
$keys = json_decode(file_get_contents('../keys.json'), true);
$newKeys = [];

// Lọc key cần xóa
foreach($keys as $k) {
    if($k['value'] !== $key) {
        $newKeys[] = $k;
    }
}

// Kiểm tra xóa thành công
if(count($newKeys) < count($keys)) {
    file_put_contents('../keys.json', json_encode($newKeys, JSON_PRETTY_PRINT));
    echo json_encode(['success' => true, 'message' => 'Key đã xóa']);
} else {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy key']);
}
