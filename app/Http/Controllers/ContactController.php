<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Simpan pesan dari halaman /contact (public).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        ContactMessage::create([
            'name'    => $data['name'],
            'email'   => $data['email'],
            'message' => $data['message'],
        ]);

        return back()->with('success', 'Pesan kamu sudah dikirim, terima kasih! 😊');
    }

    /**
     * Tampilkan semua pesan di halaman admin.
     * URL: /admin/messages
     */
    public function index()
    {
        // bisa pakai paginate kalau mau
        $messages = ContactMessage::latest()->paginate(10);

        return view('admin.messages.index', [
            'messages' => $messages,
        ]);
    }
}
