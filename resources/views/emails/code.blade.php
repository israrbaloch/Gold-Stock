<style>
    .container {
        width: 80%;
        margin: 0 auto;
        border-radius: 0 0 10px 10px;
        border: 1px solid #A9954C;
        text-align: center;
    }

    .body {
        margin: 8%;
    }

    .title-body {
        font-size: 1.4em;
        color: #F4A91D;
        padding-bottom: 30px;
        font-weight: bold;
        border-bottom: solid 2px #C4C4C4;
    }

    .btn {
        background-color: #F4A91D;
        border-color: #F4A91D;
        width: 300px;
        padding: 7px;
        margin: 0 auto;
        cursor: pointer;
    }

    a {
        color: whitesmoke;
        text-decoration: none;
    }
</style>
<x-banner />
<div class="container">
    <div class="body">
        <h1>{{ $details['title'] }}</h1>
        <p style="margin: 40px 0;">Your code is:</p>
        <div class="btn">{{ $details['code'] }}</div>
    </div>
</div>