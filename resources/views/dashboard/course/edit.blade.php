@extends('layouts.master')

@push('style')
<link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('breadcrumb')

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Ubah kursus</h4>
                <p class="card-title-desc">Isi informasi dibawah ini</p>

                <form method="POST" action="{{ route('dashboard.course.update', $course->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukan nama" name="name" value="{{ old('name') ?? $course->name }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Harga</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Masukan harga" name="price" value="{{ old('price') ?? $course->price }}">

                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="retail_price" class="form-label">Harga Retail</label>
                                        <input type="number" class="form-control @error('retail_price') is-invalid @enderror" id="retail_price" placeholder="Masukan harga retail" name="retail_price" value="{{ old('retail_price') ?? $course->retail_price }}">

                                        @error('retail_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Labels</label>
                                <span class="text-muted ms-2">(Gunakan koma untuk memisahkan setiap label)</span>

                                <select id="labels" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Masukan label" name="labels[]">
                                    @foreach (old('labels') ?? ($course->labels ?? []) as $label)
                                        <option selected>{{$label}}</option>
                                    @endforeach
                                </select>

                                @error('labels')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="thumbnail" class="form-label">Thumbnail</label>
                                <small class="text-muted">(Opsional)</small>
                                <img class="d-block mt-1 mb-1" src="{{ getFile($course->thumbnail, asset('images/default-profile.jpg')) }}" height="100">

                                <input class="form-control  @error('thumbnail') is-invalid @enderror" type="file" id="thumbnail" name="thumbnail">

                                @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>

                                        <select class="form-select @error('status') is-invalid @enderror" name="status">
                                            <option disabled>Pilih</option>
                                            @foreach (App\Enums\CourseStatusEnum::getValues() as $courseStatus)
                                                <option value="{{ $courseStatus }}" {{ old('status') ?? $course->status == $courseStatus ? 'selected' : '' }}>{{ $courseStatus }}</option>
                                            @endforeach
                                        </select>

                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Level</label>

                                        <select class="form-select @error('level') is-invalid @enderror" name="level">
                                            <option disabled>Pilih</option>
                                            @foreach (App\Enums\CourseLevelEnum::getValuesAndLabels() as $level => $label)
                                                <option value="{{ $level }}" {{ old('level') ?? $course->level == $level ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>

                                        @error('level')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>

                                        <select class="form-select @error('type') is-invalid @enderror" name="course_category_id">
                                            <option disabled>Pilih</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('course_category_id') ?? $course->course_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('course_category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tipe</label>

                                        <select class="form-select @error('type') is-invalid @enderror" name="type">
                                            <option disabled>Pilih</option>
                                            @foreach (App\Enums\CourseTypeEnum::getValues() as $type)
                                                <option value="{{ $type }}" {{ old('type') ?? $course->type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                            @endforeach
                                        </select>

                                        @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="summary">Penjelasan Singkat</label>
                                <div>
                                    <textarea class="form-control @error('summary') is-invalid @enderror" id="summary" rows="5" placeholder="Masukan penjelasan singkat" name="summary">{{ old('summary') ?? $course->summary }}</textarea>

                                    @error('summary')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>

                            <textarea id="description" name="description">
                                {{ old('description') ?? $course->description }}
                            </textarea>

                            @error('description')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                        <a href="{{ route('dashboard.course.index') }}" class="btn btn-secondary waves-effect waves-light">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script>
    $("#labels").select2({
        tags: true,
        tokenSeparators: [',', ' '],
        createTag: function (params) {
            var term = $.trim(params.term);

            if (term === '' || term.length <= 1) {
                return null;
            }

            return {
                id: term,
                text: term,
                newTag: true
            }
        }
    })

    autoSavePrefix = 'edit-course-{{ Auth::user()->id }}-{{ $course->id }}';

    tinymce.init({
        selector: '#description',
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
    });


    setInterval(() => {
        var listboxElement = document.querySelector('[role="listbox"]');
        var dialogWrap = document.querySelector('.tox-dialog-wrap');

        if (listboxElement) {
            dialogWrap.classList.add('d-none');
        } else {
            dialogWrap.classList.remove('d-none');
        }
    }, 1000);
</script>
@endpush
