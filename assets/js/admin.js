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

  var star_type = $('#Startype').val();
  showRating(star_type);


  $('#Startype').change(function(){
    var selected = $(this).val();
    showRating(selected);
  });

  function showRating(value){
    switch (value) {
      case "manual":
        $('#ManualRating').closest('tr').fadeIn();
        $('#ManualReviews').closest('tr').fadeIn();
      break;
      default:
        $('#ManualRating').closest('tr').hide();
        $('#ManualReviews').closest('tr').hide();
    }
  }

});
