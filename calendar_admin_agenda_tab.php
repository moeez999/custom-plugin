<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Agenda Tab UI</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    /* Fonts & Reset */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    html, body { margin: 0; padding: 0; font-family: 'Inter', Arial, sans-serif; background: #fff; }
    * { box-sizing: border-box; }

    /* Layout */
    .agenda-container {
      display: flex;
      min-height: 100vh;
    }
    .agenda-sidebar {
      width: 340px;
      background: #f7f7fa;
      padding: 24px 0 24px 0;
      border-right: 1.5px solid #edecec;
      display: flex;
      flex-direction: column;
      align-items: stretch;
    }
    .agenda-sidebar button,
    .agenda-sidebar .sidebar-link {
      background: #fff;
      border: none;
      margin: 0 24px 15px 24px;
      border-radius: 12px;
      font-size: 18px;
      font-weight: 500;
      color: #222;
      text-align: left;
      padding: 18px 22px;
      cursor: pointer;
      box-shadow: 0 1px 2px rgba(220,220,220,0.06);
      transition: background 0.18s;
    }
    .agenda-sidebar button {
      background: #ff3d1f;
      color: #fff;
      font-weight: 600;
      margin-bottom: 22px;
      box-shadow: none;
    }
    .agenda-sidebar button:active,
    .agenda-sidebar .sidebar-link:active { background: #eaeaea; }
    .agenda-sidebar .sidebar-link:last-child { margin-bottom: 0; }
    .agenda-sidebar .sidebar-section-label {
      font-size: 17px;
      font-weight: 600;
      margin: 32px 24px 6px 24px;
      color: #555;
      letter-spacing: 0.05em;
    }

    /* Main Content */
    .agenda-main {
      flex: 1;
      padding: 0 0 0 0;
      display: flex;
      flex-direction: column;
    }
    .agenda-header-bar {
      padding: 0 38px 0 38px;
      background: #fff;
      border-bottom: 1.5px solid #edecec;
      display: flex;
      align-items: center;
      min-height: 90px;
      justify-content: flex-start;
      gap: 18px;
    }
    .agenda-header-bar .arrow-btn {
      background: #fff;
      border: 1.5px solid #edecec;
      border-radius: 10px;
      width: 44px;
      height: 44px;
      font-size: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 4px;
      cursor: pointer;
      transition: background 0.2s;
    }
    .agenda-header-bar .arrow-btn:active { background: #eee; }
    .agenda-header-bar .agenda-date-range {
      font-size: 22px;
      font-weight: 600;
      letter-spacing: 0.03em;
      margin-right: 20px;
    }
    .agenda-header-bar .dropdown,
    .agenda-header-bar .profile-dropdown {
      position: relative;
      margin-right: 10px;
    }
    .agenda-header-bar .dropdown-toggle,
    .agenda-header-bar .profile-toggle {
      background: #fff;
      border: 1.5px solid #edecec;
      border-radius: 10px;
      font-size: 18px;
      font-weight: 500;
      padding: 9px 18px 9px 46px;
      min-width: 128px;
      cursor: pointer;
      display: flex;
      align-items: center;
      position: relative;
    }
    .agenda-header-bar .dropdown-toggle::before {
      content: '\f0b0';
      font-family: 'Font Awesome 5 Free';
      font-weight: 900;
      position: absolute;
      left: 16px; font-size: 18px;
    }
    .agenda-header-bar .profile-toggle {
      padding-left: 45px;
      padding-right: 15px;
    }
    .agenda-header-bar .profile-toggle img {
      width: 28px; height: 28px; border-radius: 50%; position: absolute; left: 10px; top: 8px; border: 2px solid #edecec;
    }
    .agenda-header-bar .dropdown-menu, .agenda-header-bar .profile-menu {
      display: none;
      position: absolute;
      left: 0;
      top: 110%;
      min-width: 150px;
      background: #fff;
      border: 1.5px solid #edecec;
      border-radius: 10px;
      box-shadow: 0 3px 12px rgba(0,0,0,0.08);
      z-index: 99;
      padding: 7px 0;
    }
    .agenda-header-bar .dropdown-menu div,
    .agenda-header-bar .profile-menu div {
      padding: 10px 20px;
      cursor: pointer;
      font-size: 17px;
      color: #333;
      transition: background 0.13s;
    }
    .agenda-header-bar .dropdown-menu div:hover,
    .agenda-header-bar .profile-menu div:hover {
      background: #f2f2f7;
    }
    .agenda-header-bar .today-btn {
      background: #fff;
      border: 1.5px solid #edecec;
      border-radius: 10px;
      padding: 10px 24px;
      font-size: 18px;
      font-weight: 500;
      margin-right: 22px;
      cursor: pointer;
      transition: background 0.18s;
    }
    .agenda-header-bar .today-btn:active { background: #eee; }
    .agenda-header-bar .view-tabs {
      margin-left: auto;
      display: flex;
      align-items: center;
      border-bottom: 2px solid #edecec;
      height: 42px;
      gap: 2px;
    }
    .agenda-header-bar .view-tab {
      font-size: 18px;
      font-weight: 500;
      color: #b3b2b2;
      padding: 0 18px 4px 18px;
      background: none;
      border: none;
      border-bottom: 3px solid transparent;
      cursor: pointer;
      transition: color 0.17s, border 0.17s;
      outline: none;
    }
    .agenda-header-bar .view-tab.active {
      color: #ff3d1f;
      border-bottom: 3px solid #ff3d1f;
    }

    /* Agenda List */
    .agenda-list {
      flex: 1;
      padding: 36px 60px 0 60px;
      background: #fcfcfd;
      overflow-y: auto;
    }
    .agenda-list-day {
      margin-bottom: 13px;
    }
    .agenda-list-date {
      font-size: 28px;
      font-weight: 600;
      color: #222;
      display: flex;
      align-items: baseline;
      gap: 8px;
    }
    .agenda-list-date span {
      font-size: 18px;
      font-weight: 400;
      color: #8e8e8e;
      margin-left: 2px;
      letter-spacing: 0.02em;
    }
    .agenda-list-event {
      margin-top: 6px;
      background: #fff;
      border-radius: 13px;
      padding: 18px 30px 18px 30px;
      box-shadow: 0 1.5px 9px rgba(235, 98, 56, 0.03);
      font-size: 21px;
      font-weight: 600;
      color: #1b1a20;
      letter-spacing: 0.01em;
      display: flex;
      align-items: baseline;
      gap: 18px;
    }
    .agenda-list-event-time {
      font-size: 18px;
      color: #888;
      min-width: 130px;
      font-weight: 500;
      margin-right: 7px;
    }

    /* Responsive */
    @media (max-width: 1150px) {
      .agenda-list { padding: 30px 20px 0 20px; }
    }
    @media (max-width: 900px) {
      .agenda-sidebar { width: 100px; min-width: 85px; }
      .agenda-sidebar button,
      .agenda-sidebar .sidebar-link {
        font-size: 14px; padding: 13px 8px;
        margin: 0 8px 10px 8px;
        border-radius: 7px;
      }
      .agenda-sidebar .sidebar-section-label { font-size: 13px; margin: 18px 8px 4px 8px; }
      .agenda-header-bar { padding: 0 10px; }
      .agenda-list { padding: 18px 5px 0 5px; }
    }
    @media (max-width: 700px) {
      .agenda-container { flex-direction: column; }
      .agenda-sidebar { width: 100vw; flex-direction: row; padding: 10px 0; border-right: none; border-bottom: 1.5px solid #edecec;}
      .agenda-sidebar button, .agenda-sidebar .sidebar-link {
        flex: 1 1 0; margin: 0 4px 0 4px; font-size: 12px; padding: 8px 2px;
      }
      .agenda-header-bar { flex-wrap: wrap; gap: 8px; }
      .agenda-header-bar .agenda-date-range { font-size: 16px; }
      .agenda-list-date { font-size: 20px; }
      .agenda-list-event { font-size: 15px; padding: 12px 8px; }
      .agenda-list-event-time { font-size: 14px; min-width: 88px; }
    }
  </style>
  <!-- Font Awesome for icon (filter) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
</head>
<body>
<div class="agenda-container">

  <!-- Sidebar -->
  <aside class="agenda-sidebar">
    <button id="createCohortBtn">Create Cohort</button>
    <div class="sidebar-link">Manage Cohort</div>
    <div class="sidebar-link">Merge Cohort</div>
    <div class="sidebar-link">1:1 Class</div>
    <div class="sidebar-link">Conference</div>
    <div class="sidebar-link">Add time off</div>
    <div class="sidebar-link">Add Extra Slots</div>
    <div class="sidebar-link">Setup Availability</div>
    <div class="sidebar-section-label" style="margin-top:32px;">Labels</div>
  </aside>

  <!-- Main -->
  <section class="agenda-main">
    <!-- Header -->
    <div class="agenda-header-bar">
      <button class="arrow-btn" id="agendaPrevBtn"><i class="fa fa-chevron-left"></i></button>
      <button class="arrow-btn" id="agendaNextBtn"><i class="fa fa-chevron-right"></i></button>
      <span class="agenda-date-range" id="agendaDateRange">September 02-08 , 2024</span>

      <!-- Cohorts Dropdown -->
      <div class="dropdown">
        <div class="dropdown-toggle" id="cohortsDropdownBtn">Cohorts <i class="fa fa-chevron-down" style="margin-left:9px;font-size:14px;"></i></div>
        <div class="dropdown-menu" id="cohortsDropdownMenu">
          <div>Cohort 1</div>
          <div>Cohort 2</div>
        </div>
      </div>

      <!-- Profile Dropdown -->
      <div class="profile-dropdown">
        <div class="profile-toggle" id="profileDropdownBtn">
          <img src="https://randomuser.me/api/portraits/women/85.jpg" alt="profile">
          dinela <i class="fa fa-chevron-down" style="margin-left:9px;font-size:14px;"></i>
        </div>
        <div class="profile-menu" id="profileDropdownMenu">
          <div>My Profile</div>
          <div>Logout</div>
        </div>
      </div>

      <button class="today-btn" id="agendaTodayBtn">Today</button>

      <div class="view-tabs">
        <button class="view-tab" id="tabSemana">Semana</button>
        <button class="view-tab active" id="tabAgenda">Agenda</button>
      </div>
    </div>

    <!-- Agenda List -->
    <div class="agenda-list" id="agendaList">
      <!-- Dynamic Content! -->
    </div>
  </section>
</div>

<script>
  // --- DATA ---
  const agendaData = [
    { date: '2', day: 'Mon', time: '18:30 - 19:30', event: "Latingles - Teachers' Team Meeting" },
    { date: '3', day: 'Tue', time: '18:30 - 19:30', event: "Latingles - Teachers' Team Meeting" },
    { date: '4', day: 'Wed', time: '18:30 - 19:30', event: "Latingles - Teachers' Team Meeting" },
    { date: '5', day: 'Thu', time: '18:30 - 19:30', event: "Latingles - Teachers' Team Meeting" }
  ];

  // --- RENDER FUNCTION ---
  function renderAgendaList() {
    const $list = $('#agendaList');
    $list.empty();
    agendaData.forEach(item => {
      $list.append(`
        <div class="agenda-list-day">
          <div class="agenda-list-date">${item.date} <span>${item.day}</span></div>
          <div class="agenda-list-event">
            <span class="agenda-list-event-time">${item.time}</span>
            <span>${item.event}</span>
          </div>
        </div>
      `);
    });
  }

  // --- DROPDOWN FUNCTIONS ---
  function toggleDropdown($btn, $menu) {
    $('.dropdown-menu, .profile-menu').not($menu).hide();
    $menu.toggle();
  }
  function closeDropdowns() {
    $('.dropdown-menu, .profile-menu').hide();
  }

  // --- TAB SWITCH FUNCTION ---
  function switchTab(tab) {
    if(tab === 'agenda') {
      $('#tabAgenda').addClass('active');
      $('#tabSemana').removeClass('active');
      $('#agendaList').show();
      // add your "Semana" view logic here (if needed)
    } else {
      $('#tabAgenda').removeClass('active');
      $('#tabSemana').addClass('active');
      $('#agendaList').hide();
      // add your "Semana" view logic here (if needed)
    }
  }

  // --- INIT ---
  $(function(){
    renderAgendaList();

    // Dropdown handlers
    $('#cohortsDropdownBtn').click(function(e){
      e.stopPropagation();
      toggleDropdown($(this), $('#cohortsDropdownMenu'));
    });
    $('#profileDropdownBtn').click(function(e){
      e.stopPropagation();
      toggleDropdown($(this), $('#profileDropdownMenu'));
    });
    $(document).on('click', function() { closeDropdowns(); });

    // Tabs
    $('#tabAgenda').click(() => switchTab('agenda'));
    $('#tabSemana').click(() => switchTab('semana'));

    // Navigation/arrows handlers (dummy)
    $('#agendaPrevBtn, #agendaNextBtn, #agendaTodayBtn').click(function(){
      // Add your week navigation logic here
      alert('Navigation is not implemented in this demo.');
    });

    // Prevent closing dropdown if clicking inside menu
    $('.dropdown-menu, .profile-menu').click(function(e){ e.stopPropagation(); });
  });
</script>
</body>
</html>
