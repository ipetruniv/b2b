$(document).ready(function(){
	$('.buyerPrice').change(function(){
		var user = $('.buyerPrice option:selected').val();
		$.ajax({
		  type: 'POST',
		  url: '/setUserPrice',
		  data: {user:user},
		  success: function(data){
		    if(data.type)
		    	location.reload();
		    else
		    	alert('FATAL ERROR!!!');
		  }
		});
	})
})