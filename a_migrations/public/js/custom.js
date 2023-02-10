$('input[type="number"]').on("keydown", function (e) {
    if (e.which == 38 || e.which == 40 || e.which == 69) {
        e.preventDefault();
    }
});
