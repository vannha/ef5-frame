(function() {
    tinymce.PluginManager.add('ef5_highlight', function( editor, url ) {
        editor.addButton( 'ef5_highlight', {
            text: 'Highlight',
            icon: false,
            type: 'menubutton', 
            menu: [
                {
                    text: 'Accent',
                    value: 'ef5-highlight accent',
                    onclick: function() {
                        editor.insertContent('<span class="'+this.value()+'">'+tinyMCE.activeEditor.selection.getContent()+'<span>');
                    }
                },
                {
                    text: 'Primary',
                    value: 'ef5-highlight primary',
                    onclick: function() {
                        editor.insertContent('<span class="'+this.value()+'">'+tinyMCE.activeEditor.selection.getContent()+'<span>');
                    }
                }
           ]
        });
    });
    tinymce.PluginManager.add('ef5_list', function( editor, url ) {
        editor.addButton( 'ef5_list', {
            text: 'List Style',
            icon: 'mce-ico mce-i-bullist',
            type: 'menubutton', 
            menu: [
                {
                    text: 'Default',
                    value: 'ef5-list',
                    onclick: function() {
                        editor.insertContent('<ul class="'+this.value()+'""><li>'+tinyMCE.activeEditor.selection.getContent()+'</li></ul>');
                    }
                },
                {
                    text: 'Hamburger',
                    value: 'ef5-list hamburger',
                    onclick: function() {
                        editor.insertContent('<ul class="'+this.value()+'""><li>'+tinyMCE.activeEditor.selection.getContent()+'</li></ul>');
                    }
                },
                {
                    text: 'Hamburger 2',
                    value: 'ef5-list hamburger hamburger2',
                    onclick: function() {
                        editor.insertContent('<ul class="'+this.value()+'""><li>'+tinyMCE.activeEditor.selection.getContent()+'</li></ul>');
                    }
                },
                {
                    text: 'Check (Primary)',
                    value: 'ef5-list check primary',
                    onclick: function() {
                        editor.insertContent('<ul class="'+this.value()+'""><li>'+tinyMCE.activeEditor.selection.getContent()+'</li></ul>');
                    }
                },
                {
                    text: 'Check (Accent)',
                    value: 'ef5-list check accent',
                    onclick: function() {
                        editor.insertContent('<ul class="'+this.value()+'""><li>'+tinyMCE.activeEditor.selection.getContent()+'</li></ul>');
                    }
                },
                {
                    text: 'Triangle (Primary)',
                    value: 'ef5-list triangle primary',
                    onclick: function() {
                        editor.insertContent('<ul class="'+this.value()+'""><li>'+tinyMCE.activeEditor.selection.getContent()+'</li></ul>');
                    }
                },
                {
                    text: 'Triangle (Accent)',
                    value: 'ef5-list triangle accent',
                    onclick: function() {
                        editor.insertContent('<ul class="'+this.value()+'""><li>'+tinyMCE.activeEditor.selection.getContent()+'</li></ul>');
                    }
                }
           ]
        });
    });
    tinymce.PluginManager.add('ef5_quote', function( editor, url ) {
        editor.addButton( 'ef5_quote', {
            text: 'Quote',
            icon: 'mce-ico mce-i-blockquote',
            type: 'menubutton',
            menu: [
                {
                    text: 'Theme Quote',
                    value: 'ef5-quote blockquote',
                    onclick: function() {
                        var selected_text = editor.selection.getContent();
                        var return_text = '';
                        if (!selected_text.trim()) {
                            return_text = 'Add a quote text here!';
                        } else {
                             return_text = selected_text;
                        }
                        editor.insertContent('<div class="'+this.value()+'"><p class="quote-text">'+return_text+'</p><cite>John Doe</cite><span class="position">Web Developer</span></div>');
                    }
                },
           ]
        });
    });
})();
