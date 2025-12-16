<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'kelas' => 'nullable|string|max:50',
            'nisn' => 'nullable|string|max:20|unique:users,nisn,' . $user->id,
            'tanggal_lahir' => 'nullable|date',
            'tentang_aku' => 'nullable|string|max:1000',
            'email_orang_tua' => 'nullable|string|email|max:255',
            'nomor_telepon_orang_tua' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Prepare data for update
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'kelas' => $validated['kelas'] ?? null,
            'nisn' => $validated['nisn'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'tentang_aku' => $validated['tentang_aku'] ?? null,
            'email_orang_tua' => $validated['email_orang_tua'] ?? null,
            'nomor_telepon_orang_tua' => $validated['nomor_telepon_orang_tua'] ?? null,
        ];

        // Handle password
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar') && $validated['avatar'] != null) {
            try {
                // Delete old avatar if exists
                if ($user->avatar) {
                    if (Storage::disk('public')->exists($user->avatar)) {
                        Storage::disk('public')->delete($user->avatar);
                    }
                }
                
                // Store new avatar
                $file = $request->file('avatar');
                $filename = 'avatars/' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = Storage::disk('public')->put($filename, file_get_contents($file->getRealPath()));
                
                if ($path) {
                    $data['avatar'] = $filename;
                }
            } catch (\Exception $e) {
                Log::error('Avatar upload error: ' . $e->getMessage(), [
                    'user_id' => $user->id,
                    'file_name' => $file->getClientOriginalName() ?? 'unknown'
                ]);
                // Continue without avatar - don't fail the entire update
            }
        }

        // Update user
        $user->update($data);

        return redirect()->route('profile.edit')
            ->with('success', 'Profile berhasil diperbarui!');
    }
}
