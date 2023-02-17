$(function() {
	$('#browser-pop-1').on('click', function() {
		selectFileWithCKFinder('Images','.box-images');
	});
});

function selectFileWithCKFinder( elementId, divid ) {
	CKFinder.popup( {
		chooseFiles: true,
		width: 800,
		height: 600,
		onInit: function( finder ) {
			finder.on( 'files:choose', function( evt ) {
				var file = evt.data.files.first();
				var output 	= $('#'+elementId);
				var showid 	= $(divid);
				var get_url = file.getUrl(); //Get url image
				output.val(get_url) ; // Set url image
				showid.html('<img src="'+get_url+'" style="max-width: 100%; max-height: 100%;" />');
				
			} );

			finder.on( 'file:choose:resizedImage', function( evt ) {
				var output = document.getElementById( elementId );
				output.value = evt.data.resizedUrl;
			} );
		}
	} );
}