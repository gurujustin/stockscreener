"use strict";
var KTDatatablesBasicScrollable = function() {

    var initTable1 = function() {
        var table = $('.kt_datatable1');

        // begin first table
        table.DataTable({
            scrollY: '50vh',
            scrollX: true,
            scrollCollapse: true,
            columnDefs: [{
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
					width: '125px'
                },
            ],
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable1();
        },

    };

}();

jQuery(document).ready(function() {
    KTDatatablesBasicScrollable.init();
});
