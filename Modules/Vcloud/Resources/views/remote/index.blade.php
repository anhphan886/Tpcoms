<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{asset('static/backend/vmks-sdk/css/wmks-all.css')}}" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.1.0.min.js"
        integrity="sha256-ycJeXbll9m7dHKeaPbXBkZH8BuP99SmPm/8q5O+SbBc=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

    <script src="{{asset('static/backend/vmks-sdk/wmks.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>[VM NAME]</title>
<style>
    .vmtable {
        width: 100%;
    }
    .vmtable tr{
        height: 30px;
    }
</style>
</head>
<body>
    <table class="vmtable">
        <tbody>
            <tr>
                <td>
                    <h2 id="vm-name">[VM NAME]</h2>
                    <h4 id="vm-status">[status]</h4>
                </td>
                <td>
                    <div class="btn btn-primary" onclick="sendCtrlAltDelete()">Ctrl+Alt+Del</div>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <div id="console" style="height : 600px; width: 400px;display : block; position: relative">

    </div>
</body>
<footer>
    <script>
        function remoteNow(data){
            window.wmks = $("#console").wmks({
                enableUint8Utf8 : true,
                disableVscanKeyboard: false
                }).bind("wmksconnected", function() {
                    $("#vm-status").text("Connected");
                }).bind("wmksconnecting", function() {
                    $("#vm-status").text("Connecting...");
                }).bind("wmksdisconnected", function(event) {
                    $("#vm-status").text("Disconnected");
                }).bind("wmksresolutionchanged", function() {
                    // $("#vm-status").text("Resolution changed");
                }).bind("wmkserror", function(event, error) {
                    $("#vm-status").text("Error occurred");
                }).bind("wmksprotocolError", function(event) {
                    $("#vm-status").text("Protocol error occurred");
                }).bind("wmksauthenticationFailed", function(event) {
                    $("#vm-status").text("Authentication failure");
                });
                wmks.wmks("option", "VCDProxyHandshakeVmxPath", data.vmx);
                wmks.wmks("connect",`wss://${data.host}/${data.port};${data.ticket}`);

        }
        $(window).resize(function(e) {
            $('#console').css({
                height : $(window).height() - 30,
                width : $(window).width(),
            });

        });
        var sendCtrlAltDelete = function() {
            var keyCodes = [17, 18, 46];
            const VSCAN_LCONTROL = 0x01D;
            const VSCAN_LALT = 0x038;
            const VSCAN_RCONTROL = 0x11D;
            const VSCAN_RALT = 0x138;
            const VSCAN_DELETE = 0x153;

            window.wmks.wmks("sendKeyCodes", keyCodes,
            [VSCAN_LCONTROL, VSCAN_LALT, VSCAN_DELETE], true);  // VSCAN codes

            window.wmks.wmks("sendKeyCodes", keyCodes,
            [VSCAN_RCONTROL, VSCAN_RALT, VSCAN_DELETE], true);  // VSCAN codes
        };


        $(document).ready(function() {
            if(window.opener == null) {
                $("body").text("This page cannot be accessed directly.  Please close this window, verify that your session is still active, and launch a console from the main vCloud Director UI.");
                return;
            }
            if(window.opener.window.vm_data && Object.keys(window.opener.window.vm_data).length > 0){
                $('#console').html(window.opener.window.loading);
                $('title').text(window.opener.window.vm_data.vm);
                $('#vm-name').text(window.opener.window.vm_data.vm);
                $.ajax({
                    url : laroute.route('vcloud.detail'),
                    method : 'POST',
                    data : {
                        customer_service_id : window.opener.window.customer_service_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success : function(data){
                        if(data.wmks){
                            remoteNow(data.wmks);
                        }
                    }
                });
            }else{
                $("body").text("Can not access data");
            }
        });
    </script>
    <script src="{{ asset('js/laroute.js?v='.time()) }}" type="text/javascript"></script>
</footer>
</html>
