<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

?>
<script type="text/javascript">
  $(function(){
    $("#grid_grades").jqGrid({
        url:'grades_xml.php',
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ACTION','ID','GRADE', 'SUBJECT UNIQUE ID','STUDENT UNIQUE ID'],
        colModel :[ 
          {name:'act',index:'act', width:50,sortable:false},
          {name:'id', index:'id', align:'left', width:20, sortable:true, editable:false, hidden:true}, 
          {name:'grade', index:'grade', align:'left', width:50, sortable:true, editable:true}, 
          {name:'subject_id', index:'subject_id', width:70, align:'left', sortable:true, editable:true}, 
          {name:'student_id', index:'student_id', width:50, align:'left', sortable:true, editable:true}
        ],
        width: 500,
        height: 270,
        pager: '#nav_grades',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function(){
          var ids = jQuery("#grid_grades").jqGrid('getDataIDs');
          for(var i=0;i < ids.length;i++){
            var id = ids[i];
            edit = "<input style='height:22px;width:20px;' type='button' value='..' onclick=\"jQuery('#grid_grades').editGridRow('"+id+"', {width:500});\"  />"; 
            del = "<input style='height:22px;width:20px;' type='button' value='x' onclick=\"jQuery('#grid_grades').delGridRow('"+id+"');\" />"; 
            jQuery("#grid_grades").jqGrid('setRowData',ids[i],{act:edit+del});
          }
        },
        editurl: "update_grade.php",
        viewrecords: true,
        gridview: true,
        caption: 'grades',
    });

  jQuery("#grid_grades").jqGrid('navGrid','#nav_grades',{edit:true,add:true,del:true}); 

}); // function

</script>
 
<table id="grid_grades"><tr><td/></tr></table> 
<div id="nav_grades"></div>