<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Kos;
use App\Models\Message;
use App\Notifications\TempatinNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * Tampilkan daftar percakapan aktif untuk pengguna yang sedang login.
     */
    public function index(): View
    {
        $user = Auth::user();

        if ($user->role === 'owner') {
            $conversations = Conversation::where('owner_id', $user->id)
                ->with(['kos', 'customer', 'messages'])
                ->latest('updated_at')
                ->get();
        } else {
            $conversations = Conversation::where('customer_id', $user->id)
                ->with(['kos', 'owner', 'messages'])
                ->latest('updated_at')
                ->get();
        }

        return view('chat.index', compact('conversations'));
    }

    /**
     * Buka percakapan tertentu beserta daftar pesan di dalamnya.
     */
    public function show(Conversation $conversation): View
    {
        $this->authorizeParticipant($conversation);

        $user = Auth::user();

        // Tandai pesan dari lawan bicara sebagai sudah dibaca
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $conversation->load(['kos', 'customer', 'owner', 'messages.sender']);

        // Ambil percakapan lain untuk sidebar chat
        if ($user->role === 'owner') {
            $conversations = Conversation::where('owner_id', $user->id)
                ->with(['kos', 'customer', 'messages'])
                ->latest('updated_at')
                ->get();
        } else {
            $conversations = Conversation::where('customer_id', $user->id)
                ->with(['kos', 'owner', 'messages'])
                ->latest('updated_at')
                ->get();
        }

        return view('chat.show', compact('conversation', 'conversations'));
    }

    /**
     * Mulai percakapan baru dengan pemilik kos dari halaman detail kos.
     */
    public function start(Request $request, Kos $kos): RedirectResponse
    {
        $user = Auth::user();

        // Cegah pemilik berkirim pesan ke kos miliknya sendiri
        if ((int) $kos->owner_id === (int) $user->id) {
            return back()->with('error', 'Anda tidak dapat mengirim pesan ke kos milik Anda sendiri.');
        }

        $conversation = Conversation::firstOrCreate([
            'kos_id' => $kos->id,
            'customer_id' => $user->id,
            'owner_id' => $kos->owner_id,
        ]);

        if ($request->filled('message')) {
            $msgContent = strip_tags($request->input('message'));
            if (mb_strlen($msgContent) > 0) {
                $message = Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $user->id,
                    'message' => $msgContent,
                ]);

                $conversation->touch();

                // Notifikasi ke pemilik kos
                try {
                    $kos->owner?->notify(new TempatinNotification(
                        'Pesan Baru dari ' . $user->name,
                        Str::limit($message->message, 80),
                        route('chat.show', $conversation->id),
                        'chat',
                        'fa-comment'
                    ));
                } catch (\Throwable $e) {
                    // Abaikan jika background notification gagal
                }
            }
        }

        return redirect()->route('chat.show', $conversation->id);
    }

    /**
     * Kirim pesan baru dalam percakapan yang ada.
     */
    public function sendMessage(Request $request, Conversation $conversation): RedirectResponse
    {
        $this->authorizeParticipant($conversation);

        $request->validate([
            'message' => 'required|string|min:1|max:2000',
        ], [
            'message.required' => 'Pesan tidak boleh kosong.',
            'message.max' => 'Pesan maksimal 2000 karakter.',
        ]);

        $user = Auth::user();
        $msgContent = strip_tags($request->input('message'));

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message' => $msgContent,
        ]);

        $conversation->touch();

        // Tentukan penerima notifikasi
        $recipient = ((int) $conversation->customer_id === (int) $user->id)
            ? $conversation->owner
            : $conversation->customer;

        try {
            $recipient?->notify(new TempatinNotification(
                'Pesan Baru dari ' . $user->name,
                Str::limit($message->message, 80),
                route('chat.show', $conversation->id),
                'chat',
                'fa-comment'
            ));
        } catch (\Throwable $e) {
            // Abaikan jika background notification gagal
        }

        return redirect()->route('chat.show', $conversation->id);
    }

    /**
     * Verifikasi bahwa user adalah peserta yang sah dalam percakapan ini (anti IDOR).
     */
    private function authorizeParticipant(Conversation $conversation): void
    {
        $userId = (int) Auth::id();
        if ((int) $conversation->customer_id !== $userId && (int) $conversation->owner_id !== $userId) {
            abort(403, 'Akses ditolak. Anda bukan peserta dalam percakapan ini.');
        }
    }
}
