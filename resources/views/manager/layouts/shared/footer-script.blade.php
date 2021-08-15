<script>
    function checkDelete(btn, formid){
    var trans = '{{ __('alerts.Are you sure you want to delete this item?') }}';
    if ($(btn).attr('dt-msg')) {
    trans = $(btn).attr('dt-msg');
    }

    mscConfirm({
    title: '{{ __('manager.delete') }}',
            subtitle: trans, // default: ''

            okText: '{{ __('manager.ok') }}', // default: OK

            cancelText: '{{ __('manager.cancel') }}', // default: Cancel

            onOk: function () {
            //btn.form.submit();
            $('#' + formid).submit();
            }
    ,
            onCancel: function () {
            //do nothing
            }
    }
    );
    return false;
    }
</script>
<!-- bundle -->
<!-- Vendor js -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<script src="{{asset('assets/js/vendor.min.js')}}"></script>
@yield('script')
<!-- App js -->

<script src="{{asset('assets/js/app.min.js')}}"></script>
@yield('script-bottom')
