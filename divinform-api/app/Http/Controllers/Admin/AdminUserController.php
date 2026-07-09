<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::select('id', 'name', 'email', 'role', 'active', 'created_at')
            ->orderBy('id')
            ->get();

        return response()->json(['data' => $users]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', Password::min(8)->mixedCase()->numbers()],
            'role'     => 'required|in:super_admin,editor,viewer,farm_manager',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'active'   => true,
        ]);

        return response()->json([
            'message' => 'Utilisateur créé avec succès.',
            'data'    => $user->only('id', 'name', 'email', 'role', 'active'),
        ], 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json(['data' => $user->only('id', 'name', 'email', 'role', 'active')]);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        // Protéger le super admin principal
        if ($user->id === 1 && $request->has('role')) {
            return response()->json(['message' => 'Impossible de modifier le rôle de l\'admin principal.'], 403);
        }

        $request->validate([
            'name'     => 'sometimes|string|max:100',
            'email'    => "sometimes|email|unique:users,email,{$user->id}",
            'password' => ['sometimes', Password::min(8)->mixedCase()->numbers()],
            'role'     => 'sometimes|in:super_admin,editor,viewer,farm_manager',
            'active'   => 'sometimes|boolean',
        ]);

        $data = $request->only('name', 'email', 'role', 'active');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Utilisateur mis à jour.',
            'data'    => $user->fresh()->only('id', 'name', 'email', 'role', 'active'),
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        if ($user->id === 1) {
            return response()->json(['message' => 'Impossible de supprimer l\'administrateur principal.'], 403);
        }

        if ($user->id === auth('api')->id()) {
            return response()->json(['message' => 'Vous ne pouvez pas supprimer votre propre compte.'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé.']);
    }
}
