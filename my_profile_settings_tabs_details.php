<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Account Setting – Left Tabs</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --my_profile_settings_tabs_details_text: #121117;
            --my_profile_settings_tabs_details_muted: #6B7280;
            --my_profile_settings_tabs_details_border: #E5E7EB;
            --my_profile_settings_tabs_details_active_bg: #F6F7FB;
            --my_profile_settings_tabs_details_active_text: #111827;
            --my_profile_settings_tabs_details_indicator: #EF4444;
            /* red line */
            --my_profile_settings_tabs_details_radius: 12px;
        }

        .my_profile_settings_tabs_details_wrapper {
            color: var(--my_profile_settings_tabs_details_text);
        }

        .my_profile_settings_tabs_details_list {
            border-right: 1px solid var(--my_profile_settings_tabs_details_border);
        }

        .my_profile_settings_tabs_details_item {
            position: relative;
            display: flex;
            align-items: center;
            gap: .625rem;
            font-weight: 500;
            line-height: 1.2;
            color: var(--my_profile_settings_tabs_details_text);
            padding: .75rem .875rem .75rem 1rem;
            border-radius: var(--my_profile_settings_tabs_details_radius);
            transition: background-color .15s ease, color .15s ease;
        }

        .my_profile_settings_tabs_details_item:hover {
            background-color: #FAFBFC;
        }

        .my_profile_settings_tabs_details_item.my_profile_settings_tabs_details_active {
            background-color: var(--my_profile_settings_tabs_details_active_bg);
            color: var(--my_profile_settings_tabs_details_active_text);
        }

        /* The vertical red line shown only on the active item */
        .my_profile_settings_tabs_details_indicator_bar {
            display: none;
            width: 3px;
            height: 22px;
            background: var(--my_profile_settings_tabs_details_indicator);
            border-radius: 2px;
            position: absolute;
            left: -6px;
            top: 50%;
            transform: translateY(-50%);
        }

        .my_profile_settings_tabs_details_item.my_profile_settings_tabs_details_active .my_profile_settings_tabs_details_indicator_bar {
            display: block;
        }

        /* Content area */
        .my_profile_settings_tabs_details_panel {
            display: none;
        }

        .my_profile_settings_tabs_details_panel.my_profile_settings_tabs_details_show {
            display: block;
        }

        /* Mobile: list becomes horizontal scroller */
        @media (max-width: 768px) {
            .my_profile_settings_tabs_details_list {
                border-right: none;
                border-bottom: 1px solid var(--my_profile_settings_tabs_details_border);
                display: flex;
                gap: .5rem;
                overflow-x: auto;
                padding-bottom: .5rem;
                scrollbar-width: thin;
            }

            .my_profile_settings_tabs_details_item {
                white-space: nowrap;
            }

            .my_profile_settings_tabs_details_item .my_profile_settings_tabs_details_indicator_bar {
                left: 0;
                height: 3px;
                width: 22px;
                top: auto;
                bottom: -6px;
                transform: none;
                /* switch to a small underline on mobile */
            }
        }
    </style>
</head>

<body class="bg-white antialiased">

    <div class="my_profile_settings_tabs_details_wrapper max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-semibold mb-6">Account Setting</h1>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            <!-- LEFT: Tabs -->
            <aside class="md:col-span-3">
                <nav class="my_profile_settings_tabs_details_list pr-0 md:pr-6">

                    <?php
                    $isSubscriptionActive =
                        isset($_GET['subscription']) && $_GET['subscription'] === 'active';
                    ?>
                    <button  class="my_profile_settings_tabs_details_item
                        <?php if (!$isSubscriptionActive) echo 'my_profile_settings_tabs_details_active'; ?>"
                        data-my_profile_settings_tabs_details_target="account">
                        
                        <span class="my_profile_settings_tabs_details_indicator_bar"></span>
                        Account
                    </button>

                    <button class="my_profile_settings_tabs_details_item"
                        data-my_profile_settings_tabs_details_target="password">
                        <span class="my_profile_settings_tabs_details_indicator_bar"></span>
                        Password
                    </button>

                    <button class="my_profile_settings_tabs_details_item"
                        data-my_profile_settings_tabs_details_target="email">
                        <span class="my_profile_settings_tabs_details_indicator_bar"></span>
                        Email
                    </button>

                    <button class="my_profile_settings_tabs_details_item"
                        data-my_profile_settings_tabs_details_target="payment_methods">
                        <span class="my_profile_settings_tabs_details_indicator_bar"></span>
                        Payment methods
                    </button>

                    <button class="my_profile_settings_tabs_details_item 
                        <?php if ($isSubscriptionActive) echo 'my_profile_settings_tabs_details_active'; ?>"
                        data-my_profile_settings_tabs_details_target="subscription">
                        <span class="my_profile_settings_tabs_details_indicator_bar"></span>
                        Subscription
                    </button>

                    <button class="my_profile_settings_tabs_details_item"
                        data-my_profile_settings_tabs_details_target="payment_history">
                        <span class="my_profile_settings_tabs_details_indicator_bar"></span>
                        Payment history
                    </button>

                    <button class="my_profile_settings_tabs_details_item"
                        data-my_profile_settings_tabs_details_target="autoconfirmation">
                        <span class="my_profile_settings_tabs_details_indicator_bar"></span>
                        Autoconfirmation
                    </button>

                    <button class="my_profile_settings_tabs_details_item"
                        data-my_profile_settings_tabs_details_target="calendar">
                        <span class="my_profile_settings_tabs_details_indicator_bar"></span>
                        Calendar
                    </button>

                    <button class="my_profile_settings_tabs_details_item"
                        data-my_profile_settings_tabs_details_target="notifications">
                        <span class="my_profile_settings_tabs_details_indicator_bar"></span>
                        Notifications
                    </button>

                    <button class="my_profile_settings_tabs_details_item"
                        data-my_profile_settings_tabs_details_target="delete_account">
                        <span class="my_profile_settings_tabs_details_indicator_bar"></span>
                        Delete account
                    </button>
                </nav>
            </aside>

            <!-- RIGHT: Tab content placeholders -->
            <section class="md:col-span-9">

                <div id="my_profile_settings_tabs_details_panel_account"
                    class="my_profile_settings_tabs_details_panel 
                     <?php if (!$isSubscriptionActive) echo 'my_profile_settings_tabs_details_show'; ?>">
                    <?php require_once('my_profile_settings_tab_account.php'); ?>
                </div>

                <div id="my_profile_settings_tabs_details_panel_password" class="my_profile_settings_tabs_details_panel">
                    <?php require_once('my_profile_settings_tab_password.php'); ?>
                </div>

                <div id="my_profile_settings_tabs_details_panel_email" class="my_profile_settings_tabs_details_panel">
                    <?php require_once('my_profile_settings_tab_email.php'); ?>
                </div>

                <div id="my_profile_settings_tabs_details_panel_payment_methods" class="my_profile_settings_tabs_details_panel">
                    <?php require_once('my_profile_settings_tab_payment_methods.php'); ?>
                </div>

                <div id="my_profile_settings_tabs_details_panel_subscription" class="my_profile_settings_tabs_details_panel <?php if ($isSubscriptionActive) echo 'my_profile_settings_tabs_details_show'; ?>">
                    <?php require_once('my_profile_settings_tab_subscription.php'); ?>
                </div>

                <div id="my_profile_settings_tabs_details_panel_payment_history" class="my_profile_settings_tabs_details_panel">
                    <?php require_once('my_profile_settings_tab_payment_history.php'); ?>
                </div>

                <div id="my_profile_settings_tabs_details_panel_autoconfirmation" class="my_profile_settings_tabs_details_panel">
                    <?php require_once('my_profile_settings_tab_auto_confirmation.php'); ?>
                </div>

                <div id="my_profile_settings_tabs_details_panel_calendar" class="my_profile_settings_tabs_details_panel">
                    <?php require_once('my_profile_settings_tab_calendar.php'); ?>
                </div>

                <div id="my_profile_settings_tabs_details_panel_notifications" class="my_profile_settings_tabs_details_panel">
                    <?php require_once('my_profile_settings_tab_notification.php'); ?>
                </div>

                <div id="my_profile_settings_tabs_details_panel_delete_account" class="my_profile_settings_tabs_details_panel">
                    <?php require_once('my_profile_settings_tab_delete_account.php'); ?>
                </div>

            </section>
        </div>
    </div>

    <script>
        // Init and click handlers
        function my_profile_settings_tabs_details_init() {
            const $items = $('.my_profile_settings_tabs_details_item');

            // Default state: first tab active + first panel visible already via markup

            $items.on('click', function() {
                const target = $(this).data('my_profile_settings_tabs_details_target');
                my_profile_settings_tabs_details_show(target);
            });
        }

        function my_profile_settings_tabs_details_show(key) {
            // update active item (shows the red bar on the active one only)
            $('.my_profile_settings_tabs_details_item')
                .removeClass('my_profile_settings_tabs_details_active')
                .filter('[data-my_profile_settings_tabs_details_target="' + key + '"]')
                .addClass('my_profile_settings_tabs_details_active');

            // toggle panels
            $('.my_profile_settings_tabs_details_panel').removeClass('my_profile_settings_tabs_details_show');
            $('#my_profile_settings_tabs_details_panel_' + key).addClass('my_profile_settings_tabs_details_show');
        }

        $(document).ready(my_profile_settings_tabs_details_init);
    </script>
</body>

</html>