@extends('layouts.master')

@push('style')
@endpush

@section('breadcrumb')

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="product-detai-imgs">
                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <img src="{{ getFile($course->thumbnail_url, asset('images/default-profile.jpg')) }}" alt="" class="img-fluid mx-auto d-block">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="mt-4 mt-xl-3">
                            <p class="text-primary">{{ $course->courseCategory->name }}</a>
                            <h4 class="mt-1 mb-3">{{ $course->name }}</h4>

                            <p class="text-muted float-start me-3">
                                <span class="bx bxs-star text-warning"></span>
                                <span class="bx bxs-star text-warning"></span>
                                <span class="bx bxs-star text-warning"></span>
                                <span class="bx bxs-star text-warning"></span>
                                <span class="bx bxs-star"></span>
                            </p>
                            <p class="text-muted mb-4">( 152 Feedback )</p>

                            @if ($course->discount > 0)
                                <h6 class="text-success text-uppercase">Diskon {{ number_format($course->discount, 1) }} % </h6>
                                <h5 class="mb-4">Harga : <span class="text-muted me-2"><del>Rp. {{ number_format($course->retail_price, 0, ',', '.') }}</del></span> <b>Rp. {{ number_format($course->price, 0, ',', '.') }}</b></h5>
                            @endif

                            <p class="text-muted mb-4">{{ $course->summary }}</p>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div>
                                        <p><span class="text-muted">Status:</span> <span class="badge font-size-12 m-1 @if($course->status == 'active') badge-soft-success @elseif($course->status == 'inactive') badge-soft-danger @elseif($course->status == 'draft') badge-soft-secondary @else badge-soft-warning @endif">{{ $course->status }}</span></p>
                                        <p><span class="text-muted">Type:</span> {{ $course->type }}</p>
                                        <p><span class="text-muted">Level:</span> {{ App\Enums\CourseLevelEnum::getLabel($course->level) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="mt-5">
                    <h5 class="mb-3">Tentang Kelas :</h5>

                    {!! $course->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush
