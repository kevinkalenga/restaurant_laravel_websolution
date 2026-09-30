
@extends('admin.layouts.master')

@section('content')

<section class="section">

    <div class="section-header">
        <h1>Reservation Times</h1>
    </div>

    <div class="card card-primary">

        <div class="card-header">
            <h4>Edit Time</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.reservation-time.update', $time->id) }}"
                  method="POST"
                  novalidate>

                @csrf
                @method('PUT')

                {{-- Start Time --}}
                <div class="form-group">
                    <label>Start Time</label>

                    <input type="text"
                           name="start_time"
                           class="form-control timepicker"
                           value="{{ old('start_time', $time->start_time) }}">

                    @error('start_time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                {{-- End Time --}}
                <div class="form-group">
                    <label>End Time</label>

                    <input type="text"
                           name="end_time"
                           class="form-control timepicker"
                           value="{{ old('end_time', $time->end_time) }}">

                    @error('end_time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                {{-- Status --}}
                <div class="form-group">
                    <label>Status</label>

                    <select name="status" class="form-control">

                        <option value="1"
                            {{ old('status', $time->status) == 1 ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0"
                            {{ old('status', $time->status) == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <button type="submit" class="btn btn-primary">
                    Update Reservation
                </button>

                <a href="{{ route('admin.reservation-time.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>

    </div>

</section>

@endsection

