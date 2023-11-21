@extends('layouts.master')

@push('style')
<style>
    .rating {
    display: inline-block;
    }

    .rating input {
    display: none;
    }

    .rating label {
    cursor: pointer;
    float: right; /* Align the stars to the right */
    }

    .rating label:before {
    content: '\2605';
    font-size: 2em;
    color: #ccc;
    }

    .rating input:checked + label:before {
    color: #ffcc00;
    }

    .rating input:checked ~ label:before {
    color: #ffcc00;
    }
</style>
@endpush

@section('breadcrumb')

@endsection

@section('content')
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Berikan feedback untuk kursus:</h4>
                <p class="card-title-desc">{{ $course->name }}</p>

                <form method="POST" action="{{ route('dashboard.student.course.feedback.store', $course->slug) }}" class="form-horizontal" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label" for="comment">Komentar</label>
                                <div>
                                    <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" rows="5" placeholder="Masukan penjelasan singkat" name="comment">{{ old('comment') ?? ($feedback->comment ?? '') }}</textarea>

                                    @error('comment')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <label class="form-label">Rating</label>
                            <div class="mb-3">
                                <div class="rating">
                                    <input type="radio" id="star5" name="rating" value="5" {{ old('rating') ?? ($feedback->rating ?? 0) == '5' ? 'checked' : '' }}>
                                    <label for="star5"></label>
                                    <input type="radio" id="star4" name="rating" value="4" {{ old('rating') ?? ($feedback->rating ?? 0) == '4' ? 'checked' : '' }}>
                                    <label for="star4"></label>
                                    <input type="radio" id="star3" name="rating" value="3" {{ old('rating') ?? ($feedback->rating ?? 0) == '3' ? 'checked' : '' }}>
                                    <label for="star3"></label>
                                    <input type="radio" id="star2" name="rating" value="2" {{ old('rating') ?? ($feedback->rating ?? 0) == '2' ? 'checked' : '' }}>
                                    <label for="star2"></label>
                                    <input type="radio" id="star1" name="rating" value="1" {{ old('rating') ?? ($feedback->rating ?? 0) == '1' ? 'checked' : '' }}>
                                    <label for="star1"></label>
                                </div>

                                @error('rating')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                        <a href="javascript:history.back()" class="btn btn-secondary waves-effect waves-light">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush
