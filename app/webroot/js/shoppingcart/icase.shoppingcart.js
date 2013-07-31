// powered by jquery cookie
// by default, cookie is independent from each tab...

(function($) {
    
    $.cookie.defaults = {path:'/'};
    var storage = {get:null, set:null};
    storage.get = $.cookie;
    storage.set = $.cookie;
    
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
            orders = [];
            orders[0] = orderId;
        } else {
            orders = orders.split(',');
            orders[orders.length] = orderId;
        }

        console.log (orders);
        orders = orders.join(",");
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
            //storage.remove(this.cookie_orders);
        } else {
            orders = orders.split(',');
            $(orders).each(
                    function(index, value) {
                        if (value == id) {
                            i = index;
                        }
                    }
            )
        }

        orders.splice(i, 1);
        if (orders.length < 1) {
            storage.remove(this.cookie_orders);
            return;
        }

        orders = orders.join(",");
        console.log (orders);
        storage.set(this.cookie_orders, orders);
    }

    ShoppingCart.prototype.removeall = function(id) {
        var orders = storage.get(this.cookie_orders);
        var j = 0;
        var left = [];
        
        if (orders == null || orders == "undefined" || orders == "") {
            storage.remove(this.cookie_orders);
        } else {
            orders = orders.split(',');
            $(orders).each(
                    function(i, value) {
                        if (value == id) {
                            return;
                        } else {
                            console.log (value);
                            left[j] = value;
                            j++;
                        }
                    }
            )
        }
        console.log("ShoppingCart.removeall");
        console.log("guid = " + id);
        console.log("left = " + left);
        console.log("left.length" + left.length);

        orders = null;
        orders = left;

        if (orders.length < 1) {
            storage.set(this.cookie_orders, "");
            return;
        }

        orders = orders.join(",");
        storage.set(this.cookie_orders, orders);
    }

    ShoppingCart.prototype.clear = function() {
        storage.set(this.cookie_orders, "");
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




