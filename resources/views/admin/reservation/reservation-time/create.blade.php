@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Reservation Times</h1>
       
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Create Time</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.reservation-time.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

               


                <div class="form-group">
                    <label>Start Time</label>
                    <input type="text" name="start_time" class="form-control timepicker">
                   
                </div>
                <div class="form-group">
                    <label>End Time</label>
                    <input type="text" name="end_time" class="form-control timepicker">
                   
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    
                </div>

                

             

                <button type="submit" class="btn btn-primary">Create Reservation</button>
                
            </form>
        </div>
    </div>
</section>
@endsection


@push('scripts')
<script>
const imageUpload = document.getElementById('image-upload');
const imagePreview = document.getElementById('image-preview');
const imageLabel = document.getElementById('image-label');

imageUpload.addEventListener('change', function() {
    const [file] = this.files;
    if(file) {
        // Supprimer l’ancien aperçu
        const oldImg = imagePreview.querySelector('img');
        if(oldImg) oldImg.remove();

        // Créer la nouvelle image
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);

        // Faire remplir le cadre
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover'; // <-- important
        img.style.display = 'block';

        imagePreview.appendChild(img);

        // Cacher le label
        imageLabel.style.display = 'none';
    }
});

</script>
@endpush

