
/* ---------- Week data (sample) ---------- */
const my_lessons_details_reshedule_weeks = [
  {
    label: "Feb 1 – 7, 2025",
    days: ["Sun 1","Mon 2","Tue 3","Wed 4","Thu 5","Fri 6","Sat 7"],
    slots: {
      "Sun 1":["08:30","09:00","10:00","11:00","11:30","14:30"],
      "Mon 2":["08:30","09:00","10:00","12:00","13:00"],
      "Tue 3":["08:30","10:30","12:00","13:00"],
      "Wed 4":["08:30","09:00","09:30","10:00","12:00"],
      "Thu 5":["08:30","09:00","12:00"],
      "Fri 6":["08:30","09:00","11:00","12:00","13:00"],
      "Sat 7":["08:30","09:00"]
    },
    disabled: new Set(["10:00@Sun 1","12:00@Mon 2","12:00@Tue 3","12:00@Wed 4","12:00@Thu 5"]),
    redBorder: new Set(["08:30@Sun 1","11:00@Fri 6"])
  },
  {
    label: "Feb 8 – 14, 2025",
    days: ["Sun 8","Mon 9","Tue 10","Wed 11","Thu 12","Fri 13","Sat 14"],
    slots: {
      "Sun 8":["08:30","09:00","11:00","11:30"],
      "Mon 9":["09:00","10:00","11:00","13:00"],
      "Tue 10":["08:30","09:00","10:30","12:00"],
      "Wed 11":["08:30","09:00","12:00","13:00"],
      "Thu 12":["08:30","10:00","12:00"],
      "Fri 13":["08:30","09:00","10:00","11:00","12:00"],
      "Sat 14":["08:30","09:00"]
    },
    disabled: new Set(["10:00@Thu 12","12:00@Fri 13"]),
    redBorder: new Set(["09:00@Mon 9"])
  }
];

/* ---------- State ---------- */
let my_lessons_details_reshedule_weekIndex = 0;
let my_lessons_details_reshedule_selectedKey = null;
let my_lessons_details_reshedule_tipEl = null;
let my_lessons_details_reshedule_selectedDuration = "50 minutes";

/* ---------- Helpers ---------- */
const my_lessons_details_reshedule_dayNice = d => {
  const map={Sun:"Sunday",Mon:"Monday",Tue:"Tuesday",Wed:"Wednesday",Thu:"Thursday",Fri:"Friday",Sat:"Saturday"};
  const [abbr, num] = d.split(' ');
  return `${map[abbr]||abbr} ${num}`;
};
function my_lessons_details_reshedule_addMinutes(hhmm, add=50){
  const [h,m]=hhmm.split(':').map(Number);
  const total=h*60+m+add, hh=Math.floor(total/60)%24, mm=total%60;
  const pad = n => String(n).padStart(2,'0');
  return `${pad(hh)}:${pad(mm)}`;
}
// Use short day (Sun, Mon, Tue, Wed, Thu, Fri, Sat)
function my_lessons_details_reshedule_formatLabel(dayKey, time){
  const [abbr, num] = dayKey.split(' ');          // e.g. "Thu 5" -> "Thu", "5"
  const end = my_lessons_details_reshedule_addMinutes(time, 50);
  const startPretty = time.replace(/^0/, '');
  return `${abbr} ${num}, ${startPretty}–${end}`; // "Thu 5, 5:00–05:50"
}





function my_lessons_details_reshedule_allTimesSorted(week){
  const set=new Set(); week.days.forEach(d=>week.slots[d]?.forEach(t=>set.add(t)));
  return [...set].sort((a,b)=> (+a.slice(0,2)*60+ +a.slice(3)) - (+b.slice(0,2)*60+ +b.slice(3)));
}
function my_lessons_details_reshedule_clearTip(){
  if(my_lessons_details_reshedule_tipEl){ my_lessons_details_reshedule_tipEl.remove(); my_lessons_details_reshedule_tipEl=null; }
}

/* ---------- Render ---------- */
function my_lessons_details_reshedule_renderDays(week){
  const $row = $("#my_lessons_details_reshedule_days").empty();
  week.days.forEach((d,i)=>{
    const isSun = i===0;
    $row.append(`
      <div class="flex justify-center">
        <div class="${isSun?'bg-red-50 text-red-600 font-semibold':'text-gray-900 font-medium'} px-3 py-2 rounded-xl">${d}</div>
      </div>
    `);
  });
}

function my_lessons_details_reshedule_renderGrid(){
  const week = my_lessons_details_reshedule_weeks[my_lessons_details_reshedule_weekIndex];
  $("#my_lessons_details_reshedule_weekLabel").text(week.label);
  my_lessons_details_reshedule_renderDays(week);

  const times = my_lessons_details_reshedule_allTimesSorted(week);
  const $grid = $("#my_lessons_details_reshedule_grid").empty();

  times.forEach(time=>{
    week.days.forEach(day=>{
      const key=`${time}@${day}`;
      if(week.slots[day]?.includes(time)){
        const isDisabled = week.disabled.has(key);
        const isRed = week.redBorder.has(key);
        const isSelected = (key===my_lessons_details_reshedule_selectedKey);

        const classes = `my_lessons_details_reshedule_slot ${isDisabled?'my_lessons_details_reshedule_disabled':''} ${isSelected?'my_lessons_details_reshedule_selected':''} ${isRed?'my_lessons_details_reshedule_redborder':''}`;

        $grid.append(`
          <div><div class="my_lessons_details_reshedule_cell">
            <div class="${classes}" data-key="${key}" data-time="${time}" data-day="${day}">${time}</div>
          </div></div>
        `);
      }else{
        $grid.append(`<div><div class="my_lessons_details_reshedule_cell"><div class="h-14 w-[168px] max-w-[90vw]"></div></div></div>`);
      }
    });
  });
}

/* ---------- Right Chip (single selection) ---------- */
function my_lessons_details_reshedule_refreshChip(){
  const $f=$("#my_lessons_details_reshedule_chipfield").empty();
  const $cta=$("#my_lessons_details_reshedule_cta");


if(!my_lessons_details_reshedule_selectedKey){
  $f.append('<div id="my_lessons_details_reshedule_placeholder" class="h-12 flex items-center px-4 border border-gray-300 rounded-xl text-gray-400 font-medium">Lesson</div>');

  // disabled state
$cta
  .prop("disabled", true)
  .removeClass("active-red bg-red-600 text-white border-red-600 border-black");
} else {
  const [time, day] = my_lessons_details_reshedule_selectedKey.split('@');

  $f.append(`
    <div class="relative">
      <div class="h-12 flex items-center w-full pl-4 pr-10 border border-gray-900 rounded-md bg-white">
        <span class="text-[15px] font-medium truncate">
          ${my_lessons_details_reshedule_formatLabel(day,time)}
        </span>
        <button id="my_lessons_details_reshedule_chipRemove"
                class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 grid place-items-center rounded-md text-gray-800 hover:text-black hover:bg-gray-100"
                aria-label="Remove">×</button>
      </div>
    </div>
  `);

  // active red state with black border
  $cta.prop("disabled", false)
      .addClass("active-red");
}



}

/* ---------- Duration Dropdown ---------- */
function my_lessons_details_reshedule_openMenu(){
  $("#my_lessons_details_reshedule_duration_menu").removeClass("hidden");
  $("#my_lessons_details_reshedule_duration_toggle").attr("aria-expanded","true");
}
function my_lessons_details_reshedule_closeMenu(){
  $("#my_lessons_details_reshedule_duration_menu").addClass("hidden");
  $("#my_lessons_details_reshedule_duration_toggle").attr("aria-expanded","false");
}

/* ---------- Events ---------- */
$(document).on("click",".my_lessons_details_reshedule_slot",function(){
  const $el=$(this);
  const key=$el.data("time")+"@"+$el.data("day");

  const week = my_lessons_details_reshedule_weeks[my_lessons_details_reshedule_weekIndex];
  if(week.disabled.has(key)){
    my_lessons_details_reshedule_clearTip();
    const r = $el[0].getBoundingClientRect();
    my_lessons_details_reshedule_tipEl = $(`<div class="my_lessons_details_reshedule_tip">Your Lesson With Daniela <span class="my_lessons_details_reshedule_tip_sub">7:00 – 7:25 PM</span></div>`)
      .appendTo(document.body);
    const t = my_lessons_details_reshedule_tipEl[0].getBoundingClientRect();
    const top = r.top - t.height - 10;
    const left = Math.max(8, Math.min(r.left + (r.width - t.width)/2, window.innerWidth - t.width - 8));
    my_lessons_details_reshedule_tipEl.css({top:`${Math.max(8,top)}px`, left:`${left}px`});
    return;
  }

  my_lessons_details_reshedule_clearTip();

  // Replace selection (single)
  my_lessons_details_reshedule_selectedKey = (my_lessons_details_reshedule_selectedKey === key) ? null : key;
  my_lessons_details_reshedule_renderGrid();
  my_lessons_details_reshedule_refreshChip();
});

$(document).on("click","#my_lessons_details_reshedule_chipRemove",function(){
  my_lessons_details_reshedule_selectedKey = null;
  my_lessons_details_reshedule_renderGrid();
  my_lessons_details_reshedule_refreshChip();
});

/* Close tooltip on outside */
$(document).on("click", e=>{
  if(!$(e.target).closest(".my_lessons_details_reshedule_slot,.my_lessons_details_reshedule_tip,#my_lessons_details_reshedule_duration_wrap").length){
    my_lessons_details_reshedule_clearTip();
    my_lessons_details_reshedule_closeMenu();
  }
});
$("#my_lessons_details_reshedule_leftpane").on("scroll", ()=>{
  my_lessons_details_reshedule_clearTip();
  my_lessons_details_reshedule_closeMenu();
});
$(window).on("resize", ()=>{
  my_lessons_details_reshedule_clearTip();
  my_lessons_details_reshedule_closeMenu();
});

/* Prev / Next week */
$("#my_lessons_details_reshedule_prev").on("click",function(){
  my_lessons_details_reshedule_weekIndex = (my_lessons_details_reshedule_weekIndex - 1 + my_lessons_details_reshedule_weeks.length) % my_lessons_details_reshedule_weeks.length;
  my_lessons_details_reshedule_selectedKey = null; my_lessons_details_reshedule_clearTip();
  my_lessons_details_reshedule_renderGrid(); my_lessons_details_reshedule_refreshChip();
});
$("#my_lessons_details_reshedule_next").on("click",function(){
  my_lessons_details_reshedule_weekIndex = (my_lessons_details_reshedule_weekIndex + 1) % my_lessons_details_reshedule_weeks.length;
  my_lessons_details_reshedule_selectedKey = null; my_lessons_details_reshedule_clearTip();
  my_lessons_details_reshedule_renderGrid(); my_lessons_details_reshedule_refreshChip();
});

/* Close panel */
$("#my_lessons_details_reshedule_close").on("click",()=> window.history.length>1 ? window.history.back() : window.close());

/* Dropdown handlers */
$("#my_lessons_details_reshedule_duration_toggle").on("click",function(e){
  e.stopPropagation();
  const menu = $("#my_lessons_details_reshedule_duration_menu");
  const isOpen = !menu.hasClass("hidden");
  if(isOpen){ my_lessons_details_reshedule_closeMenu(); } else { my_lessons_details_reshedule_openMenu(); }
});

$(document).on("click",".my_lessons_details_reshedule_duration_item",function(e){
  e.stopPropagation();
  const value=$(this).data("value");
  my_lessons_details_reshedule_selectedDuration = value;
  $("#my_lessons_details_reshedule_duration_label").text(value.replace(" minutes"," min").replace("hour, ","hr, ")+" lessons");

  // update checkmarks
  $(".my_lessons_details_reshedule_duration_item").each(function(){
    const isSel = $(this).data("value")===value;
    $(this).find(".my_lessons_details_reshedule_check").toggleClass("hidden", !isSel);
  });

  my_lessons_details_reshedule_closeMenu();
});

/* ESC to close menu */
$(document).on("keydown",function(e){
  if(e.key==="Escape"){ my_lessons_details_reshedule_closeMenu(); my_lessons_details_reshedule_clearTip(); }
});

/* Init */
function my_lessons_details_reshedule_init(){
  $("#my_lessons_details_reshedule_duration_label").text(my_lessons_details_reshedule_selectedDuration+" lessons");
  my_lessons_details_reshedule_renderGrid();
  my_lessons_details_reshedule_refreshChip();
}
my_lessons_details_reshedule_init();









/* ---- Hover tooltip for red slots (current lesson) ---- */
$(document).on("mouseenter", ".my_lessons_details_reshedule_slot.my_lessons_details_reshedule_redborder", function () {
  // clear any existing tip
  my_lessons_details_reshedule_clearTip();

  const r = this.getBoundingClientRect();

  // build tooltip
  my_lessons_details_reshedule_tipEl = $(
    '<div class="my_lessons_details_reshedule_tip">Your Current Lesson</div>'
  ).appendTo(document.body);

  // position centered above the slot (with arrow)
  const t = my_lessons_details_reshedule_tipEl[0].getBoundingClientRect();
  const top  = r.top - t.height - 10; // 10px gap
  const left = Math.max(8, Math.min(r.left + (r.width - t.width) / 2, window.innerWidth - t.width - 8));
  my_lessons_details_reshedule_tipEl.css({ top: `${Math.max(8, top)}px`, left: `${left}px` });
});

$(document).on("mouseleave", ".my_lessons_details_reshedule_slot.my_lessons_details_reshedule_redborder", function () {
  my_lessons_details_reshedule_clearTip();
});

