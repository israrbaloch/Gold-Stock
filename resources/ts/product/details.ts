export function setupProductDetails() {
    $(".thumb-container").on("click", function () {
        const img = $(this).find("img")[0];
        const img_hov = $(".main-image")[0];
        const imgSrc = $(img).attr("src");
        if (imgSrc) {
            $(img_hov).attr("src", imgSrc);
        }
    });

    // Expand Product Description
    $(".title-container").on("click", function () {
        $(this).toggleClass("active");
    });
}