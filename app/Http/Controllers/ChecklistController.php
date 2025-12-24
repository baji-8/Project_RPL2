<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DailyChecklist;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
    public function complete(Request $request)
    {
        try {
            $request->validate([
                'key' => 'required|string',
            ]);

            $userId = Auth::id();
            if (! $userId) {
                return response()->json(['success' => false], 401);
            }

            $today = now()->toDateString();

            DB::table('daily_checklists')->updateOrInsert(
                [
                    'user_id' => $userId,
                    'key'     => $request->key,
                    'date'    => $today,
                ],
                [
                    'status'       => 'selesai',
                    'completed_at' => now(),
                    'updated_at'   => now(),
                    'created_at'   => now(),
                ]
            );

            return response()->json(['success' => true]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
