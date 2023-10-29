@extends('layouts.master')

@push('style')
@endpush

@section('breadcrumb')

@endsection

@section('content')
<div class="row">
    <div class="col-lg-9 mx-auto">
        <div class="card">
            <div class="card-body">
                <h1 class="mb-4 text-center">{{ $material->name }}</h1>

                @if ($course->type == App\Enums\CourseTypeEnum::VIDEO && !is_null($material->video_url))
                    <div class="ratio ratio-16x9 mb-5">
                        <iframe src="{{ $material->video_url }}" title="{{ $material->name }}" allowfullscreen></iframe>
                    </div>
                @endif

                <div class="content-material">
                    {!! $material->content !!}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <a href="{{ route('dashboard.student.course.show', $course->slug) }}" class="btn btn-info"><i class="mdi mdi-arrow-left"></i> Ke detail kursus</a>

                <button onclick="saveUserProgress()" class="btn btn-success">Saya Sudah Paham Materi ini</button>

                @if ($nextMaterial)
                    <a href="{{ route('dashboard.student.course.material.show', [$course->slug, $nextMaterial->slug]) }}" class="btn btn-primary"> Materi Selanjutnya <i class="mdi mdi-arrow-right"></i></a>
                @endif

                @if ($isCompleted && !$nextMaterial)
                    <a href="{{ route('dashboard.student.course.feedback.create', $course->slug) }}" class="btn btn-primary">Beri Feedback</a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function(){
        $("div.content-material img").addClass("img-fluid");
    });

    function saveUserProgress() {
        $.ajax({
            url: "{{ url('api/user-material-progress') }}/{{ $material->id }}",
            method: "POST",
            data: {
               'userId': "{{ Auth::user()->id }}",
            },
            success: function(response) {
                    const nextMaterialSlug = '{{ $nextMaterial ? $nextMaterial->slug : "" }}';

                    payloadSwal = {
                        icon: 'success',
                        title: 'Keren!',
                        text: "Kamu berhasil menyelesaikan materi ini",
                        showConfirmButton: false,
                        showCancelButton : true,
                        cancelButtonText: 'Kembali ke Materi',
                    };

                    if (nextMaterialSlug != '') {
                        payloadSwal.showConfirmButton = true;
                        payloadSwal.confirmButtonText = 'Ke Materi Selanjutnya';
                    }

                    Swal.fire(payloadSwal).then((result) => {
                        if (result.isConfirmed) {
                            @if ($nextMaterial)
                                window.location.href = "{{ route('dashboard.student.course.material.show', [$course->slug, $nextMaterial->slug]) }}";
                            @endif
                        } else {
                            window.location.href = "{{ route('dashboard.student.course.material.show', [$course->slug, $material->slug]) }}";
                        }
                    });
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
</script>
@endpush
