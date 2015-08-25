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
  $(function()
  {

    var theurl = 'student_evaluated_subjects_xml.php?student_id=<?php echo $student_id; ?>&first=false';

    var can_print = false;

    $("#grid_evaluated_grades_subjects").jqGrid({
        url: theurl ,
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ID','CODE', 'DESCRIPTION','UNITS', 'PREREQUISITE', 'COURSE', 'SEMESTER', 'YEAR'],
        colModel :[
          {name:'id', index:'id', align:'left', width:20, sortable:true, editable:false, hidden:true}, 
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
        pager: '#nav_evaluated_grades_subjects',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function(){
          var ids = jQuery("#grid_evaluated_grades_subjects").jqGrid('getDataIDs');
          for(var i=0;i < ids.length;i++){
            var id = ids[i];
            edit = "<input style='height:22px;width:20px;' type='button' value='..' onclick=\"jQuery('#grid_evaluated_grades_subjects').editGridRow('"+id+"', {width:500});\"  />"; 
            del = "<input style='height:22px;width:20px;' type='button' value='x' onclick=\"jQuery('#grid_evaluated_grades_subjects').delGridRow('"+id+"');\" />";
            jQuery("#grid_evaluated_grades_subjects").jqGrid('setRowData',ids[i]);
          }
        },
        editurl: "update_grade.php",
        viewrecords: true,
        gridview: true,
        caption: 'Student Subjects',
        multiselect: true,
        ondblClickRow: function(id, rowid) {  
            var grade_unique_id = $("#grid_evaluated_grades_subjects").getRowData(id).id;
        }
    });

    jQuery("#btn_evaluate").click( function() {

      var subject_ids = jQuery("#grid_evaluated_grades_subjects").jqGrid('getGridParam','selarrrow');

      if(subject_ids.length == 0){

        alert("please select a subject");

      }else{

        $.ajax({

            type:"POST",
            url:"evaluate.php?student_id=<?php echo $student_id; ?>",
            data: {subject_ids : subject_ids},
            success: function(result){
                if(result == "success"){
                    jQuery("#grid_evaluated_grades_subjects2").trigger("reloadGrid");
                    can_print = true;
                    //alert("Successfully Evaluated");
                    window.location.reload();
                }else{
                    can_print = false;
                    window.location.reload();
                }

            },
            error: function(jqXHR, textStatus, errorThrown){
                alert("error");
            }

        });

        return false;
      }

    });
});

</script>

<button id="btnfirst">Show First Semester</button>
<button id="btnnonfirst">Show Second Semester</button>
<table id="grid_evaluated_grades_subjects"><tr><td/></tr></table> 
<div id="nav_evaluated_grades_subjects"></div>
<a href="javascript:void(0)" id="btn_evaluate">Evaluate</a>

<!-- GRID 2 -->

<script type="text/javascript">
  $(function(){

    var can_print = false;

    $("#grid_evaluated_grades_subjects2").jqGrid({
        url:'student_evaluated_subjects_xml2.php?student_id=<?php echo $student_id; ?>' ,
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ID','CODE', 'DESCRIPTION','UNITS', 'PREREQUISITE', 'COURSE', 'SEMESTER', 'YEAR', 'DATE EVALUATED'],
        colModel :[
          {name:'id', index:'id', align:'left', width:20, sortable:true, editable:false}, 
          {name:'code', index:'code', align:'left', width:50, sortable:true, editable:true}, 
          {name:'description', index:'description', width:70, align:'left', sortable:true, editable:true}, 
          {name:'units', index:'units', width:50, align:'left', sortable:true, editable:true}, 
          {name:'prereq_subject_code', index:'prereq_subject_code', width:50, align:'left', sortable:true, editable:false},
          {name:'course_code', index:'course_code', width:70, align:'left', sortable:true, editable:false}, 
          {name:'semester', index:'semester', width:50, align:'left', sortable:true, editable:true},
          {name:'year', index:'year', width:50, align:'left', sortable:true, editable:true},
          {name:'date', index:'date', width:50, align:'left', sortable:true, editable:true}
        ],
        width: 1400,
        height: 270,
        pager: '#nav_evaluated_grades_subjects2',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function(){
          var ids = jQuery("#grid_evaluated_grades_subjects2").jqGrid('getDataIDs');
          for(var i=0;i < ids.length;i++){
            var id = ids[i];
            edit = "<input style='height:22px;width:20px;' type='button' value='..' onclick=\"jQuery('#grid_evaluated_grades_subjects2').editGridRow('"+id+"', {width:500});\"  />"; 
            del = "<input style='height:22px;width:20px;' type='button' value='x' onclick=\"jQuery('#grid_evaluated_grades_subjects2').delGridRow('"+id+"');\" />";
            jQuery("#grid_evaluated_grades_subjects2").jqGrid('setRowData',ids[i]);
          }
        },
        editurl: "update_evaluated_subject.php",
        viewrecords: true,
        gridview: true,
        caption: 'Evaluated Subjects',
        multiselect: true,
        ondblClickRow: function(id, rowid) {  
            var grade_unique_id = $("#grid_evaluated_grades_subjects2").getRowData(id).id;
        }
    });

    jQuery("#btn_remove").click( function() {

      var subject_ids2 = jQuery("#grid_evaluated_grades_subjects2").jqGrid('getGridParam','selarrrow');

      if(subject_ids2.length == 0){

        alert("please select a subject");

      }else{

        $.ajax({

            type:"POST",
            url:"update_evaluated_subject.php?student_id=<?php echo $student_id; ?>",
            data: {subject_ids2 : subject_ids2},
            success: function(result){
                if(result == "success"){
                    jQuery("#grid_evaluated_grades_subjects2").trigger("reloadGrid");
                    //alert("Successfully Removed");
                }else{
                    alert(result);
                }

            },
            error: function(jqXHR, textStatus, errorThrown){
                alert("error");
            }

        });

        return false;
      }

    });
});

$("#btnfirst").click(function(){
  theurl = 'student_evaluated_subjects_xml.php?student_id=<?php echo $student_id; ?>&first=true';
  jQuery("#grid_evaluated_grades_subjects").jqGrid('setGridParam',{url:theurl,page:1}).trigger("reloadGrid");
});

$("#btnnonfirst").click(function(){
  theurl = 'student_evaluated_subjects_xml.php?student_id=<?php echo $student_id; ?>&first=2nd';
  jQuery("#grid_evaluated_grades_subjects").jqGrid('setGridParam',{url:theurl,page:1}).trigger("reloadGrid");
});

</script>

<table id="grid_evaluated_grades_subjects2"><tr><td/></tr></table> 
<div id="nav_evaluated_grades_subjects2"></div>
<a href="javascript:void(0)" id="btn_remove">Remove</a>
<a class="btnPrint" href="print/evaluated_subjects.php?student_id=<?php echo $student_id; ?>&date=">Print Evaluated Subjects</a>
<select id="thedate">
  <?php 

  $theevaluatedsubjects = EvaluatedSubject::get_by_sql("SELECT DISTINCT date FROM " . T_EVALUATED_SUBJECTS. " WHERE ".C_EVALUATED_STUDENT_ID."=".$student->id);

  foreach ($theevaluatedsubjects as $object) 
  {
    echo "<option value='".$object->date."'>".$object->date."</option>";
  }

  ?>
</select>

<script>

  var printURL = "print/evaluated_subjects.php?student_id=<?php echo $student_id; ?>&date=";

  setDate();

  $("#thedate").click(function()
  {
    setDate();
  });
  
  $(".btnPrint").click(function()
  {
    setDate();
  });

  function setDate()
  {
    var date = $("#thedate").val();
    
    var url = printURL + date;

    $(".btnPrint").attr("href", url);

    console.log("href: " + url);
  }

</script>