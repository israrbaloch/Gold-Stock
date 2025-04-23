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

    table {width: 100%;}
    .title-table {
        color: #35571A;
        font-size: 1.3em;
        font-weight: bold;
        text-align: center;
        padding: 20px 0;
    }
</style>

<x-banner />

<div class="container">
    <div class="body">
        <table>
            <tr>
                <td colspan="2" class="title-table">
                    New contact information received.
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; padding: 25px 0;">
                    You have new contact information from Customer Support
                </td>
            </tr>
            <tr>
                <td class="title-table" style="text-align: left; width: 200px; border-bottom: solid 1px rgb(160, 151, 151);">How can we help?</td>
                <td style="text-align: right; border-bottom: solid 1px rgb(160, 151, 151);">{{ $data['option'] }}</td>
            </tr>
            <tr>
                <td class="title-table" style="text-align: left; border-bottom: solid 1px rgb(160, 151, 151);">First Name</td>
                <td style="text-align: right; border-bottom: solid 1px rgb(160, 151, 151);">{{ $data['fname'] }}</td>
            </tr>
            <tr>
                <td class="title-table" style="text-align: left; border-bottom: solid 1px rgb(160, 151, 151);">Last Name</td>
                <td style="text-align: right; border-bottom: solid 1px rgb(160, 151, 151);">{{ $data['lname'] }}</td>
            </tr>
            <tr>
                <td class="title-table" style="text-align: left; border-bottom: solid 1px rgb(160, 151, 151);">Email</td>
                <td style="text-align: right; border-bottom: solid 1px rgb(160, 151, 151);">{{ $data['email'] }}</td>
            </tr>
            <tr>
                <td colspan="2" class="title-table" style="text-align: left; padding-top: 40px;">Message</td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="text-align: justify;">
                        {{ $data['message'] }}
                    </p>
                </td>
            </tr>
        </table>
    </div>
</div>

<x-footer />
