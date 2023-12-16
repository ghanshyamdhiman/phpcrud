

function addData(){
    $('.frm-status').html('');
    $('#userModalLabel').html('Add New User');

    $('#userGender_1').prop('checked', true);
    $('#userGender_2').prop('checked', false);
    $('#userStatus_1').prop('checked', true);
    $('#userStatus_2').prop('checked', false);
    $('#userFirstName').val('');
    $('#userLastName').val('');
    $('#userEmail').val('');
    $('#userCountry').val('');
    $('#userID').val(0);
    $('#userDataModal').modal('show');
}

function editData(user_data){
    $('.frm-status').html('');
    $('#userModalLabel').html('Edit User #'+user_data.id);

    if(user_data.gender == 'Female'){
        $('#userGender_1').prop('checked', false);
        $('#userGender_2').prop('checked', true);
    }else{
        $('#userGender_2').prop('checked', false);
        $('#userGender_1').prop('checked', true);
    }

    if(user_data.status == 1){ 
        $('#userStatus_2').prop('checked', false);
        $('#userStatus_1').prop('checked', true);
    }else{
        $('#userStatus_1').prop('checked', false);
        $('#userStatus_2').prop('checked', true);
    }

    $('#userFirstName').val(user_data.first_name);
    $('#userLastName').val(user_data.last_name);
    $('#userEmail').val(user_data.email);
    $('#userCountry').val(user_data.country);
    $('#userID').val(user_data.id);
    $('#userDataModal').modal('show');
}

function submitUserData(){
    $('.frm-status').html('');
    let input_data_arr = [
        document.getElementById('userFirstName').value,
        document.getElementById('userLastName').value,
        document.getElementById('userEmail').value,
        document.querySelector('input[name="userGender"]:checked').value,
        document.getElementById('userCountry').value,
        document.querySelector('input[name="userStatus"]:checked').value,
        document.getElementById('userID').value,
    ];

    fetch("eventHandler.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ request_type:'addEditUser', user_data: input_data_arr}),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status == 1) {
            Swal.fire({
                title: data.msg,
                icon: 'success',
            }).then((result) => {
                // Redraw the table
	        table.draw();

                $('#userDataModal').modal('hide');
                $("#userDataFrm")[0].reset();
            });
        } else {
            $('.frm-status').html('<div class="alert alert-danger" role="alert">'+data.error+'</div>');
        }
    })
    .catch(console.error);
}


function deleteData(user_id){
    Swal.fire({
        title: 'Are you sure to Delete?',
        text:'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // Delete event
          fetch("eventHandler.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ request_type:'deleteUser', user_id: user_id}),
          })
          .then(response => response.json())
          .then(data => {
            if (data.status == 1) {
                Swal.fire({
                    title: data.msg,
                    icon: 'success',
                }).then((result) => {
                    table.draw();
                });
            } else {
              Swal.fire(data.error, '', 'error');
            }
          })
          .catch(console.error);
        } else {
          Swal.close();
        }
    });
}