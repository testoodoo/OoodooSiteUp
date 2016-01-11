<script>
	$(document).ready(function(){

		var new_customer_id = $('input[name="new_customer_id"]').val();
		alert(new_customer_id);

		$.ajax({
			url : '/admin/activation/post',
			type : 'POST',
			data : { fn : 'customer_to_account', new_customer_id : new_customer_id }
		})
	});
</script>