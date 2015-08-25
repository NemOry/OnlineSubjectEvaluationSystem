<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in())
{
    redirect_to("index.php");
}

/////////////////////////////////////////

$teacherslist = User::get_all();

$teachers = "";

foreach ($teacherslist as $teacher) 
{
  if($teacher->level == LEVEL_TEACHER)
  {
    $teachers .= $teacher->id.":".$teacher->name.";";
  } 
}

/////////////////////////////////////////

$subjectslist = Subject::get_all();

$subjects = "";

$subjects .= ":NONE;";

foreach ($subjectslist as $subject) 
{
  $subjects .= $subject->id.":".$subject->code.";";
}

/////////////////////////////////////////

?>
<script type="text/javascript">
  $(function(){
    $("#grid_teacher_subjects").jqGrid({
        url:'teacher_subjects_xml.php',
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ACTION','ID','TEACHER ID', 'TEACHER USERNAME','SUBJECT ID','SUBJECT CODE','SUBJECT DESCRIPTION'],
        colModel :[ 
          {name:'act',index:'act', width:50,sortable:false},
          {name:'id', index:'id', align:'left', width:20, sortable:true, editable:false, hidden:true}, 
          {name:'teacher_id', index:'teacher_id', align:'left', width:50, sortable:true, editable:true, edittype:'select'}, 
          {name:'teacher_username', index:'teacher_username', width:70, align:'left', sortable:true, editable:false}, 
          {name:'subject_id', index:'subject_id', width:50, align:'left', sortable:true, editable:true, edittype:'select'},
          {name:'subject_code', index:'subject_code', width:50, align:'left', sortable:true, editable:false},
          {name:'subject_description', index:'subject_description', width:50, align:'left', sortable:true, editable:false}
        ],
        width: 1400,
        height: 270,
        pager: '#nav_teacher_subjects',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function(){

          var teachers = '<?php echo $teachers; ?>';
          $("#grid_teacher_subjects").setColProp('teacher_id', { editoptions: { value: teachers } });

          var subjects = '<?php echo $subjects; ?>';
          $("#grid_teacher_subjects").setColProp('subject_id', { editoptions: { value: subjects } });

          var ids = jQuery("#grid_teacher_subjects").jqGrid('getDataIDs');
          for(var i=0;i < ids.length;i++){
            var id = ids[i];
            edit = "<input style='height:22px;width:20px;' type='button' value='..' onclick=\"jQuery('#grid_teacher_subjects').editGridRow('"+id+"', {width:500});\"  />"; 
            del = "<input style='height:22px;width:20px;' type='button' value='x' onclick=\"jQuery('#grid_teacher_subjects').delGridRow('"+id+"');\" />"; 
            jQuery("#grid_teacher_subjects").jqGrid('setRowData',ids[i],{act:edit+del});
          }
        },
        editurl: "update_teacher_subject.php",
        viewrecords: true,
        gridview: true,
        caption: 'teacher_subjects',
    });

  jQuery("#grid_teacher_subjects").jqGrid('navGrid','#nav_teacher_subjects',{edit:true,add:true,del:true}); 

}); // function

</script>
 
<table id="grid_teacher_subjects"><tr><td/></tr></table> 
<div id="nav_teacher_subjects"></div>