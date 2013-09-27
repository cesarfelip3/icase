// powered by jquery cookie
// by default, cookie is independent from each tab...

(function($) {

    $.cookie.defaults = {path: '/'};
    var storage = {get: null, set: null};
    storage.get = $.cookie;
    storage.set = $.cookie;

    var ShoppingCart = function() {
        // this - refer to class
    }

    ShoppingCart.prototype = {
        constructor: ShoppingCart,
        storage: storage,
        // orders
        cookie_orders: "orders",
        orders: [],
        index: 0,
        init: null,
        set: null,
        get: null,
        total: null,
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
        product: null,
        cookie_current_product: "current-product-id",
        clearCurrentProductId: null,
        setCurrentProductId: null,
        getCurrentProductId: null
    }

    ShoppingCart.prototype.init = function() {
        return this;
    }

    ShoppingCart.prototype.set = function(orderId, count) {
        var orders = storage.get(this.cookie_orders);

        if (orders == null || orders == "undefined" || orders == "") {
            orders = [];
        } else {
            orders = JSON.parse(orders);
        }

        var had = false;
        for (var i = 0; i < orders.length; ++i) {
            var order = orders[i];
            if (order.id == orderId) {
                order.quantity += count;
                orders[i] = order;
                had = true;
            }
        }

        if (!had) {
            var order = new Object();
            order.id = orderId;
            order.quantity = count;
            orders[orders.length] = order;
        }

        orders = JSON.stringify(orders);
        //console.log(orders);
        storage.set(this.cookie_orders, orders);
    }

    ShoppingCart.prototype.get = function() {
        var orders = storage.get(this.cookie_orders);

        if (orders == null || orders == "undefined" || orders == "") {
            return null;
        }

        return orders;
    }

    ShoppingCart.prototype.total = function() {
        var orders = storage.get(this.cookie_orders);

        if (orders == null || orders == "undefined" || orders == "") {
            return 0;
        }

        orders = JSON.parse(orders);
        return orders.length;
    }

    ShoppingCart.prototype.remove = function(orderId) {
        var orders = storage.get(this.cookie_orders);
        var i = 0;

        if (orders == null || orders == "undefined" || orders == "") {
            return;
        } else {
            
            orders = JSON.parse(orders);
            var j = 0;
            var o = [];
            
            for (var i = 0; i < orders.length; ++i) {
                var order = orders[i];
                
                if (order.id == orderId) {
                    order.quantity -= 1;
                    if (order.quantity > 0) {
                        o[j] = order;
                        j++;
                    }
                }
            }
        }
        
        orders = null;
        orders = o;
        
        if (orders.length == 0) {
            orders = "";
        } else {
            orders = JSON.stringify(orders);
        }
        //console.log (orders);
        storage.set(this.cookie_orders, orders);
    }

    ShoppingCart.prototype.removeall = function(orderId) {
        var orders = storage.get(this.cookie_orders);
        var i = 0;

        if (orders == null || orders == "undefined" || orders == "") {
            return;
        } else {
            
            orders = JSON.parse(orders);
            var o = [];
            var j = 0;
            
            for (var i = 0; i < orders.length; ++i) {
                var order = orders[i];
                
                if (order.id == orderId) {
                    continue;
                } else {
                    o[j] = order;
                    j++;
                }
            }
        }

        orders = o;
        if (orders.length == 0) {
            orders = "";
        } else {
            orders = JSON.stringify(orders);
        }
        //console.log (orders);
        storage.set(this.cookie_orders, orders);
    }

    ShoppingCart.prototype.clear = function() {
        storage.set(this.cookie_orders, JSON.stringify({}));
        //storage.removeAll();
    }

    ShoppingCart.prototype.inituuid = function(callback) {
        var uuid = storage.get(this.cookie_uuid);

        if (uuid == null || uuid == 'undefined') {
            callback();
        } else {
            this.user = uuid;
        }
    }

    ShoppingCart.prototype.setuuid = function(uuid) {
        ////console.log (uuid);
        storage.set(this.cookie_uuid, uuid);
    }

    ShoppingCart.prototype.getuuid = function() {
        var uuid = storage.get(this.cookie_uuid);
        ////console.log (uuid);

        if (uuid == null || uuid == 'undefined') {
            return null;
        }

        return uuid;
    }

    ShoppingCart.prototype.cookie = function() {
        var TEST_COOKIE = 'test_cookie';
        $.cookie(TEST_COOKIE, true);
        if ($.cookie(TEST_COOKIE))
        {
            $.cookie(TEST_COOKIE, null);
            return true;
        }
        else
        {
            return false;
        }
    }

    ShoppingCart.prototype.clearCurrentProductId = function() {
        storage.set(this.cookie_current_product, null);
    }

    ShoppingCart.prototype.setCurrentProductId = function(id) {
        if (id == null || id == 'undefined') {
            storage.set(this.cookie_current_product, null);
        } else {
            storage.set(this.cookie_current_product, id);
        }
    }

    ShoppingCart.prototype.getCurrentProductId = function() {
        var id = storage.get(this.cookie_current_product);

        if (id == null || id == 'undefined') {
            return null;
        }

        this.product = id;
        return this.product;
    }

    // an instance <= a class - $.shoppingcart._proto_ = ShoppingCart.prototype
    $.shoppingcart = new ShoppingCart();


}(window.jQuery));




