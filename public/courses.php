<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

$curriculumlist = Curriculum::get_all();

$curriculums = "";

foreach ($curriculumlist as $curriculum) 
{
  $curriculums .= $curriculum->id.":".$curriculum->curriculum.";";
}

?>
<script type="text/javascript">
  $(function(){
    $("#grid_courses").jqGrid({
        url:'courses_xml.php',
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ACTION','ID','CODE', 'DESCRIPTION','CURRICULUM NAME','CURRICULUM ID'],
        colModel :[ 
          {name:'act',index:'act', width:50,sortable:false},
          {name:'id', index:'id', align:'left', width:20, sortable:true, editable:false, hidden:true}, 
          {name:'code', index:'code', align:'left', width:50, sortable:true, editable:true}, 
          {name:'description', index:'description', width:70, align:'left', sortable:true, editable:true}, 
          {name:'curriculum', index:'curriculum', width:50, align:'left', sortable:true, editable:false},
          {name:'curriculum_id', index:'curriculum_id', width:50, align:'left', sortable:true, editable:true, viewable: true, edittype:'select', hidden:true, editrules: {edithidden:true}}
        ],
        width: 1400,
        height: 270,
        pager: '#nav_courses',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function()
        {

          var curriculums = '<?php echo $curriculums; ?>';
          $("#grid_courses").setColProp('curriculum_id', { editoptions: { value: curriculums } });

          var ids = jQuery("#grid_courses").jqGrid('getDataIDs');
          for(var i=0;i < ids.length;i++){
            var id = ids[i];
            edit = "<input style='height:22px;width:20px;' type='button' value='..' onclick=\"jQuery('#grid_courses').editGridRow('"+id+"', {width:500});\"  />"; 
            del = "<input style='height:22px;width:20px;' type='button' value='x' onclick=\"jQuery('#grid_courses').delGridRow('"+id+"');\" />"; 
            jQuery("#grid_courses").jqGrid('setRowData',ids[i],{act:edit+del});
          }
        },
        editurl: "update_course.php",
        viewrecords: true,
        gridview: true,
        caption: 'courses',
    });

  jQuery("#grid_courses").jqGrid('navGrid','#nav_courses',{edit:true,add:true,del:true}); 

}); // function

</script>
 
<table id="grid_courses"><tr><td/></tr></table> 
<div id="nav_courses"></div>