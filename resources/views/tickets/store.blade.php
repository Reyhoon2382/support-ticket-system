@extends('layouts.app')
@section('content')


<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
    
    <h5>داشبورد</h5>

        {{-- <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Create Ticket</a> --}}
    <a href="{{ route('tickets.create') }}" class="btn btn-dark">ایجاد تیکت </a>
    </div>

    <div class="card-body">
    
      <table class="table table-striped">
        <thead>
            <tr>
                <th>شماره</th>
                <th>عنوان</th>
                <th>وضعیت</th>
                <th>دپارتمان</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket )
            <tr>
                <td>{{ $ticket->ticket_number }}</td>
                <td>{{ $ticket->title }}</td>
                <td>{{ $ticket->status->value }}</td>
                <td>{{ $ticket->department->value }}</td>
                <td>
                   
                     <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-secondary">مشاهده</a>

                   
                </td>
            </tr>       
            @endforeach
        </tbody>
    </table>
  </div>
</div>
@endsection
   