// powered by jquery plugin - storage 1.4

var $ = jQuery.noConflict ();

var shoppingcart = {
    orderIds: null,
    orders: [],
    orderKeys: [],
    init: null,
    set: null,
    get: null,
    remove: null,
    clear: null
}

shoppingcart.init = function () {
    
}

shoppingcart.set = function (order) {
    var ids = storage.get ('orderIds');
    if (ids !== null && ids !== 'undefined') {
        ids = ids + ',' + order.id;
    } else {
        ids = order.id;
    }
    
    shoppingcart.orderIds = all;
    storage.set ('orderIds', shoppingcart.orderIds);
    
    var i = 0;
    $(order).each (
        function (key, value) {
            storage.set (order.id + '_' + key, value);
            if (orderKeys === null) {
                orderKeys[i++] = key;
            }
        }
    )
}

shoppingcart.get = function (id) {
    var ids = storage.get ('orderIds');
    if (ids == null || ids == "undefined") {
        shoppingcart.orders = [];
        return;
    }
    
    shoppingcart.orderIds = ids;
    
    $(shoppingcart.orderIds.split(",")).each (
        function (index, value) {
            var order;
            
            order = {};
            order[id] = value;
            $(shoppingcart.orderKeys).each (
                function (i, k) {
                    order[k] = storage.get (order.id + '_' + key);
                }
            )
            
            shoppingcart.orders[index] = order;
        }
    )
}

shoppingcart.remove = function (id) {
    var ids = storage.get ('orderIds');
    if (ids == null || ids == "undefined") {
        return;
    }
    
    shoppingcart.orderIds = ids;
    
    ids = shoppingcart.orderIds.split(",");
    
    var i = 0;
    $(ids).each (
        function (index, value) {
            if (id == value) {
                $(shoppingcart.orderKeys).each (
                    function (i, k) {
                        storage.remove (order.id + '_' + key);
                    }
                );
                i = index;
            }
        }
    );
    
    ids.splice (index, 1);
    shoppingcart.orderIds = ids.join (",");
    
    storage.remove ('orderIds');
    storage.set ('orderIds', shoppingcart.orderIds);
}

shoppingcart.clear = function () {
    shoppingcart.orderIds = null;
    shoppingcart.orderKeys = null;
    shoppingcart.orders = [];
    
    storage.removeAll();
}