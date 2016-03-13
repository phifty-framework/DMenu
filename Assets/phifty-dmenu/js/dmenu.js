
var DMenuManager = {
    currentParent: null,
	currentLang: null,
    container: null
};



DMenuManager.init = function(el,sortableOpts) {

    if( typeof jQuery === 'undefined' ) {
        alert('jQuery is required.');
    }
    if( typeof $.facebox === 'undefined' ) {
        alert('facebox is requried');
    }

    $.facebox.settings.closeImage = '/assets/facebox/src/closelabel.png';
    $.facebox.settings.loadingImage = '/assets/facebox/src/loading.gif';

    var self = this;
    this.container = $(el);
    this.container.sortable( $.extend({
        update: function(event,ui) { 
            var items = self.getItems();
            var cnt = 0;
            var orderingData = items.map( function(i,val) { 
                var id = parseInt($(val).data().id); 
                return { 
                    record: id,
                    order: cnt++
                };
            });
            var jsondata = JSON.stringify(orderingData.toArray());
            runAction('DMenu::Action::UpdateOrdering',{ json: jsondata }, function(resp) {
            });

            self.updatePreview();
        },
        change: function(event,ui) { }

        },sortableOpts) );

    this.appendNav( 'MenuTop' );
    // $( "#sortable" ).disableSelection();

};

DMenuManager.getItems = function() {
    return this.container.find('.menu-item');
};

DMenuManager.createMenuItem = function(params,cb) {
    var self = this;
    if( this.currentParent )
        params.parent = this.currentParent;
    else
        params.parent = 0;

	if( this.currentLang )
		params.lang = this.currentLang;

    if( ! cb ) cb = function(resp) {
        self.refresh();
    };
    runAction('DMenu::Action::CreateMenuItem', params , cb );
};

DMenuManager.showMenuItemForm = function( params ) {
    var self = this;

    if( this.currentParent )
        params.parent = this.currentParent;
    else
        params.parent = 0;

	if( this.currentLang )
		params.lang = this.currentLang;

    $.facebox(function() {
        $.get( '/dmenu/menu_form' , params , function(html) {
            $.facebox(html);
            var dialog = $('#facebox .content');
            var form = $(dialog.find('form').get(0));
            console.log(form);
            Action.form(form,{
                status: true, 
                clear: true, 
                onSuccess: function(data) {
                    setTimeout(function() {
                        $.facebox.close();
                        self.refresh();
                    }, 800);
                }
            });
        });
    });
};

DMenuManager.editMenuItem = function(params) {
    var self = this;
    $.facebox(function() {
        $.get( '/dmenu/menu_form' , { id: params.id } , function(html) {
            $.facebox(html);
            var dialog = $('#facebox .content');
            var form = $(dialog.find('form').get(0));
            if( ! form.get(0) )
                alert('form element not found');

            Action.form( form, {
                    status: true,
                    clear: true,
                    onSuccess: function(data) {
                            setTimeout(function() {
                                $.facebox.close();
                                self.refresh();
                            }, 800);
                    }
            });
        });
    });
};


DMenuManager._renderItem = function(data) {
    var self = this;
    function addControll(text,cb) {
        return $('<button/>').addClass('menu-item-btn').text(text).click(cb);
    }

    // construct a new node
    var itemDiv = $('<li/>').addClass('menu-item ui-state-default');
    itemDiv.append( $('<span/>').addClass('ui-icon ui-icon-arrowthick-2-n-s') );

    var label = $('<a/>').html(data.label).addClass(data.type);
    var typeLabel = $('<span/>').addClass('desc').html(data.type );

    switch( data.type ) {
        case "folder":
            label.click(function() {
                // item is a folder, when user click on this,
                // we should refresh the menu editor, to list items which parent is this current item.
                self.advance( data );
            });
        break;
        case "link":
            label.attr({ href: data.data , target: '_blank' });
        break;
    }

    itemDiv.append( label );
    itemDiv.append( typeLabel );

    itemDiv.data( data );

    var controll = $('<span/>').addClass('menu-item-controll');
    var editBtn = addControll(_('Edit'),function() {
            self.editMenuItem(data);
            return false;
        });
    var delBtn = addControll( _('Delete'), function() {
            if ( confirm('確定刪除?') ) {
                // run action to delete it and fade out, remove item
                runAction('DMenu::Action::DeleteMenuItem',{ id: itemDiv.data().id }, {
                    remove: itemDiv
                }, function(resp) { 
                    self.updatePreview();
                });
            }
            return false;
        });
    controll.append( editBtn ).append( delBtn );
    itemDiv.append( controll );
    return itemDiv;
};

/* render and append items to the container */
DMenuManager.renderItems = function(items) {
    var self = this;
    for( var i in items ) {
        var item = items[i];
        var itemDiv = self._renderItem(item);
        self.container.append( itemDiv );
    }
};

DMenuManager.appendNav = function(text,parentId) {
    var self = this;
    var nav = $('<span/>').html('&gt; ' + text);
    nav.click(function() {
        if( parentId ) {
            self.currentParent = parentId;
            self.update({ lang: self.currentLang, parent: parentId });
        } else {
            self.currentParent = null;
            self.update({ lang: self.currentLang });
        }
        // remove next nav childs.
        $(this).nextAll().remove();
    });
    $('.menu-editor .nav').append( nav );
};

DMenuManager.wait = function(msg) {
    $('.menu-editor .status').html( 
        $('<div/>').addClass('ajax-loading').html(msg) );
};

DMenuManager.ready = function() {
    $('.menu-editor .status').empty();
};

DMenuManager.advance = function(item) {
    var self = this;
    self.appendNav( item.label , item.id );
    self.currentParent = item.id;
    self.update({ lang: self.currentLang, parent: item.id });
};

DMenuManager.refresh = function() {
	var lang = this.currentLang;
    if( this.currentParent )
        this.update({ lang: lang , parent: this.currentParent });
    else
        this.update({ lang: lang });
};

DMenuManager.updatePreview = function(query) {
	query = query || {};
    $.get('/dmenu/preview_menu_tree',query,function(html) {
        $('.preview-menu-tree .content').html( html );
    });
};

DMenuManager.update = function(query) {
	query = query || {};
    var self = this;
    self.wait( 'Updating Menu...' );

	if ( query.lang ) {
		this.currentLang = query.lang;
    }

    this.updatePreview(query);
    this.container.hide('slideRight',function() {
        self.container.empty();
        self.fetchItems(query,function(items) {
            self.renderItems(items);
            self.container.show('slideLeft');
            self.ready();
        });
    });
};

DMenuManager.fetchItems = function(query,cb) {
    query = query || {};
    // Get and render top level menu items
    $.getJSON('/dmenu/api/get_menu_items', query, cb );
};

