@extends('layouts.main')
@section('container')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Grades</h3>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-group" role="group" aria-label="Actions">
                    <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download me-1"></i>Download</a>
                    <a href="{{ route('grade.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Add Grade</a>
                </div>
            </div>
        </div>
    </div>

    <form id="filterForm" method="GET" action="{{ route('grade.index') }}">
        <div class="row mb-3">
            <div class="col-md-2">
                <select name="task_type_id" id="task_type_id" class="form-select" onchange="this.form.submit()">
                        <option value="" {{ request('task_type_id') == "" ? 'selected' : '' }}>
                            All Types
                        </option>
                    @foreach ($taskTypes as $taskType)
                        <option value="{{ $taskType->id }}" {{ request('task_type_id') == $taskType->id ? 'selected' : '' }}>
                            {{ $taskType->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <select name="teacher_classroom_relationship_id" id="teacher_classroom_relationship_id" class="form-control data-select-2 @error('teacher_classroom_relationship_id') is-invalid @enderror" onchange="this.form.submit()">
                        <option value="" {{ request('teacher_classroom_relationship_id') == "" ? 'selected' : '' }}>
                            All Classes
                        </option>
                    @foreach ($teacherClassroomRelationships as $teacherClassroomRelationship)
                        <option value="{{ $teacherClassroomRelationship->id }}" {{ request('teacher_classroom_relationship_id') == $teacherClassroomRelationship->id ? 'selected' : '' }}>
                            {{ $teacherClassroomRelationship->teacherHomeroomRelationship->classroom->classroomType->name }} -
                            {{ $teacherClassroomRelationship->teacherHomeroomRelationship->classroom->name }} - {{ $teacherClassroomRelationship->TeacherSubjectRelationship->teacher->name }}-{{ $teacherClassroomRelationship->teacherSubjectRelationship->subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Task Type</th>
                    <th>Teacher Homeroom</th>
                    <th>Percentage (%)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grades as $index => $grade)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $grade->taskType->name }}</td>
                    <td class="text-center">{{ $grade->teacherClassroomRelationship->teacherHomeroomRelationship->classroom->classroomType->name }} -
                            {{ $grade->teacherClassroomRelationship->teacherHomeroomRelationship->classroom->name }} - {{ $grade->teacherClassroomRelationship->TeacherSubjectRelationship->teacher->name }}-{{ $grade->teacherClassroomRelationship->teacherSubjectRelationship->subject->name }}</td>
                    <td class="text-center">{{ $grade->percentage }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group" aria-label="Grade Actions">
                            <a href="{{ route('grade.edit', $grade->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('grade.destroy', $grade->id) }}" onsubmit="return confirm('Are you sure you want to delete this grade?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
