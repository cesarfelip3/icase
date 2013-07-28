// powered by jquery plugin - storage 1.4


(function($) {
    var storage = $.cookieStorage;
    
    var ShoppingCart = function () {
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

    }

    ShoppingCart.prototype.set = function(orderId) {
        var orders = storage.get(this.cookie_orders);

        if (orders == null || orders == "undefined" || orders == "") {
            this.orders[0] = orderId;
        } else {
            this.orders = orders.split(',');
            this.orders[this.orders.length] = orderId;
        }

        orders = this.orders.join(",");
        storage.set(this.cookie_orders, orders);
    }

    ShoppingCart.prototype.get = function() {
        var orders = storage.get(this.cookie_orders);

        if (orders == null || orders == "undefined" || orders == "") {
            return null;
        }

        return orders;
    }

    ShoppingCart.prototype.remove = function(id) {
        var orders = storage.get(this.cookie_orders);
        var i = 0;

        if (orders == null || orders == "undefined" || orders == "") {
            storage.remove(this.cookie_orders);
        } else {
            this.orders = orders.split(',');
            $(this.orders).each(
                    function(index, value) {
                        if (value == id) {
                            i = index;
                        }
                    }
            )
        }

        this.orders.splice(i, 1);
        if (this.orders.length < 1) {
            storage.remove(this.cookie_orders);
            return;
        }

        orders = this.orders.join(",");
        storage.set(this.cookie_orders, orders);
    }

    ShoppingCart.prototype.removeall = function(id) {
        var orders = storage.get(this.cookie_orders);
        var i = 0;
        var j = 0;
        var left = [];

        if (orders == null || orders == "undefined" || orders == "") {
            storage.remove(this.cookie_orders);
        } else {
            this.orders = orders.split(',');
            $(this.orders).each(
                    function(index, value) {
                        if (value == id) {
                            i = index;
                        } else {
                            left[j] = value;
                            j++;
                        }
                    }
            )
        }
        console.log("ShoppingCart.removeall");
        console.log("guid = " + id);
        console.log("orders = " + orders);

        this.orders = null;
        this.orders = left;

        if (this.orders.length < 1) {
            storage.remove(this.cookie_orders);
            return;
        }

        orders = this.orders.join(",");
        storage.set(this.cookie_orders, orders);
    }

    ShoppingCart.prototype.clear = function() {
        storage.remove('orders');
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
        console.log (uuid);
        storage.set(this.cookie_uuid, uuid);
    }

    ShoppingCart.prototype.getuuid = function() {
        var uuid = storage.get(this.cookie_uuid);
        console.log (uuid);
        
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
    $.shoppingcart = new ShoppingCart ();
    

}(window.jQuery));




