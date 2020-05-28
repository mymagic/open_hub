<!DOCTYPE html>
<html>
<head>
    <title>Simple EventSource example</title>
</head>
<body>
    <script type="text/javascript">
    function eventsourcetest() {
        var ta = document.getElementById('output');
        var source = new EventSource('<?php echo $this->createUrl('test/doPing') ?>');
        source.addEventListener('message', function(e) {
            if (e.data !== '') {
               ta.value += e.data + '\n';
            }
        }, false);
        source.addEventListener('error', function(e) {
            source.close();
        }, false);
    }
    </script>
    <p>Output:<br/><textarea id="output" style="width: 80%; height: 25em;"></textarea></p>
    <p><button type="button" onclick="eventsourcetest();">ping google.com</button>
</html>