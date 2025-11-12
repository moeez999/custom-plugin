  function openShareModal() {
  document.getElementById('shareTutorModal').style.display = 'flex';
}
function closeShareModal() {
  document.getElementById('shareTutorModal').style.display = 'none';
}
function copyLink() {
  var input = document.getElementById('shareLink');
  input.select();
  input.setSelectionRange(0, 99999);
  document.execCommand("copy");
  var btn = document.querySelector('.modal_copy_btn');
  btn.textContent = "Copied!";
  setTimeout(() => btn.textContent = "Copy link", 1200);
}

