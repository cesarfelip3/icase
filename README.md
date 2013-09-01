iCase Version 0.1
==================

2013.09.01

It's delivered, and in maintainance.
Example site, http://www.beautahfulcreation.com

Every change to the source, may influence production server, don't change it if it's not necessary!!

This version is the first version published...
Every upgrade or changes will be only applied on this version, the reason is different version is for different site, so they are not same...


Update
========

2013.09.01

1. I saw the image of some product wasn't resized correctly on example site, is it a bug?
2. SEO - image alt - done


SEO basic --

1. page title - done
2. meta keywords - ?
3. meta description - done
4. img alt - done
5. a title - ?
6. URL name - done

    1). http://domain.com/ #must full domain name

    2). http://domain.com/products/category-url-key-C[id]

    3). http://domain.com/products/category-url-key-C[id]/product-url-key-P[id]

7. Content

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


