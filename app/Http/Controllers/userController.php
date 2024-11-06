<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function home()
    {
        return view('users.home');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('user.home')->with('success', 'Berhasil menambah data pengguna!');
    }

    public function edit($id)
{
    $user = User::findOrFail($id);  // Temukan user berdasarkan ID
    return view('users.edit', compact('user'));  // Kirim user ke view
}


public function update(Request $request, $id)
{
    $user = User::findOrFail($id);  // Cari user berdasarkan ID

    // Validasi input
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,  // Pastikan email unik, kecuali milik user sendiri
        'role' => 'required',
    ]);

    // Update data user
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ]);

    return redirect()->route('user.home')->with('success', 'Berhasil mengubah data pengguna.');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.home')->with('success', 'Berhasil menghapus data pengguna!');
    }

    public function login () {
        Auth::logout();
	            return redirect('/');
    }

    public function loginAuth(Request $request) {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $users = $request->only('email', 'password');
        if (Auth::attempt($users)) {
            return redirect()->route('home.page');
        }else {
            return redirect()->back()->with('error', 'Gagal login, silahkan cek dan coba lagi!');
        }
    }

        public function logout() 
        {
	        Auth::logout();
	            return redirect('/');
        }
}
