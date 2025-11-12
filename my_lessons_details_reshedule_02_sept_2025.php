
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <link rel="stylesheet" href="css/my_lessons_details_reshedule.css"/>

  <!-- Header -->
  <header id="my_lessons_details_reshedule_header">
    <img src="logo.png" alt="LATINGLES Logo" />
    <h1>Reschedule lesson</h1>
  </header>

  <!-- Main content -->
  <div id="my_lessons_details_reshedule_main">
    <!-- Left: calendar grid -->
    <section id="my_lessons_details_reshedule_calendar">
      <div id="my_lessons_details_reshedule_date_range">
        Feb&nbsp;16&nbsp;–&nbsp;22,&nbsp;2025
      </div>
      <div class="my_lessons_details_reshedule_nav">
        <button id="my_lessons_details_reshedule_prev"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></button>
        <button id="my_lessons_details_reshedule_next"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg></button>
      </div>
      <table id="my_lessons_details_reshedule_table">
        <thead>
          <tr>
            <th></th>
            <th>Sun 16</th><th>Mon 17</th><th>Tue 18</th>
            <th>Wed 19</th><th>Thu 20</th><th>Fri 21</th><th>Sat 22</th>
          </tr>
        </thead>
        <tbody>
          <!-- 03:00 -->
          <tr>
            <th>03:00</th>
            <td><button class="slot" data-time="03:00">03:00</button></td>
            <td></td><td></td>
            <td></td>
            <td><button class="slot" data-time="03:00">03:00</button></td>
            <td></td><td></td>
          </tr>
          <!-- 05:00 -->
          <tr>
            <th>05:00</th>
            <td></td><td></td><td></td>
            <td><button class="slot" data-time="05:00">05:00</button></td>
            <td></td>
            <td><button class="slot" data-time="05:00">05:00</button></td>
            <td></td>
          </tr>
          <!-- 05:30 -->
          <tr>
            <th>05:30</th>
            <td></td><td></td><td></td>
            <td><button class="slot" data-time="05:30">05:30</button></td>
            <td></td><td></td><td></td>
          </tr>
          <!-- 06:00 -->
          <tr>
            <th>06:00</th>
            <td></td><td></td><td></td>
            <td><button class="slot" data-time="06:00">06:00</button></td>
            <td></td><td></td><td></td>
          </tr>
          <!-- 06:30 -->
          <tr>
            <th>06:30</th>
            <td></td><td></td><td></td>
            <td><button class="slot" data-time="06:30">06:30</button></td>
            <td></td><td></td><td></td>
          </tr>
          <!-- 07:00 -->
          <tr>
            <th>07:00</th>
            <td></td><td></td><td></td>
            <td><button class="slot disabled"
                        data-tooltip-title="Your Lesson With Daniela"
                        data-tooltip-subtitle="Saturday, Feb 22, 7:00 – 7:25 PM"
                        disabled>07:00</button></td>
            <td></td>
            <td></td><td><button class="slot" data-time="07:00">07:00</button></td>
          </tr>
          <!-- 07:30 -->
          <tr>
            <th>07:30</th>
            <td></td><td></td><td></td>
            <td><button class="slot" data-time="07:30">07:30</button></td>
            <td></td><td></td><td><button class="slot" data-time="07:30">07:30</button></td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- Right: details panel -->
    <aside id="my_lessons_details_reshedule_panel">
      <div id="my_lessons_details_reshedule_close">&times;</div>
      <div id="my_lessons_details_reshedule_tutor">
        <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Daniela" />
        <div id="my_lessons_details_reshedule_tutor_info">
          <h2>English with Daniela</h2>
          <div id="my_lessons_details_reshedule_duration">50 min lessons&nbsp;▼</div>
        </div>
      </div>
      <div id="my_lessons_details_reshedule_current">
        <label>Current lesson time</label>
        <div class="value">Wed, Feb 19, 12:00 – 12:50</div>
      </div>
      <div id="my_lessons_details_reshedule_new">
        <label>New lesson time</label>
        <div class="my_lessons_details_reshedule_input_container">
          <input
            type="text"
            id="my_lessons_details_reshedule_new_time"
            placeholder="Select a time slot above"
            readonly
          />
          <span id="my_lessons_details_reshedule_clear">&times;</span>
        </div>
      </div>
      <button id="my_lessons_details_reshedule_reschedule_btn">
        Reschedule
      </button>
      <div id="my_lessons_details_reshedule_notice">
        Cancel or reschedule for free up to 12 hrs before the lesson starts.
      </div>
    </aside>
  </div>
  
  <script src="js/my_lessons_details_reshedule.js"></script>
