<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Student Feedback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --surface: #f9fafb;
            --primary: #ff4f9a;
            /* pink primary like Preply Save/Send */
            --primary-dark: #e13f85;
            --blue: #2563eb;
            --chip-green: #d8f8f2;
            --chip-green-text: #000;
            --next-chip-pink: #ffebf3;
            --next-chip-pink-text: #9d174d;
            --radius-md: 5px;
            --radius-lg: 5px;
            --shadow-soft: 0 18px 45px rgba(15, 23, 42, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #ffffff;
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* ---------- Top bar ---------- */

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: #ffffff;
            border-bottom: 1px solid var(--border);
        }

        .topbar-inner {
            max-width: 100%;
            margin: 0;
            padding: 12px 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .brand-logo {
            width: 150px;
            height: 50px;
            object-fit: contain;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-topbar {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 5px;
            border: 1px solid var(--border);
            background: #ffffff;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
            transition: background .15s ease, box-shadow .15s ease, transform .05s ease;
        }

        .btn-topbar:hover {
            background: #f9fafb;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.12);
        }

        .btn-topbar:active {
            transform: translateY(1px);
            box-shadow: none;
        }

        .btn-topbar-icon {
            width: 18px;
            height: 18px;
        }

        .btn-topbar-icon img {
            width: 100%;
            height: 100%;
            display: block;
        }

        /* ---------- Layout / hero ---------- */

        .page-wrapper {
            min-height: 100vh;
            padding: 32px 72px 40px;
        }

        .page-container {
            width: 100%;
            max-width: 960px;
            margin: 0;
        }

        .hero-eyebrow {
            font-size: 20px;
            font-weight: 700;
            color: black;
            margin-bottom: 8px;
        }

        .hero-title {
            font-size: 45px;
            line-height: 1.25;
            margin: 0;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .hero-title span {
            display: inline-block;
        }

        .hero-highlight {
            background: linear-gradient(90deg, #ec4899, #6366f1, #22c55e);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-link {
            font-size: 32px;
            margin-top: 2px;
            font-weight: 700;
            color: var(--blue);
        }

        .hero-banner {
            margin-top: 18px;
            background: #f3f4f6;
            border-radius: var(--radius-lg);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .hero-banner-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-banner-strong {
            font-weight: 600;
        }

        .spacer-hero {
            height: 26px;
        }

        /* ---------- Sections ---------- */

        .section {
            margin-bottom: 32px;
        }

        .section-header {
            margin-bottom: 14px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .section-subtitle {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 20px;
        }

        .divider {
            height: 1px;
            background: var(--border);
            margin: 30px 0;
        }

        /* ---------- Choose button ---------- */

        .choose-areas-btn {
            width: 100%;
            border-radius: 5px;
            border: 2px solid #111827;
            background: #ffffff;
            padding: 7px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            transition: background .15s ease, box-shadow .15s ease, transform .05s ease;
        }

        .choose-areas-btn:hover {
            background: #f4f5f5;
        }

        .choose-areas-btn:active {
            transform: translateY(1px);
            box-shadow: none;
        }

        .choose-areas-btn-icon {
            font-size: 30px;
            margin-bottom: 6px;
        }

        /* ---------- Cards & chips ---------- */

        .card {
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            background: #ffffff;
            padding: 18px 20px;
        }

        .progress-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            gap: 8px;
        }

        .progress-header-title {
            font-size: 18px;
            font-weight: 600;
        }

        .progress-header-edit {
            font-size: 14px;
            font-weight: 500;
            color: #000;
            cursor: pointer;
        }

        /* UPDATED: flex layout instead of fixed 3-column grid */
        .progress-summary {
            display: flex;
            gap: 14px;
        }

        .progress-summary>div {
            flex: 1;
            min-width: 0;
        }

        .progress-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            margin-bottom: 6px;
        }

        /* chips row per category */
        #summarySpeaking,
        #summaryEffort,
        #summaryListening,
        #step2SummaryEffort,
        #step2SummarySpeaking,
        #step2SummaryListening {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: flex-start;
        }

        .progress-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 5px;
            background: var(--chip-green);
            color: var(--chip-green-text);
            font-size: 13px;
            font-weight: 500;
        }

        .progress-chip-icon {
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .progress-chip-icon img {
            width: 100%;
            height: 100%;
        }

        /* step 2 / next steps pink chips */

        .next-steps-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 5px;
            background: var(--next-chip-pink);
            color: #000;
            font-size: 13px;
            font-weight: 600;
        }

        .next-steps-chip-icon {
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .next-steps-chip-icon img {
            width: 100%;
            height: 100%;
        }

        /* ---------- Modal ---------- */

        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.4);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 40;
        }

        .modal-backdrop.is-open {
            display: flex;
        }

        /* UPDATED: taller card, almost full screen height */
        .modal {
            width: calc(100% - 48px);
            max-width: 960px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: var(--shadow-soft);
            padding: 24px 32px 20px;
            max-height: calc(100vh - 32px);
            min-height: calc(100vh - 32px);
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 16px;
        }

        /* UPDATED: bolder & slightly larger title */
        .modal-title {
            font-size: 24px;
            font-weight: 700;
        }

        .modal-close {
            border: none;
            background: transparent;
            border-radius: 999px;
            cursor: pointer;
            padding: 4px;
        }

        .modal-close:hover {
            background: #f3f4f6;
        }

        .modal-close svg {
            width: 18px;
            height: 18px;
        }

        /* UPDATED: take remaining height */
        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding-right: 4px;
        }

        .modal-group {
            margin-bottom: 35px;
        }

        .modal-group-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .modal-group-title span.icon {
            width: 22px;
            height: 22px;
            border-radius: 999px;
            background: #f3f4f6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* icon images inside the circle */
        .modal-group-title span.icon img {
            width: 14px;
            height: 14px;
            display: block;
        }

        .area-pill-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* pills: same rounded style */
        .area-pill {
            border-radius: 5px;
            border: 2px solid var(--border);
            padding: 10px 18px;
            font-size: 16px;
            background: #ffffff;
            font-weight: 500;
            cursor: pointer;
            transition: background .15s ease, border-color .15s ease, color .15s ease;
        }

        .area-pill:hover:not(.is-disabled):not(.is-selected) {
            background: #f9fafb;
        }

        .area-pill.is-selected {
            background: #111827;
            color: #ffffff;
            border-color: #111827;
        }

        .area-pill.is-disabled {
            background: #f3f4f6;
            color: #9ca3af;
            border-color: #e5e7eb;
            cursor: default;
            pointer-events: none;
        }

        .modal-footer {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .areas-count {
            font-size: 13px;
            color: var(--muted);
        }

        .modal-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn {
            border-radius: 5px;
            /* 5px as you requested */
            padding: 14px 24px;
            border: 2px solid #111827 !important;
            background: #ffffff;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: background .15s ease, box-shadow .15s ease, transform .05s ease;
        }

        .btn:hover {
            background: #f9fafb;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.14);
        }

        .btn:active {
            transform: translateY(1px);
            box-shadow: none;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-ghost {
            background: #ffffff;
            border-color: var(--border);
        }

        .btn-ghost:hover {
            background: #f9fafb;
        }

        /* ---------- Toast ---------- */

        .toast {
            position: fixed;
            top: 18px;
            right: 18px;
            background: #111827;
            color: #ffffff;
            padding: 8px 12px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 500;
            opacity: 0;
            transform: translateY(-10px);
            pointer-events: none;
            transition: opacity .18s ease, transform .18s ease;
            z-index: 50;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .toast-icon {
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: #22c55e;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        .toast-close {
            border: none;
            background: transparent;
            color: #9ca3af;
            cursor: pointer;
            padding: 2px;
        }

        .toast-close:hover {
            color: #e5e7eb;
        }

        /* ---------- Wrap-note titles (step 2 & 3) ---------- */

        .wrap-note-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .wrap-note-subtitle {
            font-size: 14px;
            color: var(--muted);
            max-width: 720px;
        }

        /* ---------- Step 2 option buttons ---------- */

        .note-options {
            margin-top: 18px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .note-option-btn {
            width: 100%;
            border-radius: 5px;
            padding: 16px 18px;
            font-size: 15px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            border: 2px solid #111827;
            background: #ffffff;
            transition: background .15s ease, box-shadow .15s ease, transform .05s ease;
        }

        .note-option-btn:hover {
            background: #f9fafb;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.14);
        }

        .note-option-btn:active {
            transform: translateY(1px);
            box-shadow: none;
        }

        .note-option-btn-primary {
            border-color: transparent;
            background:
                linear-gradient(#ffffff, #ffffff) padding-box,
                linear-gradient(90deg, #ec4899, #a855f7, #6366f1) border-box;
        }

        .note-option-btn-secondary {
            border-color: #111827;
            background: #ffffff;
        }

        .note-option-icon {
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .note-option-icon img {
            width: 100%;
            height: 100%;
        }

        /* ---------- Step 3 note editor ---------- */

        .note-editor-label {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .note-editor-card {
            border-radius: 5px;
            border: 1px solid var(--border);
            background: #ffffff;
            padding: 14px 16px 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .note-editor-textarea {
            width: 100%;
            min-height: 180px;
            resize: vertical;
            border: none;
            outline: none;
            font-family: inherit;
            font-size: 14px;
            line-height: 1.5;
            color: var(--text);
        }

        .note-editor-textarea::placeholder {
            color: #9ca3af;
        }

        .note-editor-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .note-editor-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .note-editor-small-btn {
            border-radius: 999px;
            border: 1px solid var(--border);
            background: #ffffff;
            padding: 7px 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background .15s ease, box-shadow .15s ease;
        }

        .note-editor-small-btn:hover {
            background: #f9fafb;
            box-shadow: 0 5px 14px rgba(15, 23, 42, 0.12);
        }

        .note-editor-small-icon {
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .note-editor-small-icon img {
            width: 100%;
            height: 100%;
        }

        .note-editor-ai {
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .note-editor-ai-btn {
            width: 28px;
            height: 28px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0;
        }

        .note-editor-ai-btn img {
            width: 16px;
            height: 16px;
        }

        .note-editor-ai-btn-main {
            background: #16a34a;
            border-color: #16a34a;
            color: #ffffff;
        }

        .note-pro-tip {
            margin-top: 10px;
            font-size: 13px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .note-pro-tip-icon {
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .note-pro-tip-icon img {
            width: 100%;
            height: 100%;
        }

        .note-pro-tip-label {
            font-weight: 600;
            color: #2563eb;
        }

        .note-bottom-divider {
            height: 1px;
            background: var(--border);
            margin: 26px 0 18px;
        }

        .note-bottom-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .bottom-btn {
            border-radius: 5px;
            padding: 12px 20px;
            font-size: 15px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            border: 2px solid #111827;
            background: #ffffff;
            transition: background .15s ease, box-shadow .15s ease, transform .05s ease;
        }

        .bottom-btn:hover {
            background: #f9fafb;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.16);
        }

        .bottom-btn:active {
            transform: translateY(1px);
            box-shadow: none;
        }

        .bottom-btn-ghost {
            border-color: #111827;
            background: #ffffff;
        }

        .bottom-btn-primary {
            border-color: transparent;
            color: #111827;
            background: var(--primary);
        }

        .bottom-btn-primary:hover {
            background: var(--primary-dark);
        }

        .bottom-btn-icon {
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .bottom-btn-icon img {
            width: 100%;
            height: 100%;
        }

        /* ---------- Responsive ---------- */

        @media (max-width: 850px) {
            .progress-summary {
                flex-direction: column;
            }

            .hero-title,
            .hero-link {
                font-size: 26px;
            }

            .page-wrapper {
                padding-inline: 16px;
            }

            .topbar-inner {
                padding-inline: 16px;
            }
        }

        @media (max-width: 640px) {
            .modal {
                margin-inline: 10px;
                padding-inline: 18px;
            }

            .modal-footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .modal-actions {
                width: 100%;
                justify-content: flex-end;
            }

            .note-bottom-actions {
                justify-content: stretch;
            }

            .bottom-btn {
                flex: 1 1 100%;
                justify-content: center;
            }
        }
    </style>

</head>

<body>
    <!-- Toast -->
    <div class="toast" id="areasToast">
        <span class="toast-icon">✓</span>
        <span>You’ve selected 3 areas</span>
        <button class="toast-close" id="areasToastClose" type="button">✕</button>
    </div>

    <!-- Top bar -->
    <header class="topbar">
        <div class="topbar-inner">
            <a href="#" class="brand">
                <img src="img/my_students/logo_header.svg" alt="Latingles logo" class="brand-logo" />
            </a>

            <div class="topbar-actions">
                <button type="button" class="btn-topbar">
                    <span class="btn-topbar-icon">
                        <img src="img/my_students/remind_icon.svg" alt="Bell" />
                    </span>
                    <span>Remind me later</span>
                </button>

                <a href="my_students.php" class="btn-topbar">
                    <span class="btn-topbar-icon">
                        <img src="img/my_students/go home_icon.svg" alt="Home" />
                    </span>
                    <span>Go to home</span>
                </a>
            </div>
        </div>
    </header>

    <div class="page-wrapper">
        <main class="page-container">
            <!-- Hero -->
            <section>
                <div class="hero-eyebrow">
                    Congrats on another month of lessons with Latingles!
                </div>
                <h1 class="hero-title">
                    <span>Take 3 mins to celebrate Latingles’s</span>
                    <span> progress with our <span class="hero-highlight">AI-powered feedback</span></span>
                </h1>

                <div class="hero-banner">
                    <div class="hero-banner-icon">
                        <img src="img/my_students/making-progress.svg" alt="Progress" />
                    </div>
                    <div>
                        <span class="hero-banner-strong">Students who get regular feedback</span>
                        <span> are more likely to keep learning.</span>
                    </div>
                </div>
            </section>

            <div class="spacer-hero"></div>

            <!-- STEP 1: progress so far -->
            <section class="section">
                <!-- Heading is always visible on page load -->
                <header class="section-header" id="progressHeader">
                    <div class="section-title">What progress has Latingles made so far?</div>
                    <div class="section-subtitle">You last sent feedback to Latingles about 15 hours ago</div>
                </header>

                <!-- Initial state: just the button -->
                <div id="progressInitial">
                    <button class="choose-areas-btn" id="openAreasModal">
                        <span class="choose-areas-btn-icon">＋</span>
                        <span>Choose up to 3 areas</span>
                    </button>
                </div>

                <!-- Summary block (shown after Save) -->
                <div id="progressSummaryBlock" style="display:none;">
                    <div class="progress-header">
                        <div class="progress-header-title">Latingles's progress</div>
                        <a href="#" type="button" class="progress-header-edit" id="editAreasBtn" style="color:#000;text-decoration:underline;">Edit</a>
                    </div>

                    <div class="card">
                        <div class="progress-summary">
                            <div>
                                <div class="progress-label">Speaking</div>
                                <div id="summarySpeaking"></div>
                            </div>
                            <div>
                                <div class="progress-label">Effort</div>
                                <div id="summaryEffort"></div>
                            </div>
                            <div>
                                <div class="progress-label">Listening</div>
                                <div id="summaryListening"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="divider"></div>

            <!-- STEP 2 question -->
            <section class="section">
                <header class="section-header" id="focusHeader">
                    <div class="section-title">What should Latingles focus on in the next month?</div>
                </header>
            </section>

            <!-- STEP 2 next steps summary (hidden until Save in step 2) -->
            <section class="section" id="step2NextStepsSection" style="display:none;">
                <div class="progress-header">
                    <div class="progress-header-title">Latingles's next steps</div>
                    <a href="#" type="button" class="progress-header-edit" id="step2EditAreasBtn" style="color:#000;text-decoration:underline;">Edit</a>
                </div>

                <div class="card">
                    <div class="progress-summary">
                        <div>
                            <div class="progress-label">Effort</div>
                            <div id="step2SummaryEffort"></div>
                        </div>
                        <div>
                            <div class="progress-label">Speaking</div>
                            <div id="step2SummarySpeaking"></div>
                        </div>
                        <div>
                            <div class="progress-label">Listening</div>
                            <div id="step2SummaryListening"></div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="divider"></div>

            <!-- Divider under the next steps card (hidden until Save in step 2) -->
            <div class="divider" id="step2NextStepsDivider" style="display:none;"></div>

            <!-- STEP 3: static heading + dynamic content -->
            <section class="section">
                <header class="section-header">
                    <div class="section-title">Wrap up your feedback with a short note</div>
                </header>

                <?php require_once('my_student_details_menu_give_feedback_details_step2.php'); ?>
                <?php require_once('my_student_details_menu_give_feedback_details_step3.php'); ?>
            </section>

        </main>
    </div>

    <!-- STEP 1 modal -->
    <div class="modal-backdrop" id="areasModal">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="areasModalTitle">
            <div class="modal-header">
                <!-- title text -->
                <h2 class="modal-title" id="areasModalTitle">Choose up to 3 areas for Latingles to focus on next</h2>
                <button class="modal-close" id="areasModalClose" type="button">
                    <svg viewBox="0 0 20 20" fill="none">
                        <path d="M5 5l10 10M15 5 5 15" stroke="#111827" stroke-width="1.6" stroke-linecap="round" />
                    </svg>
                </button>
            </div>

            <div class="modal-body">
                <!-- Effort -->
                <div class="modal-group">
                    <div class="modal-group-title">
                        <span class="icon">
                            <!-- placeholder icon image for Effort -->
                            <img src="img/my_students/effort_icon.svg" alt="Effort" />
                        </span>
                        <span>Effort</span>
                    </div>
                    <div class="area-pill-row">
                        <button class="area-pill" data-category="Effort" data-label="Time talking in lessons">Time talking in lessons</button>
                        <button class="area-pill" data-category="Effort" data-label="Motivation">Motivation</button>
                        <button class="area-pill" data-category="Effort" data-label="Curiosity">Curiosity</button>
                        <button class="area-pill" data-category="Effort" data-label="Out-of-class activities">Out-of-class activities</button>
                        <button class="area-pill" data-category="Effort" data-label="Taking regular lessons">Taking regular lessons</button>
                        <button class="area-pill" data-category="Effort" data-label="Willing to experiment">Willing to experiment</button>
                        <button class="area-pill" data-category="Effort" data-label="Effective learning techniques">Effective learning techniques</button>
                    </div>
                </div>

                <!-- Speaking -->
                <div class="modal-group">
                    <div class="modal-group-title">
                        <span class="icon">
                            <!-- placeholder icon image for Speaking -->
                            <img src="img/my_students/speaking_icon.svg" alt="Speaking" />
                        </span>
                        <span>Speaking</span>
                    </div>
                    <div class="area-pill-row">
                        <button class="area-pill" data-category="Speaking" data-label="Fluency">Fluency</button>
                        <button class="area-pill" data-category="Speaking" data-label="Clarity">Clarity</button>
                        <button class="area-pill" data-category="Speaking" data-label="Pronunciation">Pronunciation</button>
                        <button class="area-pill" data-category="Speaking" data-label="Sounding confident">Sounding confident</button>
                        <button class="area-pill" data-category="Speaking" data-label="Organising ideas">Organising ideas</button>
                        <button class="area-pill" data-category="Speaking" data-label="Self-correction">Self-correction</button>
                    </div>
                </div>

                <!-- Listening -->
                <div class="modal-group">
                    <div class="modal-group-title">
                        <span class="icon">
                            <!-- placeholder icon image for Listening -->
                            <img src="img/my_students/listening_icon.svg" alt="Listening" />
                        </span>
                        <span>Listening</span>
                    </div>
                    <div class="area-pill-row">
                        <button class="area-pill" data-category="Listening" data-label="Listening for the main idea">Listening for the main idea</button>
                        <button class="area-pill" data-category="Listening" data-label="Listening for details">Listening for details</button>
                        <button class="area-pill" data-category="Listening" data-label="Offering responses">Offering responses</button>
                        <button class="area-pill" data-category="Listening" data-label="Good turn-taking">Good turn-taking</button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="areas-count" id="areasCount">0/3 areas</div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-ghost" id="areasCancelBtn">Cancel</button>
                    <button type="button" class="btn btn-primary" id="areasSaveBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const MAX_AREAS = 3;
        const selectedAreas = [];

        const areasModal = document.getElementById('areasModal');
        const openAreasBtn = document.getElementById('openAreasModal');
        const areasModalClose = document.getElementById('areasModalClose');
        const areasCancelBtn = document.getElementById('areasCancelBtn');
        const areasSaveBtn = document.getElementById('areasSaveBtn');
        const areasCount = document.getElementById('areasCount');
        const areaPills = Array.from(document.querySelectorAll('#areasModal .area-pill'));

        const progressInitial = document.getElementById('progressInitial');
        const progressSummaryBlock = document.getElementById('progressSummaryBlock');
        const editAreasBtn = document.getElementById('editAreasBtn');
        const progressHeader = document.getElementById('progressHeader');

        const toast = document.getElementById('areasToast');
        const toastClose = document.getElementById('areasToastClose');
        let toastTimer = null;
        let lastCount = 0;

        // STEP 2 refs
        const focusSection = document.getElementById('focusSection');
        const focusChooseBtn = document.getElementById('focusChooseBtn');
        const step2NextStepsSection = document.getElementById('step2NextStepsSection');
        const step2NextStepsDivider = document.getElementById('step2NextStepsDivider');
        const step2WrapSection = document.getElementById('step2WrapSection');
        const focusHeader = document.getElementById('focusHeader');

        const step2AreasModal = document.getElementById('step2AreasModal');
        const step2AreasModalClose = document.getElementById('step2AreasModalClose');
        const step2AreasCancelBtn = document.getElementById('step2AreasCancelBtn');
        const step2AreasSaveBtn = document.getElementById('step2AreasSaveBtn');
        const step2AreasCount = document.getElementById('step2AreasCount');
        const step2AreaPills = Array.from(document.querySelectorAll('.step2-area-pill'));

        const step2SummaryEffort = document.getElementById('step2SummaryEffort');
        const step2SummarySpeaking = document.getElementById('step2SummarySpeaking');
        const step2SummaryListening = document.getElementById('step2SummaryListening');
        let step2EditAreasBtn = document.getElementById('step2EditAreasBtn');

        const selectedAreasStep2 = [];
        let lastCountStep2 = 0;

        // STEP 3 refs
        const noteEditorSection = document.getElementById('noteEditorSection');
        const askAssistantBtn = document.getElementById('askAssistantBtn');
        const typeNoteBtn = document.getElementById('typeNoteBtn');
        const noteTextarea = document.getElementById('noteTextarea');

        // ---------- Toast ----------
        function showToast() {
            if (toast.classList.contains('show')) return;
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(hideToast, 2800);
        }

        function hideToast() {
            toast.classList.remove('show');
        }

        toastClose.addEventListener('click', hideToast);

        // ---------- STEP 1 modal ----------
        function openModal1() {
            areasModal.classList.add('is-open');
        }

        function closeModal1() {
            areasModal.classList.remove('is-open');
        }

        openAreasBtn.addEventListener('click', openModal1);
        areasModalClose.addEventListener('click', closeModal1);
        areasCancelBtn.addEventListener('click', closeModal1);

        areasModal.addEventListener('click', (e) => {
            if (e.target === areasModal) closeModal1();
        });

        function updateAreasCount() {
            areasCount.textContent = `${selectedAreas.length}/${MAX_AREAS} areas`;
        }

        function syncPillStates() {
            areaPills.forEach(pill => {
                const category = pill.dataset.category;
                const label = pill.dataset.label;
                const isSelected = selectedAreas.some(a => a.category === category && a.label === label);
                pill.classList.toggle('is-selected', isSelected);
            });

            if (selectedAreas.length >= MAX_AREAS) {
                areaPills.forEach(pill => {
                    if (!pill.classList.contains('is-selected')) {
                        pill.classList.add('is-disabled');
                    }
                });
            } else {
                areaPills.forEach(pill => pill.classList.remove('is-disabled'));
            }

            updateAreasCount();

            if (lastCount < MAX_AREAS && selectedAreas.length === MAX_AREAS) {
                showToast();
            }
            lastCount = selectedAreas.length;
        }

        areaPills.forEach(pill => {
            pill.addEventListener('click', () => {
                const category = pill.dataset.category;
                const label = pill.dataset.label;
                const index = selectedAreas.findIndex(a => a.category === category && a.label === label);

                if (index >= 0) {
                    selectedAreas.splice(index, 1);
                } else {
                    if (selectedAreas.length >= MAX_AREAS) return;
                    selectedAreas.push({
                        category,
                        label
                    });
                }

                syncPillStates();
            });
        });

        const summarySpeaking = document.getElementById('summarySpeaking');
        const summaryEffort = document.getElementById('summaryEffort');
        const summaryListening = document.getElementById('summaryListening');

        // NEW: hide/show full category blocks based on chips (step 1)
        function updateCategoryVisibilityStep1() {
            const containers = [
                summarySpeaking,
                summaryEffort,
                summaryListening
            ];

            containers.forEach(container => {
                if (!container) return;
                const wrapper = container.parentElement; // the <div> that also has the label
                if (!wrapper) return;
                const label = wrapper.querySelector('.progress-label');
                const hasItems = container.children.length > 0;

                if (hasItems) {
                    wrapper.style.display = ''; // let flex layout work
                    if (label) label.style.display = 'block';
                } else {
                    wrapper.style.display = 'none'; // remove empty category completely
                }
            });
        }

        function renderSummaryStep1() {
            summarySpeaking.innerHTML = '';
            summaryEffort.innerHTML = '';
            summaryListening.innerHTML = '';

            selectedAreas.forEach(area => {
                const chip = document.createElement('div');
                chip.className = 'progress-chip';

                const iconSpan = document.createElement('span');
                iconSpan.className = 'progress-chip-icon';
                const img = document.createElement('img');
                img.src = 'img/my_students/feedback_progress.svg';
                img.alt = 'Progress';
                iconSpan.appendChild(img);

                const textSpan = document.createElement('span');
                textSpan.textContent = area.label;

                chip.appendChild(iconSpan);
                chip.appendChild(textSpan);

                if (area.category === 'Speaking') {
                    summarySpeaking.appendChild(chip);
                } else if (area.category === 'Effort') {
                    summaryEffort.appendChild(chip);
                } else if (area.category === 'Listening') {
                    summaryListening.appendChild(chip);
                }
            });

            // ensure category widths/visibility are correct
            updateCategoryVisibilityStep1();
        }

        areasSaveBtn.addEventListener('click', () => {
            if (!selectedAreas.length) {
                closeModal1();
                return;
            }

            renderSummaryStep1();
            // Hide button block and header; show summary
            progressInitial.style.display = 'none';
            progressSummaryBlock.style.display = 'block';
            if (progressHeader) {
                progressHeader.style.display = 'none';
            }

            if (focusSection) {
                focusSection.style.display = 'block';
            }

            closeModal1();
        });

        editAreasBtn.addEventListener('click', openModal1);
        updateAreasCount();

        // ---------- STEP 2 modal ----------
        function openModal2() {
            if (!step2AreasModal) return;
            step2AreasModal.classList.add('is-open');
        }

        function closeModal2() {
            if (!step2AreasModal) return;
            step2AreasModal.classList.remove('is-open');
        }

        if (focusChooseBtn) focusChooseBtn.addEventListener('click', openModal2);
        if (step2AreasModalClose) step2AreasModalClose.addEventListener('click', closeModal2);
        if (step2AreasCancelBtn) step2AreasCancelBtn.addEventListener('click', closeModal2);
        if (step2AreasModal) {
            step2AreasModal.addEventListener('click', (e) => {
                if (e.target === step2AreasModal) closeModal2();
            });
        }

        function updateStep2AreasCount() {
            if (!step2AreasCount) return;
            step2AreasCount.textContent = `${selectedAreasStep2.length}/${MAX_AREAS} areas`;
        }

        function syncStep2PillStates() {
            step2AreaPills.forEach(pill => {
                const category = pill.dataset.category;
                const label = pill.dataset.label;
                const isSelected = selectedAreasStep2.some(a => a.category === category && a.label === label);
                pill.classList.toggle('is-selected', isSelected);
            });

            if (selectedAreasStep2.length >= MAX_AREAS) {
                step2AreaPills.forEach(pill => {
                    if (!pill.classList.contains('is-selected')) {
                        pill.classList.add('is-disabled');
                    }
                });
            } else {
                step2AreaPills.forEach(pill => pill.classList.remove('is-disabled'));
            }

            updateStep2AreasCount();

            if (lastCountStep2 < MAX_AREAS && selectedAreasStep2.length === MAX_AREAS) {
                showToast();
            }
            lastCountStep2 = selectedAreasStep2.length;
        }

        step2AreaPills.forEach(pill => {
            pill.addEventListener('click', () => {
                const category = pill.dataset.category;
                const label = pill.dataset.label;
                const index = selectedAreasStep2.findIndex(a => a.category === category && a.label === label);

                if (index >= 0) {
                    selectedAreasStep2.splice(index, 1);
                } else {
                    if (selectedAreasStep2.length >= MAX_AREAS) return;
                    selectedAreasStep2.push({
                        category,
                        label
                    });
                }

                syncStep2PillStates();
            });
        });

        // NEW: hide/show full category blocks based on chips (step 2)
        function updateCategoryVisibilityStep2() {
            const containers = [
                step2SummaryEffort,
                step2SummarySpeaking,
                step2SummaryListening
            ];

            containers.forEach(container => {
                if (!container) return;
                const wrapper = container.parentElement;
                if (!wrapper) return;
                const label = wrapper.querySelector('.progress-label');
                const hasItems = container.children.length > 0;

                if (hasItems) {
                    wrapper.style.display = '';
                    if (label) label.style.display = 'block';
                } else {
                    wrapper.style.display = 'none';
                }
            });
        }

        function renderSummaryStep2() {
            if (!step2SummaryEffort) return;
            step2SummaryEffort.innerHTML = '';
            step2SummarySpeaking.innerHTML = '';
            step2SummaryListening.innerHTML = '';

            selectedAreasStep2.forEach(area => {
                const chip = document.createElement('div');
                chip.className = 'next-steps-chip';

                const iconSpan = document.createElement('span');
                iconSpan.className = 'next-steps-chip-icon';
                const img = document.createElement('img');
                img.src = 'img/my_students/feedback_next_step.svg';
                img.alt = 'Next step';
                iconSpan.appendChild(img);

                const textSpan = document.createElement('span');
                textSpan.textContent = area.label;

                chip.appendChild(iconSpan);
                chip.appendChild(textSpan);

                if (area.category === 'Effort') {
                    step2SummaryEffort.appendChild(chip);
                } else if (area.category === 'Speaking') {
                    step2SummarySpeaking.appendChild(chip);
                } else if (area.category === 'Listening') {
                    step2SummaryListening.appendChild(chip);
                }
            });

            // ensure category widths/visibility are correct
            updateCategoryVisibilityStep2();
        }

        if (step2AreasSaveBtn) {
            step2AreasSaveBtn.addEventListener('click', () => {
                if (!selectedAreasStep2.length) {
                    closeModal2();
                    return;
                }

                renderSummaryStep2();

                if (focusSection) focusSection.style.display = 'none';
                if (step2NextStepsSection) step2NextStepsSection.style.display = 'block';
                if (step2NextStepsDivider) step2NextStepsDivider.style.display = 'block';
                if (step2WrapSection) step2WrapSection.style.display = 'block';

                // hide the step-2 heading once “Latingles's next steps” is visible
                if (focusHeader) {
                    focusHeader.style.display = 'none';
                }

                closeModal2();
            });
        }

        // wire up Edit button for next steps (in case it exists now)
        step2EditAreasBtn = document.getElementById('step2EditAreasBtn');
        if (step2EditAreasBtn) {
            step2EditAreasBtn.addEventListener('click', openModal2);
        }

        updateStep2AreasCount();

        // ---------- STEP 3: show note editor when "Type your note" is clicked ----------
        function openNoteEditor() {
            if (step2WrapSection) step2WrapSection.style.display = 'none';
            if (noteEditorSection) {
                noteEditorSection.style.display = 'block';
                if (noteTextarea) noteTextarea.focus();
            }
        }

        if (typeNoteBtn && noteEditorSection) {
            typeNoteBtn.addEventListener('click', openNoteEditor);
        }

        // (optional) also open editor if "Ask assistant" clicked
        if (askAssistantBtn && noteEditorSection) {
            askAssistantBtn.addEventListener('click', openNoteEditor);
        }

        // simple char counter (internal for now)
        if (noteTextarea) {
            noteTextarea.addEventListener('input', () => {
                if (noteTextarea.value.length > 600) {
                    noteTextarea.value = noteTextarea.value.slice(0, 600);
                }
            });
        }

        // ---------- Fix position of "Wrap up your feedback..." heading ----------
        document.addEventListener('DOMContentLoaded', () => {
            const WRAP_HEADING_TEXT = 'Wrap up your feedback with a short note';
            const wrapBlock = document.getElementById('step2WrapSection');

            // Only do this if the wrap buttons are on the page
            if (!wrapBlock) return;
            // 1) Hide/remove any existing headings with the same text
            const allTitles = Array.from(document.querySelectorAll('.section-title'))
                .filter(el => el.textContent.trim() === WRAP_HEADING_TEXT);

            allTitles.forEach(el => {
                const header = el.closest('.section-header');
                if (header && header !== wrapBlock.previousElementSibling) {
                    header.remove(); // remove full header wrapper if possible
                } else if (!header) {
                    el.remove(); // fallback: remove just the title element
                }
            });

            // 2) Insert a fresh heading just ABOVE the buttons block
            const header = document.createElement('header');
            header.className = 'section-header';

            const titleDiv = document.createElement('div');
            titleDiv.className = 'section-title';
            titleDiv.textContent = WRAP_HEADING_TEXT;

            header.appendChild(titleDiv);

            // Put the header right before the "Ask assistant / Type your note" area
            wrapBlock.parentNode.insertBefore(header, wrapBlock);

            // 3) Ensure there is a divider directly ABOVE this heading
            const prev = header.previousElementSibling;
            if (!prev || !prev.classList.contains('divider')) {
                const divider = document.createElement('div');
                divider.className = 'divider';
                header.parentNode.insertBefore(divider, header);
            }
        });
    </script>

<?php require_once('my_students_details_menu_give_feedback_details_create_draft.php');?>

</body>

</html>