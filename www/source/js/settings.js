$.validate();
    
    $(document).ready(function(){
      $('input[type=file]#uploadImage').change(function(){
        $(this).simpleUpload("pic.php", {
          allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
          maxFileSize: 5000000,

          start: function(file){
            //upload started
            console.log("upload started");
            alert("Start");
          },
          progress: function(progress){
            //received progress
            console.log("upload progress: " + Math.round(progress) + "%");
          },
          success: function(data){
            //upload successful
            console.log("upload successful!");
            console.log(data);
            window.location.href = "<?php echo $l['settings']; ?>?msg=6";
          },
          error: function(error){
            //upload failed
            console.log("upload error: " + error.name + ": " + error.message);
            alert("upload error: " + error.name + ": " + error.message);
          }
        });
      });
      $('input[type=file]#uploadImageB').change(function(){
        $(this).simpleUpload("background.php", {
          allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
          maxFileSize: 5000000,

          start: function(file){
            //upload started
            console.log("upload started");
            alert("Start");
          },
          progress: function(progress){
            //received progress
            console.log("upload progress: " + Math.round(progress) + "%");
          },
          success: function(data){
            //upload successful
            console.log("upload successful!");
            console.log(data);
            window.location.href = "<?php echo $l['settings']; ?>?msg=6";
          },
          error: function(error){
            //upload failed
            console.log("upload error: " + error.name + ": " + error.message);
            alert("upload error: " + error.name + ": " + error.message);
          }
        });
      });

      $('#deleteBP').on('click', function() {
        $.ajax({
          url: 'background.php',
          type:'POST',
          data: 'delete=yes',
          success: function() {
            alert("Finish");
            window.location.href = "<?php echo $l['settings']; ?>?msg=1";
          },
          error: function() {
            alert("ERROR");
          }
        });
      });
      $('#deletePP').on('click', function() {
        $.ajax({
          url: 'pic.php',
          type:'POST',
          data: 'delete=yes',
          success: function() {
            alert("Finish");
            window.location.href = "<?php echo $l['settings']; ?>?msg=1";
          },
          error: function() {
            alert("ERROR");
          }
        });
      });
    });