<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $query = User::query();

        $query->when(request('role'), fn ($q) => $q->where('role', request('role')))
            ->when(request('search'), function ($q) {
                $term = request('search');
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%");
            });

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.form', [
            'user' => new User(),
            'rolePreset' => request('role'),
        ]);
    }

    public function store(UserRequest $request)
    {
        $data = $this->prepareData($request);
        $user = User::create($data);

        return redirect()->route('admin.users.edit', $user)->with('success', 'Utilisateur cree.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $this->prepareData($request, $user);
        $user->update($data);

        return redirect()->route('admin.users.edit', $user)->with('success', 'Utilisateur mis a jour.');
    }

    public function destroy(User $user)
    {
        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprime.');
    }

    private function prepareData(UserRequest $request, ?User $user = null): array
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($user?->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $data['permissions'] = $data['permissions'] ? array_map('trim', explode(',', $data['permissions'])) : null;

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        unset($data['avatar']);

        $data['name'] = trim($data['first_name'] . ' ' . $data['last_name']);

        return $data;
    }
}
