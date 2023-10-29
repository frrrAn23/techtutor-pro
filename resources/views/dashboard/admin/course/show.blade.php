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
                                <h5 class="mb-4">Harga : <span class="text-muted me-2"><del>Rp. {{ number_format($course->price, 0, ',', '.') }}</del></span> <b>Rp. {{ number_format($course->retail_price, 0, ',', '.') }}</b></h5>
                            @else
                                @if ($course->price == 0)
                                    <h5 class="mb-4"><b>Gratis</b></h5>
                                @else
                                    <h5 class="mb-4">Harga : <b>Rp. {{ number_format($course->price, 0, ',', '.') }}</b></h5>
                                @endif
                            @endif

                            <p class="text-muted mb-4">{{ $course->summary }}</p>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div>
                                        <p><span class="text-muted">Status:</span> <span class="badge font-size-12 m-1 @if($course->status == 'active') badge-soft-success @elseif($course->status == 'inactive') badge-soft-danger @elseif($course->status == 'draft') badge-soft-secondary @else badge-soft-warning @endif">{{ $course->status }}</span></p>
                                        <p><span class="text-muted">Type:</span> {{ $course->type }}</p>
                                        <p><span class="text-muted">Level:</span> {{ App\Enums\CourseLevelEnum::getLabel($course->level) }}</p>
                                        <p><span class="text-muted">Durasi:</span> {{ $durationInMinute }} Menit</p>
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

    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <h4 class="card-title">List Topik</h4>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <a href="{{ route('dashboard.admin.course.topic.create', $course->id) }}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Tambah Topik</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    @foreach ($topics as $topic)
                                        <a class="nav-link mb-2 @if($loop->first) active @endif" id="v-pills-{{ $topic->id }}-tab" data-bs-toggle="pill" href="#v-pills-{{ $topic->id }}" role="tab" aria-controls="v-pills-{{ $topic->id }}" aria-selected="@if($loop->first) true @endif">{{ $topic->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                    @foreach ($topics as $topic)
                                    <div class="tab-pane fade @if($loop->first) active show @endif" id="v-pills-{{ $topic->id }}" role="tabpanel" aria-labelledby="v-pills-{{ $topic->id }}-tab">
                                        <div class="accordion" id="accordionMaterial">
                                            <div class="mb-3">
                                                @if (!$loop->first)
                                                    <form method="POST" action="{{ route('dashboard.admin.course.topic.up', ['courseId' => $course->id, 'id' => $topic->id]) }}" class="d-inline">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light btn-sm">
                                                            <i class="mdi mdi-arrow-up"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if (!$loop->last)
                                                <form method="POST" action="{{ route('dashboard.admin.course.topic.down', ['courseId' => $course->id, 'id' => $topic->id]) }}" class="d-inline">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning waves-effect waves-light btn-sm">
                                                        <i class="mdi mdi-arrow-down"></i>
                                                    </button>
                                                </form>
                                                @endif

                                                <a href="{{ route('dashboard.admin.course.topic.edit', ['courseId' => $course->id, 'id' => $topic->id]) }}" class="btn btn-success waves-effect waves-light btn-sm">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>

                                                <a href="#" onclick="modalDelete('Topik', '{{ $topic->name }}', `{{ route('dashboard.admin.course.topic.delete', ['courseId' => $course->id, 'id' => $topic->id]) }}`, '{{ url()->current() }}')" class="btn btn-danger waves-effect waves-light btn-sm">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-sm-4">
                                                    <h4 class="card-title">List Materi</h4>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="text-sm-end">
                                                        <a href="{{ route('dashboard.admin.course.material.create', $topic->id) }}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 btn-sm"><i class="mdi mdi-plus me-1"></i> Tambah materi</a>
                                                    </div>
                                                </div>
                                            </div>

                                            @forelse ($topic->materials->sortBy('order', 1) as $material)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne-{{ $material->id }}">
                                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $material->id }}" aria-expanded="false" aria-controls="collapse-{{ $material->id }}">
                                                        {{ $material->name }}
                                                    </button>
                                                </h2>
                                                <div id="collapse-{{ $material->id }}" class="accordion-collapse collapse" aria-labelledby="headingOne-{{ $material->id }}" data-bs-parent="#accordionMaterial" style="">
                                                    <div class="accordion-body">
                                                        <div class="mb-3">
                                                            @if (!$loop->first)
                                                                <form method="POST" action="{{ route('dashboard.admin.course.material.up', ['courseId' => $course->id, 'id' => $material->id]) }}" class="d-inline">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary waves-effect waves-light btn-sm">
                                                                        <i class="mdi mdi-arrow-up"></i>
                                                                    </button>
                                                                </form>
                                                            @endif

                                                            @if (!$loop->last)
                                                            <form method="POST" action="{{ route('dashboard.admin.course.material.down', ['courseId' => $course->id, 'id' => $material->id]) }}" class="d-inline">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="submit" class="btn btn-warning waves-effect waves-light btn-sm">
                                                                    <i class="mdi mdi-arrow-down"></i>
                                                                </button>
                                                            </form>
                                                            @endif

                                                            <a href="{{ route('dashboard.admin.course.material.edit', ['courseId' => $course->id, 'id' => $material->id]) }}" class="btn btn-success waves-effect waves-light btn-sm">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </a>


                                                            <a href="#" onclick="modalDelete('Materi', '{{ $material->name }}', `{{ route('dashboard.admin.course.material.delete', $material->id) }}`, '{{ url()->current() }}')" class="btn btn-danger waves-effect waves-light btn-sm">
                                                                <i class="mdi mdi-delete"></i>
                                                            </a>

                                                            <span class="text-muted ml-5">Status:</span> <span class="badge font-size-12 m-1 @if($course->status == 'active') badge-soft-success @else badge-soft-warning @endif">{{ $material->status }}</span>
                                                            @if ($material->is_preview)
                                                            |    <span class="badge font-size-12 m-1 badge-soft-primary">Pratinjau</span>
                                                            @else
                                                            |    <span class="badge font-size-12 m-1 badge-soft-secondary">Tidak Pratinjau</span>
                                                            @endif
                                                            | <span class="text-muted ml-5">Durasi:</span> {{ $material->duration_in_minutes }} Menit
                                                            @if ($material->video_url)
                                                            |   <a href="{{ $material->video_url }}" target="_blank" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                                    <i class="mdi mdi-play"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                                Belum ada materi
                                            @endforelse
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush
