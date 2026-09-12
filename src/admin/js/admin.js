$(document).ready(function(){

	getAdmins();
	
	function getAdmins(){
		$.ajax({
			url : '../admin/classes/Admin.php',
			method : 'POST',
			data : {GET_ADMIN:1},
			success : function(response){
				console.log(response);
				var resp = $.parseJSON(response);

				if (resp.status == 202) {
					var adminHTML = '';

					$.each(resp.message, function(index, value){
						adminHTML += '<tr>'+
										'<td data-label="#">'+ value.id +'</td>'+
										'<td data-label="Name">'+ value.name +'</td>'+
										'<td data-label="Email">'+ value.email +'</td>'+
									'</tr>';
					});

					$("#admin_list").html(adminHTML);

				}else if(resp.status == 303){
					$("#admin_list").html(resp.message);
				}

			}
		})
		
	}

});