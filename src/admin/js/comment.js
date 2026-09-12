$(document).ready(function(){

	getcomment();

	function getcomment(){
		$.ajax({
			url : '../admin/classes/comment.php',
			method : 'POST',
			data : {GET_COMMENT:1},
			success : function(response){
				
				console.log(response);
				var resp = $.parseJSON(response);
				if (resp.status == 202) {

					var commentHTML = "";

					$.each(resp.message, function(index, value){

						commentHTML += '<tr>'+
									          '<td>'+value.commentID+'</td>'+
									          '<td>'+value.Details+'</td>'+
									          '<td>'+value.UserID+'</td>'+
									          '<td>'+value.un+'</td>'+
									          '<td>'+value.ProductId+'</td>'+
											  '<td>'+value.an+'</td>'+
											  '<td><a commentID="'+value.commentID+'" class="btn btn-sm btn-sakura delete-comment"><i class="fas fa-trash-alt"></i></a></td>'+
									       '</tr>'

					});

					$("#comment_list").html(commentHTML);

				}else if(resp.status == 303){
					$("#comment_list").html('<tr><td colspan="7" class="text-center text-muted py-4"><i class="fas fa-inbox fa-2x mb-3 d-block text-black-50"></i>' + resp.message + '</td></tr>');
				}

			}
		})
		
	}
	
	
	$(document.body).on('click', '.delete-comment', function(){

		var commentID = $(this).attr('commentID');

		Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure to delete this comment",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f472b6',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
			$.ajax({
				url : '../admin/classes/comment.php',
				method : 'POST',
				data : {DELETE_COMMENT:1, commentID:commentID},
				success : function(response){
					var resp = $.parseJSON(response);
					if (resp.status == 202) {
						Swal.fire({text: resp.message, confirmButtonColor: '#c084fc'});
						getcomment();
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