<!DOCTYPE html>
<html>
<head>
    <title>OpenAI View</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container head-padding">
    <div class="">
    <h1>Welcome to OpenAI!</h1>
    <div class="input-group mb-3">
        <input type="text" id="description" name="description" class="form-control" placeholder="Enter description"/>
        <button type="button" id="startAi" class="btn btn-success"> Start </button>
    </div>
    <img class="image-result" name="resultImg" src="{{ asset('') }}" alt="" defer>
    </div>
    <div id="loading" style="display: none;">
    Loading...
</div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
 $(document).ready(function() {
    $('#startAi').on('click', function() {
        var description = $('#description').val();
        $('#loading').show();
        $.ajax({
            url: '/generate', // router url
            method: 'POST', // router request method
            data: {
                _token: '{{ csrf_token() }}', // Include CSRF token
                description: description
            },
            success: function(response) {
                // If successful, show image in img tag
                if(response.status) {
                    $('.image-result').attr('src', response.url);
                    $('#loading').hide();
                }
                else {
                    alert('Error! Try again.');
                    $('#loading').hide();
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
                $('#loading').hide();
            }
        });
    })
});
</script>
<style>
    .image-result {
        width: 200px;
        height: 200px;
        margin-top: 100px;
        margin-left: 250px
    }

    .head-padding {
        padding: 50px;
    }

    .input-group {
        width: 60%;
    }
    h1 {
        margin-top: 50px;
    }

    #loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            display: none;
    }
</style>
</html>
