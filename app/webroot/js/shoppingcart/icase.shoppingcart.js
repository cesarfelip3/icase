// powered by jquery plugin - storage 1.4
storage=jQuery.cookieStorage;

var shoppingcart = {
    orders: [],
    index: 0,
    user: null,
    uuidUrl: null,
    uuid: null,
    getuuid: null,
    init: null,
    set: null,
    get: null,
    remove: null,
    clear: null,
    cookie: null,
}

shoppingcart.init = function (url) {
    
    if (url != null) {
        shoppingcart.uuidUrl = url;
    }
}

shoppingcart.set = function (orderId) {
    var orders = storage.get ('orders');
    console.log ('orders = ' + orders);
    
    if (orders == null || orders == "undefined" || orders == "") {
        shoppingcart.orders[0] = orderId;
    } else {
        shoppingcart.orders = orders.split (',');
        shoppingcart.orders[shoppingcart.orders.length] = orderId;
    }
    
    console.log (shoppingcart.orders);
    
    orders = shoppingcart.orders.join(",");
    storage.set ('orders', orders);
}

shoppingcart.get = function () {
    var orders = storage.get ('orders');
    
    if (orders == null || orders == "undefined" || orders == "") {
        return null;
    }
    
    return storage.get ('orders');
}

shoppingcart.remove = function (id) {
    var orders = storage.get ('orders');
    console.log ('orders = ' + orders);
    var i = 0;
    
    if (orders == null || orders == "undefined" || orders == "") {
        storage.remove ('orders');
    } else {
        shoppingcart.orders = orders.split (',');
        jQuery(shoppingcart.orders).each (
            function (index, value) {
                if (value == id) {
                    i = index;
                }
            }
        )
    }
    
    shoppingcart.orders.splice (i, 1);
    if (shoppingcart.orders.length < 1) {
        storage.remove ('orders');
        return;
    }
    
    console.log (shoppingcart.orders);
    
    orders = shoppingcart.orders.join(",");
    storage.set ('orders', orders);
}

shoppingcart.removeall = function (id) {
    var orders = storage.get ('orders');
    console.log ('orders = ' + orders);
    var i = 0;
    var left = [];
    var j = 0;
    
    if (orders == null || orders == "undefined" || orders == "") {
        storage.remove ('orders');
    } else {
        shoppingcart.orders = orders.split (',');
        jQuery(shoppingcart.orders).each (
            function (index, value) {
                if (value == id) {
                    i = index;
                } else {
                    left[j] = value;
                    j++;
                }
            }
        )
    }
    
    shoppingcart.orders = null;
    shoppingcart.orders = left;
    
    if (shoppingcart.orders.length < 1) {
        storage.remove ('orders');
        return;
    }
    
    console.log (shoppingcart.orders);
    
    orders = shoppingcart.orders.join(",");
    storage.set ('orders', orders);
}

shoppingcart.clear = function () {
    
    storage.removeAll();
}

shoppingcart.uuid = function () {
    var uuid = storage.get ('uuid');
    
    if (uuid == null || uuid == 'undefined') {
        jQuery.ajax({
            url: shoppingcart.uuidUrl,
            type: "GET",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {
            if (jQuery.trim (data) == "") {
                return;
            }
            
            if (data == null) {
                return;
            }
            console.log ('uuid:' + data);
            shoppingcart.user = data;
    
        }).fail(function() {
            
        });
    } else {
        shoppingcart.user = uuid;
    }
    
}

shoppingcart.getuuid = function (callback) {
    var uuid = storage.get ('uuid');
    
    if (uuid == null || uuid == 'undefined') {
        return (function () {return "";})();
    }
    
    shoppingcart.user = uuid;
    return (function(){return shoppingcart.user})();
}

shoppingcart.cookie = function () {
    var TEST_COOKIE = 'test_cookie';
    jQuery.cookie( TEST_COOKIE, true );
    if ( jQuery.cookie ( TEST_COOKIE ) )
    {
      jQuery.cookie( TEST_COOKIE, null );  
      return ((function() {return true})());
    }
    else
    {
      return (function () { return false })();
    }
}

