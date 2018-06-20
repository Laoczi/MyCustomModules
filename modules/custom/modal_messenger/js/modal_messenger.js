(function ($) {
  Drupal.behaviors.modal_messenger = {
    attach: function (context, settings) {

      $(context).find('#close_button').click(function () {
        $(context).find('.overlay').removeClass('overlay');
        $(context).find('#modal_messenger_window').css('display', 'none');

      });

      $(context).find('.overlay').click(function () {
        $(context).find('.overlay').removeClass('overlay');
        $(context).find('#modal_messenger_window').css('display', 'none');
      });


    }
  }
})(jQuery);
