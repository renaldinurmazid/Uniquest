<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

new #[Layout('layouts::auth', ['title' => 'Login'])] class extends Component {
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($this->only(['email', 'password']))) {
            return redirect()->intended('dashboard');
        }

        session()->flash('error', 'Invalid credentials');
    }
};
?>

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
        --violet-200: #ddd6fe;
        --neon-purple: #bf5fff;
        --neon-pink: #ff4dff;
        --gold: #ffd700;
        --gold-dim: #c9a227;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .login-root {
        font-family: 'Exo 2', sans-serif;
        min-height: 100vh;
        background: var(--violet-950);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    /* === BACKGROUND FX === */
    .bg-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(139, 92, 246, 0.07) 1px, transparent 1px),
            linear-gradient(90deg, rgba(139, 92, 246, 0.07) 1px, transparent 1px);
        background-size: 40px 40px;
        animation: gridDrift 20s linear infinite;
    }

    @keyframes gridDrift {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(40px);
        }
    }

    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
    }

    .orb-1 {
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(124, 58, 237, 0.35) 0%, transparent 70%);
        top: -150px;
        left: -100px;
        animation: orbFloat1 8s ease-in-out infinite alternate;
    }

    .orb-2 {
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(191, 95, 255, 0.25) 0%, transparent 70%);
        bottom: -100px;
        right: -80px;
        animation: orbFloat2 10s ease-in-out infinite alternate;
    }

    .orb-3 {
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255, 77, 255, 0.15) 0%, transparent 70%);
        top: 40%;
        right: 15%;
        animation: orbFloat1 6s ease-in-out infinite alternate-reverse;
    }

    @keyframes orbFloat1 {
        from {
            transform: translate(0, 0) scale(1);
        }

        to {
            transform: translate(30px, 20px) scale(1.1);
        }
    }

    @keyframes orbFloat2 {
        from {
            transform: translate(0, 0) scale(1);
        }

        to {
            transform: translate(-20px, -30px) scale(1.08);
        }
    }

    /* floating particles */
    .particle {
        position: absolute;
        border-radius: 50%;
        background: var(--violet-400);
        opacity: 0.5;
        animation: particleFly linear infinite;
    }

    @keyframes particleFly {
        0% {
            transform: translateY(110vh) rotate(0deg);
            opacity: 0;
        }

        10% {
            opacity: 0.5;
        }

        90% {
            opacity: 0.4;
        }

        100% {
            transform: translateY(-10vh) rotate(720deg);
            opacity: 0;
        }
    }

    /* === CARD === */
    .card-wrap {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 430px;
        padding: 16px;
        animation: cardIn 0.7s cubic-bezier(.22, .68, 0, 1.2) both;
    }

    @keyframes cardIn {
        from {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .card {
        background: linear-gradient(145deg, rgba(37, 10, 69, 0.95) 0%, rgba(26, 5, 51, 0.98) 100%);
        border: 1px solid rgba(139, 92, 246, 0.3);
        border-radius: 24px;
        padding: 36px 32px 32px;
        box-shadow:
            0 0 0 1px rgba(191, 95, 255, 0.1),
            0 24px 80px rgba(0, 0, 0, 0.6),
            inset 0 1px 0 rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
    }

    /* === PLAYER HEADER === */
    .player-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
        animation: cardIn 0.7s 0.1s both;
    }

    .avatar-ring {
        position: relative;
        flex-shrink: 0;
    }

    .avatar-ring::before {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        background: conic-gradient(var(--neon-purple), var(--violet-500), var(--neon-pink), var(--violet-500), var(--neon-purple));
        animation: spin 4s linear infinite;
        z-index: 0;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .avatar-inner {
        position: relative;
        z-index: 1;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--violet-800), var(--violet-950));
        border: 2px solid var(--violet-950);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .player-meta {
        flex: 1;
    }

    .player-tag {
        font-family: 'Rajdhani', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
        color: var(--violet-400);
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .player-title {
        font-size: 20px;
        font-weight: 800;
        color: #fff;
        line-height: 1.1;
        text-shadow: 0 0 20px rgba(167, 139, 250, 0.5);
    }

    .badge {
        background: linear-gradient(135deg, var(--gold-dim), var(--gold));
        color: #1a0533;
        font-family: 'Rajdhani', sans-serif;
        font-weight: 700;
        font-size: 11px;
        letter-spacing: 1px;
        padding: 3px 8px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
        white-space: nowrap;
    }

    /* === XP BAR === */
    .xp-section {
        margin-bottom: 28px;
        animation: cardIn 0.7s 0.15s both;
    }

    .xp-label-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }

    .xp-label {
        font-family: 'Rajdhani', sans-serif;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 1.5px;
        color: var(--violet-400);
        text-transform: uppercase;
    }

    .xp-val {
        font-family: 'Rajdhani', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: var(--neon-purple);
    }

    .xp-track {
        height: 8px;
        background: rgba(139, 92, 246, 0.15);
        border-radius: 99px;
        overflow: hidden;
        border: 1px solid rgba(139, 92, 246, 0.2);
        position: relative;
    }

    .xp-fill {
        height: 100%;
        width: 72%;
        background: linear-gradient(90deg, var(--violet-600), var(--neon-purple), var(--neon-pink));
        border-radius: 99px;
        box-shadow: 0 0 12px rgba(191, 95, 255, 0.6);
        animation: xpGrow 1.2s 0.4s cubic-bezier(.22, .68, 0, 1.1) both;
        position: relative;
    }

    @keyframes xpGrow {
        from {
            width: 0%;
        }

        to {
            width: 72%;
        }
    }

    .xp-fill::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent 60%, rgba(255, 255, 255, 0.25));
        animation: xpShine 2s 1.5s ease-in-out infinite;
    }

    @keyframes xpShine {

        0%,
        100% {
            opacity: 0;
            transform: translateX(-100%);
        }

        50% {
            opacity: 1;
            transform: translateX(100%);
        }
    }

    /* === DIVIDER === */
    .quest-divider {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 22px;
        animation: cardIn 0.7s 0.2s both;
    }

    .divider-line {
        flex: 1;
        height: 1px;
        background: rgba(139, 92, 246, 0.2);
    }

    .quest-label {
        font-family: 'Rajdhani', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2.5px;
        color: var(--violet-500);
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .quest-icon {
        font-size: 13px;
    }

    /* === FORM === */
    .form-fields {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 20px;
    }

    .field-group {
        animation: cardIn 0.6s both;
    }

    .field-group:nth-child(1) {
        animation-delay: 0.25s;
    }

    .field-group:nth-child(2) {
        animation-delay: 0.32s;
    }

    .field-label-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 7px;
    }

    .field-label {
        font-family: 'Rajdhani', sans-serif;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.5px;
        color: var(--violet-300);
        text-transform: uppercase;
    }

    .forgot-link {
        font-family: 'Rajdhani', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        color: var(--neon-purple);
        text-decoration: none;
        text-transform: uppercase;
        transition: color 0.2s, text-shadow 0.2s;
    }

    .forgot-link:hover {
        color: var(--neon-pink);
        text-shadow: 0 0 10px rgba(255, 77, 255, 0.5);
    }

    .input-wrap {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--violet-500);
        pointer-events: none;
        transition: color 0.2s;
    }

    .field-input {
        width: 100%;
        padding: 13px 16px 13px 44px;
        background: rgba(59, 15, 110, 0.3);
        border: 1px solid rgba(139, 92, 246, 0.25);
        border-radius: 14px;
        color: #e9d5ff;
        font-family: 'Exo 2', sans-serif;
        font-size: 15px;
        font-weight: 500;
        outline: none;
        transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    }

    .field-input::placeholder {
        color: rgba(167, 139, 250, 0.35);
    }

    .field-input:focus {
        background: rgba(91, 33, 182, 0.2);
        border-color: var(--violet-500);
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15), 0 0 20px rgba(191, 95, 255, 0.1);
    }

    .field-input:focus+.input-focus-ring {
        opacity: 1;
    }

    .input-wrap:focus-within .input-icon {
        color: var(--neon-purple);
    }

    /* === REMEMBER ME === */
    .remember-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
        animation: cardIn 0.6s 0.38s both;
    }

    .custom-checkbox {
        position: relative;
    }

    .custom-checkbox input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .checkbox-visual {
        width: 18px;
        height: 18px;
        border: 1.5px solid rgba(139, 92, 246, 0.4);
        border-radius: 5px;
        background: rgba(59, 15, 110, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .custom-checkbox input:checked~.checkbox-visual {
        background: var(--violet-600);
        border-color: var(--violet-500);
        box-shadow: 0 0 10px rgba(124, 58, 237, 0.4);
    }

    .checkbox-visual svg {
        opacity: 0;
        transition: opacity 0.2s;
    }

    .custom-checkbox input:checked~.checkbox-visual svg {
        opacity: 1;
    }

    .remember-text {
        font-size: 13px;
        font-weight: 500;
        color: var(--violet-300);
        cursor: pointer;
        user-select: none;
    }

    /* === SUBMIT BTN === */
    .btn-submit {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, var(--violet-700) 0%, var(--neon-purple) 50%, var(--violet-600) 100%);
        background-size: 200% auto;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        color: #fff;
        font-family: 'Rajdhani', sans-serif;
        font-size: 17px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        box-shadow: 0 4px 24px rgba(124, 58, 237, 0.4), 0 0 0 1px rgba(191, 95, 255, 0.2);
        transition: background-position 0.4s, box-shadow 0.3s, transform 0.15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        animation: cardIn 0.6s 0.44s both;
    }

    .btn-submit:hover {
        background-position: right center;
        box-shadow: 0 6px 32px rgba(191, 95, 255, 0.5), 0 0 0 1px rgba(255, 77, 255, 0.3);
        transform: translateY(-1px);
    }

    .btn-submit:active {
        transform: scale(0.98) translateY(0);
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        transition: left 0.5s;
    }

    .btn-submit:hover::before {
        left: 140%;
    }

    .btn-icon {
        font-size: 18px;
    }

    /* === STATS ROW === */
    .stats-row {
        display: flex;
        gap: 10px;
        margin-top: 22px;
        animation: cardIn 0.6s 0.5s both;
    }

    .stat-box {
        flex: 1;
        background: rgba(59, 15, 110, 0.25);
        border: 1px solid rgba(139, 92, 246, 0.15);
        border-radius: 12px;
        padding: 10px 8px;
        text-align: center;
    }

    .stat-num {
        font-family: 'Rajdhani', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--neon-purple);
        line-height: 1;
        text-shadow: 0 0 12px rgba(191, 95, 255, 0.4);
    }

    .stat-desc {
        font-size: 10px;
        color: var(--violet-400);
        font-weight: 500;
        letter-spacing: 0.5px;
        margin-top: 3px;
    }

    /* === FLASH ERROR === */
    .flash-error {
        background: rgba(255, 50, 50, 0.1);
        border: 1px solid rgba(255, 80, 80, 0.3);
        border-radius: 12px;
        padding: 10px 14px;
        margin-bottom: 16px;
        color: #ff8080;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* === CORNER DECO === */
    .corner-deco {
        position: absolute;
        width: 60px;
        height: 60px;
        opacity: 0.4;
    }

    .corner-deco.tl {
        top: 16px;
        left: 16px;
    }

    .corner-deco.br {
        bottom: 16px;
        right: 16px;
        transform: rotate(180deg);
    }
</style>

<div class="login-root">
    <!-- BG -->
    <div class="bg-grid"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- Particles -->
    <div class="particle" style="width:4px;height:4px;left:10%;animation-duration:12s;animation-delay:0s;"></div>
    <div class="particle"
        style="width:3px;height:3px;left:25%;animation-duration:15s;animation-delay:3s;background:var(--neon-purple)">
    </div>
    <div class="particle"
        style="width:5px;height:5px;left:50%;animation-duration:10s;animation-delay:1s;background:var(--neon-pink)">
    </div>
    <div class="particle" style="width:3px;height:3px;left:70%;animation-duration:14s;animation-delay:5s;"></div>
    <div class="particle"
        style="width:4px;height:4px;left:85%;animation-duration:11s;animation-delay:2s;background:var(--gold)"></div>
    <div class="particle"
        style="width:2px;height:2px;left:40%;animation-duration:16s;animation-delay:7s;background:var(--violet-300)">
    </div>

    <div class="card-wrap">
        <div class="card">

            <!-- Corner decorations -->
            <svg class="corner-deco tl" viewBox="0 0 60 60" fill="none">
                <path d="M0 40 L0 0 L40 0" stroke="rgba(139,92,246,0.6)" stroke-width="1.5" />
                <circle cx="0" cy="0" r="4" fill="var(--neon-purple)" />
            </svg>
            <svg class="corner-deco br" viewBox="0 0 60 60" fill="none">
                <path d="M0 40 L0 0 L40 0" stroke="rgba(139,92,246,0.6)" stroke-width="1.5" />
                <circle cx="0" cy="0" r="4" fill="var(--neon-purple)" />
            </svg>

            <!-- Player Header -->
            <div class="player-header">
                <div class="avatar-ring">
                    <div class="avatar-inner">🧙</div>
                </div>
                <div class="player-meta">
                    <div class="player-tag">⚔️ Player Login</div>
                    <div class="player-title">Welcome Back, Hero</div>
                </div>
            </div>

            <!-- Quest Divider -->
            <div class="quest-divider">
                <div class="divider-line"></div>
                <div class="quest-label"><span class="quest-icon">🗡️</span> Daily Quest: Sign In</div>
                <div class="divider-line"></div>
            </div>

            @if (session('error'))
                <div class="flash-error">
                    <span>⚠️</span> {{ session('error') }}
                </div>
            @endif

            <form wire:submit="login">
                <div class="form-fields">
                    <!-- Email -->
                    <div class="field-group">
                        <div class="field-label-row">
                            <label class="field-label" for="email">📧 Mage Identity</label>
                        </div>
                        <div class="input-wrap">
                            <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                            <input type="email" id="email" wire:model="email" class="field-input"
                                placeholder="hero@realm.university.edu" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="field-group">
                        <div class="field-label-row">
                            <label class="field-label" for="password">🔑 Secret Spell</label>
                            <a href="#" class="forgot-link">Forgot Spell?</a>
                        </div>
                        <div class="input-wrap">
                            <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input type="password" id="password" wire:model="password" class="field-input"
                                placeholder="••••••••" required>
                        </div>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="remember-row">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="remember">
                        <div class="checkbox-visual">
                            <svg width="10" height="10" fill="none" stroke="white" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </label>
                    <label for="remember" class="remember-text">🎮 Keep me in the game for 30 days</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <span class="btn-icon">⚔️</span>
                        Enter the Realm
                    </span>
                    <span wire:loading>
                        ✨ Casting Spell...
                    </span>
                </button>
            </form>

        </div>
    </div>
</div>
