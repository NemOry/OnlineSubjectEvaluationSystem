<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in())
{
    redirect_to("index.php");
}

$courseslist = Course::get_all();

$courses = "";

foreach ($courseslist as $course) 
{
  $courses .= $course->code.":".$course->code.";";
}

$subjectslist = Subject::get_all();

$subjects = "";

$subjects .= ":NONE;";

foreach ($subjectslist as $subject) 
{
  $subjects .= $subject->code.":".$subject->code.";";
}

$curriculumlist = Curriculum::get_all();

$curriculums = "";

foreach ($curriculumlist as $curriculum) 
{
  $curriculums .= $curriculum->id.":".$curriculum->curriculum.";";
}

$edit_enabled = "true";

if(User::get_by_id($session->user_id)->level == LEVEL_TEACHER)
{
  $edit_enabled = "false";
}

?>

<script type="text/javascript">
  $(function(){

    var prereq_subject_codes = new Array();

    $.getJSON('jsons/get_subjects.php', function(data) 
    {
        $.each(data, function(key, val) {
            prereq_subject_codes.push(val);
        });
    });

    var edit_enabled = true;

    if("<?php echo $edit_enabled; ?>" == "false")
    {
      edit_enabled = false;
    }

    $("#grid_subjects").jqGrid({
        url:'subjects_xml.php',
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ACTION','ID','CODE', 'DESCRIPTION','UNITS', 'PREREQUISITE SUBJECT CODE', 'COURSE CODE', 'YEAR', 'SEMESTER', 'FAILED STUDENTS', 'CURRICULUM NAME', 'CURRICULUM ID'],
        colModel :[ 
          {name:'act',index:'act', width:50,sortable:false},
          {name:'id', index:'id', align:'left', width:20, sortable:true, editable:false, hidden:true}, 
          {name:'code', index:'code', align:'left', width:50, sortable:true, editable:true}, 
          {name:'description', index:'description', width:70, align:'left', sortable:true, editable:true}, 
          {name:'units', index:'units', width:50, align:'left', sortable:true, editable:true},
          {name:'prereq_subject_code', index:'prereq_subject_code', width:50, align:'left', sortable:true, editable:true, edittype:'select'},
          {name:'course_code', index:'course_code', width:70, align:'left', sortable:true, editable:true, edittype:'select'},
          {name:'year', index:'year', width:50, align:'left', sortable:true, hidden:true, editable:true, edittype:'select', editoptions:{value:{1:'1', 2:'2'}}},
          {name:'semester', index:'semester', width:50, align:'left', sortable:true, editable:true, edittype:'select', editoptions:{value:{1:'1', 2:'2'}}},
          {name:'failed_studs', index:'failed_studs', width:50, align:'left', sortable:true, editable:false},
          {name:'curriculum', index:'curriculum', width:50, align:'left', sortable:true, editable:false},
          {name:'curriculum_id', index:'curriculum_id', width:50, align:'left', sortable:true, editable:true, edittype:'select', viewable: true, hidden:true, editrules: {edithidden:true}}
        ],
        width: 1400,
        height: 270,
        pager: '#nav_subjects',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function()
        {
          if(edit_enabled)
          {
            jQuery("#grid_subjects").jqGrid('navGrid','#nav_subjects',{edit:true,add:true,del:true}); 
          
            var courses = '<?php echo $courses; ?>';
            $("#grid_subjects").setColProp('course_code', { editoptions: { value: courses } });

            var subjects = '<?php echo $subjects; ?>';
            $("#grid_subjects").setColProp('prereq_subject_code', { editoptions: { value: subjects } });

            var curriculums = '<?php echo $curriculums; ?>';
            $("#grid_subjects").setColProp('curriculum_id', { editoptions: { value: curriculums } });

            var ids = jQuery("#grid_subjects").jqGrid('getDataIDs');

            for(var i=0;i < ids.length;i++)
            {
              var id = ids[i];
              edit = "<input style='height:22px;width:20px;' type='button' value='..' onclick=\"jQuery('#grid_subjects').editGridRow('"+id+"', {width:500});\"  />"; 
              del = "<input style='height:22px;width:20px;' type='button' value='x' onclick=\"jQuery('#grid_subjects').delGridRow('"+id+"');\" />"; 
              jQuery("#grid_subjects").jqGrid('setRowData',ids[i],{act:edit+del});
            }

          }
        },
        ondblClickRow: function(id, rowid) {  
          if(edit_enabled == false)
          {
            var theid = $("#grid_subjects").getRowData(id).id;
            window.location.href = "teacherstudents.php?subject_id=" + theid;
          }
            
        },
        editurl: "update_subject.php",
        viewrecords: true,
        gridview: true,
        multiselect: edit_enabled,
        caption: 'subjects',
        loadComplete: function() 
        {
          //$(this).setColProp('prereq_subject_code', { editoptions: { value: prereq_subject_codes} });
        }
    });

  if(edit_enabled)
  {
    jQuery("#grid_subjects").jqGrid('navGrid','#nav_subjects',{edit:true,add:true,del:true}); 
  }  

  $("#btn_search_subjects").click(function(){
    jQuery("#grid_subjects").jqGrid('searchGrid',
      {sopt:['bw']}
    );
  });

}); // function

</script>
 
<table id="grid_subjects"><tr><td/></tr></table> 
<div id="nav_subjects"></div>
<input type="button" id="btn_search_subjects" value="Search" />