$(function() {
	
	$(document).find('.sortable-list').each(function() {
		
		var sortAble 		= $(this).attr('id'); //return sortable-demo (id)
		var sortAblePull 	= $(this).attr('data-pull'); //return string
		
		new Sortable(document.getElementById(sortAble), {
			group: {
				name: 'shared',
				pull: convertPullStatus(sortAblePull) // To clone: set pull to 'clone'
			},
			animation: 150
		});
	});
	
});