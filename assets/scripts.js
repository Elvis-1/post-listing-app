
var mailformat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
//match(mailformat)
   $(document).ready(function(){
    $('#account').change(function(event){
      alert('working');
    //  event.preventDefault();
     submitForm();
    })
   })

   function submitForm()
   {
      alert('yes');
    var form = $('#account');
       var email = form.find('input[name="email"]').val();
       var password = form.find('input[name="password"]').val();
       if(email == ''|| email.length < 1 )
       {
        $('#email_error').html('email cannot be empty');
        return;
       } else if(!email.match(mailformat)){
        $('#email_error').html('email must be correctly formed');
        return;
       }else if(password == '' || password.length < 1)
       {
        $('#password_error').html('password cannot be empty');
        return;
       }else if(password.length < 6)
       {
        $('#password_error').html('password cannot be less than 6');
        return;
       }
       
       else{
        // make post request

        form.find('button[name="account_submit"]').click(function(event){
            event.preventDefault();
            var user_data = {
                'email':email,
                'password':password
            }
            $.post( 'functions/login.php', user_data,
            function( data ) {
                window.console && console.log(data);
            }
          ).success(function(){
            $('#email_error').css('background-color', 'green');
            location.reload();
            alert('worrrrrrrrrrrrrrk');
            window.console && console.log('sucessssssssssssssfullllllllllllllll');
            alert(data);
           $('#target').css('background-color', 'white');
          })
          .error( function() { 
            alert("Dang!");
            window.console && console.log('failllllllllllllllllllllllllll');
          });
        })


       }
   }

