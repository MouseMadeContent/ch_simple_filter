
    jQuery(document).ready(function($) {
        $(".copy-button").click(function(){
            // Element auswählen, dessen Text kopiert werden soll
            var copyText = $('.my-shortcode').text();

            // Erstelle ein unsichtbares Textarea-Element zum Kopieren
            var textarea = $('<textarea>').val(copyText).appendTo('body').select();

            try {
                // Führe den Kopierbefehl aus
                var successful = document.execCommand('copy');
                var msg = successful ? 'erfolgreich' : 'fehlgeschlagen';
                console.log('Text kopieren war ' + msg);
            } catch (err) {
                console.log('Oops, das Kopieren war nicht möglich');
            } finally {
                // Entferne das unsichtbare Textarea-Element
                textarea.remove();
            }

            return false;
        });
        $('.sortable-list').sortable();
        $('.sortable-list .ui-sortable-handle').click(function () {
            var clickedElement = $(this);
            var elementID = clickedElement.attr('id');
            clickedElement.toggleClass('cat_element_checked');
            console.log('ID des angeklickten Elements:', elementID);
            // Hier kannst du die ID verwenden, wie du möchtest
          
        });
    });
