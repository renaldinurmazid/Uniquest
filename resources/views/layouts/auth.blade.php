<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} — {{ $title ?? 'App' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Exo+2:wght@300;400;500;600;700;800;900&display=swap');

        :root {
            --violet-950: #1a0533;
            --violet-900: #250a45;
            --violet-800: #3b0f6e;
            --violet-700: #5b21b6;
            --violet-600: #7c3aed;
            --violet-500: #8b5cf6;
            --violet-400: #a78bfa;
            --violet-300: #c4b5fd;
            --neon-purple: #bf5fff;
            --neon-pink: #ff4dff;
            --gold: #ffd700;
            --gold-dim: #c9a227;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Exo 2', sans-serif;
            background: var(--violet-950);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* ===== GLOBAL BG ===== */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                linear-gradient(rgba(139, 92, 246, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(139, 92, 246, 0.06) 1px, transparent 1px);
            background-size: 44px 44px;
            animation: gridDrift 24s linear infinite;
            pointer-events: none;
        }

        @keyframes gridDrift {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(44px);
            }
        }

        /* ambient orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
        }

        .orb-tl {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.32) 0%, transparent 70%);
            top: -200px;
            left: -150px;
            animation: floatA 9s ease-in-out infinite alternate;
        }

        .orb-br {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(191, 95, 255, 0.22) 0%, transparent 70%);
            bottom: -150px;
            right: -120px;
            animation: floatB 11s ease-in-out infinite alternate;
        }

        .orb-mid {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 77, 255, 0.12) 0%, transparent 70%);
            top: 35%;
            left: 48%;
            animation: floatA 7s ease-in-out infinite alternate-reverse;
        }

        @keyframes floatA {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(25px, 18px) scale(1.1);
            }
        }

        @keyframes floatB {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(-18px, -25px) scale(1.08);
            }
        }

        /* particles */
        .particle {
            position: fixed;
            border-radius: 50%;
            background: var(--violet-400);
            opacity: 0.45;
            animation: particleRise linear infinite;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes particleRise {
            0% {
                transform: translateY(105vh) rotate(0deg);
                opacity: 0;
            }

            8% {
                opacity: 0.5;
            }

            92% {
                opacity: 0.35;
            }

            100% {
                transform: translateY(-8vh) rotate(720deg);
                opacity: 0;
            }
        }

        /* ===== OUTER SHELL ===== */
        .auth-shell {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        /* ===== PANEL ===== */
        .auth-panel {
            width: 100%;
            max-width: 1040px;
            background: linear-gradient(145deg, rgba(37, 10, 69, 0.97) 0%, rgba(26, 5, 51, 0.99) 100%);
            border: 1px solid rgba(139, 92, 246, 0.28);
            border-radius: 28px;
            box-shadow:
                0 0 0 1px rgba(191, 95, 255, 0.08),
                0 32px 100px rgba(0, 0, 0, 0.65),
                inset 0 1px 0 rgba(255, 255, 255, 0.04);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 620px;
            animation: panelIn 0.7s cubic-bezier(.22, .68, 0, 1.15) both;
        }

        @keyframes panelIn {
            from {
                opacity: 0;
                transform: translateY(32px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (min-width: 768px) {
            .auth-panel {
                flex-direction: row;
            }
        }

        /* ===== LEFT BRANDING SIDE ===== */
        .brand-side {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            background: linear-gradient(160deg, rgba(91, 33, 182, 0.18) 0%, rgba(59, 15, 110, 0.12) 100%);
            border-right: 1px solid rgba(139, 92, 246, 0.15);
        }

        @media (min-width: 768px) {
            .brand-side {
                width: 48%;
            }
        }

        /* brand side inner glow */
        .brand-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 60%, rgba(139, 92, 246, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        /* scanlines overlay */
        .brand-side::after {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(0deg,
                    transparent,
                    transparent 3px,
                    rgba(139, 92, 246, 0.015) 3px,
                    rgba(139, 92, 246, 0.015) 4px);
            pointer-events: none;
        }

        /* corner decorations on brand side */
        .brand-corner {
            position: absolute;
            width: 72px;
            height: 72px;
            opacity: 0.45;
        }

        .brand-corner.tl {
            top: 20px;
            left: 20px;
        }

        .brand-corner.tr {
            top: 20px;
            right: 20px;
            transform: rotate(90deg);
        }

        .brand-corner.bl {
            bottom: 20px;
            left: 20px;
            transform: rotate(-90deg);
        }

        .brand-corner.br {
            bottom: 20px;
            right: 20px;
            transform: rotate(180deg);
        }

        /* ===== LOGO AREA ===== */
        .logo-area {
            position: relative;
            z-index: 2;
            text-align: center;
            margin-bottom: 36px;
            animation: panelIn 0.7s 0.15s both;
        }

        .logo-emblem {
            width: 72px;
            height: 72px;
            margin: 0 auto 14px;
            background: linear-gradient(135deg, var(--violet-700), var(--neon-purple));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow:
                0 0 0 1px rgba(191, 95, 255, 0.3),
                0 8px 32px rgba(124, 58, 237, 0.45),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .logo-emblem::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 21px;
            background: conic-gradient(var(--neon-purple), var(--violet-500), var(--neon-pink), var(--violet-500), var(--neon-purple));
            z-index: -1;
            animation: spin 5s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .logo-name {
            font-family: 'Rajdhani', sans-serif;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 3px;
            color: #fff;
            text-transform: uppercase;
            text-shadow: 0 0 24px rgba(191, 95, 255, 0.5);
        }

        .logo-tagline {
            font-size: 13px;
            color: var(--violet-400);
            font-weight: 500;
            margin-top: 4px;
            letter-spacing: 0.5px;
        }

        /* ===== ILLUSTRATION ===== */
        .illus-wrap {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 280px;
            margin: 0 auto 32px;
            animation: panelIn 0.7s 0.2s both;
        }

        .illus-wrap img {
            width: 100%;
            height: auto;
            filter: drop-shadow(0 0 30px rgba(191, 95, 255, 0.35)) drop-shadow(0 0 60px rgba(124, 58, 237, 0.2));
            animation: floatIllus 4s ease-in-out infinite alternate;
        }

        @keyframes floatIllus {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-10px);
            }
        }

        /* ===== BRAND COPY ===== */
        .brand-copy {
            position: relative;
            z-index: 2;
            text-align: center;
            animation: panelIn 0.7s 0.25s both;
        }

        .brand-headline {
            font-family: 'Rajdhani', sans-serif;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #fff;
            text-shadow: 0 0 20px rgba(167, 139, 250, 0.4);
            margin-bottom: 10px;
        }

        .brand-headline span {
            background: linear-gradient(90deg, var(--violet-300), var(--neon-purple), var(--neon-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-sub {
            font-size: 14px;
            color: var(--violet-400);
            font-weight: 400;
            line-height: 1.6;
            max-width: 280px;
            margin: 0 auto;
        }

        /* ===== FEATURE PILLS ===== */
        .feature-pills {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            position: relative;
            z-index: 2;
            animation: panelIn 0.7s 0.3s both;
        }

        .pill {
            background: rgba(91, 33, 182, 0.25);
            border: 1px solid rgba(139, 92, 246, 0.2);
            border-radius: 99px;
            padding: 5px 12px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: var(--violet-300);
            text-transform: uppercase;
            transition: border-color 0.2s, background 0.2s;
        }

        .pill:hover {
            border-color: var(--violet-500);
            background: rgba(124, 58, 237, 0.3);
        }

        /* ===== RIGHT CONTENT SIDE ===== */
        .content-side {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 40px;
        }

        @media (min-width: 768px) {
            .content-side {
                width: 52%;
            }
        }

        @media (max-width: 640px) {
            .content-side {
                padding: 32px 24px;
            }

            .brand-side {
                padding: 40px 24px;
            }
        }

        .content-inner {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <!-- Ambient BG -->
    <div class="orb orb-tl"></div>
    <div class="orb orb-br"></div>
    <div class="orb orb-mid"></div>

    <!-- Particles -->
    <div class="particle" style="width:4px;height:4px;left:8%;animation-duration:13s;animation-delay:0s;"></div>
    <div class="particle"
        style="width:3px;height:3px;left:22%;animation-duration:16s;animation-delay:2s;background:var(--neon-purple)">
    </div>
    <div class="particle"
        style="width:5px;height:5px;left:45%;animation-duration:11s;animation-delay:4s;background:var(--neon-pink)">
    </div>
    <div class="particle" style="width:3px;height:3px;left:65%;animation-duration:14s;animation-delay:1s;"></div>
    <div class="particle"
        style="width:4px;height:4px;left:80%;animation-duration:10s;animation-delay:6s;background:var(--gold)"></div>
    <div class="particle"
        style="width:2px;height:2px;left:92%;animation-duration:17s;animation-delay:3s;background:var(--violet-300)">
    </div>
    <div class="particle" style="width:3px;height:3px;left:35%;animation-duration:12s;animation-delay:8s;"></div>

    <div class="auth-shell">
        <div class="auth-panel">

            <!-- ===== LEFT: BRANDING ===== -->
            <div class="brand-side">
                <!-- Corner SVG deco -->
                <svg class="brand-corner tl" viewBox="0 0 72 72" fill="none">
                    <path d="M0 50 L0 0 L50 0" stroke="rgba(139,92,246,0.5)" stroke-width="1.5" />
                    <circle cx="0" cy="0" r="5" fill="var(--neon-purple)" />
                </svg>
                <svg class="brand-corner tr" viewBox="0 0 72 72" fill="none">
                    <path d="M0 50 L0 0 L50 0" stroke="rgba(139,92,246,0.5)" stroke-width="1.5" />
                    <circle cx="0" cy="0" r="5" fill="var(--neon-purple)" />
                </svg>
                <svg class="brand-corner bl" viewBox="0 0 72 72" fill="none">
                    <path d="M0 50 L0 0 L50 0" stroke="rgba(139,92,246,0.5)" stroke-width="1.5" />
                    <circle cx="0" cy="0" r="5" fill="var(--neon-purple)" />
                </svg>
                <svg class="brand-corner br" viewBox="0 0 72 72" fill="none">
                    <path d="M0 50 L0 0 L50 0" stroke="rgba(139,92,246,0.5)" stroke-width="1.5" />
                    <circle cx="0" cy="0" r="5" fill="var(--neon-purple)" />
                </svg>

                <!-- Logo -->
                <div class="logo-area">
                    <div class="logo-emblem">🏰</div>
                    <div class="logo-name">UniQuest</div>
                    <div class="logo-tagline">Your Campus. Your Adventure.</div>
                </div>

                <!-- Illustration -->
                <div class="illus-wrap">
                    <img src="{{ asset('assets/svg/man_reward.svg') }}" alt="UniQuest Hero">
                </div>

                <!-- Copy -->
                <div class="brand-copy">
                    <div class="brand-headline">
                        Level Up Your Campus Life
                    </div>
                    <p class="brand-sub">
                        Join the quest, earn rewards, and build your digital legacy at UniQuest.
                    </p>
                </div>

                <!-- Feature pills -->
                <div class="feature-pills">
                    <span class="pill">⚔️ Quests</span>
                    <span class="pill">🏆 Achievements</span>
                    <span class="pill">⚡ XP Rewards</span>
                    <span class="pill">📊 Leaderboard</span>
                </div>
            </div>

            <!-- ===== RIGHT: SLOT ===== -->
            <div class="content-side">
                <div class="content-inner">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </div>

    @livewireScripts
</body>

</html>
