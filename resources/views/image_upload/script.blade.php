<script type="text/javascript">
// Preview File(s)
  function vpb_image_preview(vpb_selector_){
    var id = 1, last_id = last_cid = '';
    $.each(vpb_selector_.files, function(vpb_o_, file)
    {
      if (file.name.length>0)
      {
        if (!file.type.match('image.*')) {
          return true;
        } else { // Do not add files which are not images
          //Clear previous previewed files and start again
          $('#vpb-display-preview').html('');
          var reader = new FileReader();
          reader.onload = function(e)
          {
            $('#vpb-display-preview').append(
            '<div id="selector_'+vpb_o_+'" class="vpb_wrapper"> \
            <img class="vpb_image_style" class="img-thumbnail" src="' + e.target.result + '" \
            title="'+ escape(file.name) +'" /><br /> \
            <a style="cursor:pointer;padding-top:5px;" title="Click here to remove '+ escape(file.name) +'" \
            onclick="vpb_remove_selected(\''+vpb_o_+'\',\''+file.name+'\')">Remove</a> \
            </div>');
          }
            reader.readAsDataURL(file);
        }
      } else {
        return false;
      }
    });
  }
  //Remove Previewed File only from the screen but will be uploaded when you click on the start upload button
  function vpb_remove_selected(id,name)
  {
      $('#v-add-'+id).remove();
      $('#selector_'+id).fadeOut();
  }
  //Upload Files
  function vpb_upload_previewed_files()
  {
    // If no file is selected then do not proceed
    if(document.getElementById('vpb-data-file').value == "")
    {
      $("#vpb-display-preview").fadeIn(2000).html('<div class="vpb_display_info" align="center">Please browse for some files to proceed.</div>');
      return false
    }
    else
    {
      //Proceed now because a user has selected some files
      var vpb_files = document.getElementById('vpb-data-file').files;
      // Create a formdata object and append the files
      var vpb_data = new FormData();
      $.each(vpb_files, function(keys, values)
      {
        vpb_data.append(keys, values);
      });
      $.ajax({
        url: 'vasplus_uploader.php',
        type: 'POST',
        data: vpb_data,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function()
        {
          $("#vpb-display-preview").html('<div style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">Please wait <img src="images/loading.gif" align="absmiddle" alt="Uploading..."></div>');
        },
        success: function(response)
        {
          $("#vpb-display-preview").html(response);
          $('#vpb-data-file').val('');
        }
      });
    }
  }

</script>
