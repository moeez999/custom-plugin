<div class="cal-controls d-flex align-items-center gap-3"
    style="font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">

    <!-- Today pill -->
    <button id="btnToday" class="btn rounded-pill fw-semibold today-btn">
        Today
    </button>

    <!-- Tabs -->
    <div class="tabs d-flex align-items-end semana-agenda" role="tablist" aria-label="Calendar view">
        <button id="calendar_admin_semana_btn" class="tab-btn active" role="tab" aria-selected="true">Semana</button>
        <button id="calendar_admin_agenda_btn" class="tab-btn" role="tab" aria-selected="false">Agenda</button>
    </div>
</div>

<style>
/* Today button style */
.today-btn {
    background: #f7f7ff;
    color: #111;
    border: 1px solid #d9d9e3;
    padding: 8px 18px;


}

/* Tabs base style */
.tab-btn {
    background: transparent;
    border: none;
    font-weight: 600;
    padding: 6px 0;
    margin: 0 12px;
    color: #bbb;
    position: relative;
}

/* Active tab style */
.tab-btn.active {
    color: #e63946;
}

.tab-btn.active::after {
    content: "";
    position: absolute;
    bottom: -1px;
    left: 50%;
    transform: translateX(-50%);
    height: 4px;
    width: 75px;
    background: #e63946;
    border-radius: 3px 3px 0 0;

}
</style>