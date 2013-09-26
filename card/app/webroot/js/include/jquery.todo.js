/*         ______________________________________
  ________|                                      |_______
  \       |        Peach Realestate Theme        |      /
   \      |    Copyright © 2012 MyOrange.ca      |     /
   /      |______________________________________|     \
  /__________)                                (_________\

 * This is part of an item on wrapbootstrap.com
 * https://wrapbootstrap.com/user/myorange
 *
 * ==================================
 * 
 *  First Author: Koesmanto Bong (koesbong@gmail.com) http://web.koesbong.com | Second Author: Sunnyat Ahmmed (myplaneticket@gmail.com) | http://MyOrange.ca
 *  Single licensed under the CC Attribution (http://creativecommons.org/licenses/by/3.0/)
 *  Authors will not be held responsible for any damages or losses todo.js code might cause - use and modify at your own risk
 *
 */


$(function() {
	var i = Number(localStorage.getItem('todo-counter')) + 1, 
			j = 0, 
			k, 
			$removeLink = $('#show-items li button'), 
			$itemList = $('#show-items'), 
			$clearAll = $('#clear-all'), 
			$newTodo = $('#todo'), 
			order = [], 
			orderList;

	// Load todo list
	orderList = localStorage.getItem('todo-orders');

	orderList = orderList ? orderList.split(',') : [];

	for ( j = 0, k = orderList.length; j < k; j++) {
		$itemList.append("<li id='" + orderList[j] + "'>" + "<span class='editable'>" + localStorage.getItem(orderList[j]) + "</span> <button></button></li>");
	}


	$('.add-to-list-js').click(function(e) {
	    e.preventDefault();
		var title = $(this).attr('data-shortlist');
		var $propertyID = $(this).attr('id');
		$(this).css( 'background-color', '#B9B9B9' )
			   .css( 'color', '#FFF')
			   .css('padding', '3px 5px 3px 2px') //add these in CSS value
			   .css('margin-left', '3px')
			   .css('text-decoration', 'none')
			   .css('-moz-transition', 'background  .2s ease-in')
			   .css('-webkit-transition', 'background  .2s ease-in')
			   .css('-o-transition', 'background  .2s ease-in')
			   .css('transition', 'background  .2s ease-in')
			
		if ($('.shortlist li').find("#"+$propertyID).length == 0) {
			console.log("item NOT found..adding new item");
			$.publish('/add/', [title]);
			 calculateShortListCount();
		}/*else {
			console.log("item is found");
			$('.shortlist li').filter(function(index) {
			  return $("#"+propertyID, this).length == 1;
			}).css('background-color', 'red');
		};*/
	});



	// Remove todo
	$itemList.delegate('button', 'click', function(e) {
		var $this = $(this);
		e.preventDefault();
		$.publish('/remove/', [$this]);
		
	});

	// Sort todo
	$itemList.sortable({
		revert : 50,
		stop : function() {
			$.publish('/regenerate-list/', []);
		}
	});


	// Clear all
	$clearAll.click(function(e) {
		e.preventDefault();
		$.publish('/clear-all/', []);
		console.log("All notes deleted");
		calculateShortListCount();
	});

	// Fade In and Fade Out the Remove link on hover
	$itemList.delegate('li', 'mouseover mouseout', function(event) {
		var $this = $(this).find('button');

		if (event.type === 'mouseover') {
			$this.stop(true, true).fadeIn();
		} else {
			$this.stop(true, true).fadeOut();
		}
	});


$.subscribe('/add/', function(title) {
    var value = title;

    if (value) {
        // Take the value of the input field and save it to localStorage
        localStorage.setItem( 
            "todo-" + i, value 
        );
         
        // Set the to-do max counter so on page refresh it keeps going up instead of reset
        localStorage.setItem(
            'todo-counter', i
        );
         
        // Append a new list item with the value of the new todo list
        $itemList.append(
            "<li id='todo-" + i + "'>"
            + "<span class='editable'>"
            + localStorage.getItem("todo-" + i)
            + " </span><button></button></li>"
        );
 
        $.publish('/regenerate-list/', []);
 
        // Hide the new list, then fade it in for effects
        $("#todo-" + i).css('display', 'none').fadeIn();
         
        // Empty the input field
        $newTodo.val("");
         
        i++;
    }
});

	$.subscribe('/remove/', function($this) {
		var parentId = $this.parent().attr('id');

		// Remove todo list from localStorage based on the id of the clicked parent element
		localStorage.removeItem("'" + parentId + "'");

		// Fade out the list item then remove from DOM
		$this.parent().fadeOut(function() {
			$this.parent().remove();
			$.publish('/regenerate-list/', []);
			calculateShortListCount();
		});
	});

	$.subscribe('/regenerate-list/', function() {
		var $todoItemLi = $('#show-items li');
		// Empty the order array
		order.length = 0;

		// Go through the list item, grab the ID then push into the array
		$todoItemLi.each(function() {
			var id = $(this).attr('id');
			order.push(id);
		});

		// Convert the array into string and save to localStorage
		localStorage.setItem('todo-orders', order.join(','));
	});

	$.subscribe('/clear-all/', function() {
		var $todoListLi = $('#show-items li');

		order.length = 0;
		localStorage.clear();
		$todoListLi.remove();
	});
});

