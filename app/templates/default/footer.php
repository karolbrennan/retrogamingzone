</div></div></section>

<footer class="layout-footer">
    <div class="row">
        <div class="small-12 medium-3 columns">
            <p>© 2014 Karol Brennan</p>
        </div><div class="small-12 medium-9 columns">
            <?php $navigation = new \core\view; $navigation->rendertemplate('navigation'); ?></div>
    </div>
</footer>

<?php echo $data['js']."\n";?>
<script>
$(document).ready(function(){
	<?php echo $data['jq']."\n";?>
});
</script>

</body>
</html>
