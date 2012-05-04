var hobo = hobo || {};
var baseUrl = baseUrl || "";

hobo.tinyMce = {

    tinyMceId: 'hobo-edit-tiny-mce',

    /* it's the editor() method's responsibility to populate hobo.core.editorContainer */
    editor: function () {
        var self = this;

        /* What content should be loaded into the editor?
         * - If there is data in the saveQueue, use that
         * - Else, query db
         * - Else innerHTML of editable element (first time edit)
         */
        var content;
        for (i=0; i<hobo.core.saveQueue.length; i++) {
            if (hobo.core.saveQueue[i].handle == hobo.core.elementBeingEdited.handle) {
                content = jQuery.trim(hobo.core.saveQueue[i].content);
            }
        }

        if (content == undefined) {
            /* make it synchronous since this step is conditional and subsequent code depends on it */
            jQuery.ajax({
                async: false,
                url: baseUrl + '/hobo/ajax/select-latest',
                data: hobo.core.elementBeingEdited,
                success: function (response) {
                    // if there was a database query result
                    if (response.content != undefined) {
                        content = jQuery.trim(self.display(response.content));
                    } else {
                        // default to html on page
                        content = jQuery('[data-hobo-handle="' + hobo.core.elementBeingEdited.handle + '"]').html().trim();
                    }
                }
            });
        }

        if (jQuery != undefined) {
            jQuery(hobo.core.editorContainer.html('<textarea id="hobo-edit-tiny-mce">' + content + '</textarea>'));
            tinyMCE.init({
                id : self.tinyMceId,
                mode : "textareas",
                
                /* Size Settings */
                width  : hobo.core.editorContainer.parent().width(),
                height : hobo.core.editorContainer.parent().height() - 50,
                
                /* Plugins */
                plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
                
                /* Theme Settings */
                theme : "advanced",
                theme_advanced_toolbar_location   : "top",
                theme_advanced_toolbar_align      : "left",
                theme_advanced_statusbar_location : "bottom",
                theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
                theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage"
            });
        }
    },

    /* getcontent() returns data for saveQueue, this is what will be stored in the database,
     * could be a serialized object or straight html, the display() method will build html from this
     * if necessary
     */
    getcontent: function () {
        var self = this;
        return tinyMCE.get(self.tinyMceId).getContent();
    },

    /* display(content) renders content to html if a transformation is necessary, for plain text, it isn't */
    display: function (content) {
        return content;
    }
};