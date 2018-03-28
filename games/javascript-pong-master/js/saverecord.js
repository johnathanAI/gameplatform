$( document ).ready(function() {
  window.startTime = new Date().valueOf();
});
function sendRecord(){
  window.endTime = new Date().valueOf();
  jQuery.ajax({
    type: "POST",
    url: "saverecord.php",
    dataType: "JSON",
    data: {
      playTime: Math.round(((endTime - startTime) / 1000)/60),
      scores:  JSON.stringify(window.scores)
    }
  });
}
$(window).on('beforeunload', sendRecord );
