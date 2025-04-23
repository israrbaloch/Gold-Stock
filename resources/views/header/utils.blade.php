@php
    if (!function_exists('addCommas')) {
        function addCommas($value, $fractions = 2)
        {
            return number_format($value, $fractions, '.', ',');
        }
    }
@endphp
