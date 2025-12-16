<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DailyChecklist;

class ChecklistController extends Controller
{
    public function complete(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
        ]);

        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $key = $request->input('key');
        $today = now()->toDateString();

        $record = DailyChecklist::updateOrCreate(
            ['user_id' => $user->id, 'key' => $key, 'date' => $today],
            ['status' => 'selesai', 'completed_at' => now()]
        );

        return response()->json(['success' => true, 'key' => $key]);
    }
}
