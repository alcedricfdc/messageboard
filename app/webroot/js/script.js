$(document).ready(function() {
    $("#name, #age, #birthdate, #gender, #hobby, #email, #password").blur(function() {
        formValidation.call(this)
    });

    function formValidation() {
        let fieldId = $(this).attr('id')
        let value = $(this).val()

        $.post(
            '/messageboard/users/validateForm',
            { field: fieldId, value: value },
            handleNameValidation
        );

        // the parameters here are received as a response from the url
        function handleNameValidation(response) {
            if(response.length > 0) { // check if there's an error
                if ($("#"+fieldId+"-error").length == 0 && $("#"+fieldId).next('.error-message').length == 0) {
                    $("#"+fieldId).after(`<div id="${fieldId}-error" class="error-message">${response}</div>`)
                } 
            } else {
                $("#name-notEmpty").remove()
            }
        }
    }
    
    

    let originalPasswordDisplayText = $(".password-display").text();
    
    $(".password-display").text(originalPasswordDisplayText.replace(/./g, "*"))

    $(".password-display").click(function() {
        let currentPasswordText = $(this).text()

        if(currentPasswordText === originalPasswordDisplayText) {
            $(this).text(currentPasswordText.replace(/./g, "*"))
        } else {
            $(this).text(originalPasswordDisplayText);
        }
    })




    $('#profile-image-file-input').change(function(){
        let input = this;
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#profile-image').attr('src', e.target.result);
            }

            $("#update-profile-image-form-container").show()
            reader.readAsDataURL(input.files[0]);
            // $('#file-name').text(input.files[0].name); // Update file name display
        }
    });


    $('#nameSelect').select2({
        placeholder: 'Type a name...',
        ajax: {
            url: '/messageboard/users/searchRecipient', // Replace 'search.php' with the URL of your server-side script to fetch matching names
            dataType: 'json',
            delay: 250, // Delay in milliseconds before sending the AJAX request
            processResults: function(data) {
                return {
                    results: data // Expected format: [{id: 1, text: 'Name 1'}, {id: 2, text: 'Name 2'}, ...]
                };
            },
            cache: true // Enable caching to improve performance
        }
    });


    

})