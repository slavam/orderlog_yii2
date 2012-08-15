
<table id="list"></table>
<div id="pager"></div>
<script type="text/javascript">

jQuery("#list").jqGrid({
        url: '/reference/Testgrid',
        datatype: 'json',
        mtype: 'POST',
        colNames: ['InvoiceLineId'],
        colModel: [
              {name: 'Amount', index: 'Amount', width: 150, align: 'right', formatter: 'number', formatoptions: { thousandsSeparator: "," }, editable: true, editrules: { required: true}},
              ],
        pager: $('#pager'),
        rowNum: 10,
        rowList: [5, 10, 20, 50],
        viewrecords: true,
        imgpath: '',
        caption: 'Invoice Lines',
        editurl:'/reference/Testgrid'
    });
    $("#list").navGrid('#pager', { edit: false, add: true, del: true, search: false }, {  }, { width: 500 }, { url: "/../InvoiceLine/Delete" });
 </script>