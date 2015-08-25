<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

$student_id = $_GET['student_id'];

$student = Student::get_by_id($student_id);

?>

<script type="text/javascript">
  $(function(){

    var can_print = false;

    $("#grid_evaluated_grades_subjects2").jqGrid({
        url:'student_evaluated_subjects_xml2.php?student_id=<?php echo $student_id; ?>' ,
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ID','CODE', 'DESCRIPTION','UNITS', 'PREREQUISITE', 'COURSE', 'SEMESTER', 'YEAR'],
        colModel :[
          {name:'id', index:'id', align:'left', width:20, sortable:true, editable:false}, 
          {name:'code', index:'code', align:'left', width:50, sortable:true, editable:true}, 
          {name:'description', index:'description', width:70, align:'left', sortable:true, editable:true}, 
          {name:'units', index:'units', width:50, align:'left', sortable:true, editable:true}, 
          {name:'prereq_subject_code', index:'prereq_subject_code', width:50, align:'left', sortable:true, editable:false},
          {name:'course_code', index:'course_code', width:70, align:'left', sortable:true, editable:false}, 
          {name:'semester', index:'semester', width:50, align:'left', sortable:true, editable:true},
          {name:'year', index:'year', width:50, align:'left', sortable:true, editable:true}
        ],
        width: 1400,
        height: 270,
        pager: '#nav_evaluated_grades_subjects2',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function(){

        },
        editurl: "update_evaluated_subject.php",
        viewrecords: true,
        gridview: true,
        caption: 'Evaluated Subjects',
        ondblClickRow: function(id, rowid) {
            var grade_unique_id = $("#grid_evaluated_grades_subjects2").getRowData(id).id;
        }
    });

});

</script>

<table id="grid_evaluated_grades_subjects2"><tr><td/></tr></table> 
<div id="nav_evaluated_grades_subjects2"></div>
<a class="btnPrint" href='print/evaluated_subjects.php?student_id=<?php echo $student_id; ?>'>Print Evaluated Subjects</a>