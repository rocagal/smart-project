@extends("layouts.main")
@section("container")


<div class="page-header">
    <div class="row align-items-center">
        <div class="col mb-3">
            <h3 class="page-title">{{ $title }}</h3>
        </div>

        <div class="col-auto text-end float-end ms-auto download-grp">
            <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
        </div>

        <form id="filterForm" action="{{ URL::to('book-return') }}" method="GET">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="startDate">From:</label>
                        <input type="date" id="startDate" name="startDate" class="form-control" value="{{ request('startDate') }}">                            
                        <button type="submit" class="btn btn-primary mt-2">Filter</button>
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label for="endDate">To:</label>
                        <input type="date" id="endDate" name="endDate" class="form-control" value="{{ request('endDate', \Carbon\Carbon::now()->toDateString()) }}">               
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">All</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                            <option value="borrowing" {{ request('status') == 'borrowing' ? 'selected' : '' }}>Borrowing</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead class="student-thread">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Patron</th>
                <th class="text-center">Description</th>
                <th class="text-center">Checkout Date</th>
                <th class="text-center">Due Date</th>
                <th class="text-center">Status</th>
                <th class="text-center">Penalty</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($filterByDate as $index => $filter)
                @if(request('status') && $filter->status != request('status'))
                    @continue
                @endif
                <tr class="align-middle">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $filter->classroom_name }} - ({{ $filter->identity_number }}) - {{ $filter->name }}</td>
                    <td>{{ $filter->description }}</td>
                    <td>{{ $filter->checkout_date }}</td>
                    <td>{{ $filter->due_date }}</td>
                    <td class="text-center">
                        @if($filter->status == 'borrowing')
                            <span class="badge bg-warning">{{ $filter->status }}</span>
                        @elseif($filter->status == 'returned')
                            <span class="badge bg-success">{{ $filter->status }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($filter->status == 'borrowing')
                            @php
                                $dueDate = \Carbon\Carbon::parse($filter->due_date);
                                $today = \Carbon\Carbon::now();
                                $penalty = $today->diffInDays($dueDate); 
                                $penaltyRate = 1000;
                                $penaltyAmount = $penalty * $penaltyRate; 
                            @endphp
                            @if ($penalty > 0)
                                {{ $penaltyAmount }} 
                            @else
                                0
                            @endif
                        @else
                            0
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <form method="POST" action="{{ URL::to('book-return/' . $filter->id) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Anda yakin mau menghapus peminjaman buku oleh {{ $filter->name }} ?')">
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



@endsection