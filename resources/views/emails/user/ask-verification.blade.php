@component('components.base')
    @component('components.banner')
    @endcomponent

    <div class="content">
        <h1 style="font-size: 24px;">Verify Your Documents <span><img src="https://goldstockcanada.com/email-icons/verify.png?1" alt="verify" width="20px" style="vertical-align: middle;"></span></h1>

        <p>Dear,</p>
        <p><strong>{{$user}}!</strong></p>
        <p>
            Thank you for choosing <strong>Gold Stock Canada.</strong> To complete your account verification and access full features, we require you to upload the following documents:
        </p>
        <ul>
            <li>A valid government-issued photo ID (e.g., driver’s license or passport).</li>
            <li>Proof of address (e.g., utility bill or bank statement).</li>
        </ul>

        <h3>How to Upload</h3>
        <ol>
            <li>Log in to your account at <strong>Gold Stock Canada - My Account.</strong></li>
            <li>Go to the Verification section.</li>
            <li>Follow the instructions to upload your documents securely.</li>
        </ol>

        @include('components.assistance')

        @include('components.social')

        <p>Thank you for helping us maintain a secure and trusted platform.
        </p>

        @include('components.footer')
    </div>
@endcomponent
