<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

?>
<script type="text/javascript">
  $(function(){
    $("#grid_users").jqGrid({
        url:'users_xml.php',
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ACTION','ID','NAME', 'USERNAME','PASSWORD', 'LEVEL'],
        colModel :[ 
          {name:'act',index:'act', width:50,sortable:false},
          {name:'id', index:'id', align:'left', width:20, sortable:true, editable:false, hidden:true}, 
          {name:'name', index:'name', align:'left', width:50, sortable:true, editable:true}, 
          {name:'username', index:'username', width:70, align:'left', sortable:true, editable:true}, 
          {name:'password', index:'password', width:50, align:'left', sortable:true, editable:true, edittype: "password"},
		      {name:'level', index:'level', width:50, align:'left', sortable:true, editable:true, edittype:'select', editoptions:{value:{0:'ADMIN', 1:'EVALUATOR', 2:'TEACHER'}}}
        ],
        width: 600,
        height: 270,
        pager: '#nav_users',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function(){
          var ids = jQuery("#grid_users").jqGrid('getDataIDs');
          for(var i=0;i < ids.length;i++){
            var id = ids[i];
            edit = "<input style='height:22px;width:20px;' type='button' value='..' onclick=\"jQuery('#grid_users').editGridRow('"+id+"', {width:500});\"  />"; 
            del = "<input style='height:22px;width:20px;' type='button' value='x' onclick=\"jQuery('#grid_users').delGridRow('"+id+"');\" />"; 
            jQuery("#grid_users").jqGrid('setRowData',ids[i],{act:edit+del});
          }
        },
        editurl: "update_user.php",
        viewrecords: true,
        gridview: true,
        caption: 'Users',
    });

  jQuery("#grid_users").jqGrid('navGrid','#nav_users',{edit:true,add:true,del:true}); 

  $("#btn_search_users").click(function(){
    jQuery("#grid_users").jqGrid('searchGrid',
      {sopt:['bw']}
    );
  });

}); // function

</script>
 
<table id="grid_users"><tr><td/></tr></table> 
<div id="nav_users"></div>
<input type="button" id="btn_search_users" value="Search" />