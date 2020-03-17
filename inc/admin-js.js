/* Custom JavaScript Code for Plugin Admin Side*/
$ = jQuery;
var ajaxUrl = "../wp-admin/admin-ajax.php";
$(document).ready(function($){
	// Task : UN2-T4
	$('.unidress_budget').change(function() {
		var user_id = $(this).data('id');
		var budget_value = $(this).val();
		if(budget_value){
			var str = '&action=unidress_narola_save_budget_option&user_id='+user_id+'&budget_value='+budget_value;
			jQuery.ajax({
				type: "POST",
				dataType: "html",
				url: ajaxUrl,
				data: str,
				success: function(data){
					console.log(data);
				},
				error: function(jqXHR, textStatus, errorThrown){
					console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
				}
			});
		}
	});
});