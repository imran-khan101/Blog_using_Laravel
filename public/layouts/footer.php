</div>
</div>
<footer class="blog-footer">
    <p>ASCII System <?php echo date('Y')?> All right reserved.</p>
    <p>
        <a href="#">Back to top</a>
    </p>
</footer>
</html>
<?php if (isset($database)) {
    $database->close_connection();
} ?>