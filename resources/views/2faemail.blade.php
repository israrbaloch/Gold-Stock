<html lang="en-US">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gold Stock Canada - {{ Route::getCurrentRoute()->getActionName() }}</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="crossorigin" />
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&amp;display=swap" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&amp;display=swap" media="print"
        onload="this.media = 'all'" />
    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&amp;display=swap" />
    </noscript>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&amp;display=swap" rel="stylesheet">
    <link href="/css/global.css?ver=1.2.0" rel="stylesheet">
    <link href="/css/home.css?ver=1.2.0" rel="stylesheet">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="/js/jquery-dateformat.min.js?ver=1.2.0"></script>
    <link href="/css/my-account.css?ver=1.2.0" rel="stylesheet">
</head>
<script>
    $(function() {
        var msg = '{{ Session::get('email-error') }}';
        if (msg !== '')
            alert(msg);

        $('.resend-email-code').on('click', function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            $.ajax({
                url: '/2faemail/reset',
                type: 'POST',
                success: function(response) {
                    if (response.success) {
                        alert(response.msg);
                    } else {
                        alert("There was a problem, please try again later");
                    }
                }
            });
        });
    });
</script>

<body class="twofaemail">
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container row g-0">
                <div class="col-12 logo-container py-4">
                    <img class="main-logo mt-2" src="/img/main-logo.png" />
                </div>
                <div class="col-10 col-md-4 offset-1 offset-md-4 mt-4">
                    <form id="second-step-email" class="login-form" method="post"
                        action="{{ route('2faemail.post') }}">
                        @csrf
                        <div class="row text-center frm-title mt-4">
                            <div class="col-12">
                                <br>
                                <h5>Please enter the code that was sent to your email, to validate your identity.</h5>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 text-left mt-2">
                                Code:
                            </div>
                            <div class="col-9">
                                <input type="text" class="email-input" name="code" id="code">
                                <div class="error username-error" style="display: none;">This field is required.</div>
                            </div>
                        </div>
                        <br>
                        <br><br>
                        <div class="row">
                            <div class="col-12 text-left">
                                <button type="submit" class="button button-2" name="continue">VALIDATE</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12 text-left">
                                <button id="resend" type="button" class="resend-email-code button button-1"
                                    name="re-send cdoe">re-send code</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
