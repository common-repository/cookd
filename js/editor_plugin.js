jQuery(document).ready(function($) {

    tinymce.create('tinymce.plugins.cookd_plugin', {
        init : function(ed, url) {
                ed.addCommand('cookd_insert_shortcode', function() {
                    content =  '[cookd]';                    
                    tinymce.execCommand('mceInsertContent', false, content);
                });

            ed.addButton('cookd_button', {title : 'Insert [cookd]', cmd : 'cookd_insert_shortcode', image: url + '/../images/icon.png' });
        },   
    });

    tinymce.PluginManager.add('cookd_button', tinymce.plugins.cookd_plugin);
});
