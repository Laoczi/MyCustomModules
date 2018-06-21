(function ($) {
    Drupal.behaviors.drag_messenger = {
        attach: function (context, settings) {
            const drag = document.getElementById('title');
            const allwin = document.getElementById('modal_messenger_window');

            drag.onmousedown = function (e) {
                let coords = getCoords(allwin);
                let shiftX = e.pageX - coords.left;
                let shiftY = e.pageY - coords.top;
                document.body.appendChild(allwin);
                moveAt(e);

                function moveAt(e) {
                    allwin.style.left = e.pageX - shiftX + 'px';
                    allwin.style.top = e.pageY - shiftY + 'px';
                }

                document.onmousemove = function (e) {
                    moveAt(e);
                };

                drag.onmouseup = function () {
                    document.onmousemove = null;
                    drag.onmouseup = null;
                };
            };

            function getCoords(elem) {
                const box = elem.getBoundingClientRect();
                return {
                    top: box.top,
                    left: box.left,
                };
            }

            drag.ondragstart = function () {
                return false;
            };
            drag.onselectstart = function () {
                return false;
            };
        }
    }
})(jQuery);