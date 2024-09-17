@extends('layouts.main.master')

@section('content')
<style>
    .fc-event-custom.event {
        background-color: #FF7F50;
        border-color: #FF7F50;
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
              <h2 class="page-title">All Salon Preorders</h2>
            </div>
          </div>
          <div id='salonCalendar'></div>
        </div> <!-- .col-12 -->
      </div> <!-- .row -->
    </div> <!-- .container-fluid -->      
  </main> <!-- main -->
</div> <!-- .wrapper -->

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' />

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('salonCalendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: '/salon/preorders', // Fetch the preorders from the server

        eventContent: function(arg) {
            let customEventContent = document.createElement('div');

            // Add the customer name (title)
            let titleElement = document.createElement('div');
            titleElement.innerHTML = arg.event.title;
            customEventContent.appendChild(titleElement);

            // Add the appointment time from `Appointment_time`
            if (arg.event.extendedProps.appointment_time) {
                let timeElement = document.createElement('div');
                timeElement.innerHTML = 'Time: ' + arg.event.extendedProps.appointment_time;
                customEventContent.appendChild(timeElement);
            }

            return { domNodes: [customEventContent] };
        },

        eventClassNames: 'fc-event-custom' // Apply your custom styles
    });

    calendar.render();
  });
</script>

@endsection
