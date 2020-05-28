function streamUpgradeEvent() {
    $('#btn-confirmUpgrade').addClass('disabled btn-default').removeClass('btn-primary');

    var ta = document.getElementById('textarea-output');
    //var source = new EventSource(ta.getAttribute('data-url'));
    ta.value = ta.getAttribute('data-url');

    source.addEventListener('message', function (e) {
        if (e.data !== '') {
            ta.value += e.data + '\n';
        }
    }, false);

    source.addEventListener('error', function (e) {
        source.close();
    }, false);


}