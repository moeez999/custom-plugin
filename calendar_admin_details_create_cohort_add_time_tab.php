<div class="calendar_admin_details_create_cohort_content tab-content" id="addTimeTabContent" style="display:none;">
    <form id="addTimeForm">
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

        <!-- TITLE -->
        <label class="addtime-label" style="margin-top:16px;">Title</label>
        <input type="text" class="addtime-title-input" value="Busy"
            style="width:100%;padding:9px 12px;border:1.3px solid #dadada;border-radius:8px;" />

<link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/local/customplugin/css/calendar_admin_details_create_cohort_add_time_tab.css">

        <!-- FROM -->
        <div>
            <label class="calendar_admin_details_create_cohort_add_time_tab_label">From</label>
            <div class="calendar_admin_details_create_cohort_add_time_tab_row"
                id="calendar_admin_details_create_cohort_add_time_tab_from_row">
                <button type="button" class="calendar_admin_details_create_cohort_add_time_tab_date_btn"
                    id="calendar_admin_details_create_cohort_add_time_tab_from_btn">
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
                    id="calendar_admin_details_create_cohort_add_time_tab_until_btn">
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
                        id="calendar_admin_details_create_cohort_add_time_tab_prev"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></button>
                    <div class="calendar_admin_details_create_cohort_add_time_tab_month_label"
                        id="calendar_admin_details_create_cohort_add_time_tab_month_label"></div>
                    <button type="button" class="calendar_admin_details_create_cohort_add_time_tab_navbtn"
                        id="calendar_admin_details_create_cohort_add_time_tab_next"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
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

        <label class="addtime-checkbox-label" style="margin-top:15px;display:flex;align-items:center;gap:6px;">
            <input type="checkbox" id="addTimeAllDay">
            All Day
        </label>
        <button type="submit" class="addtime-submit-btn">
            Schedule Time off
        </button>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const parent = document.getElementById('addTimeTabContent');
    if (!parent) return;

    const teacherTrigger = parent.querySelector('#addtimeTeacherTrigger');
    const teacherAvatar = parent.querySelector('#addtimeTeacherAvatar');
    const teacherNameEl = parent.querySelector('#addtimeTeacherName');
    const teacherMenu = parent.querySelector('#addtimeTeacherMenu');
    const teacherListBox = parent.querySelector('#addtimeTeacherList');
    const teacherSearch = parent.querySelector('#addtimeTeacherSearch');


    // copy items from main teacher list
    // copy items from main teacher list
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
                teacherMenu.style.display = 'none';
            });
            teacherListBox.appendChild(div);
        });

        // ✅ auto-select first real teacher (like previous one)
        if (items.length > 0) {
            const first = items[0];
            teacherAvatar.src = first.dataset.img || '';
            teacherNameEl.textContent = first.dataset.name || '';
            teacherTrigger.dataset.userid = first.dataset.userid || '';
            teacherTrigger.dataset.name = first.dataset.name || '';
            teacherTrigger.dataset.img = first.dataset.img || '';
        }
    }

    // dropdown open/close
    teacherTrigger.addEventListener('click', e => {
        e.stopPropagation();
        teacherMenu.style.display = teacherMenu.style.display === 'block' ? 'none' : 'block';
    });

    // ✅ close dropdown when clicking outside
    document.addEventListener('click', e => {
        if (!teacherMenu.contains(e.target) && !teacherTrigger.contains(e.target)) {
            teacherMenu.style.display = 'none';
        }
    });


    // search filter
    if (teacherSearch) {
        teacherSearch.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            teacherListBox.querySelectorAll('.addtime-teacher-item').forEach(item => {
                const nm = (item.dataset.name || '').toLowerCase();
                item.style.display = nm.includes(filter) ? 'flex' : 'none';
            });
        });
    }

    // calendar + time (same as before, scoped to parent)
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

        // Initialize the calendar label with current month
        function initializeCalendarLabel() {
            const today = new Date();
            const monthName = today.toLocaleString(undefined, {
                month: 'long'
            });
            label.textContent = monthName + ' ' + today.getFullYear();
        }
        initializeCalendarLabel();

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

            for (let i = 0; i < startIdx; i++) {
                grid.appendChild(document.createElement('div'));
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const dateObj = new Date(viewYear, viewMonth, d);
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'calendar_admin_details_create_cohort_add_time_tab_day';
                btn.textContent = d;
                if (dateObj.toDateString() === tempSelected.toDateString()) {
                    btn.classList.add('calendar_admin_details_create_cohort_add_time_tab_day--selected');
                }
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
        // 🟢 Hide/show time fields when "All Day" is toggled
        const allDayCheckbox = parent.querySelector('#addTimeAllDay');

        function applyAllDayUI(isAllDay) {
            parent.querySelectorAll('.custom-time-pill').forEach(pill => {
                const input = pill.querySelector('.time-input');
                const dropdown = pill.querySelector('.custom-time-dropdown');
                pill.style.display = isAllDay ? 'none' : ''; // hide or show
                if (isAllDay) {
                    input?.setAttribute('disabled', 'true');
                    dropdown?.style.setProperty('display', 'none');
                } else {
                    input?.removeAttribute('disabled');
                }
            });
        }

        if (allDayCheckbox) {
            // apply current state on load
            applyAllDayUI(allDayCheckbox.checked);
            // update dynamically on toggle
            allDayCheckbox.addEventListener('change', e => {
                applyAllDayUI(e.target.checked);
            });
        }

        const fromBtn = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_from_btn');
        const fromText = parent.querySelector(
            '#calendar_admin_details_create_cohort_add_time_tab_from_text');
        const untilBtn = parent.querySelector(
            '#calendar_admin_details_create_cohort_add_time_tab_until_btn');
        const untilText = parent.querySelector(
            '#calendar_admin_details_create_cohort_add_time_tab_until_text');

        function readISO(btn) {
            const iso = btn.getAttribute('data-iso');
            return iso ? new Date(iso) : new Date();
        }

        function writeField(btn, span, dateObj) {
            if (!dateObj || isNaN(dateObj)) {
                btn.removeAttribute('data-iso');
                span.textContent = 'Select date';
            } else {
                btn.setAttribute('data-iso', dateObj.toISOString().slice(0, 10));
                span.textContent = fmtLong(dateObj);
            }
        }


        if (fromBtn) {
            fromBtn.addEventListener('click', () => {
                openCalendar('from', readISO(fromBtn));
            });
        }
        if (untilBtn) {
            untilBtn.addEventListener('click', () => {
                openCalendar('until', readISO(untilBtn));
            });
        }

        const prev = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_prev');
        const next = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_next');
        if (prev) prev.addEventListener('click', () => {
            viewMonth--;
            if (viewMonth < 0) {
                viewMonth = 11;
                viewYear--;
            }
            renderCalendar();
        });
        if (next) next.addEventListener('click', () => {
            viewMonth++;
            if (viewMonth > 11) {
                viewMonth = 0;
                viewYear++;
            }
            renderCalendar();
        });

        const done = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_done');
        if (done) done.addEventListener('click', () => {
            if (activeTarget === 'from') {
                writeField(fromBtn, fromText, tempSelected);
            } else {
                writeField(untilBtn, untilText, tempSelected);
            }
            backdrop.style.display = 'none';
        });

        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                backdrop.style.display = 'none';
            }
        });

        // time dropdowns - Generate standardized times from 12:00 AM to 11:30 PM with 30-minute intervals
        function buildTimes() {
            const out = [];
            for (let h = 0; h < 24; h++) {
                for (let m = 0; m < 60; m += 30) {
                    let hour12 = h % 12 === 0 ? 12 : h % 12;
                    let period = h < 12 ? 'AM' : 'PM';
                    let mm = m < 10 ? '0' + m : m;
                    out.push(`${hour12}:${mm} ${period}`);
                }
            }
            return out;
        }
        const allTimes = buildTimes();

        function attachTime(row) {
            const pill = row.querySelector('.custom-time-pill');
            const input = pill.querySelector('.time-input');
            const dd = pill.querySelector('.custom-time-dropdown');

            if (!dd.dataset.built) {
                allTimes.forEach(t => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.textContent = t;
                    btn.addEventListener('click', () => {
                        input.value = t;
                        dd.style.display = 'none';
                    });
                    dd.appendChild(btn);
                });
                dd.dataset.built = '1';
            }

            pill.addEventListener('click', (e) => {
                e.stopPropagation();
                parent.querySelectorAll('.custom-time-dropdown').forEach(d => d.style.display =
                    'none');
                dd.style.display = dd.style.display === 'block' ? 'none' : 'block';
            });
        }

        const fromRow = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_from_row');
        const untilRow = parent.querySelector(
            '#calendar_admin_details_create_cohort_add_time_tab_until_row');
        if (fromRow) attachTime(fromRow);
        if (untilRow) attachTime(untilRow);

        document.addEventListener('click', () => {
            parent.querySelectorAll('.custom-time-dropdown').forEach(d => d.style.display = 'none');
        });
    })();

    // submit → console
    const form = parent.querySelector('#addTimeForm');
    if (form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const initialAddTimeState = {
            teacher: {
                id: teacherTrigger.dataset.userid || '',
                name: teacherTrigger.dataset.name || teacherNameEl?.textContent?.trim() || '',
                img: teacherTrigger.dataset.img || teacherAvatar?.src || ''
            },
            title: parent.querySelector('.addtime-title-input')?.value || '',
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
            },
            allDay: parent.querySelector('#addTimeAllDay')?.checked || false
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

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear old errors
            parent.querySelectorAll('.field-error').forEach(el => el.classList.remove('field-error'));

            let isValid = true;

            const teacherData = {
                id: teacherTrigger.dataset.userid || null,
                name: teacherTrigger.dataset.name || teacherNameEl?.textContent?.trim() || '',
                img: teacherTrigger.dataset.img || teacherAvatar?.src || ''
            };

            const titleInput = parent.querySelector('.addtime-title-input');
            const titleVal = titleInput ? titleInput.value.trim() : '';

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

            const allDay = parent.querySelector('#addTimeAllDay')?.checked || false;

            // 🔴 VALIDATION
            if (!teacherData.id || teacherData.name.trim() === '') {
                teacherTrigger.classList.add('field-error');
                isValid = false;
            }

            if (!titleVal) {
                titleInput.classList.add('field-error');
                isValid = false;
            }

            // FROM date validation
            const fromIso = fromBtn?.getAttribute('data-iso');
            const fromLabel = fromText?.textContent?.trim();
            if (!fromIso || !fromLabel || fromLabel === 'Select date') {
                fromBtn.classList.add('field-error');
                isValid = false;
            }

            // UNTIL date validation
            const untilIso = untilBtn?.getAttribute('data-iso');
            const untilLabel = untilText?.textContent?.trim();
            if (!untilIso || !untilLabel || untilLabel === 'Select date') {
                untilBtn.classList.add('field-error');
                isValid = false;
            }

            // Time fields (only if not all-day)
            if (!allDay) {
                if (!fromTime || !fromTime.value.trim()) {
                    fromTime.classList.add('field-error');
                    isValid = false;
                }
                if (!untilTime || !untilTime.value.trim()) {
                    untilTime.classList.add('field-error');
                    isValid = false;
                }
            }

            if (!isValid) {

                return;
            }

            // ✅ Build payload (only after passing validation)
            const payload = {
                teacher: teacherData,
                title: titleVal,
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
                allDay: allDay,
                submittedAt: new Date().toISOString()
            };

            console.log('✅ Add Time form payload:', payload);

            toggleLoader(true);
            if (submitBtn) submitBtn.disabled = true;

            $.ajax({
                url: M.cfg.wwwroot + "/local/customplugin/ajax/teacher_timeoff_add.php",
                type: "POST",
                data: JSON.stringify(payload),
                contentType: "application/json",
                success: function(response) {
                    console.log("Time Off Response:", response);

                    if (response.status === "success") {
                        notify("Teacher time off scheduled successfully!", "success");
                        resetAddTimeForm(parent, initialAddTimeState);
                        $("#manage-session-modal").fadeOut(300);

                        // Refresh calendar
                        if (window.refetchCustomPluginData) {
                            window.refetchCustomPluginData('teacher-timeoff-add');
                        } else if (window.fetchCalendarEvents) {
                            window.fetchCalendarEvents();
                        }
                    } else {
                        notify("Failed: " + response.error, "error");
                    }
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                    notify("Something went wrong.", "error");
                },
                complete: function() {
                    toggleLoader(false);
                    if (submitBtn) submitBtn.disabled = false;
                }
            });

        });


    }
});

function resetAddTimeForm(parent, initialState, slotInfo) {
    // If called without parameters but with slot info, populate from slot
    if (!parent && !initialState && slotInfo) {
        parent = document.getElementById('addTimeTabContent');
        if (!parent) return;
        
        // Create initialState from the clicked slot
        const slotDate = new Date(slotInfo.date);
        const dateStr = slotDate.toISOString().split('T')[0]; // YYYY-MM-DD format
        const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        
        const dayName = dayNames[slotDate.getDay()];
        const monthName = monthNames[slotDate.getMonth()];
        const dayNum = slotDate.getDate();
        const label = `${dayName}, ${monthName} ${dayNum}`;
        
        initialState = {
            teacher: {
                id: '',
                name: 'Select Teacher',
                img: ''
            },
            title: 'Busy',
            from: {
                iso: dateStr,
                label: label,
                time: '9:30 am'
            },
            until: {
                iso: dateStr,
                label: label,
                time: '10:00 am'
            },
            allDay: false
        };
    }
    
    if (!parent || !initialState) return;

    const teacherTrigger = parent.querySelector('#addtimeTeacherTrigger');
    const teacherAvatar = parent.querySelector('#addtimeTeacherAvatar');
    const teacherNameEl = parent.querySelector('#addtimeTeacherName');
    const teacherMenu = parent.querySelector('#addtimeTeacherMenu');

    // teacher
    if (teacherAvatar && initialState.teacher.img) teacherAvatar.src = initialState.teacher.img;
    if (teacherNameEl) teacherNameEl.textContent = initialState.teacher.name;
    if (teacherTrigger) {
        teacherTrigger.dataset.userid = initialState.teacher.id || '';
        teacherTrigger.dataset.name = initialState.teacher.name;
        teacherTrigger.dataset.img = initialState.teacher.img || '';
    }

    // title
    const titleInput = parent.querySelector('.addtime-title-input');
    if (titleInput) titleInput.value = initialState.title;

    // from
    const fromBtn = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_from_btn');
    const fromText = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_from_text');
    const fromRow = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_from_row');
    if (fromBtn) fromBtn.setAttribute('data-iso', initialState.from.iso);
    if (fromText) fromText.textContent = initialState.from.label;
    if (fromRow) {
        const ti = fromRow.querySelector('.time-input');
        if (ti) ti.value = initialState.from.time;
    }

    // until
    const untilBtn = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_until_btn');
    const untilText = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_until_text');
    const untilRow = parent.querySelector('#calendar_admin_details_create_cohort_add_time_tab_until_row');
    if (untilBtn) untilBtn.setAttribute('data-iso', initialState.until.iso);
    if (untilText) untilText.textContent = initialState.until.label;
    if (untilRow) {
        const ti2 = untilRow.querySelector('.time-input');
        if (ti2) ti2.value = initialState.until.time;
    }

    // all day
    const allDayCheckbox = parent.querySelector('#addTimeAllDay');
    if (allDayCheckbox) allDayCheckbox.checked = initialState.allDay;



    // close dropdowns
    parent.querySelectorAll('.custom-time-dropdown').forEach(d => d.style.display = 'none');
    if (teacherMenu) teacherMenu.style.display = 'none';
}
</script>