<?php

declare(strict_types=1);
namespace App\Helpers;

use App\Exceptions\GlobalException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidatorHelper {
    public function validate(string $type, Request $request): array {
        $mapped = $this->key_map($request->all());
        $validated = Validator::make($mapped, $this->rules($type));
        
        if ($validated->fails()) {
            return [
                'status' => 'error',
                'message' => $validated->errors()->first(),
            ];
        }

        return [
            'status' => 'ok',
            'validated' => $validated->validated(),
        ]; 
    }

    private function key_map($to_map): array {

        $mapped = [];
        foreach($to_map as $key => $value) {
            if($value) {
                $mapped[keyHelper()->getKey($key)] = $value;
            }
        }

        return $mapped;
    }
    
    private function rules(string $type) {
        switch($type) {
            case 'accounts_save':
                return [
                    'type' => "required|integer|max:11",
                    'familycode' => "required|string|max:255",
                    'firstname' => "required|string|max:255",
                    'middlename' => "required|string|max:255",
                    'lastname' => "required|string|max:255",
                    'birthdate' => "required|string|max:255",
                    'phone' => "required|string|max:255",
                    'email' => "required|email|max:255",
                    'password' => "required|string|max:255",
                    'confirm_password' => "required|string|max:255",
                ];
            break;

            case 'task_save':
                return [
                    'name' => "required|string|max:255",
                    'description' => "required|string",
                    'status' => "required|integer|max:11",
                    'created_by' => "required|integer|max:11",
                ];
            break;

            case 'task_update':
                return [
                    'name' => 'sometimes|string|max:255',
                    'description' => 'sometimes|string',
                    'started_date' => 'sometimes',
                    'status' => 'sometimes|integer|max:11',
                    'completed_date' => 'sometimes',
                    'assigned_to' => 'sometimes|integer|max:11',
                    'approved_by' => 'sometimes|integer|max:11',
                    'created_by' => 'sometimes|integer|max:11',
                ];
            break;
        }
    }
}