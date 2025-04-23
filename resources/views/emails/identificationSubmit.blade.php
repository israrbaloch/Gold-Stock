<style>
    .container {
        width: 80%;
        margin: 0 auto;
        border-radius: 0 0 10px 10px;
        border: 1px solid #A9954C;
    }

    .body {
        margin: 8%;
        text-align: center;
    }

    a { font-size: 1.5em; }
</style>
<x-banner />
<div class="container">
    <div class="body">
        <p>Hello Admin,</p>
        <p>{{$data['fname']}} ( {{$data['email']}} ) has submited a new ID image and it is pending for approval</p>
        <p>You can verify/approve it from the admin panel.</p><br>
    </div>
</div>
