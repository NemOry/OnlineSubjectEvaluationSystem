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

    var xxxxx = new Array();

    $("#grid_grades_subjects").jqGrid({
        url:'student_grades_subjects_xml2.php?student_id=<?php echo $student_id; ?>' ,
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ID', 'SUBJECT CODE', 'SUBJECT DESCRIPTION','GRADE','UNITS', 'YEAR', 'REMARKS'],
        colModel :[
          {name:'id', index:'id', align:'right', width:20, sortable:true, editable:false, hidden:true}, 
          {name:'xxxxx', index:'xxxxx', width:70, align:'left', sortable:true, editable:true, edittype:'text'},
          {name:'subject_description', index:'subject_description', width:70, align:'left', sortable:true, editable:false},
          {name:'grade', index:'grade', align:'left', width:50, sortable:true, editable:true, editrules:{custom:true, custom_func:checkGrade}}, 
          {name:'units', index:'units', width:70, align:'left', sortable:true, editable:false},
          {name:'year', index:'year', width:70, align:'left', sortable:true, editable:false},
          {name:'remarks', index:'remarks', width:70, align:'left', sortable:true, editable:false}
        ],
        width: 1000,
        height: 270,
        pager: '#nav_grades_subjects',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function(){
          var ids = jQuery("#grid_grades_subjects").jqGrid('getDataIDs');
          for(var i=0;i < ids.length;i++){
            var id = ids[i];
            edit = "<input style='height:22px;width:20px;' type='button' value='..' onclick=\"jQuery('#grid_grades_subjects').editGridRow('"+id+"', {width:500});\"  />"; 
            del = "<input style='height:22px;width:20px;' type='button' value='x' onclick=\"jQuery('#grid_grades_subjects').delGridRow('"+id+"');\" />";
            jQuery("#grid_grades_subjects").jqGrid('setRowData',ids[i],{act:edit+del});
          }
        },
        editurl: "update_grade.php?student_id=<?php echo $student_id; ?>",
        viewrecords: true,
        gridview: true,
        caption: 'grades',
        ondblClickRow: function(id, rowid) {  
            var grade_unique_id = $("#grid_grades_subjects").getRowData(id).id;
        },
        loadComplete: function() {
          // $(this).setColProp('xxxxx', { editoptions: { value: xxxxx} });
        }
    });
  
  //jQuery("#grid_grades_subjects").jqGrid('navGrid','#nav_grades_subjects',{edit:true,add:true,del:true});

  function checkGrade(value, colname){
    if(value > 100 || value < 1){
      return [false, colname + " Must be filled and not be over 100 or below 0"];
    }else{
      return [true, ""];
    }
  }

  function checkLength(value, colname){
    if(value.length == 0){
      return [false, colname + " Must be filled"];
    }else{
      return [true, ""];
    }
  }

  function checkcheck(response, postdata){

    alert("checking");

    return [false, "error", null] 
  }

});

</script>

<a class="btnPrint" href='print/student_subjects_grades.php?student_id=<?php echo $student->id; ?>'>Print Grades</a>
<table id="grid_grades_subjects"><tr><td/></tr></table> 
<div id="nav_grades_subjects"></div>
