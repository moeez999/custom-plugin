  <!-- Share Tutor Modal (hidden by default) -->
<div class="modal_backdrop" id="shareTutorModal" style="display:none;">
  <div class="modal_card">
    <button class="modal_close" onclick="closeShareModal()">&times;</button>
    <div class="modal_title">Share this tutor</div>
    <div class="modal_tutor_row">
      <img class="modal_tutor_avatar" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Tutor photo">
      <div class="modal_tutor_meta">
        <div class="modal_tutor_name">
          Robertson
          <span class="modal_tutor_star">★ 5</span>
          <span class="modal_tutor_reviews">(28 reviews)</span>
        </div>
        <div class="modal_tutor_tags">
          <span class="modal_tutor_tag">
            <svg width="17" height="17" viewBox="0 0 24 24"><path d="M9 12l2 2l4 -4" stroke="#232323" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="10" stroke="#232323" stroke-width="2" fill="none"/></svg>
            Verified
          </span>
          <span class="modal_tutor_tag">
            <svg width="17" height="17" viewBox="0 0 24 24"><path d="M4 21v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2" stroke="#232323" stroke-width="2" fill="none"/><circle cx="12" cy="7" r="4" stroke="#232323" stroke-width="2" fill="none"/></svg>
            Professional
          </span>
        </div>
      </div>
    </div>
    <div class="modal_link_row">
      <div class="modal_input_copy">
        <input type="text" value="https://latingles.com/Robertson" id="shareLink" readonly>
        <svg onclick="copyLink()" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="3" stroke="#232323" stroke-width="2" fill="none"/><rect x="3" y="3" width="13" height="13" rx="3" stroke="#232323" stroke-width="2" fill="none"/></svg>
      </div>
      <button class="modal_copy_btn" onclick="copyLink()">Copy link</button>
    </div>
    <div class="modal_social_grid">
      <button class="modal_social_btn">
        <svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2" stroke="#232323" stroke-width="2" fill="none"/><polyline points="3 6 12 13 21 6" stroke="#232323" stroke-width="2" fill="none"/></svg>
        Email
      </button>
      <button class="modal_social_btn">
        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="5" stroke="#232323" stroke-width="2" fill="none"/><path d="M12 17v-4M12 13c-2.8 0-5-2.2-5-5a5 5 0 1 1 10 0c0 2.8-2.2 5-5 5z" stroke="#232323" stroke-width="2" fill="none"/></svg>
        WhatsApp
      </button>
      <button class="modal_social_btn">
        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="4" stroke="#232323" stroke-width="2" fill="none"/><path d="M7 17h10M12 7v10" stroke="#232323" stroke-width="2" fill="none"/></svg>
        LinkedIn
      </button>
      <button class="modal_social_btn">
        <svg viewBox="0 0 24 24"><path d="M6.5 17l7-10M17.5 17l-7-10" stroke="#232323" stroke-width="2" fill="none"/></svg>
        X (Twitter)
      </button>
    </div>
  </div>
</div>
