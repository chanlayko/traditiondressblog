
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS --> 

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script src="../dist/js/adminlte.min.js"></script>

<script src="../plugins/summernote/summernote-bs4.min.js"></script>

<script src="../plugins/chart.js/Chart.min.js"></script>

<script src="../dist/js/pages/dashboard2.js"></script>

<script src="../dist/js/pages/dashboard3.js"></script>

<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>

<script src="../plugins/fullcalendar/main.min.js"></script>
<script src="../plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="../plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="../plugins/fullcalendar-interaction/main.min.js"></script>
<script src="../plugins/fullcalendar-bootstrap/main.min.js"></script>

<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendarInteraction.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
        console.log(eventEl);
        return {
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
        };
      }
    });

    var calendar = new Calendar(calendarEl, {
      plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      'themeSystem': 'bootstrap',
      //Random default events
      
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function(info) {
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      }    
    });

    calendar.render();
    // $('#calendar').fullCalendar()

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color'    : currColor
      })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      ini_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
</script>

<script>



    $(function() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });

        $('.swalDefaultSuccess').click(function() {
          Toast.fire({
            icon: 'success',
            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
          });
        });

        $('.swalDefaultError').click(function() {
          Toast.fire({
            icon: 'error',
            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
          })
        });
    });

  $("#reset").click(function(){
    $("#sendsubject").val('');
    $(".sendtext").val('');
  });
  
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })

  $(function () {
    //Add text editor
    $('#compose-textarea').summernote()
  })

 </script>
<script>
    $(document).ready(function() {
        // var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        // var pieData        = donutData;
        // var pieOptions     = {
        //   maintainAspectRatio : false,
        //   responsive : true,
        // }
        // //Create pie or douhnut chart
        // // You can switch between pie and douhnut using the method below.
        // var pieChart = new Chart(pieChartCanvas, {
        //   type: 'pie',
        //   data: pieData,
        //   options: pieOptions      
        // });
    });

    $(document).ready(function() {
        $('#astar').css('display', 'none');
        $('#btnstar').css('display', 'none');
        $('#checkboxstar').css('display', 'none');

        $('#btnstar1').click(function(){
            $('#astar').show();
            $('#checkboxstar').val('1');
            $('#btnstar1').css('display', 'none');
            $('#btnstar').show();
        });
        $('#btnstar').click(function(){
            $('#astar').css('display', 'none');
            $('#checkboxstar').val('');
            $('#btnstar1').show();
            $('#btnstar').css('display', 'none');
        });
    });
    $(document).ready(function() {
        $('#checkboxsta').css('display', 'none');
        $('#asta').css('display', 'none');
        $('#btnsta').css('display', 'none');

        $('#btnsta1').click(function(){
            $('#checkboxsta').val('1');
            $('#asta').show();
            $('#btnsta1').css('display', 'none');
            $('#btnsta').show();
        });
        $('#btnsta').click(function(){
            $('#checkboxsta').val('');
            $('#asta').css('display', 'none');
            $('#btnsta1').show();
            $('#btnsta').css('display', 'none');
        });
// ----------------    --------------------------------
        $('#btnst1').css('display', 'none');

        $('#btnst').click(function(){
            $('#checkboxsta').val('');
            $('#ast').css('display', 'none');
            $('#btnst1').show();
            $('#btnst').css('display', 'none');
        });
        $('#btnst1').click(function(){
            $('#checkboxsta').val('1');
            $('#ast').show();
            $('#btnst1').css('display', 'none');
            $('#btnst').show();
        });
    }); 
	$(document).ready(function() {
		$('input[id="Image"]').click(function(){
			bothFunction('Image');
		});
		var bothFunction = function(Both){
			var result = $('input[id="'+ Both +'"]:checked');
			if(result.length > 0){
				var resultString = result.length + ' is Typed' + '<br>';
				result.each(function(){
					resultString += 'CG - ' + $(this).val() + '<br>';
				});
				$('#divBox'+Both).html(resultString);
			}else{
				$('#divBox'+Both).html('Is not selected');
			}
		}
	});
	// -------------------  image_delete.php/selecting  --------------------------
	$(document).ready(function() {
        $('#hiddenselect').css('display', 'none');

        $("#viewmassage").click(function() {
                $('#hiddenselect').slideToggle(500);
            });
    });
    // ----------------------------------------------------------------------------

	$(document).ready(function(){
        $('#selectallbox').click(function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked=true;
                })
            }else{
               $('.checkbox').each(function(){
                    this.checked=false;
                }) 
            }
        })
    })
	//  -----------------  checkboxs  -----------------

    $(document).ready(function() {
        $('#J_table').DataTable();
    } );

    // ----------------------  table  ----------------------- 

	$(document).ready(function() {
			var result = '';
			$('#myDiv #from').change(function(){
				if (result == '') {
					result = $(this).val();
				}else{
					result = $(this).val();
				}
			$('#form-post input[name="inp1"]').val(result);
			});

			$('#myDiv #to').change(function(){
				if (result == '') {
					result = $(this).val();
				}else{
					result = $(this).val();
				}
			$('#form-post input[name="inp2"]').val(result);
			});
		});
// ------------------------------  date show form to  ----------------------------------

	// $(document).ready(function() {
	// 	$('#select').click(function(){
	// 		var option = $('#option').val();
	// 		// alert(option);
	// 		$('#option option').html(option);
	// 	});
	// });	
// ---------------------------------                         ----------------------------

	$(document).ready(function(){
        $('#checkboxAll').click(function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked=true;
                })
            }else{
               $('.checkbox').each(function(){
                    this.checked=false;
                }) 
            }
        })
    })
	
	$(document).ready(function(){
        $('#checkboxAlls').click(function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked=true;
                })
            }else{
               $('.checkbox').each(function(){
                    this.checked=false;
                }) 
            }
        })
    })
// ---------------------------  inbox massage checkbox array  ----------------------------

	</script>
</body>
</html>
