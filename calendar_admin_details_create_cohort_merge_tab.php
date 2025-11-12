<div class="calendar_admin_details_create_cohort_content tab-content" id="mergeTabContent" style="display:none;">
    <form id="mergeCohortForm">
        <div class="merge-row">
            <!-- Closing Cohort -->
            <div class="merge-col">
                <label class="merge-label">Closing Cohort</label>
                <div class="merge-dropdown-wrapper">
                    <div class="merge-dropdown-btn" id="mergeClosingCohortBtn">
                        <span class="merge-dropdown-selected" id="mergeClosingCohortSelected">FL-6-XXXXXX-0092</span>
                        <img src="./img/dropdown-arrow-down.svg" alt="">
                    </div>
                    <div class="merge-dropdown-list" id="mergeClosingCohortList">
                        <div class="merge-dropdown-title">Existing Cohorts</div>
                        <ul>
                            <li>TX-1-030423-0090</li>
                            <li>OH-12-032023-0089</li>
                            <li>NY-2-042522-0088</li>
                            <li>OH-12-032023-0089</li>
                            <li>TX-1-030423-0090</li>
                        </ul>
                    </div>
                </div>
                <div class="closing-merge-date-con">
                    <label class="merge-label" style="margin-top:14px;">Closing Date</label>
                    <button type="button" class="merge-date-btn" id="mergeClosingDateBtn">Select Date</button>
                </div>

                <label class="merge-checkbox-label" style="margin-top:17px;">
                    <input type="checkbox" id="mergeNow">
                    Close now
                </label>


            </div>
            <!-- Joining Cohort -->
            <div class="merge-col">
                <label class="merge-label">Joining Cohort</label>
                <div class="merge-dropdown-wrapper">
                    <div class="merge-dropdown-btn" id="mergeJoiningCohortBtn">
                        <span class="merge-dropdown-selected" id="mergeJoiningCohortSelected">FL-6-XXXXXX-0092</span>
                        <img src="./img/dropdown-arrow-down.svg" alt="">
                    </div>
                    <div class="merge-dropdown-list" id="mergeJoiningCohortList">
                        <div class="merge-dropdown-title">Existing Cohorts</div>
                        <ul>
                            <li>TX-1-030423-0090</li>
                            <li>OH-12-032023-0089</li>
                            <li>NY-2-042522-0088</li>
                            <li>OH-12-032023-0089</li>
                            <li>TX-1-030423-0090</li>
                        </ul>
                    </div>
                </div>

                <div class="merging-date-con">
                    <label class="merge-label" style="margin-top:14px;">Merging Date</label>
                    <button type="button" class="merge-date-btn" id="mergeMergingDateBtn">Select Date</button>
                </div>
                <label class="merge-checkbox-label" style="margin-top:17px;">
                    <input type="checkbox" id="mergeNow">
                    Merge now
                </label>

            </div>
        </div>
        <button type="submit" class="merge-cohort-btn">Merge Cohort</button>
    </form>
</div>

<!-- Calendar Modal -->
<div class="merge-calendar-modal-backdrop" id="mergeCalendarModalBackdrop" style="display:none;">
    <div class="merge-calendar-modal" id="mergeCalendarModal">
        <div class="merge-calendar-header">
            <button type="button" class="merge-calendar-prev"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="15 19 8 12 15 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></polyline>
                </svg></button>
            <span id="mergeCalendarMonth"></span>
            <button type="button" class="merge-calendar-next"><svg width="22" height="22" viewBox="0 0 24 24">
                    <polyline points="9 19 16 12 9 5" fill="none" stroke="#111" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></polyline>
                </svg></button>
        </div>
        <div class="merge-calendar-days"></div>
        <button class="merge-calendar-done-btn" type="button">Done</button>
    </div>
</div>