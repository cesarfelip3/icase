Business Card Designer
=======================

Suggestion for integration:

1. User browse the category and choose a template
2. From db, we get template width/height and id, so we can decide template specification and its price

3. Pass width/height to the editing tool page
4. editing tool create canvas based on width/height
5. save - will require user login/register

6. save will HTTP/POST - 
    XML : SVG data for design
    SESSION DATA : user name / user id
    id : template id - from this we can get single page price
    sales type : 1 page, 20 pages or more

    {"content":SVG data, "template_id":id}

7. from PHP, $_POST['content'], $_POST['template_id']

for db :

    category_id
    user_id
    user_name
    name : it's type name/size/industry, for example, Flyer-A6-Beautiful-Helthy

    page_front : SVG for front page design
    page_back : SVG for back page design

    status : draft or publish
    created : created time stamp
    modified : last modified time stamp

    industry : industry name, for exmple, beautiful-healthy
    size : size name, for exmple A6
    
    width : 88mm, for example
    height : 150mm, for exmaple
    
    price : the single page design and print price, for front and back for 1 paper

    thumbnails : save template thumbnails, small one, and large one
    output : save PDF file name


Update
=========

2013.09.11 - 2013.09.21

2013.09.13 - rest

https://github.com/kangax/fabric.js/issues/781
2013.09.14 - scroll bug fixed, 1.12.11

1.2.11 performance of addgrid is poor

2013.09.14
2013.09.23
2013.09.26

1.  image editor - crop - done
2.  Shape controls - fill - closed
7.  fixed - toBack / toFront ...
3.  preview - done
4.  save - done
5.  reload - done
6.  edit two side - done
7.  font type - a simple version - done - for all default web fonts only
8.  All css now independent one
9.  undo - done (exclude remove, and redo)
11. database tables - created - done
10. PDF - tested - good
11. Template - moved

TCPDF

1. use mm to be the default measure unit, so the A4 is 210mm x 297mm
2. for SVG, remember to do x = 0, y = 0, width = '210', height = '297', mm too
3. Custom page parameter, then AddPage, example_058.php is the demo

Discussion
===========

undo/redo - complex, no good solution yet.






