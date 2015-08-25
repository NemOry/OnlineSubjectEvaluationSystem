<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

$courseslist = Course::get_all();

$courses = "";

foreach ($courseslist as $course) 
{
  $courses .= $course->code.":".$course->code.";";
}

?>
<script type="text/javascript">
  $(function(){

    var last_id;

    $("#grid_students").jqGrid({
        url:'students_xml.php',
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ACTION','ID','STUDENT ID','PASSWORD', 'FIRST NAME', 'MIDDLE NAME', 'LAST NAME', 'COURSE CODE', 'SEMESTER', 'YEAR'],
        colModel :[ 
          {name:'act',index:'act', width:50,sortable:false},
          {name:'id', index:'id', align:'left', width:20, sortable:true, editable:false}, 
          {name:'student_id', index:'student_id', align:'left', width:50, sortable:true, editable:true, hidden: true}, 
          {name:'password', index:'password', width:70, align:'left', sortable:true, editable:true, edittype: "password"}, 
          {name:'first_name', index:'first_name', width:50, align:'left', sortable:true, editable:true},
          {name:'middle_name', index:'middle_name', width:50, align:'left', sortable:true, editable:true},
          {name:'last_name', index:'last_name', width:50, align:'left', sortable:true, editable:true},
          {name:'course_code', index:'course_code', width:50, align:'left', sortable:true, editable:true, edittype:'select'},
          {name:'semester', index:'semester', width:50, align:'left', sortable:true, editable:true, edittype:'select', editoptions:{value:{1:'1', 2:'2'}}},
          {name:'year', index:'year', width:50, align:'left', sortable:true, editable:true, edittype:'select', editoptions:{value:{1:'1', 2:'2'}}}
        ],
        width: 1400,
        height: 270,
        pager: '#nav_students',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function(){
          var courses = '<?php echo $courses; ?>';
          $("#grid_students").setColProp('course_code', { editoptions: { value: courses } });

          // var ids = jQuery("#grid_students").jqGrid('getDataIDs');
          // for(var i=0;i < ids.length;i++){
          //   var id = ids[i];
          //   edit = "<input style='height:22px;width:20px;' type='button' value='..' onclick=\"jQuery('#grid_students').editGridRow('"+id+"', {width:500});\"  />"; 
          //   del = "<input style='height:22px;width:20px;' type='button' value='x' onclick=\"jQuery('#grid_students').delGridRow('"+id+"');\" />";
          //   jQuery("#grid_students").jqGrid('setRowData',ids[i],{act:edit+del});
          // }
        },
        editurl: "update_student.php",
        viewrecords: true,
        gridview: true,
        caption: 'students',
        ondblClickRow: function(id, rowid) {  
            var student_unique_id = $("#grid_students").getRowData(id).id;
            window.location.href = "student_infos.php?student_id=" + student_unique_id;
        }
    });

  $("#btn_search_student").click(function(){
    jQuery("#grid_students").jqGrid('searchGrid',
      {sopt:['bw']}
    );
  });

  var user_level = "<?php echo $session->level; ?>";
  
  if(user_level == 0){ // admin
    jQuery("#grid_students").jqGrid('navGrid','#nav_students',{edit:true,add:true,del:true});
  }

});

</script>

<a class="btnPrint" href='print/students.php'>Print Students</a>
<table id="grid_students"><tr><td/></tr></table> 
<div id="nav_students"></div>
<input type="button" id="btn_search_student" value="Search" /> <br />