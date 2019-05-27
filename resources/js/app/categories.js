$(document).ready(function() {
	$('.js-datatable').DataTable({
		"processing": true,
    "serverSide": true,
    "ajax": {
    	"url": $('.js-datatable').data('base-url') + '/page',
    	"type": "GET"
    },
    columns: [
    	{ data: "dt_id" },
      { data: "name" },
      {
          data: null,
          render: function(data, type, row) {
          	return '<a href="' + $('.js-datatable').data('base-url') + '/edit/' + data.id + '" class=""><button class="btn btn-primary master-btns">Edit</button></a>' +
          		'<a href="' + $('.js-datatable').data('base-url') + '/delete/' + data.id + '" class=""><button class="btn btn-primary master-btns">Delete</button></a>';
          }
      },
    ],
    "pageLength": 2,
    "lengthMenu": [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'All']]
	});
});
