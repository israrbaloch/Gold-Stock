@component('components.base')
    <style>

    </style>

    <x-banner />


    <h1>
        New contact information received.
    </h1>
    <p>
        You have new contact information from Customer Support
    </p>

    <br>

    <table style="border-collapse: separate; border-spacing: 0 0.5rem;">
        {{-- <tr>
            <td>
                How can we help?
            </td>
            <td style="text-align: right;">
                {{ $option }}
            </td>
        </tr>
        <tr>
            <td>
                First Name
            </td>
            <td style="text-align: right;">
                {{ $fname }}
            </td>
        </tr>
        <tr>
            <td>
                Last Name
            </td>
            <td style="text-align: right;">
                {{ $lname }}
            </td>
        </tr> --}}
        <tr>
            <td>
                Name
            </td>
            <td style="text-align: right;">
                {{ $name }}
            </td>
        </tr>
        <tr>
            <td>
                Email
            </td>
            <td style="text-align: right;">
                <a class="mailto" href="mailto:{{ $email }}">
                    {{ $email }}
                </a>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <br>
                <br>
                Message:
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p>
                    {{ strval($msg) }}
                </p>
            </td>
        </tr>
    </table>
    
    @component('components.footer')
    @endcomponent
@endcomponent
