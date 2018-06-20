(function ($) {
  Drupal.behaviors.drag_messenger = {
    attach: function (context, settings) {
      const drag = document.getElementById('modal_messenger_window');

      drag.onmousedown = function (e) {
        let coords = getCoords(drag);
        let shiftX = e.pageX - coords.left;
        let shiftY = e.pageY - coords.top;
        document.body.appendChild(drag);
        moveAt(e);

        function moveAt(e) {
          drag.style.left = e.pageX - shiftX + 'px';
          drag.style.top = e.pageY - shiftY + 'px';
        }

        document.onmousemove = function (e) {
          moveAt(e);
        };

        drag.onmouseup = function () {
          document.onmousemove = null;
          drag.onmouseup = null;
        };
      };
      drag.ondragstart = function () {
        return false;
      };

      function getCoords(elem) {
        const box = elem.getBoundingClientRect();
        return {
          top: box.top,
          left: box.left,
        };
      }

    }
  }
})(jQuery);
