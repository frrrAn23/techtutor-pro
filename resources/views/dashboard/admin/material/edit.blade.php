@extends('layouts.master')

@push('style')
@endpush

@section('breadcrumb')

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Ubah materi untuk topic <u class="">{{ $material->topic->name }}</u> pada kursus <u>{{ $material->topic->course->name }}</u></h4>
                <p class="card-title-desc">Isi informasi dibawah ini</p>

                <form method="POST" action="{{ route('dashboard.admin.course.material.update', $material->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukan nama" name="name" value="{{ old('name') ?? $material->name }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @if ($material->course->type === App\Enums\CourseTypeEnum::VIDEO)
                            <div class="mb-3">
                                <label for="video-url" class="form-label">Link Video</label>
                                <input type="text" class="form-control @error('video_url') is-invalid @enderror" id="video-url" placeholder="Masukan link video" name="video_url" value="{{ old('video_url') ?? $material->video_url }}">

                                @error('video_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @endif

                            <div class="mb-3">
                                <label for="price" class="form-label">Durasi</label>
                                <span class="text-muted">(dalam menit)</span>

                                <input type="number" class="form-control @error('duration_in_minutes') is-invalid @enderror" id="duration_in_minutes" placeholder="Masukan durasi menyelesaikan materi" name="duration_in_minutes" value="{{ old('duration_in_minutes') ?? $material->duration_in_minutes }}">

                                @error('duration_in_minutes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>

                                <select class="form-select @error('status') is-invalid @enderror" name="status">
                                    <option disabled>Pilih</option>
                                    @foreach (App\Enums\MaterialStatusEnum::getValues() as $materialStatus)
                                        <option value="{{ $materialStatus }}" {{ old('status') ?? $material->status == $materialStatus ? 'selected' : '' }}>{{ $materialStatus }}</option>
                                    @endforeach
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-check form-switch form-switch-md mb-3">
                                <input class="form-check-input" type="checkbox" id="is_preview" value="true" name="is_preview" {{ old('is_preview') ?? $material->is_preview == 'true' ? 'checked' : ''}}>
                                <label class="form-check-label" for="is_preview">Pratinjau</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Konten</label>

                                <textarea id="content" name="content">
                                    {{ old('content') ?? $material->content }}
                                </textarea>

                                @error('content')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                        <a href="{{ route('dashboard.admin.course.show', $material->topic->course_id) }}" class="btn btn-secondary waves-effect waves-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('libs/tinymce/tinymce.min.js') }}"></script>
<script>
    autoSavePrefix = 'edit-material-{{ Auth::user()->id }}-{{ $material->id }}';

    tinymce.init({
        selector: '#content',
        width: 600,
        height: 300,
        plugins: [
            'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
            'searchreplace', 'wordcount', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media',
            'table', 'emoticons', 'template', 'help', 'nonbreaking', 'directionality', 'accordion', 'autosave', 'codesample'
        ],
        toolbar: 'codesample restoredraft undo redo | styles | bold italic accordion | alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
            'forecolor backcolor emoticons | help',
        menubar: 'file edit view insert format tools table help',
        codesample_languages: [
            { text: 'HTML/XML', value: 'markup' },
            { text: 'JavaScript', value: 'javascript' },
            { text: 'CSS', value: 'css' },
            { text: 'PHP', value: 'php' },
            { text: 'Ruby', value: 'ruby' },
            { text: 'Python', value: 'python' },
            { text: 'Java', value: 'java' },
            { text: 'C', value: 'c' },
            { text: 'C#', value: 'csharp' },
            { text: 'C++', value: 'cpp' }
        ],
        autosave_prefix: autoSavePrefix,
        width: '100%',
        codesample_global_prismjs: true
    });


    setInterval(() => {
        var elementWithPythonTitle = document.querySelector('[title="Python"]');
        var dialogWrap = document.querySelector('.tox-dialog-wrap');

        if (elementWithPythonTitle || dialogWrap.classList.contains('d-none')) {
            var listboxElement = document.querySelector('[role="listbox"]');

            if (listboxElement) {
                dialogWrap.classList.add('d-none');
            } else {
                dialogWrap.classList.remove('d-none');
            }
        }
    }, 1000);
</script>
@endpush
