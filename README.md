iCase
==================

Version 0.1

It's delivered to http://beautahfulcreations.com

Version 0.2

It's development version, not for any production server.

Now version 2.0 => master, so I removed version 2.0 and am working on master.
That's better way, if we want to make a new site with new theme, we just branch it to another version.
Keeping master to be the updated one.

Road Map
==============

Version 0.2

1. Admin / Code Review / Bug Fix / Reusability / Test
2. Front / Code Review / Bug Fix / Reusability / Test

3. i18n - Brazil Language / Time zone / Location
4. Order - group orders for one user



2013.09.02

1. AdminAppController.php
2. AdminController.php
3. AdministratorController.php
4. MemberController.php - on working....


Update
========

Upgrade From 0.1 to 0.2

1.  all product/images - small/medium/origin -named changed from _150 to _small, _500 to _medium
2.  remove product/featured (150w/origin) - too complex and poor reusability
3.  Routers for plugin, so it's safe, avoid /admin leaked
4.  Added Maintainance Page - switch to maintainace easily
5.  Bootstrap for plugin, simply define some global constant here
6.  Component for plugin
7.  Model - debug
8.  Payment Gateway - move to component, so we can add more payment method there
9.  Order table scheme changed

SEO basic --

1. page title
2. meta keywords
3. meta description
4. img alt
5. a title
6. URL name 

    1). http://domain.com/ #must full domain name

    2). http://domain.com/products/category-url-key-C[id]

    3). http://domain.com/products/category-url-key-C[id]/product-url-key-P[id]

7. Content


Discussion
=============

About Order - 

If one user order multi different items, as one item will be in one order <db>, so there will be many orders for one user, if we can group these orders by this user, could be better...




To save the space, and utilize the resource of server - 

About Media (uploaded) - 

1. product/template image - /img/template
2. product/product image - /uploads/product (when product deleted, should be removed)

3. creator/preview image - /uploads/preview (all images should be removed on cron job)
4. creator/order image - /uploads/order
5. creator/user image - /uploads/user (when user deleted, should be removed)

6. misc - /uploads (all images should be removed on cron job)

About name convention -

javascript - 

1. global - g_function_name
2. others - function_name
3. PHP - action in javascript - $action_{action name} (same controller) / $action_{controller}_{action name} (not same)

PHP (View) - 

1. $data, $key, $value (common name)
2. $data (multi-array) : $value = $value['Model']; performance??
2. more data types, ${data type}, ....
3. 

Security
============
http://htmlpurifier.org/docs


