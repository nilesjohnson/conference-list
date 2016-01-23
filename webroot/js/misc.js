function updateTagLink(b) {
  var x = document.getElementById("TagTag");
  var v = [];
  var i;
  for (i = 0; i < x.options.length; i++) {
    if (x.options[i].selected) {
	v.push(x.options[i].text.split('.')[0]);
    }
  }
  //console.log(v.join('-'));
  document.getElementById('tag_link').href = b+v.join('-');
  return false;
}
