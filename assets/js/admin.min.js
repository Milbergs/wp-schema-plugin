jQuery(document).ready(function($){
  // Post meta Star rating stars
  $('.rating-star').click( function(){
    $(this).find('input').attr('checked', true);
    $('.dashicons').removeClass('dashicons-star-filled');
    $('.dashicons').addClass('dashicons-star-empty');
    $(this).prevAll().find('.dashicons').removeClass('dashicons-star-empty');
    $(this).prevAll().find('.dashicons').addClass('dashicons-star-filled');
    $(this).find('.dashicons').removeClass('dashicons-star-empty');
    $(this).find('.dashicons').addClass('dashicons-star-filled');
  });


  // initially check status of #ToggleAutomatic, hide unnecessary fields
  if( $('#ToggleAutomatic').is(':checked')) {
      $('#ManualRating').closest('tr').fadeOut();
      $('#ManualReviews').closest('tr').fadeOut();
  } else {
    $('#ManualRating').closest('tr').fadeIn();
    $('#ManualReviews').closest('tr').fadeIn();
  }

  // check #ToggleAutomatic status and hide unnecessary fields
  $('#ToggleAutomatic').change(function(){
    if( $('#ToggleAutomatic').is(':checked')) {
        $('#ManualRating').closest('tr').fadeOut();
        $('#ManualReviews').closest('tr').fadeOut();
    } else {
      $('#ManualRating').closest('tr').fadeIn();
      $('#ManualReviews').closest('tr').fadeIn();
    }
  })
});
