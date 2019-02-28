// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable(
  	{
        order: [0, 'desc'],
        lengthMenu: [20, 50, 100, 200, 300],               
		displayLength: 50, // 件数デフォルト50
        bStateSave: true,
        oLanguage: {
          oPaginate: {
            sNext: '>',
            sPrevious: '<',
          }
        },
        //sPaginationType: "full_numbers",
        dom: "<'row'<'col-md-3'l><'col-md-9'fp>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-5'i><'col-sm-7'p>>", //lはプルダウン fは検索 pはpagination trはテーブル iはインフォ
    }
  
  );
});


//https://stackoverflow.com/questions/39407881/pagination-at-top-and-bottom-with-datatables
//<script>
//        	$(document).ready(function() {
//              $('#dataTable').DataTable({
//               		order: [0, 'desc'],
//               ,scrollX: true
//               ,searching:true
//               ,bSort:true
//               ,bStateSave:true
//               ,bInfo:true
//               ,bAutoWidth:false
//               // 件数切替の値を10～50の10刻みにする
//               ,lengthMenu: [ 10, 20, 30, 50, 100, 200]
//               // 件数のデフォルトの値を50にする
//               ,displayLength: 50
//               ,oLanguage: {
//                sLengthMenu: "表示行数 _MENU_ 件"
//                ,oPaginate: {
//                 sNext: "次のページ",
//                 sPrevious: "前のページ"
//                }
//                ,sInfo: "全_TOTAL_件中 _START_件から_END_件を表示"
//                ,sSearch: "検索："
               //}
//              });
//             });
//        
//        </script>

