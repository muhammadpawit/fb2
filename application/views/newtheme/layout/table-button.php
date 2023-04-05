<!-- Datatable CSS -->
   <link href='https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
   <link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'>
<!-- jQuery Library -->
   
<!-- Datatable JS -->
   <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
   <script type="text/javascript">
     $(document).ready(function(){
        var empDataTable = $('.table').DataTable({
          'lengthChange': false,
           dom: 'Blfrtip',
           buttons: [
             {  
                extend: 'copy'
             },
             {
                extend: 'pdf',
                exportOptions: {
                  columns: [0,1] // Column index which needs to export
                }
             },
             {
                extend: 'csv',
             },
             {
                extend: 'excel',
             } 
           ] 

        });

      });
   </script>