<script>
    // Display success messages (like logout)
    @if(session('status'))
        iziToast.success({
            title: 'Success',
            message: "{{ session('status') }}",
            position: 'topRight',
            timeout: 4000
        });
    @endif

    // Display error messages
    @if(session('error'))
        iziToast.error({
            title: 'Error',
            message: "{{ session('error') }}",
            position: 'topRight',
            timeout: 5000
        });
    @endif

    // Display validation errors
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            iziToast.error({
                title: 'Error',
                message: "{{ $error }}",
                position: 'topRight',
                timeout: 5000
            });
        @endforeach
    @endif
</script>
