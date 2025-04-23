<style>
    .container {
        width: 80%;
        margin: 0 auto;
        border-radius: 0 0 10px 10px;
        border: 1px solid #A9954C;
    }

    .body {
        margin: 8%;
    }
</style>
<x-banner />
<div class="container">
    <div class="body">
        <p>A new Customer has just registered in Gold Stock Canada</p>
        <p>User Email: {{ $data['newemail'] }}</p>
    </div>
</div>
