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
        var controlPanel = '' +
            '<div class="hobo-control-panel">' +
                '<a class="hobo-control-panel-edit">Edit</a>' +
            '</div>';
        jQuery('body').prepend(controlPanel);
        /* control panel listeners */
        var $controlPanel = jQuery('.hobo-control-panel');
        $controlPanel.find('.hobo-control-panel-edit').live('click', function () {
            self.editMode();
        });
    },
    
    elementBeingEdited: null,
    
    editMode: function () {
        var self = this;
        jQuery('body *').each(function () {
            var dataHoboJSON = $(this).attr('data-hobo');
            if (dataHoboJSON != undefined) {
                try {
                    var dataHobo = eval('(' + dataHoboJSON + ')');
                    if (typeof dataHobo == 'object') {
                        /* add class hobo-editable for hover effects */
                        $(this).addClass('hobo-editable');
                        /* add click handler */
                        $(this).click(function () {
                            /* add routeName, needed for database */
                            dataHobo.routeName = routeName;
                            /* save method will reference this data */
                            self.elementBeingEdited = dataHobo;
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
                    } else {
                        self.handleError("data-hobo attribute contains valid javascript, but is not an object.");
                    }
                } catch (error) {
                    self.handleError("data-hobo attribute does not contain valid javascript: " + error);
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
        console.log(self.elementBeingEdited);
        $.post(baseUrl + '/hobo/ajax/save', self.elementBeingEdited, function (response) { console.log(response);
            if (response == true) {
                /* update the page */
                jQuery('[data-hobo*=' + self.elementBeingEdited.handle + ']').html(self.elementBeingEdited.content);
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