<!-- 



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
</script> -->




<script>
    // Notifications de succès
    @if(session('status'))
        iziToast.success({
            title: 'Succès',
            message: {!! json_encode(session('status')) !!},
            position: 'topRight',
            timeout: 4000
        });
    @endif

    // Notifications d'erreur
    @if(session('error'))
        iziToast.error({
            title: 'Erreur',
            message: {!! json_encode(session('error')) !!},
            position: 'topRight',
            timeout: 5000
        });
    @endif

    // Erreurs de validation
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            iziToast.error({
                title: 'Erreur de validation',
                message: {!! json_encode($error) !!},
                position: 'topRight',
                timeout: 5000
            });
        @endforeach
    @endif
</script>




