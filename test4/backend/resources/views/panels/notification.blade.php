<script nonce="{{ csp_nonce() }}">
    $(document).ready(function(){
        console.log('asd')
        notification();
    });

    function notification(){
        $.get("{{ url('notification') }}",function(result){
            $('.appendHtmlNotif').html(result);
        });
    }
</script>