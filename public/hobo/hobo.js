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
    
    editMode: function () {
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
                               var editableIdentifier = classes[i].substring(startsWith.length);
                               console.log(editableIdentifier);
                        }
                    }
                }
            }
        });
    }
};