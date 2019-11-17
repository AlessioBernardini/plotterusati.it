$(function(){
    var last_page = $('ul.pagination #last').attr('data-last');
    $('#products').infinitescroll({
            navSelector     : "#next", // selector for the paged navigation (it will be hidden)
            nextSelector    : "a#next:last", // selector for the NEXT link (to page 2)
            itemSelector    : "#products", // selector for all items you'll retrieve
            loadingImg      : "//cdn.jsdelivr.net/jquery.infinitescroll/2.1/ajax-loader.gif",
            maxPage         : last_page,
            donetext        : 'No more advertisements',
            errorCallback   : function(){ 
                $('ul.pagination').hide();
            }
        },
        function(items) {
            // iterate across the elements we just added
            for (var i = 0; i < items.length; i++) {
                var item = items[i];
                //favorites system
                $(item).find('.add-favorite, .remove-favorite').click(function(event) {
                    event.preventDefault();
                    $this = $(this);
                    $.ajax({ url: $this.attr('href'),
                        }).done(function ( data ) {
                            $('#'+$this.data('id')+' a').toggleClass('add-favorite remove-favorite');
                            $('#'+$this.data('id')+' a i').toggleClass('glyphicon-heart-empty glyphicon-heart');
                        });
                });
                //toolbar button
                $(item).find('.toolbar').each(function(){
                    var id = '#'+$('.user-toolbar-options',this).attr('id');
                    $(this).toolbar({
                        content: id,
                        hideOnClick: true, 
                    });
                });
                $(item).find('#toolbar-all').toolbar({
                    content: '#user-toolbar-options-all',
                    hideOnClick: true, 
                });
            };

            /* Get user filter preference */
            if(getCookie('list/grid') == 1)
                $("#list").trigger("click");
            else if(getCookie('list/grid') == 0)
                $("#grid").trigger("click");
            else if(getCookie('list/grid') == null){
                if($('#listgrid').data('default') == 1)
                    $("#list").trigger("click");
                else if($('#listgrid').data('default') == 0)
                    $("#grid").trigger("click"); 
            }

            // call holder.js after adding new elements
            Holder.run();
    });
});