<script>
    var user = null
    @if(isset($user))
        user = {!! json_encode($user) !!}
    @endif
</script>
<script src="{{mix('js/app.js')}}"></script>