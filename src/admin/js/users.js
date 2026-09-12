$(document).ready(function(){

	getUsers();

	function getUsers(){
		$.ajax({
			url : '../admin/classes/Users.php',
			method : 'POST',
			data : {GET_USERS:1},
			success : function(response){
				
				console.log(response);
				var resp = $.parseJSON(response);
				if (resp.status == 202) {

					var usersHTML = "";

					$.each(resp.message, function(index, value){

						usersHTML += '<tr>'+
									          '<td>'+value.UserID+'</td>'+
									          '<td>'+value.UserName+'</td>'+
									          '<td>'+value.Email+'</td>'+
									          '<td>'+value.Phone+'</td>'+
									          '<td>'+value.areaName+'</td>'+
											  '<td><a UserID="'+value.UserID+'" class="btn btn-sm btn-danger delete-user"><i class="fas fa-trash-alt"></i></a></td>'+
									       '</tr>'

					});

					$("#user_list").html(usersHTML);

				}else if(resp.status == 303){
					$("#user_list").html(resp.message);

				}
			}
		})
	}
	
	$(document.body).on('click', '.delete-user', function(){

		var UserID = $(this).attr('UserID');

		Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure to delete this user",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f472b6',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
			$.ajax({
				url : '../admin/classes/Users.php',
				method : 'POST',
				data : {DELETE_USER:1, UserID:UserID},
				success : function(response){
					var resp = $.parseJSON(response);
					if (resp.status == 202) {
						Swal.fire({text: resp.message, confirmButtonColor: '#c084fc'});
						getUsers();
					}else if(resp.status == 303){
						Swal.fire({text: resp.message, confirmButtonColor: '#c084fc'});
					}
				}
			})
		} else {
			Swal.fire({text: 'Cancelled', confirmButtonColor: '#c084fc'});
		}
        });
	});

});