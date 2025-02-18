<?php

declare(strict_types=1);
namespace App\Helpers;

class KeysHelper {
    private const KEYS = [
        "BirthDate" => "birthdate",
        "ConfirmPassword" => "confirm_password",
        "Email" => "email",
        "FamilyCode" => "familycode",
        'FirstName' => "firstname",
        'Id' => "id",
        'LastName' => "lastname",
        'MiddleName' => "middlename",
        "Otp" => "otp", 
        'Password' => "password",
        'ContactNo' => "phone",
        "Remarks" => "remarks",
        "TaskName" => "name",
        "TaskDescription" => "description",
        "TaskStartedDate" => "started_date",
        "TaskStatus" => "status",
        "TaskCompletedDate" => "completed_date",
        "TaskAssignedTo" => "assigned_to",
        "TaskApprovedBy" => "approved_by",
        "TaskCreatedBy" => "created_by",
        "Type" => "type",
        'Username' => "username",
    ];
    
    public function getKey(string $key_index): string {
        return self::KEYS[$key_index];
    }
}