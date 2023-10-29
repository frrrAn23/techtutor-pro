<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">List Materi</li>

                @foreach ($topics as $topic)
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect {{ $material->topic->id == $topic->id ? 'mm-active' : '' }}">
                            <span key="">{{ $topic->name }}</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">

                            @foreach ($topic->materials as $m)
                                <li class="{{ $material->id == $m->id ? 'mm-active' : '' }}">
                                    <a href="{{ route('dashboard.student.course.material.show', [$course->slug, $m->slug]) }}" key="" class="{{ $material->id == $m->id ? 'active' : '' }}">
                                        {{ $m->name }}

                                        @if ($m->is_completed)
                                            <span class="mdi mdi-check-circle-outline text-success float-end"></span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- Sidebar -->

    </div>

</div>
