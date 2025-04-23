<x-base />
<x-banner />
<div class="email-container">
    <div class="body">
        <h1>Hello Admin!</h1>
        <p>
            {{ $fname }} -
            <a class="mailto" href="mailto:{{ $email }}">
                {{ $email }}
            </a>
        </p>
        <br>
        <p>Has submited a new ID image and it is pending for approval</p>
        <br>
        <p>You can verify/approve it from the admin panel.</p>
    </div>
</div>
