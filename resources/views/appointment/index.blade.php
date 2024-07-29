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
                    <div class="modal-header">
                      <h5 class="modal-title" id="varyModalLabel">New Event</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body p-4">
                      <form>
                        <div class="form-group">
                          <label for="eventTitle" class="col-form-label">Title</label>
                          <input type="text" class="form-control" id="eventTitle" placeholder="Add event title">
                        </div>
                        <div class="form-group">
                          <label for="eventNote" class="col-form-label">Note</label>
                          <textarea class="form-control" id="eventNote" placeholder="Add some note for your event"></textarea>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-8">
                            <label for="eventType">Event type</label>
                            <select id="eventType" class="form-control select2">
                              <option value="work">Work</option>
                              <option value="home">Home</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="date-input1">Start Date</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16"></span></div>
                              </div>
                              <input type="text" class="form-control drgpicker" id="drgpicker-start" value="04/24/2020">
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="startDate">Start Time</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text" id="button-addon-time"><span class="fe fe-clock fe-16"></span></div>
                              </div>
                              <input type="text" class="form-control time-input" id="start-time" placeholder="10:00 AM">
                            </div>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="date-input1">End Date</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16"></span></div>
                              </div>
                              <input type="text" class="form-control drgpicker" id="drgpicker-end" value="04/24/2020">
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="startDate">End Time</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text" id="button-addon-time"><span class="fe fe-clock fe-16"></span></div>
                              </div>
                              <input type="text" class="form-control time-input" id="end-time" placeholder="11:00 AM">
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="RepeatSwitch" checked>
                        <label class="custom-control-label" for="RepeatSwitch">All day</label>
                      </div>
                      <button type="button" class="btn mb-2 btn-primary">Save Event</button>
                    </div>
                  </div>
                </div>
              </div> <!-- new event modal -->
        </div> <!-- .col-12 -->
      </div> <!-- .row -->
    </div> <!-- .container-fluid -->      
  </main> <!-- main -->
</div> <!-- .wrapper -->

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar;

    var useDatabaseEvents = false; // Set to true to fetch events from database

    var hardcodedEvents = [
      {
        title: 'Event 1',
        start: '2024-07-20T10:30:00',
        end: '2024-07-20T12:30:00',
        className: 'fc-event-custom event' 
      },
      {
        title: 'Event 2',
        start: '2024-07-20T14:00:00',
        className: 'fc-event-custom event'
      },
      {
        title: 'Event 4',
        start: '2024-07-20T14:00:00',
        className: 'fc-event-custom event'
      },
      {
        title: 'Event 3',
        start: '2024-07-26T09:00:00',
        className: 'fc-event-custom event'
      }
    ];

    calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['dayGrid', 'timeGrid', 'list', 'bootstrap'],
      timeZone: 'UTC',
      themeSystem: 'bootstrap',
      header: {
        left: 'today, prev, next',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      buttonIcons: {
        prev: 'fe-arrow-left',
        next: 'fe-arrow-right',
        prevYear: 'left-double-arrow',
        nextYear: 'right-double-arrow'
      },
      weekNumbers: true,
      eventLimit: true, 
      events: useDatabaseEvents ? '/api/events' : hardcodedEvents,
      eventTimeFormat: { 
        hour: 'numeric',
        minute: '2-digit',
        meridiem: 'short'
      },
      eventContent: function(arg) {
        return {
          html: `
            <div class="fc-time">${arg.timeText}</div>
            <div class="fc-title">${arg.event.title}</div>
          `
        };
      },
      eventRender: function(info) {
        if (info.event.extendedProps.className) {
          info.el.classList.add(info.event.extendedProps.className);
        }
      }
    });

    calendar.render();
  });
</script>

@endsection
