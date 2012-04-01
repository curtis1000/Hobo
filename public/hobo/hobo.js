var hobo = hobo || {};
    
$(function () {
    hobo.init();   
});    
    
hobo = {
    
    init: function () {
        var self = this;
        if (jQuery != undefined) {
            jQuery.get(baseUrl + '/hobo/ajax/is-admin', function (isAdmin) {
                if (isAdmin) {
                    if (routeName != undefined && routeName != '') {
                       self.isAdmin(); 
                    } else {
                        self.handleError('var routeName must be defined');    
                    }                    
                } 
            });    
        }    
    },
    
    isAdmin: function () {
        var self = this;
        
        /* include the admin control panel */
        controlPanel = '' +
            '<div class="hobo-control-panel">' +
                '<a class="hobo-control-panel-edit">Edit</a>' +
            '</div>';
        
        jQuery('body').prepend(controlPanel);
        
        /* control panel listeners */
        $controlPanel = jQuery('.hobo-control-panel');
        $controlPanel.find('.hobo-control-panel-edit').live('click', function () {
            self.editMode();
        });
    },
    
    elementBeingEdited: null,
    
    editMode: function () {
        var self = this;

        jQuery('body *').each(function () {
            var classAttr = $(this).attr('class');
            if (classAttr != undefined) {
                if (classAttr.indexOf('editable') !== -1) {
                    /* if there are multiple classes */
                    var classes = classAttr.split(' ');
                    for (i=0; i<classes.length; i++) {
                        /* if this class starts with "editable" */
                        var startsWith = 'editable-';
                        if (classes[i].substring(startsWith.length,0) == startsWith) {
                            /* ex: editable-sidebar, the line below sets handle = 'sidebar' */
                            var handle = classes[i].substring(startsWith.length);
                            /* add class hobo-editable for hover effects */
                            $(this).addClass('hobo-editable');
                            $(this).click(function () {
                                /* save method will reference this data */
                                var isGlobal = ($(this).hasClass('global')) ? 1 : 0;
                                self.elementBeingEdited = {routeName: routeName, handle: handle, isGlobal: isGlobal};
                                console.log(self.elementBeingEdited );
                                $.colorbox({
                                    html: '<textarea id="hobo-edit-plain-text">' + $(this).html() + '</textarea>',
                                    width:"80%",
                                    height:"80%"
                                });
                                /* Since colorbox is a percentage of the viewport,
                                 * and editArea needs pixels, lets calculate the modal size.
                                 * Must be done after the cbox_complete event.
                                 */
                                $(document).bind('cbox_complete', function(){                                   
                                    editAreaLoader.init({
                                        id : "hobo-edit-plain-text",
                                        syntax: "html",
                                        start_highlight: true,
                                        word_wrap: true,
                                        allow_toggle: false,
                                        min_width:$('#cboxContent').width(),
                                        min_height:$('#cboxContent').height() - 50,
                                        toolbar: "search, go_to_line, |, undo, redo, |, help"
                                    });
                                });
                            });
                        }
                    }
                }
            }
        });
    },
    
    /* save is called from colorbox, which has no knowledge of which content is being edited,
     * data regarding which element is being saved is in self.elementBeingEdited, we just need
     * to send that along with the new content to the backend.
     */
    save: function () {
        var self = this;
        self.elementBeingEdited.content = editAreaLoader.getValue("hobo-edit-plain-text");
        
        $.post(baseUrl + '/hobo/ajax/save', self.elementBeingEdited, function (response) {
            if (response == true) {
                /* update the page */
                $selector = $('.editable-' + self.elementBeingEdited.handle);
                $selector.html(self.elementBeingEdited.content);
                /* clean up */
                self.elementBeingEdited = null;
            } else {
                self.handleError('There was a problem saving.');
            }
            $.colorbox.close();
        });
    },
    
    handleError: function (message) {
        alert(message);
    }
};