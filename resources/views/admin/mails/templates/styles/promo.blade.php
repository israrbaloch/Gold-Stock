<style>
    .mail-container {
        display: flex;
        flex-direction: column;
    }

    .mail-container h1 {
        text-align: center;
        color: #000;
    }

    .mail-container .image-container {
        display: flex;
        justify-content: center;
    }

    .mail-container img {
        max-width: 300px;
        max-height: 300px;
    }

    .mail-container p {
        max-width: 800px;
        margin: 0 auto;
        /* text-align: center; */
        color: #000;
        font-weight: 500;
        font-size: 1.5rem
    }


    .mail-container .button {
        width: fit-content;
        display: block;
        padding: 0.5rem 1rem;
        text-align: center;
        background-color: #ffd805;
        color: black;
        border-radius: 10px;
        font-weight: 500;

        margin: 0 auto;
    }

    .mail-container .product-container {
        height: 500px;
        position: relative;
        display: flex;
        align-items: center;
    }

    .mail-container .image-container {
        height: 300px;
        position: absolute;
        display: flex;
        align-items: center;

    }

    .mail-container .image-container {
        left: 50%;
        transform: translateX(-50%);
    }

    .mail-container .image-container .image {
        height: 300px;
        background: #f5f5f5;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mail-container .image-container.container-1 {
        left: 35% !important;
    }

    .mail-container .image-container.container-1 .image {
        rotate: -15deg;
    }

    .mail-container .image-container.container-2 {
        left: 50% !important;
    }

    .mail-container .image-container.container-3 {
        left: 65% !important;
    }

    .mail-container .image-container.container-3 .image {
        rotate: 15deg;
    }
</style>
