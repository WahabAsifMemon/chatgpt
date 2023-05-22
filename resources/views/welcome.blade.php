<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Open AI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    ::-webkit-scrollbar {
        width: 5px;
    }

    ::-webkit-scrollbar-track {
        background: #13254c;
    }

    ::-webkit-scrollbar-thumb {
        background: #061128;
    }
</style>

<body style="background: #05113b">
    <div>
        <div class="container-fluid m-0 d-flex p-2">
            <div class="pl-2" style="width:40px; height:50px; font-size:100%;">
                <i class="fa fa-angle-double-left text-white mt-2"></i>
            </div>
            <div style="width:50px; height:50px;">
                <img width="100%" height="100%" style="border-radius: 50px;" src="1.jpg" alt="">
            </div>

            <div class="text-white font-weight-bold ml-2 mt-2">
                ChatBot
            </div>
        </div>
        <div style="background: #061128; height:2px;"></div>
        <div id="content-box" class="container-fluid p-2" style="height: calc(100vh - 130px); overflow-y:scroll;">
        </div>
        <div class="container-fluid w-100 px-3 py-2 d-flex" style="background:#131f45; height:62px;">
            <div class="mr-2 pl-2" style="background:#ffffff1c; width: calc(100% - 90px); border-radius:5px;">
                <input type="text" id="input" class="text-white" name="input"
                    style="background:none !important;width:100%;height:100%; border:0; outline:none;">
            </div>
            <div id="button-submit" class="text-white"
                style="background:#4acfee; height:100%; width:50px; border-radius:5px;">
                <i class="fa fa-paper-plane text-white" aria-hidden="true"
                    style="line-height:45px; margin-left:15px"></i>
            </div>
            <div id="button-clear" class="text-white ml-2"
                style="background:#ff5454; height:100%; width:40px; border-radius:5px; cursor:pointer;">
                <i class="fa fa-trash-o text-white" aria-hidden="true" style="line-height:45px; margin-left:13px"></i>
            </div>
        </div>
    </div>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#button-submit').on('click', function(event) {
        event.preventDefault();
        sendQuestion();
    });

    $('#input').on('keydown', function(event) {
        if (event.keyCode === 13) { // Enter key
            event.preventDefault();
            sendQuestion();
        }
    });

    $('#button-clear').on('click', function() {
        $('#content-box').empty();
    });

    function sendQuestion() {
        $value = $('#input').val();
        if ($value.trim() !== '') {
            $('#content-box').append(`
                    <div class="md-2">
                        <div class="float-right px-3 py-2" style="width:270px; background:#4acfee; border-radius:10px; float: right; font-size:85%;">
                            ` + $value + `
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                `);

            // Show loading state
            $('#content-box').append(`
                    <div id="loading" class="d-flex md-2">
                        <div class="mr-2" style="width:45px; height:45px;">
                            <img width="100%" height="100%" style="border-radius: 50px;" src="loading.gif" alt="Loading...">
                        </div>
                        <div class="text-white px-3 py-2" style="width: 270px; background:#13254b; border-radius:10px; font-size:85%;">
                            Loading...
                        </div>
                    </div>
                `);

            $.ajax({
                type: 'post',
                url: '{{ url('send') }}',
                data: {
                    'input': $value
                },
                success: function(data) {
                    // Remove the loading state
                    $('#loading').remove();

                    // Append the answer
                    $('#content-box').append(`
                            <div class="d-flex md-2">
                                <div class="mr-2" style="width:45px; height:45px;">
                                    <img width="100%" height="100%" style="border-radius: 50px;" src="1.jpg" alt="">
                                </div>
                                <div class="text-white px-3 py-2" style="width: 270px; background:#13254b; border-radius:10px; font-size:85%;">
                                    ` + data + `
                                </div>
                            </div>
                        `);

                    $('#input').val('');
                }
            });
        }
    }
</script>
