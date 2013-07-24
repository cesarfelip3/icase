// powered by jquery plugin - storage 1.4
storage=jQuery.cookieStorage;

var shoppingcart = {
    
    // orders
    cookie_orders: "orders",
    orders: [],
    index: 0,
    init: null,
    set: null,
    get: null,
    remove: null,
    clear: null,
    cookie: null,
    
    // guest uuid
    user: null,
    cookie_uuid: "uuid",
    inituuid: null,
    setuuid: null,
    getuuid: null,
    
    // current product
    cookie_current_product: "current-product-id",
    clearCurrentProductId: null,
    setCurrentProductId: null,
    getCurrentProductId: null
}

shoppingcart.init = function () {
    
}

shoppingcart.set = function (orderId) {
    var orders = storage.get (shoppingcart.cookie_orders);
    
    if (orders == null || orders == "undefined" || orders == "") {
        shoppingcart.orders[0] = orderId;
    } else {
        shoppingcart.orders = orders.split (',');
        shoppingcart.orders[shoppingcart.orders.length] = orderId;
    }
    
    orders = shoppingcart.orders.join(",");
    storage.set ('orders', orders);
}

shoppingcart.get = function () {
    var orders = storage.get (shoppingcart.cookie_orders);
    
    if (orders == null || orders == "undefined" || orders == "") {
        return (function () {return null})();
    }
    
    return (function () {return orders})();
}

shoppingcart.remove = function (id) {
    var orders = storage.get (shoppingcart.cookie_orders);
    var i = 0;
    
    if (orders == null || orders == "undefined" || orders == "") {
        storage.remove (shoppingcart.cookie_orders);
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
        storage.remove (shoppingcart.cookie_orders);
        return;
    }
    
    orders = shoppingcart.orders.join(",");
    storage.set (shoppingcart.cookie_orders, orders);
}

shoppingcart.removeall = function (id) {
    var orders = storage.get (shoppingcart.cookie_orders);
    var i = 0;
    var j = 0;
    var left = [];
    
    if (orders == null || orders == "undefined" || orders == "") {
        storage.remove (shoppingcart.cookie_orders);
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
    console.log ("shoppingcart.removeall");
    console.log ("guid = " + id);
    console.log ("orders = " + orders);
    
    shoppingcart.orders = null;
    shoppingcart.orders = left;
    
    if (shoppingcart.orders.length < 1) {
        storage.remove (shoppingcart.cookie_orders);
        return;
    }
    
    orders = shoppingcart.orders.join(",");
    storage.set (shoppingcart.cookie_orders, orders);
}

shoppingcart.clear = function () {
    storage.remove ('orders');
    //storage.removeAll();
}

shoppingcart.inituuid = function (callback) {
    var uuid = storage.get (shoppingcart.cookie_uuid);
    
    if (uuid == null || uuid == 'undefined') {
        callback ();
    } else {
        shoppingcart.user = uuid;
    }
}

shoppingcart.setuuid = function (uuid) {
    storage.set (shoppingcart.cookie_uuid, uuid);
}

shoppingcart.getuuid = function (callback) {
    var uuid = storage.get (shoppingcart.cookie_uuid);
    
    if (uuid == null || uuid == 'undefined') {
        return (function () {return null;})();
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

shoppingcart.clearCurrentProductId = function () {
    storage.set (shoppingcart.cookie_current_product, null);
}

shoppingcart.setCurrentProductId = function (id) {
    if (id == null || id == 'undefined') {
        storage.set (shoppingcart.cookie_current_product, null);
    } else {
        storage.set (shoppingcart.cookie_current_product, id);
    }
}

shoppingcart.getCurrentProductId = function () {
    var id = storage.get (shoppingcart.cookie_current_product);
    
    if (id == null || id == 'undefined') {
        return (function () {return null;})();
    }
    
    return (function(){return id})();    
}

