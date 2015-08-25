<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

?>
<script type="text/javascript">
  $(function(){

    var last_id;

    $("#grid_eval_students").jqGrid({
        url:'evaluated_students_xml.php',
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ACTION','ID','STUDENT ID','PASSWORD', 'FIRST NAME', 'MIDDLE NAME', 'LAST NAME', 'COURSE CODE', 'SEMESTER', 'YEAR'],
        colModel :[ 
          {name:'act',index:'act', width:50,sortable:false},
          {name:'id', index:'id', align:'left', width:20, sortable:true, editable:false, hidden:true}, 
          {name:'student_id', index:'student_id', align:'left', width:50, sortable:true, editable:true}, 
          {name:'password', index:'password', width:70, align:'left', sortable:true, editable:true}, 
          {name:'first_name', index:'first_name', width:50, align:'left', sortable:true, editable:true},
          {name:'middle_name', index:'middle_name', width:50, align:'left', sortable:true, editable:true},
          {name:'last_name', index:'last_name', width:50, align:'left', sortable:true, editable:true},
          {name:'course_code', index:'course_code', width:50, align:'left', sortable:true, editable:true, edittype:'select', editoptions:{value:{CS:'CS', IT:'IT'}}},
          {name:'semester', index:'semester', width:50, align:'left', sortable:true, editable:true, edittype:'select', editoptions:{value:{1:'1', 2:'2'}}},
          {name:'year', index:'year', width:50, align:'left', sortable:true, editable:true, edittype:'select', editoptions:{value:{1:'1', 2:'2', 3:'3', 4:'4'}}}
        ],
        width: 1400,
        height: 270,
        pager: '#nav_eval_students',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function(){

        },
        editurl: "update_eval_student.php",
        viewrecords: true,
        gridview: true,
        caption: 'students',
        ondblClickRow: function(id, rowid) {  
            var student_unique_id = $("#grid_eval_students").getRowData(id).id;
            window.location.href = "student_infos.php?student_id=" + student_unique_id;
        }
    });
  
  //jQuery("#grid_eval_students").jqGrid('navGrid','#nav_eval_students',{edit:true, add:true, del:true}); 

});

</script>

<a class="btnPrint" href='print/students.php'>Print Students</a>
<table id="grid_eval_students"><tr><td/></tr></table> 
<div id="nav_eval_students"></div>