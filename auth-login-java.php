<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra key
if(empty($data['key'])) {
    echo json_encode(['success' => false, 'message' => 'Key không được trống']);
    exit;
}

$key = $data['key'];
$keys = json_decode(file_get_contents('keys.json'), true);

// Tìm key trong database
$isValid = false;
foreach($keys as $k) {
    if($k['value'] === $key) {
        $isValid = true;
        break;
    }
}

if($isValid) {
    echo json_encode(['success' => true, 'message' => 'Xác thực thành công']);
} else {
    echo json_encode(['success' => false, 'message' => 'Key không hợp lệ']);
}
