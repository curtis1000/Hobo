var hobo = hobo || {};
var baseUrl = baseUrl || "";

hobo.plainText = {

    editAreaId: 'hobo-edit-plain-text',

    /* it's the editor() method's responsibility to populate hobo.core.editorContainer */
    editor: function () {
        var self = this;

        /* What content should be loaded into the editor?
         * - If there is data in the saveQueue, use that
         * - Else, query db
         */
        var content;
        for (i=0; i<hobo.core.saveQueue.length; i++) {
            if (hobo.core.saveQueue[i].handle == hobo.core.elementBeingEdited.handle) {
                content = hobo.core.saveQueue[i].content;
            }
        }

        if (content == undefined) {
            /* make it synchronous since this step is conditional and subsequent code depends on it */
            $.ajax({
                async: false,
                url: baseUrl + '/hobo/ajax/select-latest',
                data: hobo.core.elementBeingEdited,
                success: function (response) {
                    content = response.content;
                }
            });
        }

        if (jQuery != undefined) {
            jQuery(hobo.core.editorContainer.html('<textarea id="hobo-edit-plain-text">' + content + '</textarea>'));
            editAreaLoader.init({
                id : self.editAreaId,
                syntax: "html",
                start_highlight: true,
                word_wrap: true,
                allow_toggle: false,
                min_width: hobo.core.editorContainer.parent().width(),
                min_height: hobo.core.editorContainer.parent().height() - 50,
                toolbar: "search, go_to_line, |, undo, redo, |, help"
            });
        }
    },

    /* getcontent() returns data for saveQueue, this is what will be stored in the database,
     * could be a serialized object or straight html, the display() method will build html from this
     * if necessary
     */
    getcontent: function () {
        var self = this;
        return editAreaLoader.getValue(self.editAreaId);
    },

    /* display(content) renders content to html if a transformation is necessary, for plain text, it isn't */
    display: function (content) {
        return content;
    }
};