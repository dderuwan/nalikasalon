@extends('layouts.main.master')

@section('content')
<style>
    .fc-event-custom.event {
        background-color: #27E151;
        border-color: #27E151;
    }
  
    .fc-time {
        padding: 0 0 0 2px;
        font-size: 12px;
    }

    .fc-title {
        display: block;
        padding: 0 0 0 2px;
        font-size: 12px;
    }
    .fc td, .fc th {
        border-left: 1px solid #ddd !important;
    }
</style>

<div class="wrapper">     
  <main role="main" class="main-content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="row align-items-center my-3">
            <div class="col">
              <h2 class="page-title">All Appointments</h2>
            </div>
            <div class="col-auto">
              <button type="button" class="btn" data-toggle="modal" data-target=".modal-calendar"><span class="fe fe-filter fe-16 text-muted"></span></button>
              <a href="{{ route('new_appointment') }}"><button type="button" class="btn btn-primary" data-toggle="modal">
                <span class="fe fe-plus fe-16 mr-3"></span>New Appointment</button></a>
            </div>
          </div>
          <div id='calendar'></div>
          <!-- new event modal -->
          <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
              </div>
            </div>
          </div> <!-- new event modal -->
        </div> <!-- .col-12 -->
      </div> <!-- .row -->
    </div> <!-- .container-fluid -->      
  </main> <!-- main -->
</div> <!-- .wrapper -->

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' />

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/appointments/getPreorders',
            eventClassNames: 'fc-event-custom'
        });
        calendar.render();
    });
</script>
@endsection
