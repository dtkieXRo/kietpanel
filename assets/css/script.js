// Tạo GitHub token tại: https://github.com/settings/tokens
// Cần quyền: repo, workflow
const GITHUB_TOKEN = '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';
const YOUR_USERNAME = 'dtkieXRo';
const YOUR_REPO = 'kietpanel';

// Hàm gọi GitHub API
async function callGitHubAPI(endpoint, method = 'GET', body = null) {
    try {
        const response = await fetch(`https://api.github.com/${endpoint}`, {
            method,
            headers: {
                'Authorization': `Bearer ${GITHUB_TOKEN}`,
                'Accept': 'application/vnd.github.v3+json',
                ...(body && {'Content-Type': 'application/json'})
            },
            body: body ? JSON.stringify(body) : null
        });
        
        if (!response.ok) {
            throw new Error(`GitHub API error: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('API call failed:', error);
        throw error;
    }
}

// Hàm tạo key mới
async function createKey() {
    try {
        await callGitHubAPI(`repos/${YOUR_USERNAME}/${YOUR_REPO}/dispatches`, 'POST', {
            event_type: 'create-key'
        });
        
        return { success: true, message: 'Key đang được tạo...' };
    } catch (error) {
        return { success: false, message: error.message };
    }
}

// Hàm xóa key
async function deleteKey(keyValue) {
    try {
        await callGitHubAPI(`repos/${YOUR_USERNAME}/${YOUR_REPO}/dispatches`, 'POST', {
            event_type: 'delete-key',
            client_payload: {
                key: keyValue
            }
        });
        
        return { success: true, message: 'Key đang được xóa...' };
    } catch (error) {
        return { success: false, message: error.message };
    }
}

// Hàm kiểm tra key
async function validateKey(keyValue) {
    try {
        await callGitHubAPI(`repos/${YOUR_USERNAME}/${YOUR_REPO}/dispatches`, 'POST', {
            event_type: 'validate-key',
            client_payload: {
                key: keyValue
            }
        });
        
        // Trong thực tế cần lấy kết quả từ artifact
        // Giả sử luôn thành công cho demo
        return { success: true, message: 'Key hợp lệ' };
    } catch (error) {
        return { success: false, message: 'CON CẶC KEY SAI RỒI' };
    }
}
