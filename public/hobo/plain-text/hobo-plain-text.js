var hobo = hobo || {};
var baseUrl = baseUrl || "";

hobo.plainText = {

    editAreaId: 'hobo-edit-plain-text',

    /* it's the editor() method's responsibility to populate hobo.core.editorContainer */
    editor: function (content) {
        var self = this;

        /* content param, if defined, is retrieved from saveQueue or database
           if undefined, it's the plugin's job to determine what to display
         */

        if (content == undefined) {
            // default to html on page
            content = jQuery('[data-hobo-handle="' + hobo.core.elementBeingEdited.handle + '"]').html().trim();
        }

        // lets trim it
        content = jQuery.trim(content);

        jQuery(hobo.core.$editorContainer.html('<textarea id="hobo-edit-plain-text">' + content + '</textarea>'));
        editAreaLoader.init({
            id : self.editAreaId,
            syntax: "html",
            start_highlight: true,
            word_wrap: true,
            allow_toggle: false,
            min_width: hobo.core.$editorContainer.parent().width(),
            min_height: hobo.core.$editorContainer.parent().height() - 50,
            toolbar: "search, go_to_line, |, undo, redo, |, help"
        });
    },

    /* getContent() returns data for saveQueue, this is what will be stored in the database,
     * could be a serialized object or straight html, the display() method will build html from this
     * if necessary
     */
    getContent: function () {
        var self = this;
        return editAreaLoader.getValue(self.editAreaId);
    },

    /* display(content) renders content to html if a transformation is necessary, for plain text, it isn't */
    display: function (content) {
        return content;
    },

    /* if this method exists, the core modal will call it on window resize,
     * after the modal's elements have been resized
     */
    resize: function () {
       /* editArea doesn't have api methods for resizing, but it looks like
        * we can just set css rules
        */
        var parentWidth = hobo.core.$editorContainer.parent().width();
        var parentHeight = hobo.core.$editorContainer.parent().height();
        var $iframe = hobo.core.$editorContainer.find('iframe');
        $iframe
            .css('width', parentWidth)
            .css('height', parentHeight -50);
    }
};