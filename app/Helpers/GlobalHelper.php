<?php

declare(strict_types=1);
namespace App\Helpers;

class GlobalHelper {
    
    public function apiResponse() {
        return [
            'message' => 'testing message'
        ];
    }

    public function generateFamilyCode() {
        return "FMLY-".date("ymdhis").substr(str_shuffle('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
    }
}