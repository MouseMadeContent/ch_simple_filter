    jQuery(document).ready(function($) {
        $("#select_all_tags").click(function() {
            // Wenn die "Select All" Checkbox angeklickt wird,
            // setze den Status aller anderen Checkboxen entsprechend.
            $("#tags_sort input[type='checkbox']").prop("checked", $("#select_all_tags").prop("checked"));
        });
        $("#select_all_categories").click(function() {
            // Wenn die "Select All" Checkbox angeklickt wird,
            // setze den Status aller anderen Checkboxen entsprechend.
            $("#cat_sort input[type='checkbox']").prop("checked", $("#select_all_categories").prop("checked"));
        });
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
