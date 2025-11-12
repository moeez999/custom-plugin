<!-- WEEKLY SCHEDULE FULLSCREEN MODAL — peach top + WHITE bottom, slimmer card, helper text BELOW card -->
<style>
  .my_lessons_details_calendar_content_weekly_schedule_lesson_fs{position:fixed;inset:0;z-index:9999;}
  .my_lessons_details_calendar_content_weekly_schedule_lesson_backdrop{position:fixed;inset:0;background:transparent;}
  .my_lessons_details_calendar_content_weekly_schedule_lesson_wrap{
    position:fixed;inset:0;display:flex;flex-direction:column;background:#fff;
  }
  .my_lessons_details_calendar_content_weekly_schedule_lesson_top{background:#FDE9E5;}

  .my_lessons_details_calendar_content_weekly_schedule_lesson_card{
    box-shadow:0 20px 50px rgba(16,18,27,.16);
    border-radius:14px;
  }
  .my_lessons_details_calendar_content_weekly_schedule_lesson_tile{
    border:1px solid #E6E7EF;border-radius:5px;height:56px;
    display:grid;place-items:center;background:#fff;
  }
  .my_lessons_details_calendar_content_weekly_schedule_lesson_tileGray{
    border:1px solid #E6E7EF;border-radius:5px;background:#F2F3F7;
  }

  .my_lessons_details_calendar_content_weekly_schedule_lesson_x{width:36px;height:36px;border-radius:8px}
  .my_lessons_details_calendar_content_weekly_schedule_lesson_x:hover{background:#EFEFF4}

  .my_lessons_details_calendar_content_weekly_schedule_lesson_btn{
    background:#FF3B1F;border:1px solid #000;color:#fff;
    height:50px;width:420px;border-radius:10px;font-weight:600;font-size:16px;
    border: 2px solid black;
  }
  .my_lessons_details_calendar_content_weekly_schedule_lesson_btn:hover{opacity:.96}

  .my_lessons_details_calendar_content_weekly_schedule_lesson_plus{
    width:40px;
    height:40px;
    display:grid;
    place-items:center;
    /* border-radius:8px;
    background:#fff;
    border:1px solid #D1D5DB; */
    font-size:20px;
    line-height:1;
  }

  .my_lessons_details_calendar_content_weekly_schedule_lesson_noscroll{overflow:hidden}

  /* overlap */
  .my_lessons_details_calendar_content_weekly_schedule_lesson_overlap{ margin-top:-120px; }
  @media (min-width:640px){  .my_lessons_details_calendar_content_weekly_schedule_lesson_overlap{ margin-top:-40px; } }
  @media (min-width:1024px){ .my_lessons_details_calendar_content_weekly_schedule_lesson_overlap{ margin-top:-100px; } }
</style>

<div id="my_lessons_details_calendar_content_weekly_schedule_lesson_backdrop"
     class="my_lessons_details_calendar_content_weekly_schedule_lesson_backdrop hidden"></div>

<div id="my_lessons_details_calendar_content_weekly_schedule_lesson_modal"
     class="my_lessons_details_calendar_content_weekly_schedule_lesson_fs hidden">
  <div class="my_lessons_details_calendar_content_weekly_schedule_lesson_wrap">

    <button id="my_lessons_details_calendar_content_weekly_schedule_lesson_close"
            class="my_lessons_details_calendar_content_weekly_schedule_lesson_x absolute top-4 right-4 grid place-items-center text-[22px]"
            aria-label="Close">×</button>

    <!-- peach band -->
    <div class="my_lessons_details_calendar_content_weekly_schedule_lesson_top w-full">
      <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="pt-10 sm:pt-14 pb-24 sm:pb-28 flex flex-col items-center text-center">
          <img id="my_lessons_details_calendar_content_weekly_schedule_lesson_avatar"
               class="w-20 h-20 rounded-xl object-cover mb-4 border border-white/60 shadow"
               src="" alt="">
          <h1 id="my_lessons_details_calendar_content_weekly_schedule_lesson_headline"
              class="text-[34px] sm:text-[25px] leading-[1.15] font-semibold tracking-[-0.01em]">
            All set! Your lesson with Daniela<br class="hidden sm:block"> is scheduled.
          </h1>
        </div>
      </div>
    </div>

    <!-- overlapping card (NARROWER: 520px) -->
    <div class="my_lessons_details_calendar_content_weekly_schedule_lesson_overlap flex justify-center px-4">
      <div class="my_lessons_details_calendar_content_weekly_schedule_lesson_card w-full max-w-[420px] bg-white border border-gray-200">
        <div class="px-6 pt-6 pb-2 text-center">
          <div class="text-[18px] font-semibold leading-tight">
            Upcoming<br>Lesson
          </div>
        </div>

        <!-- primary -->
        <div class="px-6">
          <div class="my_lessons_details_calendar_content_weekly_schedule_lesson_tile text-[15px]">
            <span id="my_lessons_details_calendar_content_weekly_schedule_lesson_primaryText">Fri, Feb 21, 03:00 – 03:50</span>
          </div>
        </div>

        <!-- add next week -->
        <div class="px-6 mb-4">
          <div class="my_lessons_details_calendar_content_weekly_schedule_lesson_tileGray px-3 py-3 flex items-center justify-between">
            <div>
              <div class="text-[13px] text-gray-600 mb-0.5">Add lesson same time next week?</div>
              <div id="my_lessons_details_calendar_content_weekly_schedule_lesson_nextWeekText" class="text-[15px]">Fri, Feb 28, 03:00 – 03:50</div>
            </div>
            <button id="my_lessons_details_calendar_content_weekly_schedule_lesson_addNext"
                    class="my_lessons_details_calendar_content_weekly_schedule_lesson_plus" aria-label="Add">+</button>
          </div>
        </div>
      </div>
    </div>

    <!-- helper text BELOW the card (darker like your snapshot) -->
    <div class="mt-3 flex justify-center px-4">
      <p class="text-[14px] leading-[20px] text-[#3f3f40] text-center max-w-[420px]">
        Cancel or reschedule for free up to 12 hrs before the lesson starts.
      </p>
    </div>

    <!-- big Continue -->
    <div class="py-8 flex justify-center">
      <button id="my_lessons_details_calendar_content_weekly_schedule_lesson_continue"
              class="my_lessons_details_calendar_content_weekly_schedule_lesson_btn">
        Continue
      </button>
    </div>

  </div>
</div>

<script>
(function(){
  const MONTHS=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
  const DOW3=["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];

  const $modal=document.getElementById("my_lessons_details_calendar_content_weekly_schedule_lesson_modal");
  const $back=document.getElementById("my_lessons_details_calendar_content_weekly_schedule_lesson_backdrop");
  const $avatar=document.getElementById("my_lessons_details_calendar_content_weekly_schedule_lesson_avatar");
  const $headline=document.getElementById("my_lessons_details_calendar_content_weekly_schedule_lesson_headline");
  const $prim=document.getElementById("my_lessons_details_calendar_content_weekly_schedule_lesson_primaryText");
  const $next=document.getElementById("my_lessons_details_calendar_content_weekly_schedule_lesson_nextWeekText");
  const $x=document.getElementById("my_lessons_details_calendar_content_weekly_schedule_lesson_close");
  const $cont=document.getElementById("my_lessons_details_calendar_content_weekly_schedule_lesson_continue");
  const $add=document.getElementById("my_lessons_details_calendar_content_weekly_schedule_lesson_addNext");

  function pad(n){return String(n).padStart(2,"0");}
  function addMin(hhmm,add){const [h,m]=hhmm.split(":").map(Number);const t=h*60+m+add;return `${pad(Math.floor(t/60)%24)}:${pad(t%60)}`;}
  function parseWeek(label){const m=label.match(/^([A-Za-z]+)\s+(\d+)\s+–\s+([A-Za-z]+)?\s*(\d+),\s*(\d{4})$/);if(!m)return null;const sMon=m[1],sDay=+m[2],eMon=m[3]||m[1],eDay=+m[4],y=+m[5];return{y,sMi:MONTHS.indexOf(sMon),sDay,eMi:MONTHS.indexOf(eMon),eDay};}
  function dateFromWeekAndDay(weekLabel,dayKey){const meta=parseWeek(weekLabel);if(!meta)return new Date();const dNum=+dayKey.split(" ")[1];const useEnd=dNum<meta.sDay;return new Date(meta.y,useEnd?meta.eMi:meta.sMi,dNum);}
  function fmtSingle(weekLabel,dayKey,time,minutes){const d=dateFromWeekAndDay(weekLabel,dayKey);return `${DOW3[d.getDay()]}, ${MONTHS[d.getMonth()]} ${d.getDate()}, ${time} – ${addMin(time,minutes)}`;}
  function fmtNext(weekLabel,dayKey,time,minutes){const d=dateFromWeekAndDay(weekLabel,dayKey);d.setDate(d.getDate()+7);return `${DOW3[d.getDay()]}, ${MONTHS[d.getMonth()]} ${d.getDate()}, ${time} – ${addMin(time,minutes)}`;}

  function show(){document.body.classList.add("my_lessons_details_calendar_content_weekly_schedule_lesson_noscroll");$modal.classList.remove("hidden");$back.classList.remove("hidden");}
  function hide(){document.body.classList.remove("my_lessons_details_calendar_content_weekly_schedule_lesson_noscroll");$modal.classList.add("hidden");$back.classList.add("hidden");}

  window.my_lessons_details_calendar_content_weekly_schedule_lesson_open=function(opts){
    const o=Object.assign({tutorName:"Daniela",tutorAvatar:"",weekLabel:"",dayKey:"",time:"00:00",durationMinutes:50},opts||{});
    $avatar.src=o.tutorAvatar||"";
    $headline.innerHTML=`All set! Your lesson with <span class="font-semibold">${o.tutorName}</span><br class="hidden sm:block"> is scheduled.`;
    $prim.textContent=fmtSingle(o.weekLabel,o.dayKey,o.time,o.durationMinutes);
    $next.textContent=fmtNext(o.weekLabel,o.dayKey,o.time,o.durationMinutes);
    show();
  };

  $x.addEventListener("click",hide);
  $back.addEventListener("click",hide);
  document.addEventListener("keydown",e=>{if(e.key==="Escape")hide();});
  $cont.addEventListener("click",()=>{window.location.href="my_lessons.php";});
  $add.addEventListener("click",()=>{$add.classList.add("ring-2","ring-[#FF3B1F]");setTimeout(()=>{$add.classList.remove("ring-2","ring-[#FF3B1F]")},450);});
})();
</script>
