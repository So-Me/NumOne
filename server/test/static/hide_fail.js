var d = function (arg) {
    console.log(arg);
};

window.onload = function () {
    var failBox = document.getElementById('pre-fail-box');
    failBox.style.display = 'none';
    var passBox = document.getElementById('pre-pass-box');
    passBox.style.display = 'block';
};
