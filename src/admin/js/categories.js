$(document).ready(function(){

	getCategories();

	function getCategories(){
		$.ajax({
			url : '../admin/classes/Categories.php',
			method : 'POST',
			data : {GET_CATEGORIES:1},
			success : function(response){
				
				console.log(response);
				var resp = $.parseJSON(response);
				if (resp.status == 202) {

					var categoriesHTML = "";

					$.each(resp.message, function(index, value){

						categoriesHTML += '<tr>'+
									          '<td>'+ value.CategoryID +'</td>'+
									          '<td>'+ value.CategoryName +'</td>'+
											  '<td>'+ value.c +'</td>'+
											  '<td><a class="btn btn-sm btn-info edit-category"><span style="display:none;">'+JSON.stringify(value)+'</span><i class="fas fa-pencil-alt"></i></a>&nbsp;<a CategoryID="'+value.CategoryID+'" class="btn btn-sm btn-danger delete-category"><i class="fas fa-trash-alt"></i></a></td>'+
									       '</tr>'

					});

					$("#category_list").html(categoriesHTML);

				}else if(resp.status == 303){
					$("#category_list").html(resp.message);

				}

			}
		})
		
	}
	
	
	$(".add-category").on("click", function(){

		$.ajax({
			url : '../admin/classes/Categories.php',
			method : 'POST',
			data : $("#add-category-form").serialize(),
			success : function(response){
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					getCategories();
					Swal.fire({text: resp.message, confirmButtonColor: '#c084fc'});
				}else if(resp.status == 303){
					Swal.fire({text: resp.message, confirmButtonColor: '#c084fc'});
				}
				$("#add_category_modal").modal('hide');
			}
		})

	});	
	
	

	$(document.body).on('click', '.delete-category', function(){

		var CategoryID = $(this).attr('CategoryID');

		Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure to delete this category",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f472b6',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
			$.ajax({
				url : '../admin/classes/Categories.php',
				method : 'POST',
				data : {DELETE_CATEGORY:1, CategoryID:CategoryID},
				success : function(response){
					var resp = $.parseJSON(response);
					if (resp.status == 202) {
						Swal.fire({text: resp.message, confirmButtonColor: '#c084fc'});
						getCategories();
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
	
	$(document.body).on("click", ".edit-category", function(){

		var category = $.parseJSON($.trim($(this).children("span").html()));
		$("input[name='CategoryName']").val(category.CategoryName);
		$("input[name='CategoryID']").val(category.CategoryID);

		$("#edit_category_modal").modal('show');

		

	});

	$(".edit-category-btn").on("click", function(){
		$.ajax({
			url : '../admin/classes/Categories.php',
			method : 'POST',
			data : $("#edit-category-form").serialize(),
			success : function(response){
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					getCategories();
					Swal.fire({text: resp.message, confirmButtonColor: '#c084fc'});
				}else if(resp.status == 303){
					Swal.fire({text: resp.message, confirmButtonColor: '#c084fc'});
				}
				$("#edit_category_modal").modal('hide');
			}
		});
	});
	
});