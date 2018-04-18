<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/plugins/jQueryUI/jquery-ui.min.js'); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/dist/js/dataTables.fixedColumns.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js'); ?>">
  
</script>
<!-- FastClick -->
<script src="<?php echo base_url('assets/plugins/fastclick/fastclick.js');?>"></script>
<script src="<?php echo base_url('assets/dist/js/app.min.js')?>"></script>

<!-- CK Editor -->
<!-- <script type="text/javascript" src="<?php echo base_url('assets/plugins/ckeditor/ckeditor.js'); ?>"></script> -->
<!-- <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script> -->
<!-- <script src="//cdn.ckeditor.com/4.6.1/full/ckeditor.js"></script> -->
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
<script src="<?=base_url()?>assets/dist/js/validator.js"></script>
<script type="text/javascript">
  <?php if($page_title == "Data User | Pertamina Now"){ ?>
     //get data data user
        var table = $('.data-user').DataTable({
          "sServerMethod": "POST", 
          "bProcessing": true,
          "bServerSide": true,
          "lengthMenu": [10,20, 40, 60],
          "iDisplayLength" :20,
          "scrollX":true,
          "scrollY":"57vh", //awalnya tidak ada
          "columnDefs": [
            {
              "targets": '_all',
              render : function(data, type, row, meta) {
                    var res = data.split("|");
                    if(res[0] == 't'){
                      res[0] = 'text';
                    }else if(res[0] == 'd'){
                      res[0] = 'date';
                    }else if(res[0] == 'e'){
                      res[0] = 'email';
                    }else if(res[0] == 'sg'){
                      res[0] = 'selectGender';
                    }else if(res[0] == 'sr'){
                      res[0] = 'selectRule';
                    }
                    if(res[2] == 'e'){
                      res[2] = 'editable';
                    }
                    var id = row[10].split("|");
                    return "<div><span type='"+res[0]+"' id='"+id[3]+"' name='"+res[1]+"' class='"+res[2]+"'>"+res[3]+"</span></div>"
              } 
            }
          ],
          "sAjaxSource": "<?php echo base_url('User/get_data'); ?>"
        });       

        // Inline editing
      var oldValue = null;
      $(document).on('dblclick', '.editable', function(){
        oldValue = $(this).html();
        if(oldValue == '-'){
          oldValue = '';
        }
        $(this).removeClass('editable');  // to stop from making repeated request
        if($(this).attr('type') == "text"){
          $(this).html('<input type="text" style="width:90px; height:20px;" class="update" value="'+ oldValue +'" />');
        }else if($(this).attr('type') == "date"){
          $(this).html('<input type="date" style="width:90px;" class="update" value="'+ oldValue +'" />');
        }else if($(this).attr('type') == "email"){
          $(this).html('<input type="email" style="width:90px;" class="update" value="'+ oldValue +'" />');
        }else if($(this).attr('type') == "selectGender"){
          if(oldValue == 'Laki-laki'){
            $(this).html('<select style="width:90px;" class="update"><option value="1" selected>Laki-laki</option><option value="0">Perempuan</option></select>');
          }else{
            $(this).html('<select style="width:90px;" class="update"><option value="1">Laki-laki</option><option value="0" selected>Perempuan</option></select>');
          }
        }else if($(this).attr('type') == "selectRule"){
          if (oldValue == 'Admin') {
            $(this).html('<select style="width:90px;" class="update"><option value="1" selected>Admin</option><option value="0">User</option></select>');
          }else{
            $(this).html('<select style="width:90px;" class="update"><option value="1">Admin</option><option value="0" selected>User</option></select>');
          }
        }
        $(this).find('.update').focus();
      });

      var newValue = null;
      $(document).on('blur', '.update', function(){
        var elem    = $(this);
        newValue  = $(this).val();
        var id  = $(this).parent().attr('id');
        var colName = $(this).parent().attr('name');
        if(newValue != oldValue)
        {
          $.ajax({
            url : '<?php echo base_url('User/update_data') ?>',
            method : 'post',
            data : 
            {
              id    : id,
              colName  : colName,
              newValue : newValue,
            },
            success : function(respone)
            {
              if(newValue == ''){
                newValue = '-';
              }
              $(elem).parent().addClass('editable');
              $(elem).parent().html(newValue);
              table.ajax.reload( null, false );
            }
          });
        }
        else
        {
          if(newValue == ''){
            newValue = '-';
          }
          $(elem).parent().addClass('editable');
          $(this).parent().html(newValue);
        }
      });
        // end inline editing

        // check password - confirm password  
      // $("#rePass").focusout(function(){
      //   if($("#pass").val() != $("#rePass").val()){
      //     $("#notMatch").show();
      //   }else{
      //     $("#notMatch").hide();
      //   }
      // });
        // end check password

        // ajax delete data
     // $(document).on('click','.delete-data',function(event){
     //    var id= $(this).attr('rel');
     //    var that = $(this);
     //    var name= $(this).attr('data-name');
     //     var del = window.confirm('Confirm inactive '+name+'?');
     //      if (del === false) {
     //        event.preventDefault();
     //        return false;
     //      }
          
     //    $.ajax({
     //              url: '<?php echo base_url("User/delete_data"); ?>',
     //              type: 'POST',
     //              data: { id: id },
     //              success: function (resp) {    
     //                if (resp == 1) {  
     //                 table.ajax.reload( null, false );
     //                } 
     //                else { alert('error '+resp);}
     //              },
     //              error: function(e){ alert ("Error " + e); }
     //    });
     //    event.preventDefault();
      
     //  });
        // end delete data

        // ajax modal edit password
         // $(function(){
         //      $(document).on('click','.edit-password',function(e){
         //          e.preventDefault();
         //          $("#editPassword").modal('show');
         //          $.post("<?php echo base_url('User/modelEditPassword') ?>",
         //              {id:$(this).attr('data-id')},
         //              function(html){
         //                  $("#modelEditPassword").html(html);
         //              }   
         //          );
         //      });
         //  });
  <?php } ?>

  <?php if($page_title == "Data SPBU | Pertamina Now"){ ?>
     //get data data user
        var table = $('.data-spbu').DataTable({
          "sServerMethod": "POST", 
          "bProcessing": true,
          "bServerSide": true,
          "lengthMenu": [10,20, 40, 60],
          "iDisplayLength" :20,
          "scrollX":true,
          "scrollY":"57vh", //awalnya tidak ada
          "columnDefs": [
            {
              "targets": '_all',
              render : function(data, type, row, meta) {
                    var res = data.split("|");
                    if(res[0] == 't'){
                      res[0] = 'text';
                    }else if(res[0] == 'd'){
                      res[0] = 'date';
                    }else if(res[0] == 'e'){
                      res[0] = 'email';
                    }
                    if(res[2] == 'e'){
                      res[2] = 'editable';
                    }
                    var id = row[8].split("|");
                    return "<div><span type='"+res[0]+"' id='"+id[3]+"' name='"+res[1]+"' class='"+res[2]+"'>"+res[3]+"</span></div>"
              } 
            }
          ],
          "sAjaxSource": "<?php echo base_url('SPBU/get_data'); ?>"
        });       

        // Inline editing
      var oldValue = null;
      $(document).on('dblclick', '.editable', function(){
        oldValue = $(this).html();

        $(this).removeClass('editable');  // to stop from making repeated request
        if($(this).attr('type') == "text"){
          $(this).html('<input type="text" style="width:90px; height:20px;" class="update" value="'+ oldValue +'" />');
        }else if($(this).attr('type') == "date"){
          $(this).html('<input type="date" style="width:90px;" class="update" value="'+ oldValue +'" />');
        }else if($(this).attr('type') == "email"){
          $(this).html('<input type="email" style="width:90px;" class="update" value="'+ oldValue +'" />');
        }
        $(this).find('.update').focus();
      });

      var newValue = null;
      $(document).on('blur', '.update', function(){
        var elem    = $(this);
        newValue  = $(this).val();
        var id  = $(this).parent().attr('id');
        var colName = $(this).parent().attr('name');
        if(newValue != oldValue)
        {
          $.ajax({
            url : '<?php echo base_url('SPBU/update_data') ?>',
            method : 'post',
            data : 
            {
              id    : id,
              colName  : colName,
              newValue : newValue,
            },
            success : function(respone)
            {
              if(colName == 'id_group'){
                table.ajax.reload( null, false );
              }
              $(elem).parent().addClass('editable');
              $(elem).parent().html(newValue);
            }
          });
        }
        else
        {
          $(elem).parent().addClass('editable');
          $(this).parent().html(newValue);
        }
      });
        // end inline editing

        // ajax delete data
     $(document).on('click','.delete-data',function(event){
        var id= $(this).attr('rel');
        var that = $(this);
        var name= $(this).attr('data-name');
         var del = window.confirm('Confirm inactive '+name+'?');
          if (del === false) {
            event.preventDefault();
            return false;
          }
          
        $.ajax({
                  url: '<?php echo base_url("User/delete_data"); ?>',
                  type: 'POST',
                  data: { id: id },
                  success: function (resp) {    
                    if (resp == 1) {  
                     table.ajax.reload( null, false );
                    } 
                    else { alert('error '+resp);}
                  },
                  error: function(e){ alert ("Error " + e); }
        });
        event.preventDefault();
      
      });
        // end delete data
  <?php } ?>
</script>