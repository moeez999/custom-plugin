$('#createNewCohortSelectColorLeft').click(function(e){
    e.stopPropagation();
    $('#createNewCohortColorListLeft').toggle();
    $(this).toggleClass('active');
});
$('#createNewCohortColorListLeft li').click(function(e){
    e.stopPropagation();
    var color = $(this).attr('data-color');
    $('#createNewCohortSelectedColorLeft .create_new_cohort_tab_select_color_left_circle').css('background', color);
    $('#createNewCohortColorListLeft').hide();
    $('#createNewCohortColorListLeft li').removeClass('selected');
    $(this).addClass('selected');
    $('#createNewCohortSelectColorLeft').removeClass('active');
});
$(document).click(function() {
    $('#createNewCohortColorListLeft').hide();
    $('#createNewCohortSelectColorLeft').removeClass('active');
});




$('#createNewCohortSelectColorRight').click(function(e){
  e.stopPropagation();
  $('#createNewCohortColorListRight').toggle();
  $(this).toggleClass('active');
});
$('#createNewCohortColorListRight li').click(function(e){

  e.stopPropagation();
  var color = $(this).attr('data-color');
  $('#createNewCohortSelectedColorRight .create_new_cohort_tab_select_color_right_circle').css('background', color);
  $('#createNewCohortColorListRight').hide();
  $('#createNewCohortColorListRight li').removeClass('selected');
  $(this).addClass('selected');
  $('#createNewCohortSelectColorRight').removeClass('active');
});
$(document).click(function() {
  $('#createNewCohortColorListRight').hide();
  $('#createNewCohortSelectColorRight').removeClass('active');
});
