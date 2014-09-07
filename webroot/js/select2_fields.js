//this is for all the select2 boxes . . very easy
 $(document).ready(function() {
 $("#TagTag").select2({
	placeholder: "Select subject tags",
	allowClear: true,
	width: "100%"
 }); 
 
 $("#ConferenceCountry").select2({
	placeholder: "Country...",
	//allowClear: true,
	width: "100%"
 }); 
 
 });