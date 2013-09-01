iCase Version 2.0
==================


Update
========


Upgrade From 0.1 to 0.2

1. all product/images - small/medium/origin -named changed from _150 to _small, _500 to _medium
2. remove product/featured (150w/origin) - too complex and poor reusability
3. Not tested yet




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

Test
========

2013.08.25

1. AppController
2. AuthController
3. IndexController
4. ShopController - cart, checkout

Discussion
=============

To save the space, and utilize the resource of server - 

About Media (uploaded) - 

1. product/template image - /img/template
2. product/product image - /uploads/product (when product deleted, should be removed)

3. creator/preview image - /uploads/preview (all images should be removed on cron job)
4. creator/order image - /uploads/order
5. creator/user image - /uploads/user (when user deleted, should be removed)

6. misc - /uploads (all images should be removed on cron job)

Security
============
http://htmlpurifier.org/docs


