<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DataUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function DataUserView()
    {
        $users = User::all();
        // $products = Product::all(); // <- ini penting
        return view('data_users.indexUsers', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data_users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'role'              => 'required|string|max:50',
            'password'          => 'required|max:50|min:8',
            'password_confirmation' => 'required|max:50|min:8|same:password',
            'Status'            => 'nullable|string|max:50',
            'CreatedDate'       => 'nullable|date',
        ]);

        User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'role'              => $request->role,
            'password'          => bcrypt($request->password),
            'Phone'             => $request->Phone,
            'Status'            => $request->Status,
            'CreatedDate'       => now(),
            'CreatedBy'         => Auth::user()->name,
        ]);

        return redirect()->route(route: 'data_users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('data_users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'role'              => 'required|string|max:50',
            'Status'            => 'nullable|string|max:50',
            'LastUpdatedDate'   => 'nullable|date',
            'LastUpdatedBy'     => 'nullable|string|max:255',
        ]);

        $user->update([
            'name'              => $request->name,
            'role'              => $request->role,
            'Status'            => $request->Status,
            'Phone'             => $request->Phone,
            'LastUpdatedDate'   => now(), // Set waktu update saat ini
            'LastUpdatedBy'     => Auth::user()->name, // Set nama user yang melakukan update
        ]);

        return redirect()->route('data_users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            // Pesan sukses akan ditangkap oleh SweetAlert2 di layout.master
            return redirect()->route('data_users.index')->with('success', 'User berhasil dihapus.');
        } catch (Exception $e) {
            // Tangani error, misalnya jika user tidak bisa dihapus karena relasi data
            // Pesan error ini juga akan ditangkap oleh SweetAlert2 di layout.master
            return redirect()->route('data_users.index')->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
        // $user->delete();
        // return redirect()->route('data_users.index')->with('success', 'User berhasil dihapus.');
    }
}
