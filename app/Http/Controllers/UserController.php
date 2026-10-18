<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        $roles = UserRoleEnum::cases();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:' . implode(',', array_column(UserRoleEnum::cases(), 'value'))],
        ]);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'کاربر جدید با موفقیت ایجاد شد.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'اطلاعات کاربر با موفقیت ویرایش شد.');
    }

    public function index(Request $request)
    {
        $query = User::query();

        // جستجو
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }

        // فیلتر نقش
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $roles = UserRoleEnum::cases();

        return view('users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:' . implode(',', array_column(UserRoleEnum::cases(), 'value'))],
        ]);

        // جلوگیری از تغییر نقش ادمین فعلی
        if ($user->id === auth()->id() && $user->isAdmin()) {
            return redirect()->route('users.index')->with('error', 'امکان تغییر نقش ادمین فعلی وجود ندارد.');
        }

        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'نقش کاربر با موفقیت تغییر کرد.');
    }

    public function destroy(User $user)
    {
        // جلوگیری از حذف ادمین فعلی
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'امکان حذف حساب کاربری خودتان وجود ندارد.');
        }

        // جلوگیری از حذف هر کاربر دارای نقش ادمین
        if ($user->isAdmin()) {
            return redirect()->route('users.index')->with('error', 'امکان حذف حساب مدیر سیستم وجود ندارد.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'کاربر با موفقیت حذف شد.');
    }
}
