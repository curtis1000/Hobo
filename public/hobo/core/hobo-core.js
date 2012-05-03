/* global variables */
var hobo = hobo || {};
var routeName = routeName || "";
var baseUrl = baseUrl || "";

$(function () {
    hobo.core.init();
});

/* http://stackoverflow.com/questions/2419749/get-selected-elements-outer-html
 * We need this in order to set a selector that the content type js files can use
 */
jQuery.fn.outerHTML = function(s) {
    return s
        ? this.before(s).remove()
        : jQuery("<p>").append(this.eq(0).clone()).html();
};

hobo.core = {

    /* data object that tracks what the user is currently editing */
    elementBeingEdited: null,

    /* jQuery object referring to a div inside the colorbox modal, gets set once modal loads */
    editorContainer: null,

    /* previewing changes adds/updates elements in the save queue, the save method will send all of these to the backend */
    saveQueue: [],

    /* plugin will be set per editable area, provides a generic way to access content type interface methods */
    plugin: {},

    isEditMode: false,

    $controlPanel: null,
    controlPanelLeft: true,

    init: function () {
        var self = this;
        if (jQuery != undefined) {
            jQuery.get(baseUrl + '/hobo/ajax/is-admin', function (isAdmin) {
                if (isAdmin) {
                    if (routeName != undefined && routeName != '') {
                        self.initAdmin();
                    } else {
                        self.handleError('var routeName must be defined');
                    }
                }
            });
        }
    },

    initAdmin: function () {
        var self = this;
        
        /* create control panel container */
        
        self.initControlPanel();
        self.drawControlPanel();
        
        /* bind control panel listeners */
        self.$controlPanel.find('.hobo-control-panel-edit').live('click', function () {
            if (! self.isEditMode) {
                self.enterEditMode();
            } else {
                self.exitEditMode();
            }
        });
        self.$controlPanel.find('.hobo-control-panel-save').live('click', function () {
            if (self.saveQueue.length > 0) {
                self.save();
            }
        });
        self.$controlPanel.find('.hobo-control-panel-discard').live('click', function () {
            if (self.saveQueue.length > 0) {
                /* simplest method to discard edits is to reload page */
                window.location.reload();
                /* should this be updated to reset all editable areas via ajax? */
                /* answer: yes */
            }
        });
        self.$controlPanel.find('.hobo-control-panel-toggle-side').live('mousedown', function (){
            $(this).removeClass('inactive');
        }).live('click', function () {
            self.toggleControlPanelSide();
        });
    },

    /* the inner html of the container gets re-drawn via calls to drawControlPanel */
    initControlPanel: function () {
        var self = this;
        /* setup the admin control panel container */
        jQuery('body').append('<div class="hobo-control-panel"></div>');
        self.$controlPanel = jQuery('.hobo-control-panel');
    },
    
    drawControlPanel: function () {
        var self = this;
        var toggleSideIcon = (self.controlPanelLeft) ? 'mv-right.png' : 'mv-left.png';
        var controlPanel = '' +
            '<a class="hobo-control-panel-toggle-side">' +
                '<img src="' + baseUrl + '/hobo/core/icons/' + toggleSideIcon + '" />' +
            '</a>' +
            '<a class="hobo-control-panel-edit">' +
                '<img src="' + baseUrl + '/hobo/core/icons/edit.png" />' +
            '</a> ' +
            '<a class="hobo-control-panel-save">' +
                '<img src="' + baseUrl + '/hobo/core/icons/save.png" />' +
            '</a>' +
            '<a class="hobo-control-panel-discard">' +
                '<img src="' + baseUrl + '/hobo/core/icons/discard.png" />' +
            '</a>';

        self.$controlPanel.html(controlPanel);

        /* icon treatments */
        self.$controlPanel.find('.hobo-control-panel-toggle-side').addClass('inactive');
        if (! self.isEditMode) {
            self.$controlPanel.find('.hobo-control-panel-edit').addClass('inactive');
        }
        if (self.saveQueue.length === 0) {
            self.$controlPanel.find('.hobo-control-panel-save').addClass('inactive');
            self.$controlPanel.find('.hobo-control-panel-discard').addClass('inactive');
        }
    },

    enterEditMode: function () {
        var self = this;
        self.isEditMode = true;

        jQuery('body *').each(function () {
            var dataHoboJSON = jQuery(this).attr('data-hobo');
            if (dataHoboJSON != undefined) {
                try {
                    var dataHobo = eval('(' + dataHoboJSON + ')');
                    if (typeof dataHobo == 'object') {
                        /* add class hobo-editable for hover effects */
                        jQuery(this).addClass('hobo-editable');
                        /* add click handler */
                        jQuery(this).click(function (event) {
                            event.preventDefault();
                            /* add routeName, needed for database */
                            dataHobo.routeName = routeName;
                            /* save method will reference this data, done referencing dataHobo at this point */
                            self.elementBeingEdited = dataHobo;
                            /* Using literal html as the selector, can't set $(this) and reference it in plugin file */
                            self.elementBeingEdited.$selector = jQuery(this).outerHTML();
                            /* create a generic reference to the plugin for the given content type */
                            /* example: hobo.plugin might now reference hobo.plainText */
                            hobo.plugin = eval('hobo.' + self.elementBeingEdited.contentType);
                            if (typeof hobo.plugin == 'object') {
                                jQuery.colorbox({
                                    html: '<div class="hobo-editor-container"></div>',
                                    width:"80%",
                                    height:"80%"
                                });
                                /* Once the modal is loaded */
                                jQuery(document).bind('cbox_complete', function(){
                                    /* plugins will reference this selector */
                                    self.editorContainer = jQuery('.hobo-editor-container');
                                    /* call the editor() method of the appropriate content type */
                                    hobo.plugin.editor();
                                });
                            } else {
                                self.handleError('hobo.' + self.elementBeingEdited.contentType + ' does not exist.')
                            }
                        });
                    } else {
                        self.handleError("data-hobo attribute contains valid javascript, but is not an object.");
                    }
                } catch (error) {
                    self.handleError("data-hobo attribute does not contain valid javascript: " + error);
                }               
            }
        });
        self.drawControlPanel();
    },

    exitEditMode: function () {
        var self = this;
        self.isEditMode = false;
        jQuery('.hobo-editable').unbind('click').removeClass('hobo-editable');
        self.drawControlPanel();
    },
    
    /* preview is called from colorbox, which has no knowledge of which content is being edited,
     * data regarding which element is being previewed is in self.elementBeingEdited
     */
    preview: function () {
        var self = this;
        /* create a generic reference to the plugin for the given content type */
        /* example: hobo.plugin might now reference hobo.plainText */
        hobo.plugin = eval('hobo.' + self.elementBeingEdited.contentType);
        if (typeof hobo.plugin == 'object') {
            var content = hobo.plugin.getcontent();
            self.elementBeingEdited.content = content;
            /* if an instance of this handle already exists in saveQueue, delete it, we are about to add an updated version */
            for (i=0; i<self.saveQueue.length; i++) {
                if (self.saveQueue[i].handle == self.elementBeingEdited.handle) {
                    self.saveQueue.splice(i, 1);
                }
            }
            /* make a deep copy of elementBeingEdited, store in saveQueue */
            var temp = {};
            jQuery.extend(true, temp, self.elementBeingEdited);
            self.saveQueue.push(temp);
            /* update the page */
            var previewHtml = hobo.plugin.display(content);
            jQuery('[data-hobo*=' + self.elementBeingEdited.handle + ']').html(previewHtml);
            /* clean up */
            self.elementBeingEdited = null;
            /* close modal */
            jQuery.colorbox.close();
            /* redraw control panel */
            self.drawControlPanel();
        }
    },

    /* send save queue to backend via ajax */
    save: function () {
        var self = this;
        for (var i=0; i<self.saveQueue.length; i++) {
            jQuery.post(baseUrl + '/hobo/ajax/save', self.saveQueue[i], function (response) {
                if (response) {
                    /* de-queue an element */
                    /* TODO work out a way to dequeue this exact element, currently just removes the zeroth index */
                    self.saveQueue.splice(0, 1);
                    /* if all items have been saved */
                    if (self.saveQueue.length == 0) {
                        /* confirm it to user */
                        self.exitEditMode();
                    }
                } else {
                    self.handleError('There was a problem saving content.');
                }
            });
        }
    },

    /* move the control panel to the left or right side */
    toggleControlPanelSide: function () {
        var self = this;
        if (self.controlPanelLeft) {
            self.mvControlPanelRight();
        } else {
            self.mvControlPanelLeft();
        }
        self.drawControlPanel();
    },

    mvControlPanelRight: function () {
        var self = this;
        var css = {
            "left": "auto",
            "right": "0px",
            "border-right": "none",
            "border-left": "1px solid #bbb"
        };
        self.$controlPanel.css(css);
        self.controlPanelLeft = false;
    },

    mvControlPanelLeft: function () {
        var self = this;
        var css = {
            "left": "0px",
            "right": "auto",
            "border-right": "1px solid #bbb",
            "border-left": "none"
        };
        self.$controlPanel.css(css);
        self.controlPanelLeft = true;
    },

    handleError: function (message) {
        alert(message);
    }
};