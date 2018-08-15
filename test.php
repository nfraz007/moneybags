<?php require_once 'header.php'; ?>
<style>
/*#pagination-long ul li{
    padding-top:3px;
    padding-right:10px;
    padding-left:10px;
}
#pagination-long ul li .active{
    background-color: #009688
}*/
</style>
<div class="container">
    <div id="pagination-long" class="pagination"></div>
    <div id="pagination-short"></div>
</div>
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="assets/pagination/pagination.js"></script>
<script>
$(function() {
    $(function() {
        $('#pagination-short').materializePagination({
            align: 'center',
            lastPage: 3,
            firstPage: 1,
            useUrlParameter: false,
        });

        $('#pagination-long').materializePagination({
            align: 'center',
            lastPage: 10,
            firstPage: 1,
            useUrlParameter: false,
            onClickCallback: function(requestedPage) {
                console.log('Requested page from #pagination-long: ' + requestedPage);
            }
        });
    });
});
</script>
