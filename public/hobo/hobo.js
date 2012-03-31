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
                    self.isAdmin();
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
    
    editableElements: [],
    
    editMode: function () {
        var self = this;
        
        if (routeName == undefined || routeName == '') {
            return self.handleError('routeName must be defined.');
        }

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
                            /* found an editable element, record it*/
                            var identifier = classes[i].substring(startsWith.length);
                            self.editableElements.push({identifier: identifier, isGlobal: $(this).hasClass('global')});
                            /* add class hobo-editable for hover effects */
                            $(this).addClass('hobo-editable');
                            $(this).click(function () {
                                $.colorbox({
                                    html: '<textarea id="hobo-edit-plain-text">' + $(this).html() + '</textarea>',
                                    width:"80%",
                                    height:"80%"
                                });
                                /* Since colorbox is a percentage of the viewport,
                                 * and editArea needs pixels, lets calculate width.
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
        
        $('.hobo-editable').click(function () {
            var classes = classAttr.split(' ');
            for (i=0; i<classes.length; i++) {
                /* if this class starts with "editable" */
                var startsWith = 'editable-';
                if (classes[i].substring(startsWith.length,0) == startsWith) {
                    /* found an editable element, record it*/
                    var identifier = classes[i].substring(startsWith.length);
                    self.editableElements.push({identifier: identifier, isGlobal: $(this).hasClass('global')});
                    /* add class hobo-editable for hover effects */
                    $(this).addClass('hobo-editable');
                }
            }                
        });
    },
    
    editSomething: function (identifier) {
        
    },
    
    handleError: function (message) {
        alert(message);
    }
};