<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AIController extends Controller
{
    public function index()
    {
        // If not authenticated, redirect to student login
        if (!Auth::check()) {
            return redirect()->route('login.student');
        }
        return view('ai.index');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = $request->input('message');
        
        // Simple response system (can be replaced with actual AI API)
        $response = $this->generateResponse($message);

        return response()->json([
            'response' => $response
        ]);
    }

    private function generateResponse($message)
    {
        $message = strtolower($message);
        
        // Simple keyword-based responses (can be replaced with AI API)
        if (strpos($message, 'bahasa indonesia') !== false) {
            return 'Bahasa Indonesia adalah bahasa resmi dan nasional di Indonesia yang berfungsi sebagai alat pemersatu bangsa, bahasa negara, bahasa pengantar pendidikan, dan lambang identitas nasional.';
        }
        
        if (strpos($message, 'matematika') !== false || strpos($message, 'matematik') !== false) {
            return 'Matematika adalah ilmu tentang bilangan, struktur, ruang, dan perubahan. Di sekolah dasar, kita belajar penjumlahan, pengurangan, perkalian, dan pembagian.';
        }
        
        if (strpos($message, 'sains') !== false || strpos($message, 'ipa') !== false) {
            return 'Sains atau Ilmu Pengetahuan Alam adalah ilmu yang mempelajari alam semesta, termasuk hewan, tumbuhan, dan fenomena alam. Kita bisa belajar dengan melakukan eksperimen dan observasi.';
        }
        
        if (strpos($message, 'bahasa inggris') !== false || strpos($message, 'english') !== false) {
            return 'Bahasa Inggris adalah bahasa internasional yang penting untuk dipelajari. Dengan menguasai bahasa Inggris, kita bisa berkomunikasi dengan orang dari berbagai negara.';
        }
        
        // Default response
        return 'Terima kasih atas pertanyaan Anda. Saya adalah asisten AI yang siap membantu Anda belajar. Silakan ajukan pertanyaan tentang materi pembelajaran, dan saya akan berusaha membantu menjawabnya.';
    }
}
