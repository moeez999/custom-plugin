$(document).on('click', '.save_list', function () {
  const $btn = $(this);
  const $text = $btn.find('span');

  const isSaved = $btn.toggleClass('is-saved').hasClass('is-saved');

  $text.text(isSaved ? 'Saved' : 'Save to my list');
});