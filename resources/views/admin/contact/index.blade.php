@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Contact</h1>
       
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Update Contact</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.contact.update') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
            
                
                <div class="form-group">
                    <label>Phone One </label>
                    <input type="text" name="phone_one" class="form-control" value="{{$contact->phone_one}}">
                   
                </div>
                <div class="form-group">
                    <label>Phone Two </label>
                    <input type="text" name="phone_two" class="form-control" value="{{$contact->phone_two}}">
                   
                </div>
                <div class="form-group">
                    <label>Email One </label>
                    <input type="text" name="mail_one" class="form-control" value="{{$contact->mail_one}}">
                   
                </div>
                <div class="form-group">
                    <label>Email Two </label>
                    <input type="text" name="mail_two" class="form-control" value="{{$contact->mail_two}}">
                   
                </div>

                <div class="form-group">
                    <label>Address </label>
                     <textarea name="address" class="form-control">
                        {{$contact->address}}
                     </textarea>
                   
                </div>
               
                
                
                <div class="form-group">
                    <label>Google Map Link </label>
                     <textarea name="map_link" class="form-control">
                         {{$contact->map_link}}
                     </textarea>
                   
                </div>
                
               
                <button type="submit" class="btn btn-primary">Update</button>
                
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')

<script>
$(document).ready(function(){
    $('.iconpicker').iconpicker();
});
</script>


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




