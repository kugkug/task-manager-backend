<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\GlobalException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function parent_register(Request $request) {

        try {

            $family_code = $request->Type !== User::TYPES['Child'] ? globalHelper()->generateFamilyCode() : $request->FamilyCode;
        
            $validated = validatorHelper()->validate('accounts_save',  $request->merge(['FamilyCode' => $family_code]));
            
            if ($validated['status'] === "error") {
                return $validated;
            }

            if ($validated['validated']['password'] !== $validated['validated']['confirm_password']) {
                return [
                    'status' => 'error',
                    'message' => 'Password did not match!',
                ];
            }

            $user = User::create($validated['validated']);

            return [
                'status' => 'ok',
                'detailes' => $user,
            ];

        } catch(QueryException $qe) {
            Log::channel('info')->info("Exception : ".$qe->getMessage());
            $errorCode = $qe->errorInfo[1];
            if($errorCode == 1062) {
                return [
                    'status' => 'error',
                    'message' => 'Email already exists!',
                ];
            }
            
            throw new GlobalException();
        } catch (Exception $e) {
            Log::channel('info')->info("Exception : ".$e->getMessage());
            throw new GlobalException();
        }
        
    }

    public function login(Request $request) {
        
        try {

            $data = $request->validate([
                'email' => 'required|string',
                'password' => 'required',
            ]);
    

            if (! Auth::attempt($data)) {
                throw new GlobalException('Invalid Username or Password', 400);
            }
            
            $user = User::where('email', $data['email'])->first();

            return response()->json([
                'status' => 'ok',
                'info' => [
                    'user_id' => Auth::id(),
                    'user_type' => join("", array_keys(User::TYPES, $user->type)),
                    'access_token' => $user->createToken('api_token')->plainTextToken,
                    'token_type' => 'Bearer',
                ],
            ]);

        } catch(GlobalException $ge) {
            Log::channel('info')->info($ge->getMessage());
            throw new GlobalException('Invalids Username or Password', 400);
        } catch (Exception $e) {
            Log::channel('info')->info($e->getMessage(), $e->getTrace());
            throw new GlobalException();
        }
    }

    public function logout(Request $request) {

        try {
            $request->user()->tokens()->delete();
            // Auth::user()->currentAccessToken()->delete();
            
            return response()->json([
                'status' => 'ok',
                'info' => [],
            ]);
        } catch(GlobalException $ge) {
            Log::channel('info')->info($ge->getMessage());
            throw new GlobalException('Cannot continue, please call system administrator', 400);
        } catch (Exception $e) {
            Log::channel('info')->info($e->getMessage());
            throw new GlobalException('Cannot continue, please call system administrator', 400);
        }
    }
}