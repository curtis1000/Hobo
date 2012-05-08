var hobo = hobo || {};
var baseUrl = baseUrl || "";

hobo.tinyMce = {

    tinyMceId: 'hobo-edit-tiny-mce',

    /* it's the editor() method's responsibility to populate hobo.core.$editorContainer */
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

        jQuery(hobo.core.$editorContainer.html('<textarea id="hobo-edit-tiny-mce">' + content + '</textarea>'));
        tinyMCE.init({
            id : self.tinyMceId,
            mode : "textareas",

            /* Size Settings */
            width  : hobo.core.$editorContainer.parent().width(),
            height : hobo.core.$editorContainer.parent().height() - 50,

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
    },

    /* if this method exists, the core modal will call it on window resize,
     * after the modal's elements have been resized
     */
    resize: function () {
        /* Not sure if tiny mce has api methods for resizing, but it looks like
         * we can just set css rules
         */
        var parentWidth = hobo.core.$editorContainer.parent().width();
        var parentHeight = hobo.core.$editorContainer.parent().height();
        tinyMCE.activeEditor.theme.resizeTo(parentWidth, parentHeight -163);
    }
};