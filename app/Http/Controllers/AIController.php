<?php

namespace App\Http\Controllers;

use App\Models\AiKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Materi;

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
        // 🔥 0️⃣ CARI DI MATERI GURU (SUPPORT MULTI MATERI)
        // =====================
        $materis = Materi::where('is_active', true)
            ->whereNotNull('keywords')
            ->get();

        $matchedMateri = [];

        foreach ($materis as $m) {
            $keys = array_map('trim', explode(',', strtolower($m->keywords)));

            foreach ($keys as $key) {
                if ($key !== '' && str_contains($message, $key)) {
                    $matchedMateri[] = $m;
                    break;
                }
            }
        }

        // 🔹 JIKA LEBIH DARI 1 MATERI → PILIHAN ANGKA
        if (count($matchedMateri) > 1) {
            $text = "Saya menemukan beberapa materi:\n";
            $map = [];
            $i = 1;

            foreach ($matchedMateri as $m) {
                $text .= $i . ". " . $m->judul . "\n";
                $map[$i] = "<b>{$m->judul}</b><br>" . $m->konten;
                $i++;
            }

            session(['materi_map' => $map]);

            return response()->json([
                'response' => nl2br($text . "\nSilakan pilih nomor.")
            ]);
        }

        // 🔹 JIKA HANYA 1 MATERI → LANGSUNG JAWAB
        if (count($matchedMateri) === 1) {
            $m = $matchedMateri[0];

            return response()->json([
                'response' => "<b>{$m->judul}</b><br>" . nl2br($m->konten)
            ]);
        }

        // =====================
        // 1️⃣ JIKA USER PILIH ANGKA
        // =====================
        if (is_numeric($message)) {

            // 🔹 Prioritas: materi guru
            if (session()->has('materi_map')) {
                $map = session('materi_map');

                if (isset($map[$message])) {
                    return response()->json([
                        'response' => nl2br($map[$message])
                    ]);
                }

                return response()->json([
                    'response' => 'Pilihan tidak tersedia.'
                ]);
            }

            // 🔹 Fallback: ai_keywords
            if (session()->has('ai_material_map')) {
                $map = session('ai_material_map');

                if (isset($map[$message])) {
                    return response()->json([
                        'response' => $map[$message]
                    ]);
                }
            }

            return response()->json([
                'response' => 'Silakan tanyakan topik terlebih dahulu.'
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
