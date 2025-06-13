jQuery(document).ready(function ($) {
    $(document).on('keypress', function (e) {
        if (e.which == 13) {
            login()
        }
    });
});


function loadStart() {
    $('#kt_sign_in_submit .indicator-label').css('display', 'none')
    $('#kt_sign_in_submit .indicator-progress').css('display', 'block')
}

function loadStop() {
    $('#kt_sign_in_submit .indicator-label').css('display', 'block')
    $('#kt_sign_in_submit .indicator-progress').css('display', 'none')
}

function login() {
    $.ajax({
        url: urlApi + 'login',
        type: 'POST',
        data: {
            username: $('#username').val(),
            password: $('#password').val()
        },
        beforeSend: function () {
            loadStart()
        },
        success: function (response) {
            loadStop()

            let res = response.data

            let roleID = res.user.role.id;

            if (roleID == 1 || roleID == 3 || roleID == 5) {
                localStorage.setItem("token", res.token.access_token);
                localStorage.setItem("userID", res.user.id);
                localStorage.setItem("name", res.user.nama);
                localStorage.setItem("userName", res.user.username);
                localStorage.setItem("roleName", res.user.role.nama);
                localStorage.setItem("roleID", roleID);

                if(roleID == 1 || roleID == 5){
                    window.location = baseUrl + 'dashboard';
                }else{
                    window.location = baseUrl + 'prioritas-pekerjaan';
                }
            }else{
                Swal.fire('Oopss...','Tidak memiliki akses!');
            }



        },
        error: function (msg, status, error) {

            let code = msg.status
            let message = 'Terjadi Kesalahan koneksi'
            let type = 'error'

            if (code == 422) {
                message = 'Silahkan isi form dengan benar terlebih dahulu'
                type = 'warning'
            } else if (code == 401) {
                message = 'User tidak ditemukan'
                type = 'error'
            }
            loadStop()
            localStorage.setItem("token", '');
            Swal.fire('Oopss...', message, type);
        }
    });
}

// function logout() {
//     $.ajax({
//         url:urlApi+'auth/logout',
//         type:'POST',
//         beforeSend: function (xhr) {
//             xhr.setRequestHeader("Authorization","Bearer " + localStorage.getItem("token"));
//         },
//         success:function(response){
//             localStorage.clear();
//             localStorage.setItem("token", "");
//             window.location = baseUrl+'login';
//         },
//         error:function(msg, status, error){
//             localStorage.clear();
//             localStorage.setItem("token", "");
//             window.location = baseUrl;
//         }
//     });
// }

// function checkTokenValid() {
//     $.ajax({
//         type: 'GET',
//         url: urlApi + 'auth/check_token_valid',
//         contentType: 'application/json; charset=utf-8',
//         beforeSend: function () {
//             loadingAjax(true);
//         },
//         success: function (data) {
//             loadingAjax(false);
//             if (data.data.token_valid == true) {
//                 location.href = baseUrl;
//             }
//         },
//         error: function (data) {
//             loadingAjax(false);
//             actionErrorHttpCode(data, true);
//         }
//     });
// }

// function showPassword(){
//     if(document.getElementById('xa-password').type == 'password') {
//         document.getElementById('xa-password').type = 'text'
//     } else {
//         document.getElementById('xa-password').type = 'password'
//     }
// }

// function simpanUbahSandi() {
//     $('#btn-save-change-password').click(function () {
//         Swal.fire({
//             title: 'Apakah Anda Yakin?',
//             text: 'Mengganti Password Anda',
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonText: 'Ya',
//             cancelButtonText: 'Tidak',
//             confirmButtonClass: 'btn btn-success',
//             cancelButtonClass: 'btn btn-danger',
//             buttonsStyling: false,
//             showLoaderOnConfirm: true,
//             preConfirm: function () {
//                 return new Promise(function (resolve, reject) {
//                     $.ajax({
//                         success: function (response) {
//                             resolve(response)
//                         },
//                         error: function (data) {
//                             reject("error message")
//                         }
//                     })
//                 })
//             },
//             allowOutsideClick: false
//         }).then(function (isConfirm) {
//             window.onkeydown = null;
//             window.onfocus = null;
//             if (isConfirm.value) {
//                 var allData = {
//                     current_password: $('#current_password').val(),
//                     new_password: $('#new_password').val(),
//                 };
//                 $.ajax({
//                     type: 'POST',
//                     url: urlApi + 'auth/change_password',
//                     headers: {
//                         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//                         "Authorization":"Bearer " + localStorage.getItem("token")
//                     },
//                     data: allData,
//                     success: function (data) {
//                         $('#form-change-password').validate().resetForm();
//                         $('#current_password').val('');
//                         $('#new_password').val('');
//                     },
//                     error:function(msg, status, error){

//                         let code = msg.status
//                         let message = 'Terjadi Kesalahan Koneksi'
//                         let type = 'error'

//                         if(code == 400){
//                             message = 'Password lama tidak sama dengan password yang sekarang'
//                             type = 'error'
//                         }else if(code == 422){
//                             message = 'Silahkan isi form dengan benar terlebih dahulu'
//                             type = 'warning'
//                         }
//                         Swal.fire('Oopss...', message, type);
//                     }
//                 }).then((result)=>{
//                     Swal.fire({
//                         title:"Berhasil",
//                         text:"Password berhasil diperbarui",
//                         icon:"success",
//                         confirmButtonText: "Oke",
//                         customClass: {
//                             confirmButton: "btn btn-success",
//                         }
//                     }).then(function(){
//                         location.reload();
//                     })
//                     $("#ModalPassword").modal("hide");
//                 });
//             }
//         });
//     });
// }

// function clearUbahSandi() {
//     $('#inp-eye1').val('')
//     $('#inp-eye2').val('')
//     $('#inp-eye3').val('')
// }

// function ShowPassword()
// {
//     if(document.getElementById("xa-password").value!="")
//     {
//         document.getElementById("xa-password").type="text";
//         document.getElementById("show").style.display="none";
//         document.getElementById("hide").style.display="block";
//     }
// }

// function HidePassword()
// {
//     if(document.getElementById("xa-password").type == "text")
//     {
//         document.getElementById("xa-password").type="password"
//         document.getElementById("show").style.display="block";
//         document.getElementById("hide").style.display="none";
//     }
// }
