<footer id="footer"><?php echo $text_footer; ?><br /><?php echo $text_version; ?></footer></div>
</body></html>

<style>
    .links:hover{
        cursor: pointer;
    }
    .clearfix{
        display: inline;
        float: left;
    }
    .clearfix li{
        float: left;
        padding-right: 20px;
    }
</style>
<script>
    
    $(document).on('click', '.links', function(){
        location.href = $(this).data('link');
    });
    
</script>
