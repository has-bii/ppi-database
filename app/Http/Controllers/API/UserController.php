<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            // TODO: Validate request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Check email if exists
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return ResponseFormatter::error('email is not registered yet!', 401);
            }

            // TODO: Find user by email
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error('Invalid password!', 401);
            }

            // Check if account is verified
            if ($user->is_verified == 0) {
                return ResponseFormatter::error('Account is not verified by admin!', 404);
            }

            // TODO: Generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // TODO: Return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Login success');
        } catch (Exception $e) {
            return ResponseFormatter::error('Authentication failed');
        }
    }

    public function register(Request $request)
    {
        try {
            // TODO: Validate request
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password],
            ]);

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'User registered');
        } catch (Exception $e) {
            // TODO: Return error response
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Logout success');
    }

    public function fetch(Request $request)
    {

        $id = $request->user()->id;

        $user = User::with(['role'])->find($id);

        return ResponseFormatter::success($user, 'Fetch Success');
    }

    public function fetchUsers(Request $request)
    {
        if ($request->user()->role_id == 1) {

            $limit = $request->input('limit', 100);
            $name = $request->input('name');
            $role_id = $request->input('role_id');
            $is_verified = $request->input('is_verified');
            $order_field = $request->input('order_field');
            $order_by = $request->input('order_by');

            $users = User::with('role');

            if ($is_verified) {
                $users->where('is_verified', $is_verified - 1);
            }

            if ($role_id) {
                $users->where('role_id', $role_id);
            }

            if ($name) {
                $users->where('name', 'like', '%' . $name . '%');
            }

            if ($order_field && $order_by) $users->orderBy($order_field, $order_by);

            return ResponseFormatter::success($users->paginate($limit), 'Fetch success');
        }


        return ResponseFormatter::error('Request access denied!');
    }

    public function update(Request $request)
    {
        try {
            $email = $request->input('email');
            $name = $request->input('name');


            $user = $request->user();


            if (!$user) {
                throw new Exception('User not found');
            }

            // Update user
            $user->update([
                'name' => isset($name) ? $name : $user->name,
                'email' => isset($email) ? $email : $user->email,
            ]);

            return ResponseFormatter::success($user, 'User updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            if ($request->user()->role_id != 1)
                return ResponseFormatter::error('Request access denied!');

            $IDs = $request->input('id');
            $role_id = $request->input('role_id');
            $is_verified = $request->input('is_verified');
            $select_all = $request->input('select_all');

            if ($select_all === 'all') {
                $users = User::query();
            } else {
                if (!$IDs)
                    return ResponseFormatter::error('ID is required!');

                $IDs = explode(',', $IDs);
                $users = User::query()->whereIn('id', $IDs);
            }

            if ($role_id)
                $users->update(['role_id' => $role_id]);

            if ($is_verified)
                $users->update(['is_verified' => $is_verified]);


            return ResponseFormatter::success(null, 'Updates successful');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function deleteUsers(Request $request)
    {
        try {
            $id = $request->input('id');

            if ($request->user()->role_id != 1)
                return ResponseFormatter::error('Request access denied!');

            if (!$id)
                return ResponseFormatter::error('ID is required!');

            if ($id == $request->user()->id)
                return ResponseFormatter::error('Cannot delete yourself account');

            $id = explode(',', $id);
            $user = User::whereIn('id', $id);

            if (!$user)
                return ResponseFormatter::error('User is not found!');

            $user->delete();

            return ResponseFormatter::success($id, 'User deleted successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
