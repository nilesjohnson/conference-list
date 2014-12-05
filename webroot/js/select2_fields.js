//this is for all the select2 boxes . . very easy
$(document).ready(function() {
 var sortByMatchIndex;
 $sortByMatchIndex = function(results, container, query) {
     if (query.term) {
	 // use the built in javascript sort function
	 return results.sort(function(a, b) {
		 return 2*(
			   a.text.toUpperCase().indexOf(query.term.toUpperCase()) > b.text.toUpperCase().indexOf(query.term.toUpperCase())
			   )-1;
	     });
     }
     return results;
 };


 $("#TagTag").select2({
	placeholder: "Select subject tags",
	allowClear: true,
        width: "100%",
        sortResults: $sortByMatchIndex
 }); 
 
 $("#ConferenceCountry").select2({
        placeholder: "Country...",
        //allowClear: true,
        width: "100%",
	matcher: function(term, text) { 
	     return text.toUpperCase().indexOf(term.toUpperCase())>=0; 
	},
	sortResults: $sortByMatchIndex

 }); 
});
