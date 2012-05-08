/* global variables */
var hobo = hobo || {};
var routeName = routeName || "";
var baseUrl = baseUrl || "";

$(function () {
    hobo.core.init();
});

hobo.modal = {
    $overlay: null,
    $modal: null,
    $innerFrame: null,
    $editorContainer: null,
    $menu: null,
    $cancel: null,
    $preview: null,
    margin: 10,
    overlayHtml:  '<div class="hobo-overlay"></div>',
    modalHtml: '' +
        '<div class="hobo-modal">' +
            '<div class="hobo-modal-inner-frame">' +
                '<div class="hobo-modal-editor-container"></div>' +
                '<div class="hobo-modal-menu">' +
                    '<a class="hobo-btn hobo-modal-cancel">Cancel</a>' +
                    '<a class="hobo-btn hobo-modal-preview">Preview</a>' +
                '</div>' +
            '</div>' +
        '</div>',
    
    open: function () {
        var self = this;

        /* prepend the page overlay */
        $('body').prepend(self.overlayHtml);
        self.$overlay = $('.hobo-overlay');

        /* append the modal */
        $('body').append(self.modalHtml);

        /* cache jquery objects */
        self.$modal = $('.hobo-modal');
        self.$innerFrame = self.$modal.find('.hobo-modal-inner-frame');
        self.$editorContainer = self.$innerFrame.find('.hobo-modal-editor-container');
        self.$menu = self.$innerFrame.find('.hobo-modal-menu');
        self.$cancel = self.$menu.find('.hobo-modal-cancel');
        self.$preview = self.$menu.find('.hobo-modal-preview');

        /* modal top and left are calculated based on height and width */
        self.$modal
            .css({"height":"70%","width":"70%"})
            .css({"top": (($(window).height() - self.$modal.height()) / 2) + $(window).scrollTop()})
            .css({"left": (($(window).width() - self.$modal.width()) / 2) + $(window).scrollLeft()});

        /* need to calculate height of inner frame based on modal height */
        self.$innerFrame
            .css({"height": self.$modal.height() - (self.margin *2) + "px"});

        /* need to calculate height of editor container (inner frame height - menu height)*/
        self.$editorContainer
            .css({"height": self.$innerFrame.height() - self.$menu.height() - self.margin + "px"});

        /* now bind listeners */
        self.bind();
    },

    bind: function () {
        var self = this;
        /* since the modal width and height is a percetange, it resizes with the window,
         * however everything else is calculated in pixels against that percentage, so
         * when the window is resized, we need to re-calculate a bunch of things here
         */
        jQuery(window).resize(function (event) {
            self.$modal
                .css({"top": (($(window).height() - self.$modal.height()) / 2) + $(window).scrollTop()})
                .css({"left": (($(window).width() - self.$modal.width()) / 2) + $(window).scrollLeft()});
            self.$innerFrame
                .css({"height": self.$modal.height() - (self.margin *2) + "px"});
            self.$editorContainer
                .css({"height": self.$innerFrame.height() - self.$menu.height() - self.margin + "px"});
            /* notify the plugin */
            hobo.plugin = eval('hobo.' + hobo.core.elementBeingEdited.contentType);
            if (hobo.plugin != undefined && typeof hobo.plugin == 'object') {
                if (hobo.plugin.resize != undefined && typeof hobo.plugin.resize == 'function') {
                    hobo.plugin.resize();
                }
            }
        });

        self.$cancel.live('click', function () {
            self.cancel();
        });
        self.$preview.live('click', function () {
            self.preview();
        });
    },

    /* unbind modal listeners, called from close */
    unbind: function () {
        var self = this;
        jQuery(window).unbind('resize');
        self.$cancel.die('click');
        self.$preview.die('click');
    },

    /* cancel is just an alias to close */
    cancel: function () {
        var self = this;
        self.close();
    },
    close: function () {
        var self = this;
        self.unbind();
        self.$modal.remove();
        self.$overlay.remove();
    },
    preview: function () {
        hobo.core.preview();
    }
};

hobo.core = {

    /* data object that tracks what the user is currently editing */
    elementBeingEdited: null,

    /* jQuery object referring to an element that content type plugins will populate with their editing ui */
    $editorContainer: null,

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

        self.setHandles();

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
                self.discardEdits();
            }
        });
        self.$controlPanel.find('.hobo-control-panel-toggle-side').live('mousedown', function (){
            $(this).removeClass('inactive');
        }).live('click', function () {
            self.toggleControlPanelSide();
        });
        /* escape key */
        jQuery(document).keyup(function(e) {
            if (e.keyCode == 27 && self.isEditMode) {
                self.exitEditMode();
            }
        });
    },

    /* Each editable area need a unique selector for jquery when editing the page,
    *  so, for each element with data-hobo, pull out the handle and create a
    *  handle="whatever" attribute on that eleement, then jquery can select with
    *  [data-hobo-handle="whatever"]. Called from initAdmin()
    */
    setHandles: function () {
        var self = this;
        jQuery('body *').each(function () {
            var dataHoboJSON = jQuery(this).attr('data-hobo');
            if (dataHoboJSON != undefined) {
                try {
                    var dataHobo = eval('(' + dataHoboJSON + ')');
                    if (typeof dataHobo == 'object') {
                       if (dataHobo.handle != undefined) {
                           $(this).attr('data-hobo-handle', dataHobo.handle);
                       }
                    }
                } catch (error) {
                    self.handleError(error.message);
                }
            }
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

        jQuery('[data-hobo-handle]').each(function () {
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
                            /* create a generic reference to the plugin for the given content type */
                            /* example: hobo.plugin might now reference hobo.plainText */
                            hobo.plugin = eval('hobo.' + self.elementBeingEdited.contentType);
                            if (typeof hobo.plugin == 'object') {
                                hobo.modal.open();
                                /* setting the editorContainer reference allows plugins to always reference hobo.core.editorContainer,
                                 * while the core can change what the editorContainer is (ie. changing the modal library)
                                 */
                                self.$editorContainer = hobo.modal.$editorContainer;
                                hobo.plugin.editor();
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
    
    /* preview is called from the edit modal, which has no knowledge of which content is being edited,
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
            hobo.modal.close();
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

    discardEdits: function () {
        var self = this;
        // to-do make this ajax for each element in save queue
        // window.location.reload();
        for (var i=0; i<self.saveQueue.length; i++) {
            jQuery.post(baseUrl + '/hobo/ajax/select-latest', self.saveQueue[i], function (response) {
                // if there was a database query result
                if (response.content != undefined) {
                    try {
                        /* create a generic reference to the plugin for the given content type */
                        var plugin = eval('hobo.' + response.contentType);
                        /* finally, revert the content */
                        jQuery('[data-hobo-handle="' + response.handle + '"]').html(plugin.display(response.content));
                    } catch (error) {
                        self.handleError(error.message);
                    }
                }
            });
        }
        /* flush saveQueue and exit edit mode */
        self.saveQueue = [];
        self.exitEditMode();
    },

    handleError: function (message) {
        alert(message);
    }
};