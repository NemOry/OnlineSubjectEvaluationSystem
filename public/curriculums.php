<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

?>
<script type="text/javascript">
  $(function(){
    $("#grid_curriculums").jqGrid({
        url:'curriculums_xml.php',
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ACTION','ID','CURRICULUM'],
        colModel :[ 
          {name:'act',index:'act', width:50,sortable:false},
          {name:'id', index:'id', align:'left', width:20, sortable:true, editable:false, hidden:true}, 
          {name:'curriculum', index:'curriculum', align:'left', width:50, sortable:true, editable:true}
        ],
        width: 1400,
        height: 270,
        pager: '#nav_curriculums',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function(){
          var ids = jQuery("#grid_curriculums").jqGrid('getDataIDs');
          for(var i=0;i < ids.length;i++){
            var id = ids[i];
            edit = "<input style='height:22px;width:20px;' type='button' value='..' onclick=\"jQuery('#grid_curriculums').editGridRow('"+id+"', {width:500});\"  />"; 
            del = "<input style='height:22px;width:20px;' type='button' value='x' onclick=\"jQuery('#grid_curriculums').delGridRow('"+id+"');\" />"; 
            jQuery("#grid_curriculums").jqGrid('setRowData',ids[i],{act:edit+del});
          }
        },
        editurl: "update_curriculum.php",
        viewrecords: true,
        gridview: true,
        caption: 'curriculums',
        ondblClickRow: function(id, rowid) 
        {  
            var curriculumid = $("#grid_curriculums").getRowData(id).id;
            window.location.href = "viewsubjects.php?curriculumid=" + curriculumid;
        }
    });

  jQuery("#grid_curriculums").jqGrid('navGrid','#nav_curriculums',{edit:true,add:true,del:true}); 

}); // function

</script>
 
<table id="grid_curriculums"><tr><td/></tr></table> 
<div id="nav_curriculums"></div>