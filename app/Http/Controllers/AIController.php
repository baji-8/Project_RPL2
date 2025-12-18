<?php

namespace App\Http\Controllers;

use App\Models\AiKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AiController extends Controller
{

    public function index()
    {
        return view('ai.index');
    }

    public function chat(Request $request)
    {
        $message = strtolower(trim($request->message));

        // =====================
        // 1️⃣ JIKA USER PILIH ANGKA
        // =====================
        if (is_numeric($message)) {

            if (!session()->has('ai_material_map')) {
                return response()->json([
                    'response' => 'Silakan tanyakan topik terlebih dahulu.'
                ]);
            }

            $map = session('ai_material_map');

            if (isset($map[$message])) {
                return response()->json([
                    'response' => $map[$message]
                ]);
            }

            return response()->json([
                'response' => 'Pilihan tidak tersedia.'
            ]);
        }

        // =====================
        // 2️⃣ DETEKSI SEMUA KEYWORD
        // =====================
        $keywords = \App\Models\AiKeyword::all();
        $matched = [];

        foreach ($keywords as $item) {
            if (str_contains($message, strtolower($item->keyword))) {
                $matched[] = $item;
            }
        }

        if (count($matched) === 0) {
            return response()->json([
                'response' => 'Maaf, saya belum memahami pertanyaan tersebut.'
            ]);
        }

        // =====================
        // 3️⃣ BANGUN OUTPUT + MAP ANGKA
        // =====================
        $text = '';
        $number = 1;
        $materialMap = [];

        foreach ($matched as $item) {
            $data = json_decode($item->response, true);

            // Pengertian
            $text .= $data['definition'] . "\n";

            // Materi bernomor
            foreach ($data['materials'] as $mat) {
                $text .= $number . '. ' . $mat['title'] . "\n";
                $materialMap[$number] = $mat['answer'];
                $number++;
            }

            $text .= "\n";
        }

        // Simpan mapping ke session
        session(['ai_material_map' => $materialMap]);

        $text .= "Silakan pilih angka untuk mempelajari lebih lanjut.";

        return response()->json([
            'response' => nl2br(trim($text))
        ]);
    }
}
