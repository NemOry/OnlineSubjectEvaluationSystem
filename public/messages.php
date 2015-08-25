<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

?>
<script type="text/javascript">

var theid = 0;

  $(function(){
    $("#grid_messages").jqGrid({
        url:'messages_xml.php',
        datatype: 'xml',
        mtype: 'GET',
        colNames:['ACTION','ID','MESSAGE','STUDENT'],
        colModel :[ 
          {name:'act',index:'act', width:100,sortable:false},
          {name:'id', index:'id', align:'left', width:20, sortable:true, editable:false, hidden:true}, 
          {name:'message', index:'message', align:'left', width:400, sortable:true, editable:true}, 
          {name:'student_id', index:'student_id', width:200, align:'left', sortable:true, editable:true}
        ],
        width: 1000,
        height: 270,
        pager: '#nav_messages',
        rowNum:10,
        rowList:[10,20,30,40,50,100,200,300,400,500],
        sortname: 'id',
        sortorder: 'desc',
        gridComplete: function(){
          var ids = jQuery("#grid_messages").jqGrid('getDataIDs');
          for(var i=0;i < ids.length;i++){
            var id = ids[i];

            theid = id;

            edit = "<input style='height:22px;width:20px;' type='button' value='..' onclick=\"jQuery('#grid_messages').editGridRow('"+id+"', {width:500});\"  />"; 
            del = "<input style='height:22px;width:20px;' type='button' value='x' onclick=\"jQuery('#grid_messages').delGridRow('"+id+"');\" />"; 
            reply = "<input style='height:22px;width:50px;' type='button' value='Reply' onclick=\"$('#myModal').modal('show'); return false;\"  />"; 
            jQuery("#grid_messages").jqGrid('setRowData',ids[i],{act:edit+del});
          }
        },
        editurl: "update_message.php",
        viewrecords: true,
        gridview: true,
        caption: 'messages',
    });

  jQuery("#grid_messages").jqGrid('navGrid','#nav_messages',{edit:true,add:true,del:true}); 

}); // function

function send()
{
  var message = $("#message").val();

  alert(theid + ", " + message);

  $.post( "send.php?id="+theid+"&message="+message, function( result ) 
  {
    alert(result);
  });
}

</script>

<!-- <div class="modal hide fade" id="myModal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Modal header</h3>
  </div>
  <div class="modal-body">
    
    <form class="form-horizontal">
      <fieldset>
        <legend>Reply</legend>
        <div class="control-group">
          <label class="control-label" for="message">Your Message</label>
          <div class="controls">
            <textarea id="message" name="message"></textarea>
          </div>
        </div>
      </fieldset>
    </form>

  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-primary" onclick="send();">Send</a>
  </div>
</div> -->

<table id="grid_messages"><tr><td/></tr></table> 
<div id="nav_messages"></div>