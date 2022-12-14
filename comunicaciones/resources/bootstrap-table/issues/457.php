<!DOCTYPE html>
<html>
<head>
    <title>Set the global defaults for the table</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/bootstrap-table/src/bootstrap-table.css">
    <link rel="stylesheet" href="../assets/examples.css">
    <script src="../assets/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/bootstrap-table/src/bootstrap-table.js"></script>
    <script>
        $.extend($.fn.bootstrapTable.defaults, {
//            method: 'post',
            pagination: true,
            sidePagination: 'server',
//            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            showRefresh: true
        });
        $.extend($.fn.bootstrapTable.columnDefaults, {
            align: 'center',
            valign: 'middle'
        });
    </script>
    <script src="../ga.js"></script>
</head>
<body>
    <div class="container">
        <h1>Set the global defaults for the table(<a href="https://github.com/wenzhixin/bootstrap-table/issues/457" target="_blank">#457</a>).</h1>
        <table id="table"
               data-toggle="table"
               data-url="<?= base_url('admin/cients/clientsgetjson') ?>">
            <thead>
            <tr>
                <th data-field="id">ID</th>
                <th data-field="name">Item Name</th>
                <th data-field="price">Item Price  </th>
            </tr>
            </thead>
        </table>
    </div>
</body>
</html>