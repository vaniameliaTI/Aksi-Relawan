<?php
class TestController {
    public function test() {
        return [
            'status' => 'success',
            'message' => 'Backend is connected successfully!',
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
}
?> 