function changedateSQLtoVN (date) {
	var time = new Date();
	var hours = time.getHours();
	var minute = time.getMinutes();
	var date = time.getDate();
	var month = time.getMonth()+1;
	var year = time.getFullYear();
	return hours+":"+minute+" "+date+"/"+month+"/"+year;
}
 function addcomment(input, type,task_id,chatbox,avatar_path){
     var comment= $( '#'+input).val();
    if(comment ==""){
      return;
    }
    $( '#'+input).val("");
    $('#'+chatbox).append("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
        $.ajax({
            type:"POST",                          
            url:"/manager-tasks/addcomment",
            data:{task_id:task_id,
                   comment:comment,
                   type:type,
                   },
            success: function(data){
                  getCommentList(chatbox,task_id,type,avatar_path)

            }
        });
  }
function getCommentList(chatbox,task_id,type,avatar_path){
    $.ajax({
            type:"POST",                          
            url:"/manager-tasks/getcomment",
            data:{task_id:task_id,
                   type:type,
                   },
            success: function(data){
                 var chat ="";
                for(var i = 0 ; i < data.length ;i++){
                     chat +='<div class="item">';
                      chat +='<img src="'+avatar_path+data[i].avatar+'" alt="user image" class="offline">';
                      chat +='<p class="message">';
                      chat +='  <a href="#" class="name">';
                      chat += '<small class="text-muted pull-right"><i class="fa fa-clock-o">'+changedateSQLtoVN(data[i].create_date)+'</i> </small>';
                      chat +=    data[i].username;
                      chat +=  '</a>';
                      chat +=    data[i].comment;
                      chat +='</p></div>';
               }
           
                $('#'+chatbox).html(chat);
                var objDiv = document.getElementById(chatbox);
                objDiv.scrollTop = objDiv.scrollHeight;
            }
   });
}