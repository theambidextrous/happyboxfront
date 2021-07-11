  <script src="<?=$util->AdminHome()?>/vendor/jquery/jquery.min.js"></script>
  
  <script src="<?=$util->AdminHome()?>/vendor/bootstrap/js/popper.min.js"></script>
  <script src="<?=$util->AdminHome()?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=$util->AdminHome()?>/vendor/bootstrap/js/select2.min.js"></script>
  <script src="<?=$util->AdminHome()?>/vendor/bootstrap/js/jquery.dataTables.min.js"></script>
  <script src="<?=$util->AdminHome()?>/vendor/bootstrap/js/dataTables.buttons.min.js"></script>

  <!-- moment extnesion of DT -->
  <script src="<?=$util->AppHome()?>/vendor/mom/moment.min.js"></script>
  <script src="<?=$util->AppHome()?>/vendor/mom/datetime-moment.js"></script>


  <script src="<?=$util->AdminHome()?>/vendor/bootstrap/js/jszip.min.js"></script>
  <script src="<?=$util->AdminHome()?>/vendor/bootstrap/js/pdfmake.min.js"></script>
  <script src="<?=$util->AdminHome()?>/vendor/bootstrap/js/vfs_fonts.js"></script>
  <script src="<?=$util->AdminHome()?>/vendor/bootstrap/js/wt.js"></script>
  <script src="<?=$util->AdminHome()?>/vendor/bootstrap/js/buttons.html5.min.js"></script>
  <!-- jQuery Tinymce -->
  <script src="<?=$util->AdminHome()?>/vendor/tinymce/jquery.tinymce.min.js"></script>
  <script src="<?=$util->AdminHome()?>/vendor/tinymce/tinymce.min.js"></script>

  <script>
    $(document).ready(function() {
        $('.select2').select2();
        //Dt
        $('.reportable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel',
                {
                  extend: 'pdfHtml5',
                  orientation: 'landscape',
                  pageSize: 'A4'
                }
            ]
        } );
        $.fn.dataTable.moment( 'DD/MM/YYYY' );
        $('.reportable-purchases').DataTable( {
          "order": [[ 7, "desc" ]]
        });

        $('#goTop').on('click', function(e){
            $("html, body").animate({scrollTop: $("#top").offset().top}, 500);
        });

        //Load TinyMCE	
        tinymce.init({		
          selector: 'textarea.tinymce',
          height: 150,
          theme: 'modern',
          menubar: false,	
          plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code help wordcount'
          ],
          toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link unlink | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat | help'
        });
    });
  </script>