@extends('layouts.app')

@php
    $otherUser = Auth::user()->role === 'owner' ? $conversation->customer : $conversation->owner;
@endphp

@section('title', 'Percakapan dengan ' . ($otherUser?->name ?? 'Pengguna') . ' - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 15px; padding-bottom: 60px;">

        <!-- BREADCRUMB -->
        <div class="container mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('chat.index') }}" style="color: var(--color-stone); text-decoration: none;">Pesan</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">
                        {{ $otherUser?->name ?? 'Percakapan' }}
                    </li>
                </ol>
            </nav>
        </div>

        <section class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">

                    <div class="rounded overflow-hidden" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

                        <!-- CHAT HEADER -->
                        <div class="p-3 d-flex justify-content-between align-items-center border-bottom" style="border-color: rgba(0,0,0,0.06) !important; background-color: var(--surface-page-canvas);">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('chat.index') }}" class="btn btn-sm btn-link text-muted mr-2 p-0" title="Kembali ke daftar pesan">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-3" style="width: 40px; height: 40px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 700; font-size: 15px;">
                                    {{ strtoupper(substr($otherUser?->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="mb-0 font-weight-bold" style="font-size: 14.5px; color: var(--color-midnight-ink);">
                                        {{ $otherUser?->name ?? 'Pengguna' }}
                                    </h4>
                                    <small class="text-muted" style="font-size: 11.5px;">
                                        Konteks: <strong>{{ $conversation->kos?->title }}</strong>
                                    </small>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('kos.show', $conversation->kos?->slug) }}" target="_blank" class="btn btn-sm" style="background-color: #ffffff; color: var(--color-midnight-ink); border: var(--border-hairline); font-size: 12px; font-weight: 600; border-radius: var(--radius-buttons); padding: 5px 12px;">
                                    <i class="fa fa-external-link-alt mr-1"></i> Detail Kos
                                </a>
                            </div>
                        </div>

                        <!-- CHAT MESSAGES BODY -->
                        <div class="p-4" id="chatMessagesContainer" style="height: 440px; overflow-y: auto; background-color: #faf9f8;">
                            @forelse($conversation->messages as $msg)
                                @php
                                    $isMine = (int) $msg->sender_id === (int) Auth::id();
                                @endphp
                                <div class="d-flex mb-3 {{ $isMine ? 'justify-content-end' : 'justify-content-start' }}">
                                    @if(!$isMine)
                                        <div class="rounded-circle mr-2 d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 700;">
                                            {{ strtoupper(substr($msg->sender?->name ?? 'U', 0, 1)) }}
                                        </div>
                                    @endif
                                    <div style="max-width: 70%;">
                                        <div class="p-3 rounded" style="font-size: 13.5px; line-height: 1.5; border-radius: 12px; {{ $isMine ? 'background-color: var(--color-notion-blue); color: #ffffff;' : 'background-color: #ffffff; color: var(--color-midnight-ink); border: var(--border-hairline);' }}">
                                            {{ $msg->message }}
                                        </div>
                                        <div class="text-muted mt-1 px-1 {{ $isMine ? 'text-right' : 'text-left' }}" style="font-size: 10.5px;">
                                            {{ $msg->created_at->format('H:i') }}
                                            @if($isMine)
                                                • <i class="fa {{ $msg->is_read ? 'fa-check-double text-primary' : 'fa-check' }}"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="h-100 d-flex flex-column align-items-center justify-content-center text-center text-muted">
                                    <i class="fa fa-comments fa-3x mb-2 opacity-50"></i>
                                    <p class="mb-0" style="font-size: 13.5px;">Belum ada pesan dalam percakapan ini.<br>Kirimkan sapaan atau pertanyaan Anda sekarang.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- CHAT INPUT FORM -->
                        <div class="p-3 border-top" style="border-color: rgba(0,0,0,0.06) !important; background-color: #ffffff;">
                            <form action="{{ route('chat.send', $conversation->id) }}" method="POST" id="formSendMessage">
                                @csrf
                                <div class="input-group">
                                    <textarea name="message" class="form-control" rows="1" placeholder="Ketik pesan Anda di sini..." required style="border-radius: var(--radius-inputs) 0 0 var(--radius-inputs); border: var(--border-hairline); font-size: 13.5px; resize: none;"></textarea>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13.5px; padding: 0 20px; border-radius: 0 var(--radius-inputs) var(--radius-inputs) 0; border: none;">
                                            <i class="fa fa-paper-plane mr-1"></i> Kirim
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById("chatMessagesContainer");
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });
</script>
@endpush
@endsection
