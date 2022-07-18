var task_data;

// There will be a modify button for every task that is displayed
// This method sets up a event listner for all such buttons.
function setup_modify_event_listner() {
    $(".modify-button").click(function(event) {
        var i = $(this).attr('id').split("_")[1];
        $("#modify-title").val(task_data[i].title);
        $("#modify-deadline").val(task_data[i].deadline);
        $("#modify-comments").val(task_data[i].notes);
        $('#modify-creation').val(task_data[i].creation_time);
        $("#modify-task-modal").modal('show');
    });

    $('#modify_btn').click(function(event) {
        var $form = $('#modify-task-form');
        var $inputs = $form.find("input");
        var serializedData = $form.serialize();
        $inputs.prop("disabled", true);
        $.ajax({
            url: "api/update.php",
            type: "post",
            data: serializedData,
            success: function(data) {
                console.log("success");
                $inputs.prop("disabled", false);
                $("#modify-task-modal").modal('hide');
                notify_sucess("Modifed sucessfully");
                load_data_from_db();
            },
            error: function(data) {
                console.log("failed");
                $inputs.prop("disabled", false);
                $("#modify-task-modal").modal('hide');
                notify_failure("Modify operation failed!");
            }
        });
    });
}

// There will be a delete button for every task that is displayed
// This method sets up a event listner for all such buttons.
function setup_delete_event_listner() {
    $(".delete-button").click(function(event) {
        var i = $(this).attr('id').split("_")[1];
        var creation_time = "task-creation=" + task_data[i].creation_time;
        $.ajax({
            url: "api/delete.php",
            type: "post",
            data: creation_time,
            success: function(data) {
                console.log("success");
                notify_sucess("Deleted sucessfully");
                load_data_from_db();
            },
            error: function(data) {
                console.log("failed");
                notify_failure("Delete operation failed");
            }
        });
    });
}

// This method sets up a event listner for  button in "add-task" page
// Event listner does a Jquery's ajax call to the api/insert.php which
// add's the data into the database.
function setup_add_event_listner(){
  $("#add-task-form").submit(function(event) {
    var $form = $(this);
    var $inputs = $form.find("input");
    var serializedData = $form.serialize();
    $inputs.prop("disabled", true);
    $.ajax({
      url: "api/insert.php",
      type: "post",
      data: serializedData,
      success: function(data) {
          console.log("success");
          $inputs.prop("disabled", false);          
          notify_sucess("Task added sucessfully");
      },
      error: function(data) {
          console.log("failed");
          $inputs.prop("disabled", false);        
          notify_failure("Task add operation failed!");  
      }
  });
  });
}

// This method dynamically populates the task table
// and invokes "DataTable()" method on the table, which does pagination, sort, search.
function populate_tasklist_table() {
  $('#task-table  > tbody').empty();
    for (var i in task_data) {
        $('#task-table  > tbody').append("<tr><td>" + i +
            "</td><td>" + task_data[i].title +
            "</td><td>" + task_data[i].deadline +
            "</td><td>" + task_data[i].notes +
            "</td><td>" + task_data[i].creation_time +
            "</td><td><button id=\"m_" + i + "\" type=\"button\" class=\"btn btn-outline-primary modify-button\">Modify</button>" +
            "</td><td><button id=\"d_" + i + "\" type=\"button\" class=\"btn btn-outline-danger delete-button\">Delete</button>" +
            "</td></tr>");
    }
    setup_modify_event_listner();
    setup_delete_event_listner();
    $('#task-table').DataTable();
}

// This method reads the exisiting tasks in DB.
function load_data_from_db() {
    $.ajax({
        url: "api/read.php",
        method: "GET",
        success: function(data) {
            task_data = $.parseJSON(data);
            populate_tasklist_table();            
        },
        error: function(data) {
            console.log("failed")
        }
    });
}

//Sucess alert pop-up and auto hide.
function notify_sucess(message){
  $("#task-list-alert-sucess").empty();                                    // clear previous message
  $("#task-list-alert-sucess").append("<strong>"+message+"</strong>");     // addnew message
  $("#task-list-alert-sucess").fadeTo(2000, 500).slideUp(500, function() { // Slide down and up(auto close)
    $("#stask-list-alert-sucess").slideUp(500);
  });
}

//Failure alert pop-up and auto hide.
function notify_failure(message){
  $("#task-list-alert-fail").empty();                                     // clear previous message
  $("#task-list-alert-fail").append("<strong>"+message+"</strong>");      // addnew message
  $("#task-list-alert-fail").fadeTo(2000, 500).slideUp(500, function() {  // Slide down and up(auto close)
    $("#stask-list-alert-fail").slideUp(500);
  });
}

$(document).ready(function() {

    //hide modal window, this will be poped up when a "modify button is pressed"
    $(".modify-task-modal-close").click(function() {
        $("#modify-task-modal").modal('hide');
    });

    //hide alerts, will be popped up when there is an alert"
    $("#task-list-alert-sucess").hide();
    $("#task-list-alert-fail").hide();

    load_data_from_db();
    setup_add_event_listner();
    
});