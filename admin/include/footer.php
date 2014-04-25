
            </div>
        </div>
        <div class="footer">
            <p>&copy; Radford Child Development Inc. 2014</p>
        </div>
        
        <script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui.min.js"></script>
        <?php if ($_GET['p'] == 'manage_pages') 
                 echo "<script type=\"text/javascript\" src=\"/admin/js/manage_pages.js\"></script>\n"; 
              if ($_GET['p'] == 'edit_user')
                 echo "<script type=\"text/javascript\" src=\"/admin/js/edit_user.js\"></script>\n";
              if ($_GET['p'] == 'interested')
                 echo "<script type=\"text/javascript\" src=\"/admin/js/interested.js\"></script>\n";?>
    </body>
</html>