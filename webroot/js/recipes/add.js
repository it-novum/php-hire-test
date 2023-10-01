window.addIngredientToList = function () {
    let valueString = "";
    let outputString = "";

    const desc = $("#ingredientDescription");
    const amount = $("#ingredientAmount");
    const unit = $("#ingredientUnit");
    const descVal = desc.val();
    const amountVal = amount.val();
    const unitVal = unit.val();

    valueString += descVal + ";";
    valueString += amountVal + ";";
    valueString += unitVal;
    outputString += amountVal + "";
    outputString += unitVal + " ";
    outputString += descVal;
    desc.val("");
    amount.val("");
    unit.val("");

    $("#addIngredientBtn").prop("disabled", true);

    $("#ingredientsList").append(
        $("<option>", {
            value: valueString,
            text: outputString,
        })
    );
};

window.handleAddIngredientBtn = function () {
    let failed = false;
    $(".add-ingredient-input").each(function () {
        if (!$(this).val()) {
            failed = true;
        }
    });

    $("#addIngredientBtn").prop("disabled", failed);
};

window.handleRemoveIngredientBtn = function () {
    $("#removeIngredientBtn").prop("disabled", false);
};

window.removeIngredientFromList = function () {
    $("#ingredientsList").find(":selected").remove();
    $("#removeIngredientBtn").prop("disabled", true);
};

window.selectAllIngredients = function () {
    $("#ingredientsList option").each(function () {
        $(this).prop("selected", true);
    });
};
