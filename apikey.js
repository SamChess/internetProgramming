$(document).ready(function() {

	$('#api-key-btn').click((event) => {

		
		$.ajax({
			url: 'apikey.php',
			type: 'post',
			success: function(data) {
				if (data['success'] == 1) {
					$('#api_key').val(data['message']);
				} else {
					alert("Something went wrong. Please try again");
				}
			},
			error: function(error) {
				console.log(error);
			}

		});

	});

});