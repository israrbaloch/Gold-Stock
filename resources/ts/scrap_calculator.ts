$(document).ready(function () {
    const metalSelect = $("#metal") as JQuery<HTMLSelectElement>;
    const weightInput = $("#weight") as JQuery<HTMLInputElement>;
    const puritySelect = $("#purity") as JQuery<HTMLSelectElement>;
    const unitSelect = $("#unit") as JQuery<HTMLSelectElement>;
    const calculateBtn = $("#calculateBtn") as JQuery<HTMLButtonElement>;
    const estimatedValueDisplay = $("#estimatedValue") as JQuery<HTMLElement>;

    // Hidden fields with current metal prices (per ounce)
    const goldPrice = parseFloat($("#goldValue").val() as string) || 0;
    const silverPrice = parseFloat($("#silverValue").val() as string) || 0;
    const platinumPrice = parseFloat($("#platinumValue").val() as string) || 0;
    const palladiumPrice = parseFloat($("#palladiumValue").val() as string) || 0;


    // hidden admin scrap commission
    const CommissionGold = parseFloat($("#CommissionGold").val() as string) || 0;
    const CommissionSilver = parseFloat($("#CommissionSilver").val() as string) || 0;
    const CommissionPlatinum = parseFloat($("#CommissionPlatinum").val() as string) || 0;
    const CommissionPalladium = parseFloat($("#CommissionPalladium").val() as string) || 0;

    const currencyMultiplier = parseFloat($("#currencyValue").val() as string) || 1;
    const currency = ($("#currency").val() as string) || "CAD";

    // Purity Data (from provided tables)
    const purityLevels: { [key: string]: { [key: string]: number } } = {
        "Gold": {
            "24K": 99.9, "22K": 91.6, "21K": 87.5, "18K": 75,
            "14K": 58.3, "12K": 50, "10K": 41.7, "9K": 37.5, "8K": 33.3
        },
        "Silver": {
            "Fine Silver": 99.9, "Britannia Silver": 95.8, "Sterling Silver": 92.5,
            "Coin Silver": 90, "European Silver": 83.5, "German Silver (Nickel)": 0
        },
        "Platinum": {
            "Pure Platinum": 99.95, "Platinum 950": 95, "Platinum 900": 90, "Platinum 850": 85
        },
        "Palladium": {
            "Pure Palladium": 99.9, "Palladium 950": 95, "Palladium 900": 90, "Palladium 500": 50
        }
    };

    /**
     * Updates purity dropdown based on the selected metal.
     */
    function updatePurityOptions(): void {
        puritySelect.empty();
        let selectedMetal: string = metalSelect.val() as string;

        if (purityLevels[selectedMetal]) {
            Object.entries(purityLevels[selectedMetal]).forEach(([key, value]) => {
                puritySelect.append(`<option value="${value}">${key}</option>`);
            });
        }
    }

    /**
     * Calculates and updates the estimated value.
     */
    function calculateValue(): void {
        let selectedMetal: string = metalSelect.val() as string;
        let weight: number = parseFloat(weightInput.val() as string) || 0;
        let purityPercentage: number = parseFloat(puritySelect.val() as string) || 0;
        let selectedUnit: string = unitSelect.val() as string;

        if (weight <= 0) {
            estimatedValueDisplay.text("0.00 " + currency);
            return;
        }

        // Get the correct price per ounce
        let metalPrice: number = 0;
        let Commission: number = 0;
        switch (selectedMetal) {
            case "Gold":
                metalPrice = goldPrice;
                Commission = CommissionGold;
                break;
            case "Silver":
                metalPrice = silverPrice;
                Commission = CommissionSilver;
                break;
            case "Platinum":
                metalPrice = platinumPrice;
                Commission = CommissionPlatinum;
                break;
            case "Palladium":
                metalPrice = palladiumPrice;
                Commission = CommissionPalladium;
                break;
        }

        // Convert grams to ounces if necessary (1 ounce = 31.1035 grams)
        let weightInOunces: number = (selectedUnit === "Grams") ? weight / 31.1035 : weight;

        // Final value calculation
        let estimatedValue: number = ((metalPrice * weightInOunces) * (purityPercentage / 100)) * currencyMultiplier;

        // subtracting commission
        estimatedValue = estimatedValue - (estimatedValue * (Commission / 100));

        // Display result
        estimatedValueDisplay.text(estimatedValue.toFixed(2) + " " + currency);
    }

    // Event Listeners
    metalSelect.on("change", function () {
        updatePurityOptions();
    });

    calculateBtn.on("click", function () {
        calculateValue();
    });

    // Initialize purity options on page load
    updatePurityOptions();
});
