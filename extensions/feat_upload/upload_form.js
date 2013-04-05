var files = document.getElementById('include_file');
var add_file_link = '<a href="javascript:void(0)" onclick="add_file_prompt();" id="add_file_link">Add a file</a><br />';

if(files != null) {
    files.innerHTML = add_file_link;
}

function file_prompt () {
    var files_len = files.innerHTML.length;
    return '<label>(2MB Max)<input type="file" name="file'+files_len+'">' +
            '<a href="javascript:void(0);" onclick="remove_file_prompt(this);">x</a><br /></label>';
}

function add_file_prompt() {
    files.innerHTML += file_prompt();
    if (files.children.length >= 8)
        document.getElementById('add_file_link').style.visibility = 'hidden';
}

function remove_file_prompt(el) {
    el.parentNode.remove();
    if (files.children.length < 8)
        document.getElementById('add_file_link').style.visibility = '';
}