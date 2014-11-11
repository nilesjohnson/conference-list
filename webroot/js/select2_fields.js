//this is for all the select2 boxes . . very easy
 $(document).ready(function() {
 $("#TagTag").select2({
	placeholder: "Select some tags",
	allowClear: true,
	width: "1000px"
 }); 
 
 $("#ConferenceCountry").select2({
	placeholder: "Select your Country",
	//allowClear: true,
	width: "1000px"
 }); 
 
 });