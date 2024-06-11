<script src="{{asset('front_assets/js/sweetalert2.all.min.js')}}"></script>
<script>
    var soundfile = "{{asset('intuition.mp3')}}";

    const Toast = Swal.mixin({
        toast: true,
        position: "top-start",
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
            var audplay = new Audio(soundfile)
            audplay.play();
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;

        }
    });
</script>
@if(session('error'))
    <script>

        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}'
        })

    </script>
@endif
@if(session('success'))
    <script>

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        })

    </script>
@endif

@if(session('info'))
    <script>

        Toast.fire({
            icon: 'info',
            title: '{{ session('info') }}'
        })

    </script>
@endif

