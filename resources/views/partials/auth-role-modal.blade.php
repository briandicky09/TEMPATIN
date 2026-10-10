{{-- Modal Pilihan Role Autentikasi (Masuk / Daftar) - Tema TEMPATIN --}}
<div class="modal fade" id="authRoleModal" tabindex="-1" role="dialog" aria-labelledby="authRoleModalTitle" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px; margin: 1.75rem auto;">
        <div class="modal-content" style="border-radius: 20px; border: 1px solid rgba(0, 0, 0, 0.08); box-shadow: 0 24px 48px -12px rgba(2, 9, 58, 0.22); overflow: hidden; background: #ffffff;">
            
            {{-- Header Modal --}}
            <div class="modal-header border-0 pb-0 pt-4 px-4 px-sm-5 d-flex align-items-start justify-content-between position-relative">
                <div class="pr-3">
                    <h3 class="modal-title" id="authRoleModalTitle" style="font-family: var(--font-lyon-text, serif); font-size: 1.55rem; font-weight: 700; color: var(--color-midnight-ink, #02093a); line-height: 1.25; margin: 0;">
                        Masuk ke TEMPATIN
                    </h3>
                    <p id="authRoleModalSubtitle" style="font-size: 14px; color: var(--color-stone, #757575); margin-top: 6px; margin-bottom: 0;">
                        Saya ingin masuk sebagai
                    </p>
                </div>
                <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Tutup" style="color: #615d59; font-size: 1.75rem; font-weight: 300; opacity: 0.8; transition: opacity 0.15s ease, transform 0.15s ease; line-height: 1; border: none; background: transparent; cursor: pointer;" onmouseover="this.style.opacity='1'; this.style.transform='scale(1.1)';" onmouseout="this.style.opacity='0.8'; this.style.transform='scale(1)';">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Body Modal: Pilihan Role --}}
            <div class="modal-body px-4 px-sm-5 pt-4 pb-4">
                <div class="d-flex flex-column" style="gap: 14px;">

                    {{-- Opsi 1: Pencari Kos --}}
                    <a href="{{ route('login', ['role' => 'customer']) }}" id="authRoleCardCustomer" class="auth-role-option-card d-flex align-items-center text-decoration-none" style="background: #ffffff; border: 1.5px solid #e5e7eb; border-radius: 14px; padding: 18px 20px; color: var(--color-midnight-ink, #02093a); transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                        <div class="auth-role-illustration mr-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 72px; height: 72px; border-radius: 14px; background: linear-gradient(135deg, #e8f4fd 0%, #d4ebfc 100%); border: 1px solid rgba(0, 117, 222, 0.12);">
                            {{-- Ilustrasi Pencari Kos (Karakter & Pintu/Kamar) --}}
                            <svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                {{-- Background room hint --}}
                                <rect x="8" y="10" width="48" height="44" rx="4" fill="#ffffff" fill-opacity="0.85"/>
                                {{-- Open Door frame --}}
                                <rect x="36" y="14" width="16" height="40" rx="2" fill="#0075de" fill-opacity="0.15" stroke="#0075de" stroke-width="2"/>
                                {{-- Door slab open angle --}}
                                <path d="M52 14L40 18V50L52 54V14Z" fill="#0075de" stroke="#0075de" stroke-width="2" stroke-linejoin="round"/>
                                <circle cx="43" cy="35" r="1.5" fill="#ffffff"/>
                                {{-- Character --}}
                                <circle cx="23" cy="22" r="7" fill="#fbb040"/>
                                <path d="M18 19C18 16 20 14 24 14C27 14 29 16 29 19" stroke="#1f2937" stroke-width="2.2" stroke-linecap="round"/>
                                {{-- Body / Shirt --}}
                                <path d="M14 42C14 34.5 18 31 23 31C28 31 32 34.5 32 42V52H14V42Z" fill="#0075de"/>
                                {{-- Arm opening door --}}
                                <path d="M28 35L36 32" stroke="#fbb040" stroke-width="3" stroke-linecap="round"/>
                                {{-- Legs --}}
                                <rect x="18" y="52" width="4" height="4" fill="#1f2937"/>
                                <rect x="25" y="52" width="4" height="4" fill="#1f2937"/>
                            </svg>
                        </div>
                        <div class="flex-grow-1 pr-2">
                            <h4 class="auth-role-name mb-1" style="font-size: 1.05rem; font-weight: 700; color: var(--color-midnight-ink, #02093a); margin: 0; line-height: 1.3;">
                                Pencari Kos
                            </h4>
                            <p class="auth-role-desc mb-0" style="font-size: 13px; color: var(--color-stone, #757575); line-height: 1.4;">
                                Saya ingin mencari, menyewa, dan menginap di kos
                            </p>
                        </div>
                        <div class="auth-role-arrow flex-shrink-0 text-muted" style="transition: transform 0.2s ease;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.6;">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>

                    {{-- Opsi 2: Pemilik Kos --}}
                    <a href="{{ route('login', ['role' => 'owner']) }}" id="authRoleCardOwner" class="auth-role-option-card d-flex align-items-center text-decoration-none" style="background: #ffffff; border: 1.5px solid #e5e7eb; border-radius: 14px; padding: 18px 20px; color: var(--color-midnight-ink, #02093a); transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                        <div class="auth-role-illustration mr-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 72px; height: 72px; border-radius: 14px; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 1px solid rgba(5, 150, 105, 0.15);">
                            {{-- Ilustrasi Pemilik Kos (Karakter & Rumah) --}}
                            <svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                {{-- House body --}}
                                <path d="M26 28L44 14L60 28V52C60 53.1 59.1 54 58 54H30C28.9 54 28 53.1 28 52V28H26Z" fill="#ffffff" stroke="#059669" stroke-width="2" stroke-linejoin="round"/>
                                {{-- Green Roof --}}
                                <path d="M22 28L44 11L64 28" stroke="#059669" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                {{-- House Window & Door --}}
                                <rect x="34" y="32" width="8" height="8" rx="1.5" fill="#d1fae5" stroke="#059669" stroke-width="1.5"/>
                                <rect x="47" y="38" width="9" height="16" rx="1" fill="#059669" stroke="#059669" stroke-width="1.5"/>
                                <circle cx="49" cy="46" r="1" fill="#ffffff"/>
                                {{-- Character (Owner) --}}
                                <circle cx="16" cy="24" r="7" fill="#fbb040"/>
                                <path d="M10 22C10 18 13 16 17 16C21 16 23 18 23 22" stroke="#1f2937" stroke-width="2.2" stroke-linecap="round"/>
                                {{-- Owner Body / Shirt (Teal/Emerald) --}}
                                <path d="M7 43C7 36 11 33 16 33C21 33 25 36 25 43V54H7V43Z" fill="#059669"/>
                                {{-- Keys in hand --}}
                                <circle cx="26" cy="40" r="3" stroke="#fbb040" stroke-width="2"/>
                                <line x1="28" y1="42" x2="33" y2="46" stroke="#fbb040" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="flex-grow-1 pr-2">
                            <h4 class="auth-role-name mb-1" style="font-size: 1.05rem; font-weight: 700; color: var(--color-midnight-ink, #02093a); margin: 0; line-height: 1.3;">
                                Pemilik Kos
                            </h4>
                            <p class="auth-role-desc mb-0" style="font-size: 13px; color: var(--color-stone, #757575); line-height: 1.4;">
                                Saya ingin mengelola dan menyewakan properti kos
                            </p>
                        </div>
                        <div class="auth-role-arrow flex-shrink-0 text-muted" style="transition: transform 0.2s ease;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.6;">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>

                </div>
            </div>

            {{-- Footer Modal: Switch Masuk vs Daftar --}}
            <div class="modal-footer border-0 pt-0 pb-4 px-4 px-sm-5 justify-content-center" style="background: #fafafa; border-top: 1px solid #f0f0f0 !important;">
                <div class="text-center w-100" style="font-size: 13px;">
                    <span id="authRoleSwitchPrompt" style="color: var(--color-stone, #757575);">Belum memiliki akun?</span>
                    <button type="button" id="authRoleSwitchBtn" class="btn btn-link p-0 ml-1 font-weight-bold" style="color: var(--color-notion-blue, #0075de); text-decoration: none; font-size: 13px; vertical-align: baseline;">
                        Daftar akun baru
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* Hover & Animation Style untuk Role Card */
.auth-role-option-card:hover {
    border-color: var(--color-midnight-ink, #02093a) !important;
    background-color: #fbfbfb !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px -4px rgba(2, 9, 58, 0.12) !important;
}
.auth-role-option-card:hover .auth-role-arrow {
    transform: translateX(3px);
}
.auth-role-option-card:hover .auth-role-arrow svg {
    opacity: 1 !important;
    stroke: var(--color-midnight-ink, #02093a);
}
.auth-role-option-card:active {
    transform: scale(0.99);
}
#authRoleModal .modal-backdrop {
    background-color: rgba(2, 9, 58, 0.5) !important;
    backdrop-filter: blur(4px);
}
</style>

<script>
(function() {
    let authMode = 'login'; // 'login' atau 'register'

    function updateAuthRoleModalUI(mode) {
        authMode = mode;
        const titleEl = document.getElementById('authRoleModalTitle');
        const subtitleEl = document.getElementById('authRoleModalSubtitle');
        const cardCustomer = document.getElementById('authRoleCardCustomer');
        const cardOwner = document.getElementById('authRoleCardOwner');
        const promptEl = document.getElementById('authRoleSwitchPrompt');
        const switchBtn = document.getElementById('authRoleSwitchBtn');

        if (!titleEl || !cardCustomer || !cardOwner) return;

        if (mode === 'register') {
            titleEl.textContent = 'Daftar ke TEMPATIN';
            subtitleEl.textContent = 'Saya ingin mendaftar sebagai';
            cardCustomer.href = "{{ route('register', ['role' => 'customer']) }}";
            cardOwner.href = "{{ route('register', ['role' => 'owner']) }}";
            if (promptEl) promptEl.textContent = 'Sudah memiliki akun?';
            if (switchBtn) switchBtn.textContent = 'Masuk ke akun';
        } else {
            titleEl.textContent = 'Masuk ke TEMPATIN';
            subtitleEl.textContent = 'Saya ingin masuk sebagai';
            cardCustomer.href = "{{ route('login', ['role' => 'customer']) }}";
            cardOwner.href = "{{ route('login', ['role' => 'owner']) }}";
            if (promptEl) promptEl.textContent = 'Belum memiliki akun?';
            if (switchBtn) switchBtn.textContent = 'Daftar akun baru';
        }
    }

    // Ekspor fungsi agar bisa dipanggil secara global
    window.openAuthRoleModal = function(mode) {
        updateAuthRoleModalUI(mode || 'login');
        if (typeof $ !== 'undefined' && $.fn && $.fn.modal) {
            $('#authRoleModal').modal('show');
        } else {
            const modalEl = document.getElementById('authRoleModal');
            if (modalEl) {
                modalEl.classList.add('show');
                modalEl.style.display = 'block';
                document.body.classList.add('modal-open');
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        const switchBtn = document.getElementById('authRoleSwitchBtn');
        if (switchBtn) {
            switchBtn.addEventListener('click', function(e) {
                e.preventDefault();
                updateAuthRoleModalUI(authMode === 'login' ? 'register' : 'login');
            });
        }

        // Tangkap trigger pembuka modal yang memiliki atribut data-auth-mode
        document.querySelectorAll('[data-toggle="modal"][data-target="#authRoleModal"]').forEach(function(el) {
            el.addEventListener('click', function() {
                const targetMode = this.getAttribute('data-auth-mode') || 'login';
                updateAuthRoleModalUI(targetMode);
            });
        });
    });
})();
</script>
