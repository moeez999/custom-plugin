<div class="calendar_admin_details_create_cohort_content tab-content" id="addExtraSlotsTabContent"
    style="display:none;">
    <form id="addTimeFormExtraSlots">
        <!-- TEACHER -->
        <label class="addtime-label" style="margin-top:5px;">Teacher</label>
        <div class="addtime-teacher-dropdown" id="addtimeTeacherDropdown" style="position:relative;">
            <!-- trigger -->
            <button type="button" class="addtime-teacher-selected" id="addtimeTeacherTrigger" aria-haspopup="listbox"
                aria-expanded="false"
                style="display:flex;align-items:center;gap:10px;width:100%;background:#fff;border:1.3px solid #dadada;border-radius:10px;padding:9px 12px;cursor:pointer;">
                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop"
                    class="addtime-teacher-avatar" id="addtimeTeacherAvatar"
                    style="width:32px;height:32px;border-radius:50%;object-fit:cover;" alt="Selected teacher">
                <span id="addtimeTeacherName">Daniela</span>
                <img src="./img/dropdown-arrow-down.svg" alt="" style="margin-left:auto;width:16px;">
            </button>

            <!-- dropdown list (filled from first tab by JS) -->
            <div class="addtime-teacher-menu" id="addtimeTeacherMenu"
                style="display:none;position:absolute;top:calc(100% + 6px);left:0;width:100%;background:#fff;border:1.3px solid #ddd;border-radius:10px;box-shadow:0 4px 16px rgba(0,0,0,.08);z-index:1000;max-height:260px;overflow:hidden;">
                <input type="text" id="addtimeTeacherSearch" class="dropdown-search" placeholder="Enter Teacher Name..."
                    style="width:97%;margin:8px auto 6px auto;display:block;padding:7px 10px;border:1.3px solid #dadada;border-radius:7px;outline:none;font-size:.88rem;">
                <div id="addtimeTeacherList" style="max-height:205px;overflow-y:auto;"></div>
            </div>
        </div>
        <div style="margin-top:20px;margin-bottom:10px;font-weight:600;color:#222;">
            <h2>
                Add Extra slots for Booking
            </h2>
            <span style="text-align:center;font-size:1rem;margin-bottom:6px;font-weight:500; color:#6A697C;">Choose time
                slot up to 24
                hours
                long.</span>
        </div>

        <style>
        #addTimeFormExtraSlots {
            height: 535px;
            padding: 0 6px;
        }

        #addtime-teacher-selected:hover {
            border: 2px solid #232323 !important;
        }

        .calendar_admin_details_create_cohort_add_time_tab_label {
            display: block;
            font-weight: 600;
            margin: 10px 0 6px;
            color: #222;
        }

        .calendar_admin_details_create_cohort_add_time_tab_row {
            display: flex;
            gap: 12px;

            align-items: center;
            margin-bottom: 14px;
        }

        #calendar_admin_details_create_cohort_add_time_tab_previous_times {
            list-style: none;
            padding: 0;
            margin: 12px 0 0 0;
        }

        .delete-extra-slot-btn {
            background: transparent;
            border: none;
            padding: 0;
        }

        .previous-extra-slot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: transparent;
            color: #898989;
            border-radius: 8px;
            padding: 14px 12px;
            margin-bottom: 8px;
            font-size: 0.96rem;
            letter-spacing: 0.2px;
            border: 1px solid #dcdcdc;
            font-size: 14px;
        }

        .previous-extra-slot .range {
            color: #898989;
            font-weight: 600;
        }

        .previous-extra-slot-empty {
            color: #898989;
            font-size: 0.95rem;
            margin-top: 6px;
        }

        #addtimeTeacherList::-webkit-scrollbar {
            width: 0.5rem;
        }

        #addtimeTeacherList::-webkit-scrollbar-thumb {
            background-color: #e6e6f0;
            border-radius: 10px;
        }

        .calendar_admin_details_create_cohort_add_time_tab_date_btn {
            width: 100%;
            text-align: left;
            cursor: pointer;
            background: #fff;
            border: 1.5px solid #e7e7ef;
            color: #222;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .03);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #addExtraSlotsTabContent .custom-time-pill {
            width: auto !important;
            flex: none;
        }

        #addExtraSlotsTabContent .custom-time-pill .time-input {
            width: 100%;
            border: 0;
            outline: none;
            background: transparent;
            font-size: 15px;
            color: #222;
            cursor: pointer;
            margin: 0;
            padding: 22px 16px !important;
            text-align: start;
        }

        #addExtraSlotsTabContent .custom-time-pill .time-input:hover {
            border: 2px solid #232323 !important;
        }

        .custom-time-dropdown {
            display: none;
            position: absolute;
            left: 0;
            right: 0;
            top: calc(100% + 6px);
            z-index: 10;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            max-height: 220px;
            overflow: auto;
            box-shadow: 0 12px 26px rgba(0, 0, 0, .12);
        }

        /* Scrollbar customization */
        .custom-time-dropdown::-webkit-scrollbar {
            width: 6px;
            /* thinner scrollbar */
        }

        .custom-time-dropdown::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 10px;
        }

        .custom-time-dropdown::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .custom-time-dropdown::-webkit-scrollbar-thumb:hover {
            background: #aaa;
            /* darker on hover */
        }



        .custom-time-dropdown button {
            width: 100%;
            text-align: left;
            padding: 9px 11px;
            border: 0;
            background: #fff;
            cursor: pointer;
        }

        .custom-time-dropdown button:hover {
            background: #f6f6fb;
        }

        .calendar_admin_details_create_cohort_add_time_tab_backdrop {
            display: none;
            position: fixed;
            z-index: 3002;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.14);
        }

        .calendar_admin_details_create_cohort_add_time_tab_modal {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 36px 0 rgba(0, 0, 0, .16);
            max-width: 300px;
            max-width: 97vw;
            padding: 26px 24px 24px 24px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: inherit;
        }

        .calendar_admin_details_create_cohort_add_time_tab_header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .calendar_admin_details_create_cohort_add_time_tab_navbtn {
            background: none;
            border: none;
            font-size: 1.4rem;
            cursor: pointer;
        }

        .calendar_admin_details_create_cohort_add_time_tab_month_label {
            font-size: 1.18rem;
            font-weight: 600;
        }

        .calendar_admin_details_create_cohort_add_time_tab_weekdays {
            display: grid;
            grid-template-columns: repeat(7, 36px);
            grid-gap: 6px;
            justify-content: center;
            font-weight: bold;
            color: #888;
            margin-bottom: 6px;
            text-align: center;
            font-size: 1.01rem;
        }

        .calendar_admin_details_create_cohort_add_time_tab_weekdays>div {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .calendar_admin_details_create_cohort_add_time_tab_grid {
            display: grid;
            grid-template-columns: repeat(7, 36px);
            grid-gap: 6px;
            justify-content: center;
        }

        .calendar_admin_details_create_cohort_add_time_tab_grid>* {
            width: 36px;
            height: 36px;
            background: #fff;
        }

        .calendar_admin_details_create_cohort_add_time_tab_day {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.01rem;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.13s;
            background: #fff;
            border: none;
            padding: 0;
            color: #222;
        }

        .calendar_admin_details_create_cohort_add_time_tab_day.inactive {
            color: #c2c2c2;
            background: #fff;
            pointer-events: none;
            cursor: default;
        }

        .calendar_admin_details_create_cohort_add_time_tab_day--selected,
        .calendar_admin_details_create_cohort_add_time_tab_day:hover {
            background: #fe2e0c;
            color: #fff;
        }

        .calendar_admin_details_create_cohort_add_time_tab_done {
            width: 100%;
            background: #fe2e0c;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            padding: 12px 0;
            margin-top: 19px;
            cursor: pointer;
            transition: background 0.13s;
        }

        .calendar_admin_details_create_cohort_add_time_tab_done:active {
            background: #ea2000;
        }
        </style>

        <!-- FROM -->
        <div>
            <label class="calendar_admin_details_create_cohort_add_time_tab_label">From</label>
            <div class="calendar_admin_details_create_cohort_add_time_tab_row"
                id="calendar_admin_details_create_cohort_add_time_tab_from_row">
                <button type="button" class="calendar_admin_details_create_cohort_add_time_tab_date_btn"
                    id="calendar_admin_details_create_cohort_add_time_tab_from_btn" data-iso="2025-08-05">
                    <span id="calendar_admin_details_create_cohort_add_time_tab_from_text">Select date</span>
                    <img src="./img/dropdown-arrow-down.svg" alt="dropdown">

                </button>
                <div class="custom-time-pill" style="position:relative;">
                    <input type="text" class="time-input" value="9:30 am">
                    <img style="position: absolute;
right: 14px;
top: 50%;
transform: translateY(-50%);" src="./img/dropdown-arrow-down.svg" alt="dropdown">
                    <div class="custom-time-dropdown"></div>
                </div>
            </div>

            <!-- UNTIL -->
            <label class="calendar_admin_details_create_cohort_add_time_tab_label">Until</label>
            <div class="calendar_admin_details_create_cohort_add_time_tab_row"
                id="calendar_admin_details_create_cohort_add_time_tab_until_row">
                <button type="button" class="calendar_admin_details_create_cohort_add_time_tab_date_btn"
                    id="calendar_admin_details_create_cohort_add_time_tab_until_btn" data-iso="2025-08-05">
                    <span id="calendar_admin_details_create_cohort_add_time_tab_until_text">Select date</span>
                    <img src="./img/dropdown-arrow-down.svg" alt="dropdown">
                </button>
                <div class="custom-time-pill" style="position:relative;">
                    <input type="text" class="time-input" value="9:30 am">
                    <img style="position: absolute;
right: 14px;
top: 50%;
transform: translateY(-50%);" src="./img/dropdown-arrow-down.svg" alt="dropdown">
                    <div class="custom-time-dropdown"></div>
                </div>
            </div>
        </div>

        <!-- calendar modal -->
        <div class="calendar_admin_details_create_cohort_add_time_tab_backdrop"
            id="calendar_admin_details_create_cohort_add_time_tab_backdrop">
            <div class="calendar_admin_details_create_cohort_add_time_tab_modal" role="dialog" aria-modal="true">
                <div class="calendar_admin_details_create_cohort_add_time_tab_header">
                    <button type="button" class="calendar_admin_details_create_cohort_add_time_tab_navbtn"
                        id="calendar_admin_details_create_cohort_add_time_tab_prev"><svg width="22" height="22"
                            viewBox="0 0 24 24">
                            <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></polyline>
                        </svg></button>
                    <div class="calendar_admin_details_create_cohort_add_time_tab_month_label"
                        id="calendar_admin_details_create_cohort_add_time_tab_month_label">August 2025</div>
                    <button type="button" class="calendar_admin_details_create_cohort_add_time_tab_navbtn"
                        id="calendar_admin_details_create_cohort_add_time_tab_next"><svg width="22" height="22"
                            viewBox="0 0 24 24">
                            <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></polyline>
                        </svg></button>
                </div>
                <div class="calendar_admin_details_create_cohort_add_time_tab_weekdays">
                    <div>Mo</div>
                    <div>Tu</div>
                    <div>We</div>
                    <div>Th</div>
                    <div>Fr</div>
                    <div>Sa</div>
                    <div>Su</div>
                </div>
                <div class="calendar_admin_details_create_cohort_add_time_tab_grid"
                    id="calendar_admin_details_create_cohort_add_time_tab_grid"></div>
                <button type="button" class="calendar_admin_details_create_cohort_add_time_tab_done"
                    id="calendar_admin_details_create_cohort_add_time_tab_done">Done</button>
            </div>
        </div>
        <div>
            <div style="margin-top:20px;margin-bottom:10px;font-weight:600;color:#222;">
                <h2>
                    Previously added slots
                </h2>
                <span style="text-align:center;font-size:1rem;margin-bottom:6px;font-weight:500; color:#6A697C;">Delete
                    the slots to
                    make them unavailable.</span>
            </div>
            <ul id="calendar_admin_details_create_cohort_add_time_tab_previous_times"></ul>
        </div>
        <button type="submit" class="addtime-submit-btn"
            style="margin-top:12px;background:#fe2e0c;color:#fff;border:none;border-radius:8px;padding:11px 0;width:100%;font-weight:600;cursor:pointer;">
            Add
        </button>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const parent = document.getElementById('addExtraSlotsTabContent');
    if (!parent) return;

    const teacherTrigger = parent.querySelector('#addtimeTeacherTrigger');
    const teacherAvatar = parent.querySelector('#addtimeTeacherAvatar');
    const teacherNameEl = parent.querySelector('#addtimeTeacherName');
    const teacherMenu = parent.querySelector('#addtimeTeacherMenu');
    const teacherListBox = parent.querySelector('#addtimeTeacherList');
    const teacherSearch = parent.querySelector('#addtimeTeacherSearch');
    const previousList = parent.querySelector(
        '#calendar_admin_details_create_cohort_add_time_tab_previous_times');

    const getCurrentTeacherId = () => teacherTrigger.dataset.userid || '';

    const formatSlotTime = (dateObj) => {
        const h = String(dateObj.getHours()).padStart(2, '0');
        const m = String(dateObj.getMinutes()).padStart(2, '0');
        return `${h}:${m}`;
    };

    const formatSlotDateLabel = (dateObj) => {
        const weekday = dateObj.toLocaleDateString(undefined, {
            weekday: 'short'
        });
        const month = dateObj.toLocaleDateString(undefined, {
            month: 'short'
        }).replace('.', '');
        const day = dateObj.getDate();
        return `${weekday}, ${month}${day}`;
    };

    function renderPreviousExtraSlots(map, teacherId) {
        if (!previousList) return;
        previousList.innerHTML = '';

        if (!teacherId) {
            previousList.innerHTML =
                '<li class="previous-extra-slot-empty">Select a teacher to view extra slots.</li>';
            return;
        }

        const slots = (map && (map[teacherId] || map[String(teacherId)] || map[Number(teacherId)])) || [];
        if (!slots || slots.length === 0) {
            previousList.innerHTML =
                '<li class="previous-extra-slot-empty">No extra slots for this teacher yet.</li>';
            return;
        }

        slots.forEach(slot => {
            const startDate = slot.start ? new Date(slot.start) : (slot.start_ts ? new Date(slot
                .start_ts * 1000) : null);
            const endDate = slot.end ? new Date(slot.end) : (slot.end_ts ? new Date(slot.end_ts *
                1000) : null);
            if (!startDate || Number.isNaN(startDate.getTime())) return;

            const dateLabel = formatSlotDateLabel(startDate);
            const rangeLabel = endDate && !Number.isNaN(endDate.getTime()) ?
                `${formatSlotTime(startDate)}-${formatSlotTime(endDate)}` :
                formatSlotTime(startDate);

            const li = document.createElement('li');
            li.className = 'previous-extra-slot';
            const slotId = slot.id || slot.slotid || slot.extra_slot_id || '';
            li.innerHTML =
                `<div><span>${dateLabel}</span>, <span class="range">${rangeLabel}</span> </div><button type="button" class="delete-extra-slot-btn" data-slot-id="${slotId}"><img src="./img/delete.svg" alt="Delete slot"></button>`;
            previousList.appendChild(li);
        });
    }

    // populate teacher list if available
    // 🧩 Populate teacher list & setup dropdown
    const sourceList = document.getElementById('calendar_admin_details_create_cohort_manage_class_tab_list');
    if (sourceList && teacherListBox) {
        const items = sourceList.querySelectorAll(
            '.calendar_admin_details_create_cohort_manage_class_tab_item[role="option"]'
        );

        items.forEach(srcItem => {
            const div = document.createElement('div');
            div.className = 'addtime-teacher-item';
            div.dataset.userid = srcItem.dataset.userid || '';
            div.dataset.name = srcItem.dataset.name || '';
            div.dataset.img = srcItem.dataset.img || '';
            div.style = 'display:flex;align-items:center;gap:10px;padding:10px 12px;cursor:pointer;';
            div.innerHTML = `
      <img src="${srcItem.dataset.img || ''}" alt="${srcItem.dataset.name || ''}"
           style="width:30px;height:30px;border-radius:50%;object-fit:cover;">
      <span>${srcItem.dataset.name || ''}</span>
    `;
            div.addEventListener('click', function() {
                teacherAvatar.src = this.dataset.img;
                teacherNameEl.textContent = this.dataset.name;
                teacherTrigger.dataset.userid = this.dataset.userid;
                teacherTrigger.dataset.name = this.dataset.name;
                teacherTrigger.dataset.img = this.dataset.img;
                renderPreviousExtraSlots(window.teacherExtraSlots || {}, this.dataset.userid);
                teacherMenu.style.display = 'none';
            });
            teacherListBox.appendChild(div);
        });

        // ✅ Auto-select first real teacher if list not empty
        if (items.length > 0) {
            const first = items[0];
            teacherAvatar.src = first.dataset.img || '';
            teacherNameEl.textContent = first.dataset.name || '';
            teacherTrigger.dataset.userid = first.dataset.userid || '';
            teacherTrigger.dataset.name = first.dataset.name || '';
            teacherTrigger.dataset.img = first.dataset.img || '';
            renderPreviousExtraSlots(window.teacherExtraSlots || {}, teacherTrigger.dataset.userid);
        }
    }

    // 🟠 Toggle dropdown open/close
    teacherTrigger.addEventListener('click', e => {
        e.stopPropagation();
        teacherMenu.style.display = teacherMenu.style.display === 'block' ? 'none' : 'block';
    });

    // ✅ Close dropdown when clicking outside (more precise)
    document.addEventListener('click', e => {
        if (!teacherMenu.contains(e.target) && !teacherTrigger.contains(e.target)) {
            teacherMenu.style.display = 'none';
        }
    });


    // search filter
    teacherSearch.addEventListener('input', function() {
        const f = this.value.toLowerCase();
        teacherListBox.querySelectorAll('.addtime-teacher-item').forEach(i => {
            const nm = (i.dataset.name || '').toLowerCase();
            i.style.display = nm.includes(f) ? 'flex' : 'none';
        });
    });

    document.addEventListener('extraSlotsUpdated', e => {
        const map = (e.detail && e.detail.map) || window.teacherExtraSlots || {};
        renderPreviousExtraSlots(map, getCurrentTeacherId());
    });

    // Log payload when a delete extra slot button is clicked
    previousList.addEventListener('click', async e => {
        const btn = e.target.closest('.delete-extra-slot-btn');
        if (!btn) return;
        const slotId = btn.dataset.slotId || '';
        if (!slotId) return;

        // Loader on
        if (window.showGlobalLoader) window.showGlobalLoader();
        else {
            const el = document.getElementById('loader');
            if (el) el.style.display = 'flex';
        }

        try {
            const res = await fetch(M.cfg.wwwroot +
                '/local/customplugin/ajax/delete_extra_slot.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        slotid: slotId
                    })
                });
            const data = await res.json();
            if (data.ok) {
                if (typeof showToast === 'function') showToast('Extra slot deleted!', 'success');
                else alert('Extra slot deleted!');
                // Refresh calendar/slots
                if (window.refetchCustomPluginData) {
                    window.refetchCustomPluginData('delete-extra-slot');
                } else if (window.fetchCalendarEvents) {
                    window.fetchCalendarEvents();
                } else if (typeof loadAdminCalendarEvents === "function") {
                    loadAdminCalendarEvents();
                }
            } else {
                if (typeof showToast === 'function') showToast(data.error ||
                    'Failed to delete slot', 'error');
                else alert(data.error || 'Failed to delete slot');
            }
        } catch (err) {
            if (typeof showToast === 'function') showToast('Error deleting slot', 'error');
            else alert('Error deleting slot');
        } finally {
            // Loader off
            if (window.hideGlobalLoader) window.hideGlobalLoader();
            else {
                const el = document.getElementById('loader');
                if (el) el.style.display = 'none';
            }
        }
    });

    renderPreviousExtraSlots(window.teacherExtraSlots || {}, getCurrentTeacherId());

    // timepicker + calendar setup
    (function() {
        function fmtLong(d) {
            return d.toLocaleDateString(undefined, {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
        let activeTarget = null;
        let viewYear = new Date().getFullYear();
        let viewMonth = new Date().getMonth();
        let tempSelected = new Date();

        const backdrop = parent.querySelector(
            '#calendar_admin_details_create_cohort_add_time_tab_backdrop');
        const grid = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_grid');
        const label = parent.querySelector(
            '#calendar_admin_details_create_cohort_add_time_tab_month_label');

        function openCalendar(target, seed) {
            activeTarget = target;
            viewYear = seed.getFullYear();
            viewMonth = seed.getMonth();
            tempSelected = new Date(seed.getFullYear(), seed.getMonth(), seed.getDate());
            renderCalendar();
            backdrop.style.display = 'flex';
        }

        function renderCalendar() {
            const monthName = new Date(viewYear, viewMonth, 1).toLocaleString(undefined, {
                month: 'long'
            });
            label.textContent = monthName + ' ' + viewYear;
            grid.innerHTML = '';

            const first = new Date(viewYear, viewMonth, 1);
            const startIdx = (first.getDay() + 6) % 7;
            const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();

            for (let i = 0; i < startIdx; i++) grid.appendChild(document.createElement('div'));
            for (let d = 1; d <= daysInMonth; d++) {
                const dateObj = new Date(viewYear, viewMonth, d);
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'calendar_admin_details_create_cohort_add_time_tab_day';
                btn.textContent = d;
                if (dateObj.toDateString() === tempSelected.toDateString())
                    btn.classList.add('calendar_admin_details_create_cohort_add_time_tab_day--selected');
                btn.addEventListener('click', function() {
                    tempSelected = dateObj;
                    grid.querySelectorAll(
                            '.calendar_admin_details_create_cohort_add_time_tab_day--selected')
                        .forEach(el => el.classList.remove(
                            'calendar_admin_details_create_cohort_add_time_tab_day--selected'));
                    btn.classList.add(
                        'calendar_admin_details_create_cohort_add_time_tab_day--selected');
                });
                grid.appendChild(btn);
            }
        }

        const fromBtn = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_from_btn');
        const fromText = parent.querySelector(
            '#calendar_admin_details_create_cohort_add_time_tab_from_text');
        const untilBtn = parent.querySelector(
            '#calendar_admin_details_create_cohort_add_time_tab_until_btn');
        const untilText = parent.querySelector(
            '#calendar_admin_details_create_cohort_add_time_tab_until_text');

        const prev = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_prev');
        const next = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_next');
        if (prev) prev.addEventListener('click', () => {
            if (--viewMonth < 0) {
                viewMonth = 11;
                viewYear--;
            }
            renderCalendar();
        });
        if (next) next.addEventListener('click', () => {
            if (++viewMonth > 11) {
                viewMonth = 0;
                viewYear++;
            }
            renderCalendar();
        });

        function writeField(btn, span, dateObj) {
            btn.setAttribute('data-iso', dateObj.toISOString().slice(0, 10));
            span.textContent = fmtLong(dateObj);
        }

        fromBtn.addEventListener('click', () => openCalendar('from', new Date()));
        untilBtn.addEventListener('click', () => openCalendar('until', new Date()));
        parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_done')
            .addEventListener('click', () => {
                if (activeTarget === 'from') writeField(fromBtn, fromText, tempSelected);
                else writeField(untilBtn, untilText, tempSelected);
                backdrop.style.display = 'none';
            });
        backdrop.addEventListener('click', e => {
            if (e.target === backdrop) backdrop.style.display = 'none';
        });

        // Generate standardized times from 12:00 AM to 11:30 PM with 30-minute intervals
        const times = [];
        for (let h = 0; h < 24; h++) {
            for (let m = 0; m < 60; m += 30) {
                let hour12 = h % 12 === 0 ? 12 : h % 12;
                let period = h < 12 ? 'AM' : 'PM';
                let mm = m < 10 ? '0' + m : m;
                times.push(`${hour12}:${mm} ${period}`);
            }
        }

        parent.querySelectorAll('.custom-time-pill').forEach(pill => {
            const input = pill.querySelector('.time-input');
            const dd = pill.querySelector('.custom-time-dropdown');
            times.forEach(t => {
                const b = document.createElement('button');
                b.type = 'button';
                b.textContent = t;
                b.onclick = () => {
                    input.value = t;
                    dd.style.display = 'none';
                };
                dd.appendChild(b);
            });
            pill.addEventListener('click', e => {
                e.stopPropagation();
                parent.querySelectorAll('.custom-time-dropdown').forEach(d => d.style
                    .display = 'none');
                dd.style.display = dd.style.display === 'block' ? 'none' : 'block';
            });
        });
        document.addEventListener('click', () => parent.querySelectorAll('.custom-time-dropdown')
            .forEach(d => d.style.display = 'none'));
    })();

    // form submit
    // form submit with validation
    const form = parent.querySelector('#addTimeFormExtraSlots');
    if (form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const initialExtraSlotsState = {
            teacher: {
                id: teacherTrigger.dataset.userid || '',
                name: teacherTrigger.dataset.name || teacherNameEl?.textContent?.trim() || '',
                img: teacherTrigger.dataset.img || teacherAvatar?.src || ''
            },
            from: {
                iso: parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_from_btn')
                    ?.getAttribute('data-iso') || '',
                label: parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_from_text')
                    ?.textContent?.trim() || '',
                time: parent.querySelector(
                        '#calendar_admin_details_create_cohort_add_time_tab_from_row .time-input')?.value ||
                    ''
            },
            until: {
                iso: parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_until_btn')
                    ?.getAttribute('data-iso') || '',
                label: parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_until_text')
                    ?.textContent?.trim() || '',
                time: parent.querySelector(
                        '#calendar_admin_details_create_cohort_add_time_tab_until_row .time-input')
                    ?.value || ''
            }
        };

        const toggleLoader = (on) => {
            if (on) {
                if (window.showGlobalLoader) window.showGlobalLoader();
                else {
                    const el = document.getElementById('loader');
                    if (el) el.style.display = 'flex';
                }
            } else {
                if (window.hideGlobalLoader) window.hideGlobalLoader();
                else {
                    const el = document.getElementById('loader');
                    if (el) el.style.display = 'none';
                }
            }
        };

        const notify = (msg, type = 'info') => {
            if (typeof showToast === 'function') showToast(msg, type);
            else alert(msg);
        };

        form.addEventListener('submit', e => {
            e.preventDefault();

            // remove previous error styles
            parent.querySelectorAll('.field-error').forEach(el => el.classList.remove('field-error'));

            let isValid = true;

            // collect elements
            const teacherTrigger = parent.querySelector('#addtimeTeacherTrigger');
            const teacherAvatar = parent.querySelector('#addtimeTeacherAvatar');
            const teacherNameEl = parent.querySelector('#addtimeTeacherName');

            const fromBtn = parent.querySelector(
                '#calendar_admin_details_create_cohort_add_time_tab_from_btn');
            const fromText = parent.querySelector(
                '#calendar_admin_details_create_cohort_add_time_tab_from_text');
            const fromRow = parent.querySelector(
                '#calendar_admin_details_create_cohort_add_time_tab_from_row');
            const fromTime = fromRow ? fromRow.querySelector('.time-input') : null;

            const untilBtn = parent.querySelector(
                '#calendar_admin_details_create_cohort_add_time_tab_until_btn');
            const untilText = parent.querySelector(
                '#calendar_admin_details_create_cohort_add_time_tab_until_text');
            const untilRow = parent.querySelector(
                '#calendar_admin_details_create_cohort_add_time_tab_until_row');
            const untilTime = untilRow ? untilRow.querySelector('.time-input') : null;

            // 🧩 read teacher data
            const teacherData = {
                id: teacherTrigger.dataset.userid || null,
                name: teacherTrigger.dataset.name || teacherNameEl?.textContent?.trim() || '',
                img: teacherTrigger.dataset.img || teacherAvatar?.src || ''
            };

            // 🔴 Validation section
            if (!teacherData.id || teacherData.name.trim() === '') {
                teacherTrigger.classList.add('field-error');
                isValid = false;
            }

            const fromIso = fromBtn?.getAttribute('data-iso');
            const fromLabel = fromText?.textContent?.trim();
            if (!fromIso || !fromLabel || fromLabel === 'Select date') {
                fromBtn.classList.add('field-error');
                isValid = false;
            }

            const untilIso = untilBtn?.getAttribute('data-iso');
            const untilLabel = untilText?.textContent?.trim();
            if (!untilIso || !untilLabel || untilLabel === 'Select date') {
                untilBtn.classList.add('field-error');
                isValid = false;
            }

            if (!fromTime || !fromTime.value.trim()) {
                fromTime.classList.add('field-error');
                isValid = false;
            }
            if (!untilTime || !untilTime.value.trim()) {
                untilTime.classList.add('field-error');
                isValid = false;
            }

            if (!isValid) {

                return;
            }

            // ✅ Build payload only after passing validation
            const payload = {
                teacher: teacherData,
                from: {
                    iso: fromIso,
                    label: fromLabel,
                    time: fromTime ? fromTime.value.trim() : ''
                },
                until: {
                    iso: untilIso,
                    label: untilLabel,
                    time: untilTime ? untilTime.value.trim() : ''
                },
                submittedAt: new Date().toISOString()
            };

            console.log('✅ Add Extra Slots form payload:', payload);

            toggleLoader(true);
            if (submitBtn) submitBtn.disabled = true;

            $.ajax({
                url: M.cfg.wwwroot + "/local/customplugin/ajax/add_extra_slot.php",
                type: "POST",
                data: JSON.stringify(payload), // payload is your JS object
                contentType: "application/json",
                success: function(response) {
                    console.log("Extra Slot Created:", response);

                    if (response.ok) {
                        notify("Extra slot added successfully!", "success");
                        resetAddTimeFormExtraSlots(parent, initialExtraSlotsState);
                    } else {
                        notify("Failed: " + response.error, "error");
                    }

                    // Close modal if you have one
                    $("#addExtraSlotModal").fadeOut(300);

                    // Refresh calendar
                    if (window.refetchCustomPluginData) {
                        window.refetchCustomPluginData('add-extra-slot');
                    } else if (window.fetchCalendarEvents) {
                        window.fetchCalendarEvents();
                    } else if (typeof loadAdminCalendarEvents === "function") {
                        loadAdminCalendarEvents();
                    }
                },
                error: function(xhr) {
                    console.error("Extra Slot Error:", xhr.responseText);
                    notify("Something went wrong while adding extra slot.", "error");
                },
                complete: function() {
                    toggleLoader(false);
                    if (submitBtn) submitBtn.disabled = false;
                }
            });
        });
    }

});

// reset form helper
function resetAddTimeFormExtraSlots(parent, initialState) {
    if (!parent || !initialState) return;
    const teacherTrigger = parent.querySelector('#addtimeTeacherTrigger');
    const teacherAvatar = parent.querySelector('#addtimeTeacherAvatar');
    const teacherNameEl = parent.querySelector('#addtimeTeacherName');

    teacherAvatar.src = initialState.teacher.img;
    teacherNameEl.textContent = initialState.teacher.name;
    teacherTrigger.dataset.userid = initialState.teacher.id;
    teacherTrigger.dataset.name = initialState.teacher.name;
    teacherTrigger.dataset.img = initialState.teacher.img;

    parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_from_btn')
        .setAttribute('data-iso', initialState.from.iso);
    parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_from_text')
        .textContent = initialState.from.label;
    parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_from_row .time-input')
        .value = initialState.from.time;

    parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_until_btn')
        .setAttribute('data-iso', initialState.until.iso);
    parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_until_text')
        .textContent = initialState.until.label;
    parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_until_row .time-input')
        .value = initialState.until.time;
}
</script>