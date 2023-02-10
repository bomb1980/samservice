function controlnumbers(thestr) {
    var controlstr = "-.0123456789";

    if (
        controlstr.indexOf(thestr.value.charAt(thestr.value.length - 1)) == -1
    ) {
        var x = thestr.value.length - 1;
        thestr.value = thestr.value.substring(0, x);
    }

    var Num = thestr.value;
    Num += "";
    Num = Num.replace(/,/g, "");

    x = Num.split(".");
    x1 = x[0];
    x2 = x.length > 1 ? "." + x[1] : "";
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) x1 = x1.replace(rgx, "$1" + "," + "$2");

    if (x1 + x2 < 0) {
        thestr.value = (x1 + x2) * -1;
    } else {
        thestr.value = x1 + x2;
    }
}
