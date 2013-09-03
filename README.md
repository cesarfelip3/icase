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
3. Orders - Display all items in one cart at ADMIN, should be delivered at same time
4. Orders - Display Transaction ID at admin, to verify payment
5. CakePHP - core.php - if (debug == 0) model will never refreshed, if debug > 0 will refresh...
6. Media - Now ccompatiable with master branch, so we can upgrade master to version 0.1 too!

7. Order - Shipment Track 
8. Email History - Order
9. Order - Delete
10.Upgraded <Server>

11.Move creator/save - images from uploads to user/uploads
12.Cron Job to clean images in "uploads/" folder...

13.Move images to /order and /user

DON'T PULL ON SERVER


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

1. uploads/ - images uploaded from creator
2. uploads/ - images uploaded from admin/product

3. preview/ - images in ceator/preview
4. preview/ - ordered => uploads/order, user => user


Security
============
http://htmlpurifier.org/docs


