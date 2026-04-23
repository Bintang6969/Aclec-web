<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showForm()
    {
        return view('emails.reset-pw');
    }

    public function process(Request $request)
    {
        // 1. Validasi: Email harus ada dan Password harus diisi (min 8 karakter)
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ]);

        // 2. Cari user
        $user = User::where('email', $request->email)->first();

        // 3. Update password dengan hash baru
        $user->password = Hash::make($request->password);
        $user->save();

        // 4. Return respon sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diperbarui!'
        ]);
    }
}