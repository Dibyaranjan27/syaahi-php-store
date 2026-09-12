$(document).ready(function(){

	getreport();

	function getreport(){
		$.ajax({
			url : '../admin/classes/report.php',
			method : 'POST',
			data : {GET_REPORT:1},
			success : function(response){
				
				console.log(response);
				var resp = $.parseJSON(response);
				if (resp.status == 202) {

					var reportHTML = "";

					$.each(resp.message, function(index, value){

						reportHTML += '<tr>'+
									          '<td>'+value.UserID+'</td>'+
									          '<td>'+value.un+'</td>'+
									          '<td>'+value.AdsID+'</td>'+
									          '<td>'+value.an+'</td>'+
									          '<td>'+value.details+'</td>'+
											  '<td>'+value.Date+'</td>'+
											  '<td><a UserID="'+value.UserID+'" AdsID="'+value.AdsID+'" class="btn btn-sm btn-danger delete-report"><i class="fas fa-trash-alt"></i></a></td>'+
									       '</tr>'

					});

					$("#report_list").html(reportHTML);

				}else if(resp.status == 303){
					$("#report_list").html(resp.message);

				}

			}
		})
		
	}
	
	$(document.body).on('click', '.delete-report', function(){

		var UserID = $(this).attr('UserID');
		var AdsID = $(this).attr('AdsID');

		Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure to delete this report",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f472b6',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
			$.ajax({
				url : '../admin/classes/report.php',
				method : 'POST',
				data : {DELETE_REPORT:1, UserID:UserID, AdsID:AdsID},
				success : function(response){
					var resp = $.parseJSON(response);
					if (resp.status == 202) {
						Swal.fire({text: resp.message, confirmButtonColor: '#c084fc'});
						getreport();
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