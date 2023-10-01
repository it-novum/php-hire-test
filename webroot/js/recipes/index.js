$(document).ready(function () {
    let previewAjax;

    $("#search").keyup(function () {
        handleSearch(this);
    });

    $("#sort").change(function () {
        window.location.href = "?sort=" + $(this).val();
    });

    $(".title-link").each(function () {
        $(this).hover(
            function (e) {
                const target = this;
                const xPos = e.pageX;
                const yPos = e.pageY;
                const id = $(this).attr("href").split("/")[3];
                previewAjax = $.get(
                    "recipes/getDescription",
                    { id: id },
                    function (data) {
                        showPreview(
                            target,
                            xPos,
                            yPos,
                            data.description.substring(0, 200) + "..."
                        );
                    }
                );
            },
            function () {
                if (previewAjax) {
                    previewAjax.abort();
                }
                closePreview();
            }
        );
    });

    window.handleSearch = function (target, xPos, yPos) {
        var value = $(target).val().toLowerCase();
        $("#recipesTable tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    };

    window.showPreview = function (target, xPos, yPos, description) {
        $("#previewOverlay")
            .css("left", xPos + 20 + "px")
            .css("top", yPos + 20 + "px")
            .text(description)
            .fadeIn(300);
    };

    window.closePreview = function () {
        $("#previewOverlay").fadeOut(300);
    };
});
