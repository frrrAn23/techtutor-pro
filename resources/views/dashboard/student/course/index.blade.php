@extends('layouts.master')

@push('style')
<style>
    .course {
        transition: transform 0.2s;
    }

    .course:hover {
        transform: scale(1.05);
        cursor: pointer;
    }

    .product-image {
        height: 200px; /* Set a fixed height for the product images */
        object-fit: cover; /* This property ensures the image covers the container */
    }

    .product-card {
        height: 450px;
    }
</style>
@endpush

@section('breadcrumb')

@endsection

@section('content')
<div class="row">
    <div class="col-lg-3">
        <form action="{{ route('dashboard.student.course.index') }}">
            <div class="search-box me-2 mb-3">
                <div class="position-relative">
                    <input type="text" class="form-control border-0" placeholder="Cari kursus..." name="name" value="{{ request('name') }}">
                    <i class="bx bx-search-alt search-icon"></i>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Filter</h4>

                    <div class="mt-4 pt-2">
                        <h5 class="font-size-14 mb-3">Metode</h5>
                        @foreach (App\Enums\CourseTypeEnum::getValues() as $type)
                        <div class="form-check mt-2">
                            <input class="form-check-input" value="{{ $type }}" type="checkbox" id="type-{{ $type }}" name="types[]" {{ request('types') && in_array($type, request('types')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="type-{{ $type }}">
                                {{ $type }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-2">
                        <h5 class="font-size-14 mb-3">Level</h5>

                        <select class="form-select" name="level">
                            <option selected>Semua Level</option>

                            @foreach (App\Enums\CourseLevelEnum::getValuesAndLabels() as $level)
                                <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4 pt-2">
                        <h5 class="font-size-14 mb-3">Teknologi</h5>

                        <select class="form-select" name="technology">
                            <option selected>Semua Teknologi</option>

                            @foreach ($courseCategories as $courseCategory)
                                <option value="{{ $courseCategory->id }}" {{ request('technology') == $courseCategory->id ? 'selected' : '' }}>{{ $courseCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4 pt-3">
                        <h5 class="font-size-14 mb-3">Feedback Siswa</h5>
                        <div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="productratingCheck1">
                                <label class="form-check-label" for="productratingCheck1">
                                    5 <i class="bx bxs-star text-warning"></i>
                                </label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="productratingCheck1">
                                <label class="form-check-label" for="productratingCheck1">
                                    4 <i class="bx bxs-star text-warning"></i>
                                </label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="productratingCheck2">
                                <label class="form-check-label" for="productratingCheck2">
                                    3 <i class="bx bxs-star text-warning"></i>
                                </label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="productratingCheck3">
                                <label class="form-check-label" for="productratingCheck3">
                                    2 <i class="bx bxs-star text-warning"></i>
                                </label>
                            </div>

                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="productratingCheck4">
                                <label class="form-check-label" for="productratingCheck4">
                                    1 <i class="bx bxs-star text-warning"></i>
                                </label>
                            </div>

                        </div>
                    </div>

                    <!-- submit button with class success -->
                    <div class="mt-4 pt-3">
                        <button type="submit" class="btn btn-success btn-block waves-effect waves-light w-100">Terapkan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-lg-9">
        <div class="row mb-3">
            <div class="col-xl-4 col-sm-6">
                <div class="mt-2">
                    <h5>Kursus</h5>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse ($courses as $course)
                @php
                    $course->discount = $course->retail_price != 0 ? ($course->price - $course->retail_price) / $course->price * 100 : 0;
                    $course->duration_in_minutes = $course->topics->sum(function ($topic) {
                        return $topic->materials->sum('duration_in_minutes');
                    });
                    $course->total_materials = $course->topics->sum(function ($topic) {
                        return $topic->materials->count();
                    });

                    $course->rating = $course->feedbacks->avg('rating');
                @endphp

                <div class="col-xl-4 col-sm-6" onclick="window.location.href='{{ route('dashboard.student.course.show', $course->slug) }}'">
                    <div class="card course">
                        <div class="card-body">
                            <div class="product-card">
                                <div class="product-img position-relative">
                                    @if ($course->discount > 0)
                                        <div class="avatar-sm product-ribbon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                - {{ $course->discount }} %
                                            </span>
                                        </div>
                                    @endif
                                    <img src="{{ getFile($course->thumbnail_url, asset('images/default-profile.jpg')) }}" alt="" class="img-fluid mx-auto d-block product-image">
                                </div>
                                <div class="mt-4">
                                    <h5 class="mb-2 text-truncate"><a href="javascript: void(0);" class="text-dark">{{ $course->name }} </a></h5>
                                    <div class="mb-2">
                                        @php
                                            $level = $course->level;
                                            $levelLabel = $level == 0 ? 'Pemula' : ($level == 1 ? 'Menengah' : 'Mahir');
                                            $levelColor = $level == 0 ? 'primary' : ($level == 1 ? 'warning' : 'danger');
                                        @endphp
                                        <span class="badge rounded-pill bg-{{ $levelColor }} font-size-12">{{ $levelLabel }}</span>

                                        <p class="ms-2 text-muted d-inline">
                                            @for ($i = 1; $i <= $course->rating; $i++)
                                                <i class="bx bxs-star text-warning"></i>
                                            @endfor
                                            @for ($i = $course->rating; $i < 5; $i++)
                                                <i class="bx bxs-star"></i>
                                            @endfor

                                            ({{ $course->feedbacks->count() }} Feedback)
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <span class="font-size-12"><i class="mdi mdi-account"></i> {{ $course->users->count() }} Siswa</span>
                                        <span class="ms-2 font-size-12"><i class="mdi mdi-book-open-page-variant"></i> {{ $course->total_materials }} Materi</span>
                                        <span class="ms-2 font-size-12"><i class="mdi mdi-clock-outline"></i> {{ $course->duration_in_minutes }} Menit</span>
                                    </div>

                                    <p>{{ Str::limit($course->summary, 88) }}</p>

                                    <h5 class="my-0">
                                        @if ($course->discount > 0)
                                            <span class="text-muted me-2"><del>Rp. {{ number_format($course->price, 0, ',', '.')  }}</del>  <b>Rp. {{ number_format($course->retail_price, 0, ',', '.') }}</b></span>
                                        @else
                                            @if ($course->price == 0)
                                                <b>Gratis</b>
                                            @else
                                                <b>Rp. {{ number_format($course->price, 0, ',', '.') }}</b>
                                            @endif
                                        @endif
                                    </h5>

                                    <div class="mt-3">
                                        <span class="badge badge-soft-success font-size-12">{{ $course->type }}</span>
                                        @foreach ($course->labels ?? [] as $label)
                                            <span class="badge rounded-pill badge-soft-info font-size-12">{{ $label }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <a href="#" class="btn btn-primary btn-sm w-100 mt-3">Lihat kursus</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center">
                                Belum ada kursus
                                @if(request('types') || request('level') || request('category'))
                                    dengan filter tersebut
                                @elseif (request('name'))
                                    dengan kata kunci <b>{{ request('name') }}</b>
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush
