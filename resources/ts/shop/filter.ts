export function setupFilters() {
    $('#filter-open').on('click', function () {
        $('.shop-filters').toggleClass('active');
    });
    $('#filter-close').on('click', function () {
        $('.shop-filters').removeClass('active');
    });

    const current_params = window.location.search;
    const urlParams = new URLSearchParams(current_params);
    if (urlParams.get('type')) {
        updateTypesOptions(urlParams);
    }
    if (urlParams.get('metal')) {
        updateMetalsOptions(urlParams);
    } else {
        updateMetalsOptions();
    }
    // in-stock
    if (urlParams.get('in-stock')) {
        if (urlParams.get('in-stock') === '1') {
            $('#in-stock').prop("checked", true);
        }else if (urlParams.get('in-stock') === '0') {
            $('#out-of-stock').prop("checked", true);
        }
    }
    if (urlParams.get('sort')) {
        updateSortSelect(urlParams);
    }
    if (urlParams.get('weight')) {
        updateWeightSelect(urlParams);
    }

    if (urlParams.get('producer')) {
        updateProducerSelect(urlParams);
    }

    // $('.sort').on('change', function () {
    //     let new_params = removeParam('sort', current_params);
    //     if ($(this).val() !== "best-match") {
    //         new_params = (new_params.length > 0) ? new_params + "&sort=" : "?sort=";
    //         new_params += $(this).val();
    //     }
    //     reloadWithParams(new_params);
    // });
    $('#sort1').on('change', function () {
        let new_params = removeParam('sort', current_params);
        if ($(this).val() !== "best-match") {
            new_params = (new_params.length > 0) ? new_params + "&sort=" : "?sort=";
            new_params += $(this).val();
        }
        reloadWithParams(new_params);
    });

    // producer
    $('#producer1').on('change', function () {
        let new_params = removeParam('producer', current_params);
        if ($(this).val() !== "all") {
            new_params = (new_params.length > 0) ? new_params + "&producer=" : "?producer=";
            new_params += $(this).val();
        }
        reloadWithParams(new_params);
    });
    $('#coins-only').on('change', function () {
        const params = removeParam('page', current_params);
        let new_params = removeParam('type', params);
        if ($(this).is(':checked')) {
            new_params = (new_params.length > 0) ? new_params + "&type=coin" : "?type=coin";
            $('#bars-only').prop("checked", false);
        }
        reloadWithParams(new_params);
    });
    $('#bars-only').on('change', function () {
        const current_params = window.location.search;
        const params = removeParam('page', current_params);
        let new_params = removeParam('type', params);
        if ($(this).is(':checked')) {
            new_params = (new_params.length > 0) ? new_params + "&type=bar" : "?type=bar";
            $('#coins-only').prop("checked", false);
        }
        reloadWithParams(new_params);
    });
    $('#in-stock').on('change', function () {
        const current_params = window.location.search;
        const params = removeParam('page', current_params);
        let new_params = removeParam('in-stock', params);
        // remove out-of-stock
        if ($(this).is(':checked')) {
            new_params = (new_params.length > 0) ? new_params + "&in-stock=1" : "?in-stock=1";
        }
        reloadWithParams(new_params);
    });
    // out-of-stock
    $('#out-of-stock').on('change', function () {
        const current_params = window.location.search;
        const params = removeParam('page', current_params);
        let new_params = removeParam('in-stock', params);
        if ($(this).is(':checked')) {
            new_params = (new_params.length > 0) ? new_params + "&in-stock=0" : "?in-stock=0";
        }
        reloadWithParams(new_params);
    });
    $('.cat-check').on('change', function () {
        const current_params = window.location.search;
        const params = removeParam('page', current_params);
        let new_params = removeParam('metal', params);
        const checkeds = $(".cat-check:checkbox:checked");
        const length = checkeds.length;
        if (length > 0) {
            new_params = (new_params.length > 0) ? new_params + "&metal=" : "?metal=";
            new_params += $(checkeds[0]).val();
            if (length > 1) {
                for (let i = 1; i < length; i++) {
                    new_params += "-" + $(checkeds[i]).val();
                }
            }
        }
        reloadWithParams(new_params);
    });
    $('#weight-select').on('change', function () {
        const current_params = window.location.search;
        const params = removeParam('page', current_params);
        let new_params = removeParam('weight', params);
        const checked = $(this).val();
        new_params = (new_params.length > 0) ? new_params + "&weight=" : "?weight=";
        new_params += checked;
        reloadWithParams(new_params);
    });
    $('.weight-check').on('change', function () {
        const current_params = window.location.search;
        const params = removeParam('page', current_params);
        let new_params = removeParam('weight', params);
        const checkeds = $(".weight-check:checkbox:checked");
        const length = checkeds.length;
        if (length > 0) {
            new_params = (new_params.length > 0) ? new_params + "&weight=" : "?weight=";
            new_params += $(checkeds[0]).val();
            if (length > 1) {
                for (let i = 1; i < length; i++) {
                    new_params += "-" + $(checkeds[i]).val();
                }
            }
        }
        reloadWithParams(new_params);
    });
}

function reloadWithParams(params?: string) {
    if (params) {
        window.location.href = window.location.pathname + params;
    } else {
        window.location.href = window.location.pathname;
    }
}

function updateTypesOptions(urlParams: URLSearchParams) {
    if (urlParams.get('type') === 'coin') {
        $('#coins-only').prop("checked", true);
        $('#bars-only').prop("checked", false);
    } else {
        $('#bars-only').prop("checked", true);
        $('#coins-only').prop("checked", false);
    }
}

function updateMetalsOptions(urlParams?: URLSearchParams) {
    if (urlParams) {
        const params = urlParams.get('metal');
        if (params) {
            const metals = params.split("-");
            metals.forEach(function (metal) {
                $('.cat-check[value=' + metal + ']').prop("checked", true);
            });
        }

    } else {
        $('.cat-check').each(function () {
            $(this).prop("checked", false);
        });
    }
}

function updateWeightSelect(urlParams: URLSearchParams) {
    const params = urlParams.get('weight');
    if (!params) {
        return;
    }
    const weights = params.split("-");

    weights.forEach(function (weight) {
        weight = weight.replace(/[&\/\\#, +()$~%.'":*?<>{}]/g, '_');
        $('.weight-check[value=' + weight + ']').prop("checked", true);
    });
    $('#weight-select').val(weights[0]);
}

function updateSortSelect(urlParams: URLSearchParams) {
    const params = urlParams.get('sort');
    if (!params) {
        return;
    }
    $('#sort').val(params);
}

function updateProducerSelect(urlParams: URLSearchParams) {
    const params = urlParams.get('producer');
    if (!params) {
        return;
    }
    $('#producer').val(params);
}

function removeParam(key: string, sourceURL: string) {
    let rtn = sourceURL.split("?")[0]
    let param;
    let params_arr = []
    const queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (let i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        if (params_arr.length) rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}

$('#producer').on('input', function (this: HTMLInputElement): void {
    const value = $(this).val();
    
    // Ensure value is treated as a string and safely trimmed
    const trimmedValue = typeof value === 'string' ? value.trim() : '';

    if (trimmedValue === '') {
        // Get the current URL
        const currentUrl = window.location.href;

        // Check if the URL contains query parameters
        if (currentUrl.includes('producer=')) {
            const [baseUrl, queryString] = currentUrl.split('?');
            const queryParams = new URLSearchParams(queryString);

            // Remove the 'producer' parameter
            queryParams.delete('producer');

            // Construct the new URL
            const newUrl = queryParams.toString()
                ? `${baseUrl}?${queryParams.toString()}`
                : baseUrl;

            // Redirect to the updated URL
            window.location.href = newUrl;
        }
    }
});

// $('#producer').on('keyup', function () {
//     let producer = $(this).val();
//     if (producer.length > 3) {
//         $.ajax({
//             url: '/get-producers',
//             type: 'GET',
//             data: {
//                 producer: producer
//             },
//             success: function (data) {
//                 $('#producer-suggestions').html(data);
//             }
//         });
//     } else {
//         $('#producer-suggestions').html('');
//     }
// });