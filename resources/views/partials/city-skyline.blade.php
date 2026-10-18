<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 370" fill="none" class="w-100 h-100" style="object-fit: contain; object-position: center bottom; display: block;">
    <defs>
        <!-- Soft Minimalist Gradients -->
        <linearGradient id="skylineFarGrad" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stop-color="#dbeafe" stop-opacity="0.6"/>
            <stop offset="100%" stop-color="#bfdbfe" stop-opacity="0.3"/>
        </linearGradient>

        <linearGradient id="skylineMidGrad" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stop-color="#f8fafc" stop-opacity="0.9"/>
            <stop offset="100%" stop-color="#e2e8f0" stop-opacity="0.65"/>
        </linearGradient>

        <linearGradient id="skylineNearGrad" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stop-color="#ffffff" stop-opacity="0.95"/>
            <stop offset="100%" stop-color="#f1f5f9" stop-opacity="0.85"/>
        </linearGradient>

        <linearGradient id="glassWindowAccent" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#0075de" stop-opacity="0.3"/>
            <stop offset="100%" stop-color="#0075de" stop-opacity="0.55"/>
        </linearGradient>

        <linearGradient id="warmWindowAccent" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#f59e0b" stop-opacity="0.35"/>
            <stop offset="100%" stop-color="#f59e0b" stop-opacity="0.6"/>
        </linearGradient>

        <linearGradient id="cloudSoftGrad" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stop-color="#ffffff" stop-opacity="0.9"/>
            <stop offset="100%" stop-color="#e0e7ff" stop-opacity="0.45"/>
        </linearGradient>

        <!-- Dynamic Micro-Animations Style -->
        <style>
            /* Ambient Skyline Float */
            @keyframes skylineSoftBreathe {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-4px); }
            }
            .anim-skyline-float {
                animation: skylineSoftBreathe 9s ease-in-out infinite;
                will-change: transform;
            }

            /* Cloud Drifting */
            @keyframes cloudDriftSlow1 {
                0%, 100% { transform: translateX(0px); }
                50% { transform: translateX(24px); }
            }
            @keyframes cloudDriftSlow2 {
                0%, 100% { transform: translateX(0px); }
                50% { transform: translateX(-20px); }
            }
            @keyframes cloudDriftSlow3 {
                0%, 100% { transform: translateX(0px); }
                50% { transform: translateX(16px); }
            }
            .anim-cloud-1 { animation: cloudDriftSlow1 18s ease-in-out infinite; will-change: transform; }
            .anim-cloud-2 { animation: cloudDriftSlow2 23s ease-in-out infinite; will-change: transform; }
            .anim-cloud-3 { animation: cloudDriftSlow3 20s ease-in-out infinite 2s; will-change: transform; }

            /* Bird Glides */
            @keyframes birdGlideA {
                0%, 100% { transform: translate(0px, 0px); }
                50% { transform: translate(14px, -7px); }
            }
            @keyframes birdGlideB {
                0%, 100% { transform: translate(0px, 0px); }
                50% { transform: translate(-12px, -6px); }
            }
            .anim-bird-1 { animation: birdGlideA 7s ease-in-out infinite; will-change: transform; }
            .anim-bird-2 { animation: birdGlideB 8.5s ease-in-out infinite 1s; will-change: transform; }

            /* Skyscraper Spire Beacons Pulsing */
            @keyframes spireBeaconPulse {
                0%, 100% { opacity: 0.35; transform: scale(0.9); }
                50% { opacity: 1; transform: scale(1.35); }
            }
            .anim-beacon-left {
                animation: spireBeaconPulse 2.4s ease-in-out infinite;
                transform-origin: 140px 92px;
            }
            .anim-beacon-right {
                animation: spireBeaconPulse 2.8s ease-in-out infinite 0.7s;
                transform-origin: 1030px 88px;
            }

            /* Window Shimmer / Glow */
            @keyframes windowSoftGlow1 {
                0%, 100% { fill-opacity: 0.25; }
                50% { fill-opacity: 0.85; }
            }
            @keyframes windowSoftGlow2 {
                0%, 100% { fill-opacity: 0.3; }
                50% { fill-opacity: 0.9; }
            }
            @keyframes windowWarmGlow {
                0%, 100% { fill-opacity: 0.3; }
                50% { fill-opacity: 0.95; }
            }
            .anim-win-glow-1 { animation: windowSoftGlow1 4s ease-in-out infinite; }
            .anim-win-glow-2 { animation: windowSoftGlow2 4.8s ease-in-out infinite 1.6s; }
            .anim-win-warm { animation: windowWarmGlow 5.2s ease-in-out infinite 0.8s; }

            /* Gentle Foliage Sway */
            @keyframes foliageSwayLeft {
                0%, 100% { transform: rotate(0deg); }
                50% { transform: rotate(2.8deg); }
            }
            @keyframes foliageSwayRight {
                0%, 100% { transform: rotate(0deg); }
                50% { transform: rotate(-2.5deg); }
            }
            .anim-tree-1 { transform-origin: 395px 360px; animation: foliageSwayLeft 5.5s ease-in-out infinite; }
            .anim-tree-2 { transform-origin: 795px 360px; animation: foliageSwayRight 6s ease-in-out infinite 1s; }
            .anim-tree-3 { transform-origin: 1165px 360px; animation: foliageSwayLeft 5s ease-in-out infinite 0.5s; }
        </style>
    </defs>

    <!-- ========================================================
         AMBIENT CLOUDS WITH DRIFT ANIMATIONS
         Positioned on upper edges so headline area remains clean
         ======================================================== -->
    <g fill="url(#cloudSoftGrad)" stroke="#cbd5e1" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
        <!-- Cloud Upper Left -->
        <g class="anim-cloud-1">
            <path d="M 60 78 a 18 18 0 0 1 28 -10 a 26 26 0 0 1 42 3 a 18 18 0 0 1 20 17 l -90 0 z" />
        </g>
        <!-- Cloud Mid Left High -->
        <g class="anim-cloud-2">
            <path d="M 230 52 a 15 15 0 0 1 22 -8 a 22 22 0 0 1 34 2 a 15 15 0 0 1 18 14 l -74 0 z" />
        </g>
        <!-- Cloud Upper Right -->
        <g class="anim-cloud-3">
            <path d="M 940 55 a 16 16 0 0 1 25 -9 a 24 24 0 0 1 38 3 a 16 16 0 0 1 18 15 l -81 0 z" />
        </g>
        <!-- Cloud Far Right High -->
        <g class="anim-cloud-1">
            <path d="M 1060 72 a 18 18 0 0 1 28 -10 a 26 26 0 0 1 42 3 a 18 18 0 0 1 20 17 l -90 0 z" />
        </g>
    </g>

    <!-- ========================================================
         SOARING BIRDS (Minimalist vectors on outer sides)
         ======================================================== -->
    <g stroke="#64748b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none">
        <g class="anim-bird-1">
            <path d="M 160 85 q 5 -7 11 0 q 5 -7 11 0"/>
        </g>
        <g class="anim-bird-2">
            <path d="M 900 80 q 5 -7 11 0 q 5 -7 11 0"/>
        </g>
    </g>

    <!-- ========================================================
         MAIN ARCHITECTURAL SKYLINE WITH SUBTLE AMBIENT FLOAT
         ======================================================== -->
    <g class="anim-skyline-float">

        <!-- LAYER 1: DISTANT SILHOUETTES & SPIRES (Soft, Atmospheric) -->
        <g fill="url(#skylineFarGrad)" stroke="#94a3b8" stroke-width="1.1" stroke-linejoin="round">
            <!-- Left Outer Towers -->
            <polygon points="10,360 10,230 45,230 45,190 75,190 75,230 95,230 95,360"/>
            <!-- Left Landmark Tower with Antenna Spire -->
            <polygon points="110,360 110,180 135,135 139,95 141,95 145,135 170,180 170,360"/>
            <!-- Left Stepped Highrise -->
            <polygon points="185,360 185,215 220,215 220,170 250,170 250,215 285,215 285,360"/>
            <!-- Left Angled Tower -->
            <polygon points="300,360 300,240 340,195 365,195 365,360"/>

            <!-- Center Dip (Kept low & graceful behind main headline text) -->
            <polygon points="380,360 380,310 440,310 440,295 470,295 470,310 540,310 540,360"/>
            <polygon points="560,360 560,315 620,315 620,360"/>
            <polygon points="640,360 640,310 710,310 710,295 740,295 740,310 790,310 790,360"/>

            <!-- Right Angled Tower -->
            <polygon points="815,360 815,245 845,205 880,205 880,360"/>
            <!-- Right Stepped Highrise -->
            <polygon points="895,360 895,210 925,210 925,165 955,165 955,210 985,210 985,360"/>
            <!-- Right Landmark Tower with Antenna Spire -->
            <polygon points="1000,360 1000,175 1025,130 1029,90 1031,90 1035,130 1060,175 1060,360"/>
            <!-- Right Outer Towers -->
            <polygon points="1075,360 1075,220 1105,220 1105,185 1135,185 1135,220 1165,220 1165,360"/>
            <polygon points="1175,360 1175,240 1195,240 1195,360"/>
        </g>

        <!-- SPIRE BEACON GLOWS (Subtle animated flashing light at antenna tips) -->
        <g>
            <!-- Left Spire Beacon -->
            <circle cx="140" cy="93" r="4.5" fill="#ef4444" fill-opacity="0.25" class="anim-beacon-left"/>
            <circle cx="140" cy="93" r="2.2" fill="#ef4444" class="anim-beacon-left"/>
            <!-- Right Spire Beacon -->
            <circle cx="1030" cy="89" r="4.5" fill="#0075de" fill-opacity="0.3" class="anim-beacon-right"/>
            <circle cx="1030" cy="89" r="2.2" fill="#0075de" class="anim-beacon-right"/>
        </g>

        <!-- LAYER 2: MIDGROUND MODERN APARTMENTS & RESIDENCES -->
        <g fill="url(#skylineMidGrad)" stroke="#64748b" stroke-width="1.3" stroke-linejoin="round">
            <!-- Left Mid-Rise Residence -->
            <polygon points="35,360 35,260 65,260 65,230 100,230 100,260 120,260 120,360"/>
            <!-- Left Slanted Roof Kos Studio -->
            <polygon points="135,360 135,275 175,235 205,235 205,360"/>
            <!-- Left Modern Urban Kos Complex -->
            <polygon points="220,360 220,270 255,270 255,245 285,245 285,270 310,270 310,360"/>
            <polygon points="325,360 325,305 355,280 385,305 385,360"/>

            <!-- Center Low Residences (Clean geometric lines, low profile) -->
            <polygon points="405,360 405,320 435,300 465,320 465,360"/>
            <polygon points="485,360 485,315 545,315 545,360"/>
            <polygon points="565,360 565,310 625,310 625,360"/>
            <polygon points="645,360 645,315 705,315 705,360"/>
            <polygon points="725,360 725,320 755,300 785,320 785,360"/>

            <!-- Right Mid-Rise Residence -->
            <polygon points="805,360 805,275 835,250 865,275 865,360"/>
            <polygon points="880,360 880,265 910,265 910,240 940,240 940,265 970,265 970,360"/>
            <!-- Right Slanted Roof Kos Studio -->
            <polygon points="985,360 985,240 1015,240 1055,280 1055,360"/>
            <polygon points="1070,360 1070,255 1090,255 1090,225 1125,225 1125,255 1150,255 1150,360"/>
        </g>

        <!-- LAYER 3: FOREGROUND RESIDENTIAL ACCENTS (Doors, subtle balconies, louvers) -->
        <g stroke="#475569" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
            <!-- Building 1 (Far Left): Entrance & Balcony Line -->
            <rect x="55" y="325" width="12" height="35" rx="1" fill="#cbd5e1" fill-opacity="0.4"/>
            <line x1="45" y1="290" x2="110" y2="290" stroke="#94a3b8" stroke-width="1.2"/>

            <!-- Building 2 (Studio): Balcony Railing -->
            <line x1="145" y1="285" x2="195" y2="285" stroke="#94a3b8" stroke-width="1.4"/>
            <rect x="160" y="325" width="16" height="35" rx="1" fill="#cbd5e1" fill-opacity="0.4"/>

            <!-- Building 3 (Kos Complex): Balconies -->
            <line x1="230" y1="295" x2="300" y2="295" stroke="#94a3b8" stroke-width="1.4"/>
            <line x1="230" y1="325" x2="300" y2="325" stroke="#94a3b8" stroke-width="1.4"/>

            <!-- Center Residences (Terraces & Entrances) -->
            <rect x="425" y="335" width="15" height="25" rx="1" fill="#cbd5e1" fill-opacity="0.4"/>
            <line x1="495" y1="330" x2="535" y2="330" stroke="#94a3b8" stroke-width="1.2"/>
            <rect x="585" y="330" width="20" height="30" rx="1" fill="#cbd5e1" fill-opacity="0.4"/>
            <line x1="655" y1="330" x2="695" y2="330" stroke="#94a3b8" stroke-width="1.2"/>
            <rect x="745" y="335" width="15" height="25" rx="1" fill="#cbd5e1" fill-opacity="0.4"/>

            <!-- Right Residences: Balconies & Entrances -->
            <line x1="890" y1="295" x2="960" y2="295" stroke="#94a3b8" stroke-width="1.4"/>
            <line x1="890" y1="325" x2="960" y2="325" stroke="#94a3b8" stroke-width="1.4"/>
            <rect x="1010" y="325" width="16" height="35" rx="1" fill="#cbd5e1" fill-opacity="0.4"/>
            <line x1="1080" y1="285" x2="1140" y2="285" stroke="#94a3b8" stroke-width="1.4"/>
        </g>

        <!-- SELECTIVE ANIMATED WINDOWS (Subtle breathing light effects) -->
        <g stroke="#94a3b8" stroke-width="0.8">
            <!-- Left Tower Windows (Cool Modern Blue Tint) -->
            <rect x="50" y="240" width="18" height="15" rx="1" fill="url(#glassWindowAccent)" class="anim-win-glow-1"/>
            <rect x="75" y="240" width="18" height="15" rx="1" fill="url(#glassWindowAccent)"/>
            <rect x="50" y="265" width="18" height="15" rx="1" fill="url(#glassWindowAccent)"/>
            <rect x="75" y="265" width="18" height="15" rx="1" fill="url(#glassWindowAccent)" class="anim-win-glow-2"/>

            <!-- Left Studio Ribbon Windows -->
            <rect x="148" y="250" width="38" height="14" rx="2" fill="url(#glassWindowAccent)" class="anim-win-glow-1"/>
            <rect x="148" y="295" width="38" height="14" rx="2" fill="url(#glassWindowAccent)" class="anim-win-glow-2"/>

            <!-- Left Kos Complex Warm Light (Warm amber tint for lived-in feeling) -->
            <rect x="235" y="255" width="16" height="18" rx="2" fill="url(#warmWindowAccent)" class="anim-win-warm"/>
            <rect x="260" y="255" width="16" height="18" rx="2" fill="url(#glassWindowAccent)"/>
            <rect x="235" y="302" width="16" height="18" rx="2" fill="url(#glassWindowAccent)"/>
            <rect x="260" y="302" width="16" height="18" rx="2" fill="url(#warmWindowAccent)" class="anim-win-warm"/>

            <!-- Center Low Residences (Subtle small windows) -->
            <rect x="498" y="335" width="14" height="12" rx="1" fill="url(#glassWindowAccent)" class="anim-win-glow-1"/>
            <rect x="518" y="335" width="14" height="12" rx="1" fill="url(#glassWindowAccent)"/>
            <rect x="660" y="335" width="14" height="12" rx="1" fill="url(#glassWindowAccent)"/>
            <rect x="680" y="335" width="14" height="12" rx="1" fill="url(#warmWindowAccent)" class="anim-win-warm"/>

            <!-- Right Kos Complex Windows -->
            <rect x="895" y="255" width="16" height="18" rx="2" fill="url(#glassWindowAccent)"/>
            <rect x="920" y="255" width="16" height="18" rx="2" fill="url(#warmWindowAccent)" class="anim-win-warm"/>
            <rect x="895" y="302" width="16" height="18" rx="2" fill="url(#warmWindowAccent)" class="anim-win-warm"/>
            <rect x="920" y="302" width="16" height="18" rx="2" fill="url(#glassWindowAccent)" class="anim-win-glow-2"/>

            <!-- Right Studio Ribbon Windows -->
            <rect x="998" y="250" width="38" height="14" rx="2" fill="url(#glassWindowAccent)" class="anim-win-glow-2"/>
            <rect x="998" y="295" width="38" height="14" rx="2" fill="url(#glassWindowAccent)" class="anim-win-glow-1"/>

            <!-- Right Tower Windows -->
            <rect x="1085" y="235" width="16" height="16" rx="1" fill="url(#glassWindowAccent)" class="anim-win-glow-1"/>
            <rect x="1110" y="235" width="16" height="16" rx="1" fill="url(#glassWindowAccent)"/>
            <rect x="1085" y="260" width="16" height="16" rx="1" fill="url(#glassWindowAccent)"/>
            <rect x="1110" y="260" width="16" height="16" rx="1" fill="url(#glassWindowAccent)" class="anim-win-glow-2"/>
        </g>

        <!-- SUBTLE GREENERY / TREES WITH SWAY ANIMATIONS -->
        <g stroke="#059669" stroke-width="1.3" fill="#10b981" fill-opacity="0.35">
            <!-- Tree 1 (Between Center Left residences) -->
            <g class="anim-tree-1">
                <path d="M 395 360 L 395 342 Q 386 332 395 320 Q 404 332 395 342"/>
            </g>
            <!-- Tree 2 (Between Center Right residences) -->
            <g class="anim-tree-2">
                <path d="M 795 360 L 795 340 Q 786 330 795 318 Q 804 330 795 340"/>
            </g>
            <!-- Tree 3 (Far Right edge) -->
            <g class="anim-tree-3">
                <path d="M 1165 360 L 1165 342 Q 1156 332 1165 322 Q 1174 332 1165 342"/>
            </g>
        </g>

        <!-- CLEAN MINIMALIST BASELINE GROUND -->
        <line x1="0" y1="360" x2="1200" y2="360" stroke="#cbd5e1" stroke-width="1.8"/>
    </g>
</svg>
