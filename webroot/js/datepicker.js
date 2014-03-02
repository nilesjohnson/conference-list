
$(function() { var
  dates = $( "#ConferenceStartDate, #ConferenceEndDate" ).datepicker({
    dateFormat: "yy-mm-dd", 
    defaultDate: "+1w", 
    changeMonth: true,
    numberOfMonths: 1, 
    onSelect: function( selectedDate ) { 
	      var option = this.id == "ConferenceStartDate" ? "minDate" : "maxDate",
	      instance = $( this ).data( "datepicker" ), 
	      date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings ); 
	      dates.not( this ).datepicker("option", option, date ); 
	  } 
      }); 
    });